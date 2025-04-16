<?php
namespace App\Http\Controllers\Dashboard\Post;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Request\PostCatalogue\CreateRequest;
use App\Http\Request\PostCatalogue\UpdateRequest;
use App\Http\Services\Interfaces\Post\PostCatalogueServiceInterface as PostCatalogueService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class PostCatalogueController extends BaseController
{
    use Loggable, HasRender;
    protected PostCatalogueService $postCatalogueService;
    protected PostCatalogueRepository $postCatalogueRepository;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository,
    )
    {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        parent::__construct($postCatalogueService);
    }

    public function index()
    {
        try {
            $postCatalogues = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý danh mục bài viết", 'body' => "postCatalogue/index", 'postCatalogues' => $postCatalogues]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $postCatalogues = $this->postCatalogueRepository->all()['data'];
        $this->view('index', ['title' => "Tạo danh mục bài viết", 'postCatalogues' => $postCatalogues, 'body' => "postCatalogue/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $postCatalogue = $this->baseShow($id);
            $postCatalogues = $this->postCatalogueRepository->all()['data'];
            $this->view('index', ['title' => "Cập nhật danh mục bài viết", 'body' => "postCatalogue/store", 'postCatalogue' => $postCatalogue, 'postCatalogues' => $postCatalogues]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->storeRequest = new CreateRequest();
            if ($this->storeRequest->fails()) {
                withInput([
                    'name' => $this->storeRequest->input('name'),
                    'canonical' => $this->storeRequest->input('canonical'),
                    'parent_id' => $this->storeRequest->input('parent_id'),
                    'description' => $this->storeRequest->input('description'),
                    'meta_title' => $this->storeRequest->input('meta_title'),
                    'meta_keyword' => $this->storeRequest->input('meta_keyword'),
                    'meta_description' => $this->storeRequest->input('meta_description'),
                    'image' => $this->storeRequest->input('image'),
                    'publish' => $this->storeRequest->input('publish'),
                ]);
                $this->view('index', ['body' => "postCatalogue/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "postCatalogue/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'parent_id',
                'description',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'publish',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/post_catalogues/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function update(int $id): void
    {
        try {
            $this->updateRequest = new UpdateRequest($id);
            if ($this->updateRequest->fails()) {
                withInput([
                    'name' => $this->updateRequest->input('name'),
                    'canonical' => $this->updateRequest->input('canonical'),
                    'parent_id' => $this->updateRequest->input('parent_id'),
                    'description' => $this->updateRequest->input('description'),
                    'meta_title' => $this->updateRequest->input('meta_title'),
                    'meta_keyword' => $this->updateRequest->input('meta_keyword'),
                    'meta_description' => $this->updateRequest->input('meta_description'),
                    'image' => $this->updateRequest->input('image'),
                    'publish' => $this->updateRequest->input('publish'),
                ]);
                $postCatalogue = $this->baseShow($id);
                $postCatalogues = $this->postCatalogueRepository->all()['data'];
                $this->view('index', [
                    'body' => "postCatalogue/store",
                    'errors' => $this->updateRequest->errors(),
                    'postCatalogue' => $postCatalogue,
                    'postCatalogues' => $postCatalogues,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "postCatalogue/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'parent_id',
                'description',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'publish',
            ]);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/post_catalogues/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $admin = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá danh mục bài viết", 'body' => "postCatalogue/delete", 'admin' => $admin]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/post_catalogues/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}