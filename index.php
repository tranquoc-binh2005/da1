<?php
session_start();
ob_start();
//session_destroy();
//unset($_SESSION['recentlyProduct']);
//print_r($_SESSION); die();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Http/Helpers/helpers.php';

use App\Http\Controllers\Ajax\ChangeStatusController;
use App\Http\Controllers\Ajax\VariantProductController;
use App\Http\Controllers\Ajax\CartController;
use App\Http\Controllers\Ajax\UserController as AjaxUserController;
use App\Http\Controllers\Ajax\ChangePassword as AjaxChangePasswordController;
use App\Http\Controllers\Ajax\AddressShoppingController as AjaxAddressShoppingController;
use App\Http\Controllers\Ajax\VoucherController as AjaxVoucherController;
use App\Http\Controllers\Ajax\HistoryController as AjaxHistoryController;

use App\Http\Controllers\Dashboard\Account\AdminController;
use App\Http\Controllers\Dashboard\Account\UserController;
use App\Http\Controllers\Dashboard\Auth\AuthenticateController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Post\PostCatalogueController;
use App\Http\Controllers\Dashboard\Post\PostController;
use App\Http\Controllers\Dashboard\Product\BrandProductController;
use App\Http\Controllers\Dashboard\Product\ProductCatalogueController;
use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\Product\UnitProductController;
use App\Http\Controllers\Dashboard\Role\PermissionController;
use App\Http\Controllers\Dashboard\Role\RoleController;
use App\Http\Controllers\Dashboard\Voucher\VoucherController;
use App\Http\Controllers\Dashboard\Order\OrderController as BackendOrderController;

use App\Http\Controllers\Frontend\Auth\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\Home\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\Product\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\Cart\CartController as FrontendCartController;
use App\Http\Controllers\Frontend\Profile\ProfileController as FrontendProfileController;
use App\Http\Controllers\Frontend\Checkout\CheckoutController as FrontendCheckoutController;
use App\Http\Controllers\Frontend\History\HistoryController as FrontendHistoryController;
use App\Http\Controllers\Frontend\Post\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\About\AboutController as FrontendAboutController;
use App\Routes\web;

$router = new web();

$router->group(['middleware' => ['AuthMiddleware']], function($router) {
    $router->get('/dashboard', DashboardController::class . '@index');
    $router->post('/ajax/changeStatusSingle', ChangeStatusController::class . '@changeStatusSingle');
    $router->post('/ajax/getAllUnitProduct', ChangeStatusController::class . '@getAllUnitProduct');
    $router->post('/ajax/getVariantProductById', VariantProductController::class . '@getVariantProductById');
    $router->post('/ajax/changeSingleOrderTop', ChangeStatusController::class . '@changeSingleOrderTop');
    $router->post('/ajax/bulkChangeStatusOrder', ChangeStatusController::class . '@bulkChangeStatusOrder');
});

$router->group(['middleware' => ['ClientIsLogin']], function($router) {
    $router->post('/ajax/checkIsVoucher', AjaxVoucherController::class . '@checkIsVoucher');
    $router->post('/ajax/addCart', CartController::class . '@addCart');
    $router->post('/ajax/updateCart', CartController::class . '@updateCart');
    $router->post('/ajax/removeCart', CartController::class . '@removeCart');
    $router->post('/ajax/updateProfileUser', AjaxUserController::class . '@updateProfileUser');
    $router->post('/ajax/checkIsPassword', AjaxChangePasswordController::class . '@checkIsPassword');
    $router->post('/ajax/saveAddressShopping', AjaxAddressShoppingController::class . '@saveAddressShopping');
    $router->post('/ajax/removeAddressShopping', AjaxAddressShoppingController::class . '@removeAddressShopping');
    $router->post('/ajax/detailAddressShopping', AjaxAddressShoppingController::class . '@detailAddressShopping');
    $router->post('/ajax/updateAddressShopping', AjaxAddressShoppingController::class . '@updateAddressShopping');
    $router->post('/ajax/changeAddressShopping', AjaxAddressShoppingController::class . '@changeAddressShopping');
    $router->post('/ajax/callHistoryOrderByStatus', AjaxHistoryController::class . '@callHistoryOrderByStatus');
});

$router->group(['middleware' => ['CheckPermission']], function($router) {
    $router->get('/dashboard/users/index', UserController::class . '@index')->middleware(['AuthMiddleware']);
//$router->get('/dashboard/users/create', UserController::class . '@create')->middleware(['AuthMiddleware']);
//$router->post('/dashboard/users/store', UserController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/users/show/{id}', UserController::class . '@show')->middleware(['AuthMiddleware']);
//$router->post('/dashboard/users/update/{id}', UserController::class . '@update')->middleware(['AuthMiddleware']);
//$router->get('/dashboard/users/delete/{id}', UserController::class . '@delete')->middleware(['AuthMiddleware']);
//$router->post('/dashboard/users/destroy/{id}', UserController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/roles/index', RoleController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/roles/create', RoleController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/roles/store', RoleController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/roles/show/{id}', RoleController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/roles/update/{id}', RoleController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/roles/delete/{id}', RoleController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/roles/destroy/{id}', RoleController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/admins/index', AdminController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/admins/create', AdminController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/admins/store', AdminController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/admins/show/{id}', AdminController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/admins/update/{id}', AdminController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/admins/delete/{id}', AdminController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/admins/destroy/{id}', AdminController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/permissions/index', PermissionController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/permissions/create', PermissionController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/permissions/store', PermissionController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/permissions/show/{id}', PermissionController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/permissions/update/{id}', PermissionController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/permissions/delete/{id}', PermissionController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/permissions/destroy/{id}', PermissionController::class . '@destroy')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/permissions/bulkStore', PermissionController::class . '@bulkStore')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/permissions/setPermission/{id}', PermissionController::class . '@setPermission')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/permissions/savePermission', PermissionController::class . '@savePermission')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/post_catalogues/index', PostCatalogueController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/post_catalogues/create', PostCatalogueController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/post_catalogues/store', PostCatalogueController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/post_catalogues/show/{id}', PostCatalogueController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/post_catalogues/update/{id}', PostCatalogueController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/post_catalogues/delete/{id}', PostCatalogueController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/post_catalogues/destroy/{id}', PostCatalogueController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/posts/index', PostController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/posts/create', PostController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/posts/store', PostController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/posts/show/{id}', PostController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/posts/update/{id}', PostController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/posts/delete/{id}', PostController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/posts/destroy/{id}', PostController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/product_catalogues/index', ProductCatalogueController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/product_catalogues/create', ProductCatalogueController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/product_catalogues/store', ProductCatalogueController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/product_catalogues/show/{id}', ProductCatalogueController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/product_catalogues/update/{id}', ProductCatalogueController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/product_catalogues/delete/{id}', ProductCatalogueController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/product_catalogues/destroy/{id}', ProductCatalogueController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/unit_products/index', UnitProductController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/unit_products/create', UnitProductController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/unit_products/store', UnitProductController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/unit_products/show/{id}', UnitProductController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/unit_products/update/{id}', UnitProductController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/unit_products/delete/{id}', UnitProductController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/unit_products/destroy/{id}', UnitProductController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/brand_products/index', BrandProductController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/brand_products/create', BrandProductController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/brand_products/store', BrandProductController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/brand_products/show/{id}', BrandProductController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/brand_products/update/{id}', BrandProductController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/brand_products/delete/{id}', BrandProductController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/brand_products/destroy/{id}', BrandProductController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/products/index', ProductController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/products/create', ProductController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/products/store', ProductController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/products/show/{id}', ProductController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/products/update/{id}', ProductController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/products/delete/{id}', ProductController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/products/destroy/{id}', ProductController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/vouchers/index', VoucherController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/vouchers/create', VoucherController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/vouchers/store', VoucherController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/vouchers/show/{id}', VoucherController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/vouchers/update/{id}', VoucherController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/vouchers/delete/{id}', VoucherController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/vouchers/destroy/{id}', VoucherController::class . '@destroy')->middleware(['AuthMiddleware']);

    $router->get('/dashboard/orders/index', BackendOrderController::class . '@index')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/orders/create', BackendOrderController::class . '@create')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/orders/store', BackendOrderController::class . '@store')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/orders/show/{id}', BackendOrderController::class . '@show')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/orders/update/{id}', BackendOrderController::class . '@update')->middleware(['AuthMiddleware']);
    $router->get('/dashboard/orders/delete/{id}', BackendOrderController::class . '@delete')->middleware(['AuthMiddleware']);
    $router->post('/dashboard/orders/destroy/{id}', BackendOrderController::class . '@destroy')->middleware(['AuthMiddleware']);
});

$router->post('/auth/authenticate', AuthenticateController::class . '@authenticate');
$router->get('/auth/register', AuthenticateController::class . '@register')->middleware(['IsLoginMiddleware']);
$router->get('/auth/login', AuthenticateController::class . '@login')->middleware(['IsLoginMiddleware']);
$router->get('/auth/logout', AuthenticateController::class . '@logout');
$router->post('/auth/handleRegister', AuthenticateController::class . '@handleRegister');
$router->get('/auth/revoke', AuthenticateController::class . '@revoke');

// router client
$router->get('/trang-chu', FrontendHomeController::class . '@index');
$router->get('/', FrontendHomeController::class . '@index');

$router->get('/san-pham', FrontendProductController::class . '@index');
$router->get('/san-pham/chi-tiet-san-pham/{canonical}', FrontendProductController::class . '@detail');
$router->get('/bai-viet', FrontendPostController::class . '@index');
$router->get('/bai-viet/{canonical}', FrontendPostController::class . '@detail');

$router->group(['middleware' => ['ClientIsLogin']], function($router) {
    $router->get('/gio-hang', FrontendCartController::class . '@index')->middleware(['ClientIsLogin']);

    $router->post('/thanh-toan', FrontendCheckoutController::class . '@checkout');
    $router->post('/xu-ly-thanh-toan', FrontendCheckoutController::class . '@handleCheckout');
    $router->get('/xu-ly-thanh-toan-paypal', FrontendCheckoutController::class . '@completePaymentPaypal');
    $router->get('/xu-ly-thanh-toan-paypal-failed', FrontendCheckoutController::class . '@completePaymentPaypalFailed');

    $router->get('/thong-tin-ca-nhan', FrontendProfileController::class . '@profile');
    $router->get('/cap-nhat-mat-khau', FrontendProfileController::class . '@password');
    $router->get('/cap-nhat-dia-chi', FrontendProfileController::class . '@address');

    $router->get('/don-hang', FrontendHistoryController::class . '@history');
    $router->get('/don-hang/chi-tiet-don-hang/{id}', FrontendHistoryController::class . '@detail');
});
$router->get('/gioi-thieu', FrontendAboutController::class . '@about');

// auth client
$router->get('/dang-nhap', FrontendAuthController::class . '@login');
$router->post('/xu-ly-dang-nhap', FrontendAuthController::class . '@handleLogin');
$router->get('/dang-xuat', FrontendAuthController::class . '@logout');
$router->get('/dang-ky-tai-khoan', FrontendAuthController::class . '@register');
$router->post('/xu-ly-dang-ky-tai-khoan', FrontendAuthController::class . '@handleRegister');
$router->post('/xac-nhan-otp', FrontendAuthController::class . '@handleVerify');
$router->get('/profile', FrontendAuthController::class . '@profile');

$router->run();