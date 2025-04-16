<?php
namespace App\Http\Controllers\Frontend\Post;

use App\Http\Controllers\Frontend\BaseController;
use App\Http\Resources\Post\PostResource;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\Http\Services\Interfaces\Post\PostServiceInterface as PostService;
use App\Http\Resources\Post\DetailPostResource;
use App\Http\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
class PostController extends BaseController
{
    use HasRender, Loggable;
    protected string $dataHeader;
    protected PostService $postService;
    protected PostRepository $postRepository;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
    )
    {
        parent::__construct();
        $this->postService = $postService;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        try {
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "post/home",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'posts' => $this->getAllPosts()
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    /**
     * @throws \Exception
     */
    private function getAllPosts(): array
    {
        $_GET = $this->buildRequest(['product_catalogue_id'], 1000, "id,desc");
        $posts = $this->postService->paginate($_GET)['data'];
        $posts = new PostResource($posts);
        return $posts->toArray();
    }

    public function detail($canonical)
    {
        try {
            $post = $this->callDetailProduct($canonical);
            $postRelated = $this->callPostRelated($post['post_catalogue_id'], $post['id'], 10);
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "post/detail",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'post' => $this->callDetailProduct($canonical),
                'postRelated' => $postRelated,
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    /**
     * @throws \Exception
     */
    private function callDetailProduct(string $canonical): array
    {
        $post = $this->postRepository->findByCanonical($canonical);
        $post = new DetailPostResource($post);
        return $post->toArray();
    }

    /**
     * @throws \Exception
     */
    private function callPostRelated(int $postCatalogueId, int $postId, int $limit): array
    {
        $postRelated = $this->postRepository->getRelatedPosts($postCatalogueId, $postId, $limit);
        $postRelated = new PostResource($postRelated);
        return $postRelated->toArray();
    }
}