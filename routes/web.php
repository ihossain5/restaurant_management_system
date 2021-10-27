<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\AssetTypeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\HomeHeroSectionController;
use App\Http\Controllers\Backend\ItemComboController;
use App\Http\Controllers\Backend\ItemController;
use App\Http\Controllers\Backend\ManagerController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\OrderPerformanceController;
use App\Http\Controllers\Backend\RestaurantController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Frontend\AboutUsController as FrontendAboutUsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\CustomerController as FrontendCustomerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RestaurantMenuController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\ManagerOrderPerformanceController;
use App\Http\Controllers\Manager\ManagerOrdersController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/password-update', [AdminController::class, 'passwordChange'])->name('password.change');
    Route::post('/password-update', [AdminController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile-update', [AdminController::class, 'profile'])->name('user.profile');
    Route::post('/profile-update', [AdminController::class, 'profileUpdate'])->name('profile.update');

//* admin route start */
    Route::get('/admins', [AdminController::class, 'allAdmin'])->name('admin.admins');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::post('/admin/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/show', [AdminController::class, 'show'])->name('admin.show');
    Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/admin/delete', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::post('/admin/status/update', [AdminController::class, 'updateActiveStatus'])->name('admin.status.update');
//* admin route end */

    // user routes start
    Route::get('/users', [UserController::class, 'allUser'])->name('admin.users');
    Route::post('/change/admin/status', [UserController::class, 'changeAdminStatus'])->name('is.admin');
    // user routes end

    //* Home Hero section route start */
    Route::group(['prefix' => 'home-hero-Section'], function () {
        Route::get('/', [HomeHeroSectionController::class, 'index'])->name('home.hero.section');
        Route::post('/store', [HomeHeroSectionController::class, 'store'])->name('hero.section.store');
        Route::post('/edit', [HomeHeroSectionController::class, 'edit'])->name('hero.section.edit');
        Route::post('/show', [HomeHeroSectionController::class, 'show'])->name('hero.section.show');
        Route::post('/update', [HomeHeroSectionController::class, 'update'])->name('hero.section.update');
        Route::post('/delete', [HomeHeroSectionController::class, 'destroy'])->name('hero.section.delete');

    }); //* Home Hero section route end */

    //* About us oute start */
    Route::group(['prefix' => 'about-us'], function () {
        Route::get('/', [AboutUsController::class, 'index'])->name('about.us');
        Route::post('/edit', [AboutUsController::class, 'edit'])->name('about.us.edit');
        Route::post('/show', [AboutUsController::class, 'show'])->name('about.us.show');
        Route::post('/update', [AboutUsController::class, 'update'])->name('about.us.update');
        Route::post('/delete', [AboutUsController::class, 'destroy'])->name('about.us.delete');

    }); //* About us route end */

    //* Contact us route start */
    Route::group(['prefix' => 'contact-us'], function () {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact.us');
        Route::post('/edit', [ContactUsController::class, 'edit'])->name('contact.us.edit');
        Route::post('/show', [ContactUsController::class, 'show'])->name('contact.us.show');
        Route::post('/update', [ContactUsController::class, 'update'])->name('contact.us.update');
        Route::post('/delete', [ContactUsController::class, 'destroy'])->name('contact.us.delete');

    }); //* Contact us route end */

    //* Asset Type route start */
    Route::group(['prefix' => 'asset-types'], function () {
        Route::get('/', [AssetTypeController::class, 'index'])->name('asset.type');
        Route::post('/store', [AssetTypeController::class, 'store'])->name('asset.type.store');
        Route::post('/edit', [AssetTypeController::class, 'edit'])->name('asset.type.edit');
        Route::post('/show', [AssetTypeController::class, 'show'])->name('asset.type.show');
        Route::post('/update', [AssetTypeController::class, 'update'])->name('asset.type.update');
        Route::post('/delete', [AssetTypeController::class, 'destroy'])->name('asset.type.delete');

    }); //* Asset Type route end */

    //* Restaurant route start */
    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('/', [RestaurantController::class, 'index'])->name('restaurant.index');
        Route::post('/store', [RestaurantController::class, 'store'])->name('restaurant.store');
        Route::post('/edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::post('/show', [RestaurantController::class, 'show'])->name('restaurant.show');
        Route::post('/update', [RestaurantController::class, 'update'])->name('restaurant.update');
        Route::post('/delete', [RestaurantController::class, 'destroy'])->name('restaurant.delete');
        Route::post('/deleteAsset', [RestaurantController::class, 'deleteAsset'])->name('restaurant.asset.delete');
        Route::post('/status/update', [RestaurantController::class, 'updateStatus'])->name('restaurant.status.update');
        Route::get('/{id}/overview', [RestaurantController::class, 'restaurantOverview'])->name('restaurant.overview');
        Route::post('/overview', [RestaurantController::class, 'orderReportByRestaurant'])->name('order.report.restaurant');
        Route::get('{id}/daily-reports', [OrderPerformanceController::class, 'dailyReports'])->name('orders.daily.report');

        Route::get('{id}/daily/order-reports', [OrderPerformanceController::class, 'dailyOrderReports'])->name('daily.order.report.restaurant');
        Route::get('date-wise/order-reports', [OrderPerformanceController::class, 'dailyOrderReportsByRestaurant'])->name('date.wise.order.report.restaurant');

        Route::post('daily-reports', [OrderPerformanceController::class, 'dailyReportByRestaurant'])->name('order.daily.report.restaurant');
        Route::post('order-reports', [OrderPerformanceController::class, 'dateWiseReportByRestaurant'])->name('order.daily.report.restaurant.date');
        Route::get('{id}/time-range/reports', [OrderPerformanceController::class, 'timeRangeReports'])->name('orders.time.range.report');
        Route::post('/time-range/reports', [OrderPerformanceController::class, 'timeRangeReportsByRestaurant'])->name('order.report.restaurant.date.range');
        Route::get('/{id}/monthly-reports', [OrderPerformanceController::class, 'currentMonthReportsByRestaurant'])->name('order.report.restaurant.current.month');
        Route::post('monthly-reports', [OrderPerformanceController::class, 'monthlyOrdersReportByRestaurant'])->name('order.report.restaurant.month');
        Route::get('/{id}/item/performance-reports', [OrderPerformanceController::class, 'itemReportsByRestaurant'])->name('order.report.item');
        Route::post('item/performance-reports', [OrderPerformanceController::class, 'itemReportsByDate'])->name('order.report.item.date');

    }); //* Restaurant route end */

    //* Restaurant Manager route start */
    Route::group(['prefix' => 'managers'], function () {
        Route::get('/', [ManagerController::class, 'index'])->name('restaurant.manager');
        Route::post('/store', [ManagerController::class, 'store'])->name('restaurant.manager.store');
        Route::post('/edit', [ManagerController::class, 'edit'])->name('restaurant.manager.edit');
        Route::post('/show', [ManagerController::class, 'show'])->name('restaurant.manager.show');
        Route::post('/update', [ManagerController::class, 'update'])->name('restaurant.manager.update');
        Route::post('/delete', [ManagerController::class, 'destroy'])->name('restaurant.manager.delete');
    }); //* Restaurant Manager route end */

    //* Item route start */
        Route::group(['prefix' => 'items'], function () {
            // Route::get('/', [ItemController::class, 'index'])->name('item.index');
            Route::get('/{id}', [ItemController::class, 'index'])->name('item.index');
            Route::post('/store', [ItemController::class, 'store'])->name('item.store');
            Route::post('/edit', [ItemController::class, 'edit'])->name('item.edit');
            Route::post('/show', [ItemController::class, 'show'])->name('item.show');
            Route::post('/update', [ItemController::class, 'update'])->name('item.update');
            Route::post('/delete', [ItemController::class, 'destroy'])->name('item.delete');
            Route::post('/restaurant-items', [ItemController::class, 'getItemsByRestaurant'])->name('item.restaurant');
            Route::post('/available-status/update', [ItemController::class, 'updateAvailableStatus'])->name('item.available.status.update');
            /* Item combo route start */
            Route::get('/{id}/combos', [ItemComboController::class, 'index'])->name('item.combo.index');
            Route::post('/combo/store', [ItemComboController::class, 'store'])->name('item.combo.store');
            Route::post('combo/edit', [ItemComboController::class, 'edit'])->name('item.combo.edit');
            Route::post('combo/show', [ItemComboController::class, 'show'])->name('item.combo.show');
            Route::post('combo/update', [ItemComboController::class, 'update'])->name('item.combo.update');
            Route::post('combo/delete', [ItemComboController::class, 'destroy'])->name('item.combo.delete');
            Route::post('combo/restaurant', [ItemComboController::class, 'getComboByRestaurant'])->name('item.combo.restaurant');
            /* Item combo route start */

        }); //* Item route end */

        //* Category route start */
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('item.category.index');
            Route::get('/{id}', [CategoryController::class, 'index'])->name('item.category');
            Route::post('/store', [CategoryController::class, 'store'])->name('item.category.store');
            Route::post('/edit', [CategoryController::class, 'edit'])->name('item.category.edit');
            Route::post('/show', [CategoryController::class, 'show'])->name('item.category.show');
            Route::post('/update', [CategoryController::class, 'update'])->name('item.category.update');
            Route::post('/delete', [CategoryController::class, 'destroy'])->name('item.category.delete');
            Route::post('/restaurant-categories', [CategoryController::class, 'getCategoriesByRestaurant'])->name('item.category.restaurant');

        }); //* Category route end */

    //* order route start */
    Route::group(['prefix' => 'orders'], function () {
        Route::get('restaurant/{id}/today-orders', [OrderController::class, 'getTodayOrders'])->name('orders.today');
        Route::get('restaurant/{id}/past-orders', [OrderController::class, 'getPastOrders'])->name('orders.past');
        //  Route::get('/{id}', [CategoryController::class, 'index'])->name('item.category');
        Route::post('/store', [CategoryController::class, 'store'])->name('item.category.store');
        Route::post('/edit', [CategoryController::class, 'edit'])->name('item.category.edit');
        Route::post('/show', [OrderController::class, 'show'])->name('order.show');
        Route::post('/update', [CategoryController::class, 'update'])->name('item.category.update');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('item.category.delete');
        Route::post('/restaurant-orders', [OrderController::class, 'getOrdersByRestaurant'])->name('order.restaurant');
        Route::get('/today/{id}', [OrderController::class, 'todayOrders'])->name('today.order.restaurant');
        Route::get('/past/{id}', [OrderController::class, 'pastOrders'])->name('past.order.restaurant');
        Route::post('/restaurant-past-orders', [OrderController::class, 'getPastOrdersByRestaurant'])->name('order.past.restaurant');
    }); //* order route end */

    //* performance route start */
    Route::group(['prefix' => 'orders'], function () {
        Route::post('/restaurant-past-orders', [OrderController::class, 'getPastOrdersByRestaurant'])->name('order.past.restaurant');
    }); //* performance route end */

    //* customer route start */
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('/show', [CustomerController::class, 'show'])->name('customer.show');
        Route::post('/banned', [CustomerController::class, 'banCustomer'])->name('customer.banned');
        Route::get('{id}/all-order/', [CustomerController::class, 'customerOrders'])->name('customer.orders');
        Route::post('/orders', [CustomerController::class, 'customerOrderByRestaurant'])->name('customer.order.restaurant');
        Route::get('/order', [CustomerController::class, 'getOrders'])->name('customer.order');
        Route::post('/delete', [ManagerController::class, 'destroy'])->name('restaurant.manager.delete');
    }); //* customer route end */

    Route::get('test-orders', [OrderController::class, 'getAllOrders'])->name('order.test');
    Route::get('orders', [OrderController::class, 'orders'])->name('orders.all');

});

Route::group(['prefix' => 'admin'], function () {
//* password reset start */
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgot.password');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});

Route::get('/super-admin', [UserController::class, 'superAdmin']);
Route::post('/make/super/admin', [UserController::class, 'makeSuperAdmin'])->name('is.superadmin');

Route::get('/send-email/{token}', [ManagerController::class, 'registerNewManager'])->name('send.email');
Route::post('/sign-up', [ManagerController::class, 'userSignUp'])->name('user.sign.up');

Route::group(['prefix' => 'manager', 'middleware' => ['auth', 'manager']], function () {
    Route::get('dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::post('update/restaurant-status', [ManagerDashboardController::class, 'updateRestaurantStatus'])->name('manager.restaurant.status.update');

    /* Item Routes */
    Route::get('/items', [ItemController::class, 'itemsByManager'])->name('manager.restaurant.items');
    Route::post('/items', [ItemController::class, 'getItemsByCategory'])->name('category.items');
    Route::get('/item/combos', [ItemComboController::class, 'itemsCombosByManager'])->name('manager.restaurant.item.combos');
    Route::post('/available-status/update', [ItemComboController::class, 'updateAvailableStatus'])->name('item.combo.available.status.update');
    

    /* Order Routes */
    Route::get('/new-orders', [ManagerOrdersController::class, 'newOrders'])->name('manager.new.order');
    Route::get('/order-in-preparation', [ManagerOrdersController::class, 'ordersInPreparation'])->name('manager.order.in.preparation');
    Route::get('/order-in-delivery', [ManagerOrdersController::class, 'ordersInDelivery'])->name('manager.order.in.delivery');
    Route::get('/completed-orders', [ManagerOrdersController::class, 'completedOrders'])->name('manager.completed.order');
    Route::get('/cancelled-orders', [ManagerOrdersController::class, 'cancelledOrders'])->name('manager.cancelled.order');
    Route::post('/cancel-order', [ManagerOrdersController::class, 'cancelOrder'])->name('manager.order.cancel');
    Route::post('/accept-order', [ManagerOrdersController::class, 'acceptOrder'])->name('manager.order.accept.new_order');
    Route::post('/accept-order-in-delivery', [ManagerOrdersController::class, 'acceptOrderInDelivery'])->name('manager.order.accept.delivery');
    Route::post('/accept-order-in-preparation', [ManagerOrdersController::class, 'acceptOrderInPreparation'])->name('manager.order.accept.preparation');

    /* Performance report routes */
    Route::get('/daily-sales-report', [ManagerOrderPerformanceController::class, 'dailyReports'])->name('manager.daily.sales.report');
    Route::post('/daily-sales-report/by-date', [ManagerOrderPerformanceController::class, 'dailyReportsByDate'])->name('manager.daily.report.by.date');
    Route::get('/item-performance-report', [ManagerOrderPerformanceController::class, 'itemPerformanceReport'])->name('manager.item.performance.report');
    Route::post('/item-performance-report', [ManagerOrderPerformanceController::class, 'itemPerformanceReportByDate'])->name('manager.item.performance.by.date');

});

Route::get('/listen', function () {
    return view('pusher-test');
});

Route::get('test/new', function () {
    // event(new App\Events\MyEvent('You Have Three New Orders!'));
    // event(new App\Events\OrderEvent('You Have Three New Orders!'));
});

Route::get('/',[HomeController::class,'index'])->name('frontend.index');
Route::post('/',[HomeController::class,'getRestaurantsByLocation'])->name('frontend.restaurant.by.location');

Route::get('/restaurant/{restaurant}/menu',[RestaurantMenuController::class,'getRestaurant'])->name('frontend.restaurant.menu');
Route::get('/about-us',[FrontendAboutUsController::class,'index'])->name('frontend.about.us');
Route::get('/sign-in',[FrontendCustomerController::class,'customerSignIn'])->name('frontend.customer.sign.in');

 /* cart routes */
 Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('frontend.cart.add');
 Route::post('/upadte-cart',[CartController::class,'increaseCartQuantity'])->name('frontend.cart.update');
 Route::post('/decrease-cart',[CartController::class,'decreaseCartQuantity'])->name('frontend.cart.decrease.quantity');
 Route::post('/delete-cart',[CartController::class,'deleteCart'])->name('frontend.cart.delete');
 
 /* customer sign in */
 Route::post('/customer-sign-in',[FrontendCustomerController::class,'signIn'])->name('customer.sign.in');
 Route::post('/customer-sign-up',[FrontendCustomerController::class,'signUp'])->name('customer.sign.up');
 Route::post('/customer-sign-out',[FrontendCustomerController::class,'signOut'])->name('cusetomer.sign.out');

  /* customer profile */
 Route::get('/profile',[FrontendCustomerController::class,'customerProfile'])->name('customer.profile');
 Route::post('/profile/photo/update',[FrontendCustomerController::class,'customerProfilePhotoUpdate'])->name('customer.profile.photo.update');
 Route::post('/delivery/info/update',[FrontendCustomerController::class,'customerDeliveryInfoUpdate'])->name('customer.delivery.info.update');
 Route::post('/account/info/update',[FrontendCustomerController::class,'customerAccountInfoUpdate'])->name('customer.account.info.update');

  /* checkout */
 Route::get('/checkout',[CheckOutController::class,'index'])->name('frontend.chekout');
 Route::post('/place-order',[CheckOutController::class,'placeOrder'])->name('order.place');
 Route::get('/order-placed/{order}',[CheckOutController::class,'orderPlaced'])->name('order.placed');

 Route::get('/my-orders',[FrontendCustomerController::class,'customerOrders'])->name('frontend.customer.order');
 Route::post('/order-details',[FrontendCustomerController::class,'customerOrderDetails'])->name('frontend.customer.order.detail');


 Route::get('auth/facebook', [FrontendCustomerController::class, 'redirectToGoogle']);
Route::get('auth/facebook/callback', [FrontendCustomerController::class, 'handleGoogleCallback']);