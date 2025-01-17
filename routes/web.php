<?php

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

/* 
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
*/

Auth::routes();
Route::get('home', 'Auth\LoginController@redirectAfterLogin');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('manage/heyCheck', 'Front\FrontController@heyCheck');
//Route::get('postsConverter', 'Front\TestController@postsConverter');

/*
|--------------------------------------------------------------------------
| Manage Side
|--------------------------------------------------------------------------
|
*/
Route::group([
	'prefix' => "manage",
	'middleware' => ['auth', 'is:admin'],
	'namespace' => "Manage",
], function () {
	Route::get('/', 'HomeController@index');
	Route::get('/index', 'HomeController@index');
	Route::get('/account', 'HomeController@account');
	Route::post('/password', 'HomeController@changePassword');

	/*-----------------------------------------------
	| Admins ...
	*/
	//Route::group(['prefix' => 'admins', 'middleware' => 'is:super'], function () {
	//	Route::get('/update/{item_id}/{adding?}', 'AdminsController@update');
	//	Route::get('/', 'AdminsController@browse');
	//	Route::get('/browse/{request_tab?}', 'AdminsController@browse');
	//	Route::get('/create/', 'AdminsController@create');
	//	Route::get('/search', 'AdminsController@search');
	//	Route::get('/{user_id}/{modal_action}', 'AdminsController@singleAction');
	//
	//	Route::group(['prefix' => 'save'], function () {
	//		Route::post('/', 'AdminsController@save');
	//
	//		Route::post('/password', 'AdminsController@password');
	//		Route::post('/delete', 'AdminsController@delete');
	//		Route::post('/undelete', 'AdminsController@undelete');
	//		Route::post('/destroy', 'AdminsController@destroy');
	//		Route::post('/permits', 'AdminsController@permits');
	//	});
	//});

	/*-----------------------------------------------
	| Users ...
	*/
	Route::group(['prefix' => "users", 'middleware' => "can:users",], function () {
		Route::get('/update/{item_id}', 'UsersController@update');
		Route::get('browse/{role}/search/{keyword?}', 'UsersController@search');
		Route::get('browse/{role}/{request_tab?}', 'UsersController@browse');
		Route::get('create/{role}', 'UsersController@create');
		Route::get('/act/{model_id}/{action}/{option?}', 'UsersController@singleAction');

		Route::group(['prefix' => 'save'], function () {
			Route::post('/', 'UsersController@save');
			Route::post('/password', 'UsersController@savePassword');
			Route::post('/permits', 'UsersController@savePermits');
			Route::post('/role', 'UsersController@saveRole');
			Route::post('/delete', 'UsersController@delete');
			Route::post('/undelete', 'UsersController@undelete');
			Route::post('/destroy', 'UsersController@destroy');
			Route::post('/receipt' , 'UsersController@saveNewReceipt');
		});
	});

	/*-----------------------------------------------
	| Comments ...
	*/
	Route::group(['prefix' => 'comments' , 'middleware' => 'can:comments'] , function() {
		Route::get('/update/{item_id}', 'CommentsController@update');
		Route::get('/act/{model_id}/{action}', 'CommentsController@singleAction');
		Route::get('{request_tab?}/{switches?}' , 'CommentsController@browse');
		Route::group(['prefix' => 'save'], function () {
			Route::post('/', 'CommentsController@save');
			Route::post('/process' , 'CommentsController@process');
			Route::post('/delete', 'CommentsController@delete');
			Route::post('/deleteMass' , 'CommentsController@deleteMass');
			Route::post('/undelete', 'CommentsController@undelete');
			Route::post('/undeleteMass', 'CommentsController@undeleteMass');
			Route::post('/destroy', 'CommentsController@destroy');
			Route::post('/destroyMass', 'CommentsController@destroyMass');
			Route::post('/statusMass', 'CommentsController@statusMass');
		});

	});



	/*-----------------------------------------------
	| Posts ...
	*/
	Route::group(['prefix' => 'posts'], function () {
		Route::get('/update/{item_id}', 'PostsController@update');
		Route::get('/tab_update/{posttype}/{request_tab?}/{switches?}', 'PostsController@tabUpdate');

		Route::get('/act/{model_id}/{action}/{option?}', 'PostsController@singleAction');
		Route::get('/check_slug/{id}/{type}/{locale}/{slug?}/p', 'PostsController@checkSlug');

		Route::get('/{posttype}', 'PostsController@browse');
		Route::get('/{posttype}/create/{locale?}/{sisterhood?}', 'PostsController@create');
		Route::get('{posttype}/edit/{post_id}', 'PostsController@editor');
		//		Route::get('{posttype}/searched' , 'PostsController@searchResult');
		Route::get('{posttype}/{locale}/search', 'PostsController@search');
		Route::get('/{posttype}/{request_tab?}/{switches?}', 'PostsController@browse');

		Route::group(['prefix' => 'save'], function () {
			Route::post('/', 'PostsController@save');
			Route::post('/delete', 'PostsController@delete');
			Route::post('/undelete', 'PostsController@undelete');
			Route::post('/destroy', 'PostsController@destroy');
			Route::post('/clone', 'PostsController@makeClone');
			Route::post('/deleteMass' , 'PostsController@deleteMass');
			Route::post('/undeleteMass', 'PostsController@undeleteMass');
			Route::post('/destroyMass', 'PostsController@destroyMass');
			Route::post('/owner', 'PostsController@changeOwner');
		});

	});

	/*-----------------------------------------------
	| Club ...
	*/
	Route::group(['prefix' => "club",] , function() {
		Route::group(['prefix' => 'save'], function () {
			Route::post('/draw_prepare' , 'ClubController@drawPrepare');
			Route::post('/draw_select' , 'ClubController@drawSelect');
			Route::get('/draw_delete/{key}' , 'ClubController@drawDelete');
		});
	});




	/*-----------------------------------------------
	| Settings ...
	*/
	Route::group(['prefix' => 'settings', 'middleware' => 'can:super'], function () {
		Route::get('/', 'SettingsController@index');
		Route::get('/tab/{request_tab?}', 'SettingsController@index');
		Route::get('/search', 'SettingsController@search');
		Route::get('/update/{model_id}', 'SettingsController@update');
		Route::get('/act/{model_id}/{action}/{option?}', 'SettingsController@singleAction');

		Route::group(['prefix' => 'save'], function () {
			Route::post('/', 'SettingsController@save');
			Route::post('/posttype', 'SettingsController@savePosttypeDownstream');
		});
	});

	/*-----------------------------------------------
	| Categories ...
	*/
	Route::group(['prefix' => 'categories', 'middleware' => 'can:super'], function () {
		Route::get('/' , 'CategoriesController@index');
		Route::get('/update/{id}' , 'CategoriesController@update');
		Route::get('/browse/{type}/{locale}' , 'CategoriesController@index');
		Route::get('/create/folder/{type}/{locale}' , 'CategoriesController@createFolder');
		Route::get('/create/{folder_id}/' , 'CategoriesController@createCategory');
		Route::get('/edit/folder/{folder_id}' , 'CategoriesController@editFolder');
		Route::get('/edit/{category_id}' , 'CategoriesController@editCategory');
		Route::group(['prefix' => 'save'], function () {
			Route::post('' , 'CategoriesController@saveCategory');
			Route::post('folder' , 'CategoriesController@saveFolder');
		});
	});


	/*-----------------------------------------------
	| Upstream ...
	*/
	Route::group(['prefix' => 'upstream', 'middleware' => 'is:developer'], function () {
		Route::get('/{request_tab?}', 'UpstreamController@index');
		Route::get('/{request_tab}/search/', 'UpstreamController@search');
		Route::get('/edit/{request_tab?}/{item_id?}/{parent_id?}', 'UpstreamController@editor');
		Route::get('/{request_tab}/{item_id}/{parent_id?}', 'UpstreamController@item');

		Route::group(['prefix' => 'save'], function () {
			Route::post('role', 'UpstreamController@saveRole');
			Route::post('state', 'UpstreamController@saveProvince');
			Route::post('city', 'UpstreamController@saveCity');
			Route::post('posttype', 'UpstreamController@savePosttype');
			Route::post('department', 'UpstreamController@saveDepartment');
			Route::post('category', 'UpstreamController@saveCategory');
			Route::post('downstream', 'UpstreamController@saveDownstream');
			Route::post('package', 'UpstreamController@savePackage');
			Route::post('login_as', 'UpstreamController@loginAs');
		});
	});
});


/*
|--------------------------------------------------------------------------
| Front Side
|--------------------------------------------------------------------------
|
*/
Route::group(['namespace' => 'Auth', 'prefix' => '{lang}', 'middleware' => ['DetectLanguage', 'Setting']], function () {
	// reset password
	Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm');
	Route::post('/password/reset', 'ForgotPasswordController@sendResetLinkEmail');
	Route::get('/password/token', 'ForgotPasswordController@getToken');
	Route::post('/password/token', 'ForgotPasswordController@checkToken');
	Route::get('/password/new', 'ForgotPasswordController@newPassword');
	Route::post('/password/new', 'ForgotPasswordController@changePassword');

});


Route::group(['namespace' => 'Front', 'middleware' => ['DetectLanguage', 'Setting']], function () {
    Route::get('/', 'FrontController@index');
    Route::get('/hadi', 'TestController@index');
    Route::post('/register/new', 'FrontController@register');

    // drawing code
    Route::post('/drawing/check', 'DrawingCodeController@sumbitCode');

    Route::group(['prefix' => '{lang}', 'middleware' => ['UserIpDetect']], function () {

        Route::get('/', 'FrontController@index');

        // test view TODO: remove this route and related function
        Route::get('test/cart', 'FrontController@testCart');

        // saving comments for all posts
        Route::post('/comment', 'PostController@submit_comment');

        // search in all posts
        Route::get('/posts/search', 'PostController@search');

        // products
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'ProductsController@index');
            Route::post('filter', 'ProductsController@ajaxFilter');
            Route::get('{identifier}', 'ProductsController@showProduct')
                ->where('identifier', '^pd-(\w|-)+$'); // if identifier starts with "pd-"
            Route::get('{folder}/{category?}', 'ProductsController@products');
//            Route::get('categories/{slug}', 'ProductsController@products');
        });

        // news
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', 'NewsController@archive');
            Route::get('{identifier}', 'NewsController@single')
                ->where('identifier', '^nw-(\w|-)+$'); // if identifier starts with "nw-"
        });

        // faqs
        Route::group(['prefix' => 'faqs'], function () {
            Route::get('/', 'FaqsController@archive');
            Route::get('{identifier}', 'FaqsController@single')
                ->where('identifier', '^faq-(\w|-)+$'); // if identifier starts with "faq-"
        });

        // teammates
        Route::group(['prefix' => 'teammates'], function () {
            Route::get('/', 'TeammatesController@archive');
            Route::get('{identifier}', 'TeammatesController@single')
                ->where('identifier', '^tm-(\w|-)+$'); // if identifier starts with "tm-"
        });

        // teammates
        Route::group(['prefix' => 'events'], function () {
            Route::get('/', 'EventsController@archive');
            Route::get('waiting', 'EventsController@waitingEvents');
            Route::get('expired', 'EventsController@expiredEvents');
//            Route::get('{identifier}', 'TeammatesController@single')
//                ->where('identifier', '^tm-(\w|-)+$'); // if identifier starts with "tm-"
        });

        Route::get('/page/{slug}', 'PostController@page');

        // user Route
        Route::group(['prefix' => 'user', 'middleware' => ['auth', 'is:customer']], function () {
            Route::get('/dashboard', 'UserController@index');
            Route::get('/dashboard/previous_comments/{post_id}', 'UserController@previousComments');
            Route::get('/profile', 'UserController@profile');
            Route::post('/profile/update', 'UserController@update');
            Route::get('/drawing',  'UserController@drawing');
            Route::get('/events', 'UserController@events');
        });
    });

});
