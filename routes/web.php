<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\AssetTypeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\HomeHeroSectionController;
use App\Http\Controllers\Backend\ItemController;
use App\Http\Controllers\Backend\ManagerController;
use App\Http\Controllers\Backend\RestaurantController;
use App\Http\Controllers\ForgotPasswordController;
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
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
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

    });  //* Contact us route end */
  

    //* Asset Type route start */
    Route::group(['prefix' => 'asset-types'], function () {
        Route::get('/', [AssetTypeController::class, 'index'])->name('asset.type');
        Route::post('/store', [AssetTypeController::class, 'store'])->name('asset.type.store');
        Route::post('/edit', [AssetTypeController::class, 'edit'])->name('asset.type.edit');
        Route::post('/show', [AssetTypeController::class, 'show'])->name('asset.type.show');
        Route::post('/update', [AssetTypeController::class, 'update'])->name('asset.type.update');
        Route::post('/delete', [AssetTypeController::class, 'destroy'])->name('asset.type.delete');

    });  //* Asset Type route end */

    //* Restaurant route start */
    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('/', [RestaurantController::class, 'index'])->name('restaurant.index');
        Route::post('/store', [RestaurantController::class, 'store'])->name('restaurant.store');
        Route::post('/edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::post('/show', [RestaurantController::class, 'show'])->name('restaurant.show');
        Route::post('/update', [RestaurantController::class, 'update'])->name('restaurant.update');
        Route::post('/delete', [RestaurantController::class, 'destroy'])->name('restaurant.delete');
        Route::post('/deleteAsset', [RestaurantController::class, 'deleteAsset'])->name('restaurant.asset.delete');

    });  //* Restaurant route end */

    //* Restaurant Manager route start */
    Route::group(['prefix' => 'managers'], function () {
        Route::get('/', [ManagerController::class, 'index'])->name('restaurant.manager');
        Route::post('/store', [ManagerController::class, 'store'])->name('restaurant.manager.store');
        Route::post('/edit', [ManagerController::class, 'edit'])->name('restaurant.manager.edit');
        Route::post('/show', [ManagerController::class, 'show'])->name('restaurant.manager.show');
        Route::post('/update', [ManagerController::class, 'update'])->name('restaurant.manager.update');
        Route::post('/delete', [ManagerController::class, 'destroy'])->name('restaurant.manager.delete');
    });  //* Restaurant Manager route end */

    //* Item route start */
    Route::group(['prefix' => 'items'], function () {
        Route::get('/', [ItemController::class, 'index'])->name('item.index');
        Route::post('/store', [ItemController::class, 'store'])->name('item.store');
        Route::post('/edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/show', [ItemController::class, 'show'])->name('item.show');
        Route::post('/update', [ItemController::class, 'update'])->name('item.update');
        Route::post('/delete', [ItemController::class, 'destroy'])->name('item.delete');
        Route::post('/restaurant-items', [ItemController::class, 'getItemsByRestaurant'])->name('item.restaurant');
        Route::post('/available-status/update', [ItemController::class, 'updateAvailableStatus'])->name('item.available.status.update');
    });  //* Item route end */

    //* Category route start */
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('item.category.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('item.category.store');
        Route::post('/edit', [CategoryController::class, 'edit'])->name('item.category.edit');
        Route::post('/show', [CategoryController::class, 'show'])->name('item.category.show');
        Route::post('/update', [CategoryController::class, 'update'])->name('item.category.update');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('item.category.delete');
        Route::post('/restaurant-categories', [CategoryController::class, 'getCategoriesByRestaurant'])->name('item.category.restaurant');
       
    });  //* Category route end */
  

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