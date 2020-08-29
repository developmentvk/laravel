<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group([
    'prefix' => 'v1',
    'namespace' => 'API\v1\User',
    'middleware' => ['language'],
], function ($router) {
    Route::post('app/settings', 'AuthController@siteConfig');
    Route::post('country', 'AuthController@country');
    Route::post('login', 'AuthController@login');
    Route::post('resend/otp', 'AuthController@resendOTP');
    Route::post('verify/otp', 'AuthController@verifyOtp');
    Route::post('refresh/token', 'AuthController@refreshToken');
    Route::post('update/fcm/token', 'AuthController@updateFCMToken');
    Route::post('logout', 'AuthController@logout');

    //Admin Routes
    Route::post('internal/settings', 'UserController@cdnInfo');
    Route::post('complete/profile', 'UserController@completeProfile');
    Route::post('get/profile', 'UserController@getProfile');
    Route::post('update/profile', 'UserController@updateProfile');
    Route::post('update/profile/image', 'UserController@updateProfileImage');
    Route::post('update/profile/cover', 'UserController@updateProfileCover');
    Route::post('change/password', 'UserController@changePassword');
    Route::post('check/username', 'UserController@checkUsername');
    Route::post('change/username', 'UserController@changeUsername');
    Route::post('change/privacy', 'UserController@changePrivacy');
    Route::post('change/notification/preference', 'UserController@changeNotificationPreference');
    Route::post('view/profile', 'UserController@viewProfile');
    Route::post('search/users', 'UserController@search');

    //Notification Routes
    Route::post('unread/notification/count', 'NotificationController@unreadNotificationCount');
    Route::post('notifications', 'NotificationController@notificationListings');
    Route::delete('delete/notification', 'NotificationController@deleteNotification');

    //Post Routes
    Route::post('submit/post', 'PostController@submitPost');
    Route::post('like/post', 'PostController@likePost');
    Route::delete('dislike/post', 'PostController@dislikePost');
    Route::post('submit/comment', 'PostController@submitComment');
    Route::post('submit/comment/reply', 'PostController@submitCommentReply');
    Route::post('like/comment', 'PostController@likeComment');
    Route::delete('dislike/comment', 'PostController@dislikeComment');
    Route::post('share/post', 'PostController@sharePost');
    Route::post('posts', 'PostController@posts');
    Route::post('hashtag/suggestion', 'PostController@hashtagSuggestion');
    Route::post('timeline', 'PostController@timeline');
    Route::post('video', 'PostController@video');
    Route::post('photo', 'PostController@photo');
    Route::post('view/post', 'PostController@viewPost');
    Route::post('post/likes', 'PostController@likes');
    Route::post('post/comments', 'PostController@comments');
    Route::post('comment/replies', 'PostController@commentReplies');
    Route::post('report/list', 'PostController@reportList');
    Route::post('report/post', 'PostController@reportPost');
    Route::delete('delete/post', 'PostController@deletePost');
    Route::post('edit/post', 'PostController@editPost');

    // Friend Routes
    Route::post('send/invitation', 'FriendController@sendInvitation');
    Route::delete('cancel/invitation', 'FriendController@cancelInvitation');
    Route::post('accept/invitation', 'FriendController@acceptInvitation');
    Route::delete('reject/invitation', 'FriendController@rejectInvitation');
    Route::delete('unfriend', 'FriendController@unfriend');
    Route::post('search/friends', 'FriendController@search');
    Route::post('friend/requests', 'FriendController@requests');

    // Follower Routes
    Route::post('follow', 'FollowerController@follow');
    Route::delete('unfollow', 'FollowerController@unfollow');
    Route::post('followers', 'FollowerController@followers');
    Route::post('following', 'FollowerController@following');
});
