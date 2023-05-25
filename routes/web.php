<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [MainController::class,'getIndex']);

Route::get('login', [LoginController::class,'getLogin']);
Route::post('login', [LoginController::class,'postLogin']);
Route::get('register', [LoginController::class,'getRegister']);
Route::post('register', [LoginController::class,'postRegister']);
Route::get('logout', [LoginController::class,'getLogout']);

Route::get('products', [MainController::class,'getProducts']);
Route::get('product', [MainController::class,'getProduct']);
Route::get('add-product', [MainController::class,'getAddProduct']);
Route::post('add-product', [MainController::class,'postAddProduct']);
Route::get('edit-product', [MainController::class,'getEditProduct']);
Route::post('edit-product', [MainController::class,'postEditProduct']);
Route::get('disable-product', [MainController::class,'getDisableProduct']);
Route::get('delete-product', [MainController::class,'getDeleteProduct']);

Route::get('users', [MainController::class,'getUsers']);
Route::get('user', [MainController::class,'getUser']);
Route::post('user', [MainController::class,'postUser']);
Route::get('edu', [MainController::class,'getManageUserStatus']);

Route::get('categories', [MainController::class,'getCategories']);
Route::get('add-category', [MainController::class,'getAddCategory']);
Route::post('add-category', [MainController::class,'postAddCategory']);
Route::get('edit-category', [MainController::class,'getEditCategory']);
Route::post('edit-category', [MainController::class,'postEditCategory']);

Route::get('ads', [MainController::class,'getAds']);
Route::get('new-ad', [MainController::class,'getAddAd']);
Route::post('new-ad', [MainController::class,'postAddAd']);
Route::get('edit-ad', [MainController::class,'getEditAd']);
Route::post('edit-ad', [MainController::class,'postEditAd']);

Route::get('banners', [MainController::class,'getBanners']);
Route::get('new-banner', [MainController::class,'getAddBanner']);
Route::post('new-banner', [MainController::class,'postAddBanner']);
Route::get('edit-banner', [MainController::class,'getEditBanner']);
Route::post('edit-banner', [MainController::class,'postEditBanner']);

Route::get('set-cover-img', [MainController::class,'getSetCoverImage']);
Route::get('delete-img', [MainController::class,'getDeleteImage']);

Route::get('reviews', [MainController::class,'getReviews']);
Route::get('edit-review', [MainController::class,'getEditReview']);
Route::post('edit-review', [MainController::class,'postEditReview']);

Route::get('order-reviews', [MainController::class,'getOrderReviews']);
Route::get('update-order-review', [MainController::class,'getUpdateOrderReview']);
Route::get('track', [MainController::class,'getTrackings']);
Route::get('new-tracking', [MainController::class,'getAddTracking']);
Route::post('new-tracking', [MainController::class,'postAddTracking']);

Route::get('orders', [MainController::class,'getOrders']);
Route::get('ask-for-review', [MainController::class,'getAskForReview']);
Route::get('reports', [MainController::class,'getReports']);
Route::get('report', [MainController::class,'getReport']);
Route::get('new-order', [MainController::class,'getAddOrder']);
Route::get('aba', [MainController::class,'getTestAddOrder']);
Route::post('new-order', [MainController::class,'postAddOrder']);
Route::get('edit-order', [MainController::class,'getEditOrder']);
Route::post('edit-order', [MainController::class,'postEditOrder']);
Route::get('delete-order', [MainController::class,'getDeleteOrder']);

Route::get('new-discount', [MainController::class,'getAddDiscount']);
Route::post('new-discount', [MainController::class,'postAddDiscount']);
Route::get('discounts', [MainController::class,'getDiscounts']);
Route::get('edit-discount', [MainController::class,'getEditDiscount']);
Route::post('edit-discount', [MainController::class,'postEditDiscount']);
Route::get('delete-discount', [MainController::class,'getDeleteDiscount']);

Route::get('confirm-payment', [MainController::class,'getConfirmPayment']);

Route::get('carts', [MainController::class,'getUserCarts']);
Route::get('but', [MainController::class,'getBulkUpdateTracking']);
Route::post('but', [MainController::class,'postBulkUpdateTracking']);
Route::get('bcp', [MainController::class,'getBulkConfirmPayment']);
Route::post('bcp', [MainController::class,'postBulkConfirmPayment']);
Route::get('bup', [MainController::class,'getBulkUpdateProducts']);
Route::post('bup', [MainController::class,'postBulkUpdateProducts']);
Route::get('buup', [MainController::class,'getBulkUploadProducts']);
Route::post('buup', [MainController::class,'postBulkUploadProducts']);

Route::get('add-setting', [MainController::class,'getAddSetting']);
Route::get('settings', [MainController::class,'getSettings']);
Route::get('senders', [MainController::class,'getSenders']);
Route::get('add-sender', [MainController::class,'getAddSender']);
Route::post('add-sender', [MainController::class,'postAddSender']);
Route::get('sender', [MainController::class,'getSender']);
Route::post('sender', [MainController::class,'postSender']);
Route::get('remove-sender', [MainController::class,'getRemoveSender']);
Route::get('mark-sender', [MainController::class,'getMarkSender']);

Route::get('gdf', [MainController::class,'getDeliveryFee']);
Route::post('settings-delivery', [MainController::class,'postSettingsDelivery']);
Route::post('settings-sender', [MainController::class,'postSettingsSender']);
Route::post('settings-bank', [MainController::class,'postSettingsBank']);
Route::post('settings-discount', [MainController::class,'postSettingsDiscount']);

Route::get('plugins', [MainController::class,'getPlugins']);
Route::get('add-plugin', [MainController::class,'getAddPlugin']);
Route::post('add-plugin', [MainController::class,'postAddPlugin']);
Route::get('plugin', [MainController::class,'getPlugin']);
Route::post('plugin', [MainController::class,'postPlugin']);
Route::get('remove-plugin', [MainController::class,'getRemovePlugin']);

Route::get('couriers', [MainController::class,'getCouriers']);
Route::get('add-courier', [MainController::class,'getAddCourier']);
Route::post('add-courier', [MainController::class,'postAddCourier']);
Route::get('courier', [MainController::class,'getCourier']);
Route::post('courier', [MainController::class,'postCourier']);
Route::get('remove-courier', [MainController::class,'getRemoveCourier']);

Route::get('analytics', [MainController::class,'getAnalytics']);
Route::post('analytics', [MainController::class,'postAnalytics']);
Route::get('facebook-catalog', [MainController::class,'getFacebookCatalog']);
Route::post('facebook-catalog', [MainController::class,'postFacebookCatalog']);
Route::get('facebook-catalog-add', [MainController::class,'getFacebookCatalogAdd']);
Route::post('facebook-catalog-add', [MainController::class,'postFacebookCatalogAdd']);
Route::get('facebook-catalog-update', [MainController::class,'getFacebookCatalogUpdate']);
Route::post('facebook-catalog-update', [MainController::class,'postFacebookCatalogUpdate']);
Route::get('facebook-catalog-delete', [MainController::class,'getFacebookCatalogUpdate']);
Route::post('facebook-catalog-delete', [MainController::class,'postFacebookCatalogDelete']);

Route::get('apitest', [MainController::class,'getAPITest']);

Route::get('get-fb-token', [MainController::class,'getFbToken']);
Route::get('save-fb-token', [MainController::class,'saveFbToken']);


