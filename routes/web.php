<?php

use App\Helper\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::namespace('FrontEnd')->name('fe.')->group(function ()
{
    Route::view('/', 'frontend.index')->name('index');
    Route::view('/about', 'frontend.about')->name('about');
    Route::view('/landing', 'frontend.landing')->name('landing');
    Route::view('/disclaimer', 'frontend.disclaimer')->name('disclaimer');

    Route::get('/blogs', 'BlogController@index')->name('blogs.index');
    Route::get('blogs/{slug}', 'BlogController@show')->name('blogs.show');

    Route::get('/services/{slug}', 'ServiceController@show')->name('services.show');

    Route::get('/categories', 'CategoryController@index')->name('categories.index');
    Route::get('/categories/{slug}', 'CategoryController@show')->name('categories.show');

    Route::get('/tags', 'TagController@index')->name('tags.index');
    Route::get('/tags/{slug}', 'TagController@show')->name('tags.show');

    Route::get('/get-in-touch', 'EnquiryController@create')->name('enquiries.create');
    Route::post('/get-in-touch', 'EnquiryController@store')->name('enquiries.store');
});

Route::name('admin.')->prefix('cp')->middleware('auth')->group(function ()
{
    Route::get('/', function(){
        LogActivity::add('ActivityLabels::_LOGIN');
        return redirect()->route('admin.dashboard');
    }); // for do not delete

    Route::middleware('userLogin')->group(function(){
        Route::view('dashboard', 'cp.dashboard')->name('dashboard');
        Route::get('blogs', 'BlogController@blogs')->name('blogs');
        Route::get('testimonials','TestimonialController@testimonials')->name('testimonials');
        Route::get('categories', 'CategoryController@categories')->name('categories');
        Route::get('tags', 'TagController@tags')->name('tags');
        Route::get('services', 'ServiceController@services')->name('services');
        Route::view('galleries','cp.galleries')->name('galleries');
        Route::get('roles', 'RoleController@roles')->name('roles');
        Route::get('users', 'UserController@users')->name('users');
        Route::get('settings', 'SettingController@settings')->name('settings');
        Route::get('activities', 'ActivityController@activities')->name('activities');
        Route::get('pages', 'PageController@pages')->name('pages');
        Route::get('menus', 'MenuController@menus')->name('menus');
        Route::get('sliders', 'SliderController@sliders')->name('sliders');
        Route::get('brands', 'BrandController@brands')->name('brands');
        Route::get('attribute-groups', 'AttributeGroupController@attributeGroups')->name('attributeGroups');
        Route::get('attributes', 'AttributeController@attributes')->name('attributes');
        Route::get('products', 'ProductController@products')->name('products');




    });
    
});

//Api secured routes
Route::prefix('api')->middleware(['auth', 'settings'])->group(function () {
    //general routes
    Route::post('user-permissions', 'PermissionController@userPermissions');
    Route::post('status-change', 'Controller@statusChange');
    Route::post('delete-image', 'Controller@deleteimage');

    Route::post('get-all-active', 'Controller@getAllActive');
    Route::post('get-all-active-filtered', 'Controller@getAllActiveFiltered');
    Route::get('getall/{table}', 'Controller@getAll');

    Route::resource('settings', 'SettingController');
    Route::put('settings/edit/{id}', 'SettingController@update');

    //blog
    Route::apiResource('blogs', 'BlogController');
    Route::delete('delete-blog-image/{blog}', 'BlogController@deleteImage');
    //testimonial
    Route::apiResource('testimonials','TestimonialController');
    Route::delete('delete-testimonial-image/{testimonial}', 'TestimonialController@deleteImage');
    //enquiry
    Route::apiResource('enquiries','EnquiryController');
    Route::post('enquiry-reply', 'EnquiryController@reply');
    Route::post('mark_read_at', 'EnquiryController@mark_read_at');
    //comment
    Route::apiResource('comments','CommentController');
    //categorie

    Route::get('activities', 'ActivityController@index');
    Route::apiResource('categories', 'CategoryController');
    //gallery
    Route::apiResource('galleries', 'GalleryController');
    //tag
    Route::apiResource('tags', 'TagController');
    //role
    Route::apiResource('roles', 'RoleController');
    //products
    Route::apiResource('products', 'ProductController');
    Route::delete('delete-product-image/{product}', 'ProductController@deleteImage');
    //services
    Route::apiResource('services', 'ServiceController');
    Route::delete('delete-service-image/{service}', 'ServiceController@deleteImage');
    //pages
    Route::apiResource('pages', 'PageController');
    Route::delete('delete-page-image/{page}', 'PageController@deleteImage');
    //menus
    Route::apiResource('menus', 'MenuController');
    Route::delete('delete-menu-image/{menu}', 'MenuController@deleteImage');
    //Sliders
    Route::apiResource('sliders', 'SliderController');
    Route::delete('delete-slider-image/{slider}', 'SliderController@deleteImage');
    //brands
    Route::apiResource('brands', 'BrandController');
    Route::delete('delete-brand-image/{brand}','BrandController@deleteImage');
    //attribute-groups
    Route::apiResource('attributeGroups','AttributeGroupController');
    //attributes
    Route::apiResource('attributes','AttributeController');
    //user
    Route::apiResource('users', 'UserController');
    //Report Routes
    Route::post('activity-reports','DashboardController@activity_reports');
});

//Api non-secured routes
Route::prefix('api')->group(function () {
    //Route::post('send-enquiry-email', 'MailController@sendEnquiryEmail');
    Route::post('send-enquiry-email', 'EnquiryController@store');
    Route::post('post-a-comment', 'CommentController@store')->name('comments.store');

});

Auth::routes();
Route::redirect('/home', 'cp/dashboard')->name('home'); // do not delete
