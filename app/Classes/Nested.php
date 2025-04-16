<?php
namespace App\Classes;

use App\Models\Database;
use App\Http\Repositories\BaseRepository;
class Nested {

    protected $checked;
    protected $data;
    protected $count;
    protected $count_level;
    protected $lft;
    protected $rgt;
    protected $level;
    protected $params;
    protected $auth;
    protected BaseRepository $baseRepository;

    public function __construct(mixed $params = null)
    {
        $this->params = $params;
        $this->data = null;
        $this->checked = null;
        $this->count = 0;
        $this->count_level = 0;
        $this->lft = null;
        $this->rgt = null;
        $this->level = null;
        $this->auth = $_SESSION['admin'];

        $this->baseRepository = new BaseRepository(Database::connection());
    }


    public function get(){
        $sql = "SELECT id, name, parent_id, lft, rgt, level FROM {$this->params['table']} ORDER BY lft ASC";
        $this->data = $this->baseRepository->get($sql);
    }

    public function set(){
        $arr = null;
        if(isset($this->data) && count($this->data)){
            foreach($this->data as $key => $val){
                $arr[$val['id']][$val['parent_id']] = 1;
                $arr[$val['parent_id']][$val['id']] = 1;
            }
        }
        return $arr;
    }
    public function recursive($start = 0, $arr = null){
        $this->lft[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;
        if(isset($arr) && is_array($arr) && count($arr)){
            foreach($arr as $key => $val){
                if((isset($arr[$start][$key]) || isset($val[$start])) && (!isset($this->checked[$key][$start])  && !isset($this->checked[$start][$key]))){
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->rgt[$start] = ++$this->count;
    }

    public function action(){
        if(isset($this->level, $this->lft, $this->rgt) && is_array($this->level) && is_array($this->lft) && is_array($this->rgt)){
            $data = [];
            foreach($this->level as $key => $val) {
                if($key == 0) continue;

                $data = [
                    'id' => $key,
                    'level' => $val,
                    'lft' => $this->lft[$key],
                    'rgt'=> $this->rgt[$key],
                    'admin_id' => $this->auth['id'],
                ];

                $updateFields = ['lft', 'rgt', 'level', 'admin_id'];

                $this->baseRepository->upsert($this->params['table'], $data, $updateFields);
            }
        }
    }

}