<?php
namespace App\Providers;

use App\Http\Repositories\Account\AdminRepository;
use App\Http\Repositories\Account\UserRepository;
use App\Http\Repositories\AddressShopping\AddressShoppingRepository;
use App\Http\Repositories\Auth\AuthenticateRepository;
use App\Http\Repositories\Auth\VerifyRepository;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Cart\CartItemRepository;
use App\Http\Repositories\Cart\CartRepository;
use App\Http\Repositories\Checkout\OrderDetailRepository;
use App\Http\Repositories\Checkout\OrderRepository;
use App\Http\Repositories\Checkout\OrderStatusRepository;
use App\Http\Repositories\Interfaces\AddressShoppingRepositoryInterface;
use App\Http\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Repositories\Interfaces\AuthenticateRepositoryInterface;
use App\Http\Repositories\Interfaces\BaseRepositoryInterface;
use App\Http\Repositories\Interfaces\BrandProductRepositoryInterface;
use App\Http\Repositories\Interfaces\CartItemRepositoryInterface;
use App\Http\Repositories\Interfaces\CartRepositoryInterface;
use App\Http\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Http\Repositories\Interfaces\OrderRepositoryInterface;
use App\Http\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Http\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Http\Repositories\Interfaces\PostCatalogueRepositoryInterface;
use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Http\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface;
use App\Http\Repositories\Interfaces\RoleRepositoryInterface;
use App\Http\Repositories\Interfaces\UnitProductRepositoryInterface;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Interfaces\VerifyRepositoryInterface;
use App\Http\Repositories\Interfaces\VoucherRepositoryInterface;
use App\Http\Repositories\Post\PostCatalogueRepository;
use App\Http\Repositories\Post\PostRepository;
use App\Http\Repositories\Product\BrandProductRepository;
use App\Http\Repositories\Product\ProductCatalogueRepository;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Product\ProductVariantRepository;
use App\Http\Repositories\Product\UnitProductRepository;
use App\Http\Repositories\Role\PermissionRepository;
use App\Http\Repositories\Role\RoleRepository;
use App\Http\Repositories\Voucher\VoucherRepository;
use App\Http\Services\Impl\Account\AdminService;
use App\Http\Services\Impl\Account\UserService;
use App\Http\Services\Impl\Auth\AuthenticateService;
use App\Http\Services\Impl\Auth\ClientAuthService;
use App\Http\Services\Impl\Cart\ClientCartService;
use App\Http\Services\Impl\Mail\RegisterAccountSendMail;
use App\Http\Services\Impl\Mail\SendMailInvoiceService;
use App\Http\Services\Impl\Order\OrderService;
use App\Http\Services\Impl\Post\PostCatalogueService;
use App\Http\Services\Impl\Post\PostService;
use App\Http\Services\Impl\Product\BrandProductService;
use App\Http\Services\Impl\Product\ProductCatalogueService;
use App\Http\Services\Impl\Product\ProductService;
use App\Http\Services\Impl\Product\UnitProductService;
use App\Http\Services\Impl\Role\PermissionService;
use App\Http\Services\Impl\Role\RoleService;
use App\Http\Services\Impl\Upload\ImageService;
use App\Http\Services\Impl\Voucher\VoucherService;
use App\Http\Services\Interfaces\Account\AdminServiceInterface;
use App\Http\Services\Interfaces\Account\UserServiceInterface;
use App\Http\Services\Interfaces\Auth\AuthenticateServiceInterface;
use App\Http\Services\Interfaces\Auth\ClientAuthServiceInterface;
use App\Http\Services\Interfaces\Cart\ClientCartServiceInterface;
use App\Http\Services\Interfaces\Checkout\OrderServiceInterface;
use App\Http\Services\Interfaces\Mail\RegisterAccountSendMailInterface;
use App\Http\Services\Interfaces\Mail\SendMailInvoiceServiceInterface;
use App\Http\Services\Interfaces\Post\PostCatalogueServiceInterface;
use App\Http\Services\Interfaces\Post\PostServiceInterface;
use App\Http\Services\Interfaces\Product\BrandProductServiceInterface;
use App\Http\Services\Interfaces\Product\ProductCatalogueServiceInterface;
use App\Http\Services\Interfaces\Product\ProductServiceInterface;
use App\Http\Services\Interfaces\Product\UnitProductServiceInterface;
use App\Http\Services\Interfaces\Role\PermissionServiceInterface;
use App\Http\Services\Interfaces\Role\RoleServiceInterface;
use App\Http\Services\Interfaces\Upload\ImageServiceInterface;
use App\Http\Services\Interfaces\Voucher\VoucherServiceInterface;
use App\Http\Repositories\Interfaces\DashboardBuilderRepositoryInterface;
use App\Http\Repositories\Dashboard\DashboardBuilderRepository;
use App\Http\Repositories\Product\ProductRatingRepository;
use App\Http\Repositories\Interfaces\ProductRatingRepositoryInterface;

class ServiceProvider
{
    protected static array $bindings = [
        BaseRepositoryInterface::class => BaseRepository::class,
        UserServiceInterface::class => UserService::class,
        UserRepositoryInterface::class => UserRepository::class,
        AuthenticateServiceInterface::class => AuthenticateService::class,
        AuthenticateRepositoryInterface::class => AuthenticateRepository::class,
        RoleServiceInterface::class => RoleService::class,
        RoleRepositoryInterface::class => RoleRepository::class,
        AdminRepositoryInterface::class => AdminRepository::class,
        AdminServiceInterface::class => AdminService::class,
        ImageServiceInterface::class => ImageService::class,
        PermissionServiceInterface::class => PermissionService::class,
        PermissionRepositoryInterface::class => PermissionRepository::class,
        PostCatalogueServiceInterface::class => PostCatalogueService::class,
        PostCatalogueRepositoryInterface::class => PostCatalogueRepository::class,
        PostServiceInterface::class => PostService::class,
        PostRepositoryInterface::class => PostRepository::class,
        ProductCatalogueServiceInterface::class => ProductCatalogueService::class,
        ProductCatalogueRepositoryInterface::class => ProductCatalogueRepository::class,
        UnitProductRepositoryInterface::class => UnitProductRepository::class,
        UnitProductServiceInterface::class => UnitProductService::class,
        BrandProductServiceInterface::class => BrandProductService::class,
        BrandProductRepositoryInterface::class => BrandProductRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        ProductServiceInterface::class => ProductService::class,
        ProductVariantRepositoryInterface::class => ProductVariantRepository::class,
        ClientAuthServiceInterface::class => ClientAuthService::class,
        RegisterAccountSendMailInterface::class => RegisterAccountSendMail::class,
        VerifyRepositoryInterface::class => VerifyRepository::class,
        CartItemRepositoryInterface::class => CartItemRepository::class,
        CartRepositoryInterface::class => CartRepository::class,
        ClientCartServiceInterface::class => ClientCartService::class,
        AddressShoppingRepositoryInterface::class => AddressShoppingRepository::class,
        VoucherRepositoryInterface::class => VoucherRepository::class,
        VoucherServiceInterface::class => VoucherService::class,
        OrderServiceInterface::class => OrderService::class,
        OrderRepositoryInterface::class => OrderRepository::class,
        OrderDetailRepositoryInterface::class => OrderDetailRepository::class,
        OrderStatusRepositoryInterface::class => OrderStatusRepository::class,
        SendMailInvoiceServiceInterface::class => SendMailInvoiceService::class,
        DashboardBuilderRepositoryInterface::class => DashboardBuilderRepository::class,
        ProductRatingRepositoryInterface::class => ProductRatingRepository::class,
    ];

    /**
     * @throws \Exception
     */
    public static function resolve(string $abstract)
    {
        if (isset(self::$bindings[$abstract])) {
            $concrete = self::$bindings[$abstract];

            $reflection = new \ReflectionClass($concrete);
            $constructor = $reflection->getConstructor();

            if (!$constructor) {
                return new $concrete();
            }

            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                $paramType = $parameter->getType();

                if ($paramType && !$paramType->isBuiltin()) {
                    $dependencyClass = $paramType->getName();
                    $dependencies[] = self::resolve($dependencyClass);
                } elseif ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Không thể tự động inject dependency cho {$concrete}");
                }
            }

            return $reflection->newInstanceArgs($dependencies);
        }

        throw new \Exception("Không tìm thấy binding cho {$abstract}");
    }

}
