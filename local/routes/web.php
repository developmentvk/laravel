<?php

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

Route::group([
    'namespace' => 'Site',
    'middleware' => ['optimizeImages', 'language'],
], function () {
    Route::get('/', [
        'uses' => 'HomeController@getSoon',
        'as' => 'home.soon',
    ]);
    Route::get('{locale?}', [
        'uses' => 'HomeController@getIndex',
        'as' => 'home',
    ])->where('locale', '(en|ar)');
});

Route::group([
    'namespace' => 'Admin',
    'prefix' => env('urlPrefix'),
    'middleware' => ['language', 'assign.guard:admin', 'optimizeImages'],
], function () {
    Route::get('/', [
        'uses' => 'LoginController@index',
        'as' => 'login',
    ]);
    Route::get('login', [
        'uses' => 'LoginController@index',
        'as' => 'admin.login',
    ]);
    Route::post('validate/login', [
        'uses' => 'LoginController@validateLogin',
        'as' => 'validate.admin.login',
    ]);
    Route::get('forgot-password', [
        'uses' => 'LoginController@getForgotPassword',
        'as' => 'admin.forgot.password',
    ]);
    Route::post('forgot-password/generate-link', [
        'uses' => 'LoginController@generateForgotPasswordLink',
        'as' => 'admin.forgot.password.generate.link',
    ]);
    Route::get('create-password/{remember_token?}/{id?}', [
        'uses' => 'LoginController@createForgotPassword',
        'as' => 'admin.forgot.password.link',
    ]);
    Route::post('update-new-password/{remember_token?}/{id?}', [
        'uses' => 'LoginController@updateNewPassword',
        'as' => 'admin.update.new.password',
    ]);

    Route::group([
        'middleware' => ['auth:admin'],
    ], function () {
        //Dashboard Routes
        Route::get('dashboard', [
            'uses' => 'DashboardController@getIndex',
            'as' => 'admin.dashboard',
        ]);
        Route::get('dashboard/stats', [
            'uses' => 'DashboardController@getStats',
            'as' => 'admin.dashboard.stats',
        ]);

        // Login Routes
        Route::get('logout', [
            'uses' => 'LoginController@getLogout',
            'as' => 'admin.logout',
        ]);
        //Navigation Routes
        Route::get('navigation', [
            'uses' => 'NavigationController@getIndex',
            'as' => 'admin.navigation.index',
        ]);
        Route::get('navigation/create', [
            'uses' => 'NavigationController@getCreate',
            'as' => 'admin.navigation.create',
        ]);
        Route::post('navigation/create', [
            'uses' => 'NavigationController@postCreate',
            'as' => 'admin.navigation.create',
        ]);
        Route::get('navigation/listings', [
            'uses' => 'NavigationController@listings',
            'as' => 'admin.navigation.listings',
        ]);
        Route::get('navigation/delete/{id?}', [
            'uses' => 'NavigationController@delete',
            'as' => 'admin.navigation.delete',
        ]);
        Route::get('navigation/update/{id?}', [
            'uses' => 'NavigationController@getUpdate',
            'as' => 'admin.navigation.update',
        ]);
        Route::post('navigation/update/{id?}', [
            'uses' => 'NavigationController@postUpdate',
            'as' => 'admin.navigation.update',
        ]);
        //Admin Routes
        Route::get('admin', [
            'uses' => 'AdminController@getIndex',
            'as' => 'admin.admin.index',
        ]);
        Route::get('admin/create', [
            'uses' => 'AdminController@getCreate',
            'as' => 'admin.admin.create',
        ]);
        Route::post('admin/create', [
            'uses' => 'AdminController@postCreate',
            'as' => 'admin.admin.create',
        ]);
        Route::get('admin/listings/{id?}', [
            'uses' => 'AdminController@listings',
            'as' => 'admin.admin.listings',
        ]);
        Route::get('admin/delete/{id?}', [
            'uses' => 'AdminController@delete',
            'as' => 'admin.admin.delete',
        ]);
        Route::get('admin/view/{id?}', [
            'uses' => 'AdminController@view',
            'as' => 'admin.admin.view',
        ]);
        Route::get('admin/update/{id?}', [
            'uses' => 'AdminController@getUpdate',
            'as' => 'admin.admin.update',
        ]);
        Route::post('admin/update/{id?}', [
            'uses' => 'AdminController@postUpdate',
            'as' => 'admin.admin.update',
        ]);
        Route::get('admin/update/profile/{id?}', [
            'uses' => 'AdminController@getUpdateProfile',
            'as' => 'admin.admin.update.profile',
        ]);
        Route::post('admin/update/profile/{id?}', [
            'uses' => 'AdminController@postUpdateProfile',
            'as' => 'admin.admin.update.profile',
        ]);
        Route::get('admin/change-password/{id?}', [
            'uses' => 'AdminController@getChangePassword',
            'as' => 'admin.admin.change-password',
        ]);
        Route::post('admin/change-password/{id?}', [
            'uses' => 'AdminController@postChangePassword',
            'as' => 'admin.admin.change-password',
        ]);
        Route::get('admin/permission/{id?}', [
            'uses' => 'AdminController@getPermission',
            'as' => 'admin.admin.permission',
        ]);
        Route::post('admin/permission/{id?}', [
            'uses' => 'AdminController@postPermission',
            'as' => 'admin.admin.permission',
        ]);
        Route::get('admin/change/lang/{lang?}', [
            'uses' => 'AdminController@getChangeLang',
            'as' => 'admin.change.lang',
        ]);
        //Department Routes
        Route::get('departments', [
            'uses' => 'DepartmentController@getIndex',
            'as' => 'admin.department.index',
        ]);
        Route::get('department/create', [
            'uses' => 'DepartmentController@getCreate',
            'as' => 'admin.department.create',
        ]);
        Route::post('department/create', [
            'uses' => 'DepartmentController@postCreate',
            'as' => 'admin.department.create',
        ]);
        Route::get('department/listings', [
            'uses' => 'DepartmentController@listings',
            'as' => 'admin.department.listings',
        ]);
        Route::get('department/delete/{id?}', [
            'uses' => 'DepartmentController@delete',
            'as' => 'admin.department.delete',
        ]);
        Route::get('department/update/{id?}', [
            'uses' => 'DepartmentController@getUpdate',
            'as' => 'admin.department.update',
        ]);
        Route::post('department/update/{id?}', [
            'uses' => 'DepartmentController@postUpdate',
            'as' => 'admin.department.update',
        ]);
        Route::get('department/permission/{id?}', [
            'uses' => 'DepartmentController@getPermission',
            'as' => 'admin.department.permission',
        ]);
        Route::post('department/permission/{id?}', [
            'uses' => 'DepartmentController@postPermission',
            'as' => 'admin.department.permission',
        ]);
        // Notification Controller Routes
        Route::get('notification', [
            'uses' => 'NotificationController@getIndex',
            'as' => 'admin.notification.index',
        ]);
        Route::get('notification/send', [
            'uses' => 'NotificationController@getSend',
            'as' => 'admin.notification.send',
        ]);
        Route::post('notification/send', [
            'uses' => 'NotificationController@postSend',
            'as' => 'admin.notification.send',
        ]);
        Route::get('notification/listing', [
            'uses' => 'NotificationController@getListings',
            'as' => 'admin.notification.listing',
        ]);
        Route::get('notification/delete/{id?}', [
            'uses' => 'NotificationController@getDelete',
            'as' => 'admin.notification.delete',
        ]);
        Route::post('/filter/notification/users', [
            'uses' => 'NotificationController@filterNotificationUsers',
            'as' => 'admin.filter.notification.users',
        ]);
        Route::get('notification/view-receivers/{id?}', [
            'uses' => 'NotificationController@viewReceivers',
            'as' => 'admin.notification.view-receivers',
        ]);
        Route::get('notification/receivers/listing/{id?}', [
            'uses' => 'NotificationController@getReceiversListings',
            'as' => 'admin.notification.receivers.listing',
        ]);

        
        //Feedback Routes
        Route::get('feedback', [
            'uses' => 'FeedbackController@getIndex',
            'as' => 'admin.feedback.index',
        ]);
        Route::get('feedback/listings', [
            'uses' => 'FeedbackController@listings',
            'as' => 'admin.feedback.listings',
        ]);
        Route::get('feedback/delete/{id?}', [
            'uses' => 'FeedbackController@getDelete',
            'as' => 'admin.feedback.delete',
        ]);

        //User Routes
        Route::get('user', [
            'uses' => 'UserController@getIndex',
            'as' => 'admin.user.index',
        ]);
        Route::get('user/listings', [
            'uses' => 'UserController@listings',
            'as' => 'admin.user.listings',
        ]);
        Route::post('user/chart', [
            'uses' => 'UserController@postChart',
            'as' => 'admin.user.chart',
        ]);
        Route::get('user/delete/{id?}', [
            'uses' => 'UserController@getDelete',
            'as' => 'admin.user.delete',
        ]);
        Route::get('user/create', [
            'uses' => 'UserController@getCreate',
            'as' => 'admin.user.create',
        ]);
        Route::post('user/create', [
            'uses' => 'UserController@postCreate',
            'as' => 'admin.user.create',
        ]);
        Route::get('user/update/{id?}', [
            'uses' => 'UserController@getUpdate',
            'as' => 'admin.user.update',
        ]);
        Route::post('user/update/{id?}', [
            'uses' => 'UserController@postUpdate',
            'as' => 'admin.user.update',
        ]);
        Route::get('user/change-password/{id?}', [
            'uses' => 'UserController@getChangePassword',
            'as' => 'admin.user.change-password',
        ]);
        Route::post('user/change-password/{id?}', [
            'uses' => 'UserController@postChangePassword',
            'as' => 'admin.user.change-password',
        ]);
        Route::get('user/view/{id?}', [
            'uses' => 'UserController@getView',
            'as' => 'admin.user.view',
        ]);

        //Country Routes
        Route::get('country', [
            'uses' => 'CountryController@getIndex',
            'as' => 'admin.country.index',
        ]);
        Route::get('country/listings', [
            'uses' => 'CountryController@listings',
            'as' => 'admin.country.listings',
        ]);
        Route::get('country/delete/{id?}', [
            'uses' => 'CountryController@getDelete',
            'as' => 'admin.country.delete',
        ]);
        Route::get('country/create', [
            'uses' => 'CountryController@getCreate',
            'as' => 'admin.country.create',
        ]);
        Route::post('country/create', [
            'uses' => 'CountryController@postCreate',
            'as' => 'admin.country.create',
        ]);
        Route::get('country/update/{id?}', [
            'uses' => 'CountryController@getUpdate',
            'as' => 'admin.country.update',
        ]);
        Route::post('country/update/{id?}', [
            'uses' => 'CountryController@postUpdate',
            'as' => 'admin.country.update',
        ]);

        //Config Routes
        Route::get('setting', [
            'uses' => 'SettingsController@getIndex',
            'as' => 'admin.setting.index',
        ]);
        Route::post('setting/update', [
            'uses' => 'SettingsController@postUpdate',
            'as' => 'admin.settings.update',
        ]);

        //Report List Routes
        Route::get('report-list', [
            'uses' => 'ReportListController@getIndex',
            'as' => 'admin.report-list.index',
        ]);
        Route::post('report-list/order/update', [
            'uses' => 'ReportListController@updateFieldOrder',
            'as' => 'admin.report-list.order.update',
        ]);
        Route::get('report-list/delete/{id?}', [
            'uses' => 'ReportListController@getDelete',
            'as' => 'admin.report-list.delete',
        ]);
        Route::get('report-list/create', [
            'uses' => 'ReportListController@getCreate',
            'as' => 'admin.report-list.create',
        ]);
        Route::post('report-list/create', [
            'uses' => 'ReportListController@postCreate',
            'as' => 'admin.report-list.create',
        ]);
        Route::get('report-list/update/{id?}', [
            'uses' => 'ReportListController@getUpdate',
            'as' => 'admin.report-list.update',
        ]);
        Route::post('report-list/update/{id?}', [
            'uses' => 'ReportListController@postUpdate',
            'as' => 'admin.report-list.update',
        ]);
       
    });
});
