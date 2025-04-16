<?php
namespace App\Http\Controllers\Dashboard\Post;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Request\Post\CreateRequest;
use App\Http\Request\Post\UpdateRequest;
use App\Http\Services\Interfaces\Post\PostServiceInterface as PostService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class PostController extends BaseController
{
    use Loggable, HasRender;
    protected PostService $postService;
    protected PostCatalogueRepository $postCatalogueRepository;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        PostService $postService,
        PostCatalogueRepository $postCatalogueRepository,
    )
    {
        $this->postService = $postService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        parent::__construct($postService);
    }

    public function index()
    {
        try {
            $posts = $this->baseIndex();
            $postCatalogues = $this->postCatalogueRepository->all()['data'];
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'post_catalogue_id' => $_GET['post_catalogue_id'] ?? null,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý bài viết", 'body' => "post/index", 'posts' => $posts, 'postCatalogues' => $postCatalogues]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $posts = $this->postCatalogueRepository->all()['data'];
        $postCatalogues = $this->postCatalogueRepository->all()['data'];
        $this->view('index', ['title' => "Tạo bài viết", 'posts' => $posts, 'body' => "post/store", 'postCatalogues' => $postCatalogues]);
    }

    public function show(int $id = null): void
    {
        try {
            $post = $this->baseShow($id);
            $postCatalogues = $this->postCatalogueRepository->all()['data'];
            $this->view('index', ['title' => "Cập nhật bài viết", 'body' => "post/store", 'post' => $post, 'postCatalogues' => $postCatalogues]);
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
                    'post_catalogue_id' => $this->storeRequest->input('post_catalogue_id'),
                    'description' => $this->storeRequest->input('description'),
                    'content' => $this->storeRequest->input('content'),
                    'meta_title' => $this->storeRequest->input('meta_title'),
                    'meta_keyword' => $this->storeRequest->input('meta_keyword'),
                    'meta_description' => $this->storeRequest->input('meta_description'),
                    'image' => $this->storeRequest->input('image'),
                    'publish' => $this->storeRequest->input('publish'),
                ]);
                $this->view('index', ['body' => "post/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "post/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'parent_id',
                'content',
                'description',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'publish',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/posts/index');
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
                $post = $this->baseShow($id);
                $postCatalogues = $this->postCatalogueRepository->all()['data'];
                $this->view('index', [
                    'body' => "post/store",
                    'errors' => $this->updateRequest->errors(),
                    'postCatalogues' => $postCatalogues,
                    'post' => $post,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "post/store",'errors' => $this->updateRequest->errors()]);
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
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/posts/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $admin = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá bài viết", 'body' => "post/delete", 'admin' => $admin]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/posts/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}