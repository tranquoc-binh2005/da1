<?php
namespace App\Http\Repositories\Post;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\PostCatalogueRepositoryInterface;
use App\Models\Database;
use App\Models\PostCatalogue;
use PDO;

class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
    protected PDO $database;
    protected PostCatalogue $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new PostCatalogue();
        parent::__construct($this->model);
    }
}