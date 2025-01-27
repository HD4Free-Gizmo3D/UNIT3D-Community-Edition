<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['middleware' => 'language'], function () {

    /*
    |------------------------------------------
    | Website (Not Authorized)
    |------------------------------------------
    */
    Route::group(['before' => 'auth', 'middleware' => 'guest'], function () {
        // Authentication Routes
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login')->name('');

        // Password Reset Routes
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('');
        Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

        // Registration Routes
        Route::get('/register/{code?}', 'Auth\RegisterController@registrationForm')->name('registrationForm');
        Route::post('/register/{code?}', 'Auth\RegisterController@register')->name('register');

        // Application Routes
        Route::get('/application', 'Auth\ApplicationController@create')->name('application.create');
        Route::post('/application', 'Auth\ApplicationController@store')->name('application.store');

        // Activation Routes
        Route::get('/activate/{token}', 'Auth\ActivationController@activate')->name('activate');

        // Forgot Username Routes
        Route::get('username/reminder', 'Auth\ForgotUsernameController@showForgotUsernameForm')->name('username.request');
        Route::post('username/reminder', 'Auth\ForgotUsernameController@sendUsernameReminder')->name('username.email');
    });

    Route::group(['before' => 'auth'], function () {
        // Announce
        Route::get('/announce/{passkey}', 'AnnounceController@announce')->name('announce');

        // RSS Custom Routes (RSS Key Auth)
        Route::get('/rss/{id}.{rsskey}', 'RssController@show')->name('rss.show.rsskey');
        Route::get('/torrent/download/{slug}.{id}.{rsskey}', 'TorrentController@download')->name('torrent.download.rsskey');
    });

    /*
    |------------------------------------------
    | Website (When Authorized)
    |------------------------------------------
    */
    Route::group(['middleware' => ['auth', 'twostep', 'banned']], function () {

        // RSS Custom Routes
        Route::get('/rss#{hash?}', 'RssController@index')->name('rss.index.hash');

        // RSS CRUD
        Route::resource('rss', 'RssController')->except([
            'show',
        ]);

        // Two Step Auth
        Route::get('/twostep/needed', 'Auth\TwoStepController@showVerification')->name('verificationNeeded');
        Route::post('/twostep/verify', 'Auth\TwoStepController@verify')->name('verify');
        Route::post('/twostep/resend', 'Auth\TwoStepController@resend')->name('resend');

        // General
        Route::get('/', 'HomeController@home')->name('home');
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        // Article
        Route::get('/articles', 'ArticleController@articles')->name('articles');
        Route::get('/articles/{slug}.{id}', 'ArticleController@post')->name('article');

        // Bonus System
        Route::get('/bonus', 'BonusController@bonus')->name('bonus');
        Route::get('/bonus/gifts', 'BonusController@gifts')->name('bonus_gifts');
        Route::get('/bonus/tips', 'BonusController@tips')->name('bonus_tips');
        Route::get('/bonus/store', 'BonusController@store')->name('bonus_store');
        Route::get('/bonus/gift', 'BonusController@gift')->name('bonus_gift');
        Route::post('/bonus/exchange/{id}', 'BonusController@exchange')->name('bonus_exchange');
        Route::post('/bonus/gift', 'BonusController@sendGift')->name('bonus_send_gift');

        // Bookmarks
        Route::get('/{slug}.{id}/bookmarks', 'UserController@bookmarks')->name('user_bookmarks');
        Route::get('/torrents/bookmark/{id}', 'TorrentController@bookmark')->name('bookmark');
        Route::get('/torrents/unbookmark/{id}', 'TorrentController@unBookmark')->name('unbookmark');

        // User Reports
        Route::post('/report/torrent/{slug}.{id}', 'ReportController@torrent')->name('report_torrent');
        Route::post('/report/request/{id}', 'ReportController@request')->name('report_request');
        Route::post('/report/user/{username}.{id}', 'ReportController@user')->name('report_user');

        // Bug Report
        Route::get('/bug', 'BugController@bugForm')->name('bug');
        Route::post('/bug', 'BugController@bug')->name('postBug');

        // Category
        Route::get('/categories', 'CategoryController@categories')->name('categories');
        Route::get('/categories/{slug}.{id}', 'CategoryController@category')->name('category');

        // Contact Us
        Route::get('/contact', 'ContactController@index')->name('contact');
        Route::post('/contact', 'ContactController@contact')->name('sendContact');

        // Page
        Route::get('/page/{slug}.{id}', 'PageController@page')->name('page');

        // Staff List
        Route::get('/staff', 'PageController@staff')->name('staff');

        // Internals List
        Route::get('/internal', 'PageController@internal')->name('internal');

        // Client Blacklist
        Route::get('/blacklist', 'PageController@blacklist')->name('blacklist');

        // About Us
        Route::get('/aboutus', 'PageController@about')->name('about');

        // Email Whitelist / Blacklist
        Route::get('/emaillist', 'PageController@emailList')->name('emaillist');

        // Comments
        Route::post('/comment/article/{slug}.{id}', 'CommentController@article')->name('comment_article');
        Route::post('/comment/torrent/{slug}.{id}', 'CommentController@torrent')->name('comment_torrent');
        Route::get('/comment/thanks/{id}', 'CommentController@quickthanks')->name('comment_thanks');
        Route::post('/comment/request/{id}', 'CommentController@request')->name('comment_request');
        Route::post('/comment/playlist/{id}', 'CommentController@playlist')->name('comment_playlist');
        Route::post('/comment/edit/{comment_id}', 'CommentController@editComment')->name('comment_edit');
        Route::get('/comment/delete/{comment_id}', 'CommentController@deleteComment')->name('comment_delete');

        //Extra-Stats
        Route::get('/stats', 'StatsController@index')->name('stats');
        //User
        Route::get('/stats/user/uploaded', 'StatsController@uploaded')->name('uploaded');
        Route::get('/stats/user/downloaded', 'StatsController@downloaded')->name('downloaded');
        Route::get('/stats/user/seeders', 'StatsController@seeders')->name('seeders');
        Route::get('/stats/user/leechers', 'StatsController@leechers')->name('leechers');
        Route::get('/stats/user/uploaders', 'StatsController@uploaders')->name('uploaders');
        Route::get('/stats/user/bankers', 'StatsController@bankers')->name('bankers');
        Route::get('/stats/user/seedtime', 'StatsController@seedtime')->name('seedtime');
        Route::get('/stats/user/seedsize', 'StatsController@seedsize')->name('seedsize');
        //Torrent
        Route::get('/stats/torrent/seeded', 'StatsController@seeded')->name('seeded');
        Route::get('/stats/torrent/leeched', 'StatsController@leeched')->name('leeched');
        Route::get('/stats/torrent/completed', 'StatsController@completed')->name('completed');
        Route::get('/stats/torrent/dying', 'StatsController@dying')->name('dying');
        Route::get('/stats/torrent/dead', 'StatsController@dead')->name('dead');
        //Request
        Route::get('/stats/request/bountied', 'StatsController@bountied')->name('bountied');
        //Groups
        Route::get('/stats/groups', 'StatsController@groups')->name('groups');
        Route::get('/stats/groups/group/{id}', 'StatsController@group')->name('group');
        // Languages
        Route::get('/stats/languages', 'StatsController@languages')->name('languages');

        // Private Messages System
        Route::post('/mail/searchPMInbox', 'PrivateMessageController@searchPMInbox')->name('searchPMInbox');
        Route::post('/mail/searchPMOutbox', 'PrivateMessageController@searchPMOutbox')->name('searchPMOutbox');
        Route::get('/mail/inbox', 'PrivateMessageController@getPrivateMessages')->name('inbox');
        Route::get('/mail/message/{id}', 'PrivateMessageController@getPrivateMessageById')->name('message');
        Route::get('/mail/outbox', 'PrivateMessageController@getPrivateMessagesSent')->name('outbox');
        Route::get('/mail/create/{receiver_id}/{username}', 'PrivateMessageController@makePrivateMessage')->name('create');
        Route::get('/mail/mark-all-read', 'PrivateMessageController@markAllAsRead')->name('mark-all-read');
        Route::post('/mail/send', 'PrivateMessageController@sendPrivateMessage')->name('send-pm');
        Route::post('/mail/reply/{id}', 'PrivateMessageController@replyPrivateMessage')->name('reply-pm');
        Route::post('/mail/delete/{id}', 'PrivateMessageController@deletePrivateMessage')->name('delete-pm');

        // Requests
        Route::get('/filterRequests', 'RequestController@faceted');
        Route::get('/requests', 'RequestController@requests')->name('requests');
        Route::get('/request/add/{title?}/{imdb?}/{tmdb?}', 'RequestController@addRequestForm')->name('add_request_form');
        Route::post('/request/add', 'RequestController@addRequest')->name('add_request');
        Route::get('/request/{id}/edit', 'RequestController@editRequestForm')->name('edit_request_form');
        Route::post('/request/{id}/edit', 'RequestController@editRequest')->name('edit_request');
        Route::get('/request/{id}{hash?}', 'RequestController@request')->name('request');
        Route::get('/request/{id}/accept', 'RequestController@approveRequest')->name('approveRequest');
        Route::post('/request/{id}/delete', 'RequestController@deleteRequest')->name('deleteRequest');
        Route::post('/request/{id}/fill', 'RequestController@fillRequest')->name('fill_request');
        Route::get('/request/{id}/reject', 'RequestController@rejectRequest')->name('rejectRequest');
        Route::post('/request/{id}/vote', 'RequestController@addBonus')->name('add_votes');
        Route::post('/request/{id}/claim', 'RequestController@claimRequest')->name('claimRequest');
        Route::get('/request/{id}/unclaim', 'RequestController@unclaimRequest')->name('unclaimRequest');

        // Torrent
        Route::get('/feedizeTorrents/{type}', 'TorrentController@feedize')->name('feedizeTorrents')->middleware('modo');
        Route::get('/filterTorrents', 'TorrentController@faceted');
        Route::get('/filterSettings', 'TorrentController@filtered');
        Route::get('/torrents', 'TorrentController@torrents')->name('torrents');
        Route::get('/torrents/{slug}.{id}{hash?}', 'TorrentController@torrent')->name('torrent');
        Route::get('/torrents/{slug}.{id}/peers', 'TorrentController@peers')->name('peers');
        Route::get('/torrents/{slug}.{id}/history', 'TorrentController@history')->name('history');
        Route::get('/upload/{title?}/{imdb?}/{tmdb?}', 'TorrentController@uploadForm')->name('upload_form');
        Route::post('/upload', 'TorrentController@upload')->name('upload');
        Route::get('/download_check/{slug}.{id}', 'TorrentController@downloadCheck')->name('download_check');
        Route::get('/download/{slug}.{id}', 'TorrentController@download')->name('download');
        Route::get('/torrents/cards', 'TorrentController@cardLayout')->name('cards');
        Route::get('/torrents/groupings', 'TorrentController@groupingLayout')->name('groupings');
        Route::post('/torrents/delete', 'TorrentController@deleteTorrent')->name('delete');
        Route::get('/torrents/{slug}.{id}/edit', 'TorrentController@editForm')->name('edit_form');
        Route::post('/torrents/{slug}.{id}/edit', 'TorrentController@edit')->name('edit');
        Route::get('/torrents/{slug}.{id}/torrent_fl', 'TorrentController@grantFL')->name('torrent_fl');
        Route::get('/torrents/{slug}.{id}/torrent_doubleup', 'TorrentController@grantDoubleUp')->name('torrent_doubleup');
        Route::get('/torrents/{slug}.{id}/bumpTorrent', 'TorrentController@bumpTorrent')->name('bumpTorrent');
        Route::get('/torrents/{slug}.{id}/torrent_sticky', 'TorrentController@sticky')->name('torrent_sticky');
        Route::get('/torrents/{slug}.{id}/torrent_feature', 'TorrentController@grantFeatured')->name('torrent_feature');
        Route::get('/torrents/{slug}.{id}/reseed', 'TorrentController@reseedTorrent')->name('reseed');
        Route::post('/torrents/{slug}.{id}/tip_uploader', 'BonusController@tipUploader')->name('tip_uploader');
        Route::get('/torrents/{slug}.{id}/freeleech_token', 'TorrentController@freeleechToken')->name('freeleech_token');
        Route::get('/torrents/similar/{category_id}.{tmdb}', 'TorrentController@similar')->name('torrents.similar');

        // Achievements
        Route::get('/achievements', 'AchievementsController@index')->name('achievements');

        // User
        Route::get('/members', 'UserController@members')->name('members');
        Route::get('/members/results', 'UserController@userSearch')->name('userSearch');
        Route::get('/{username}.{id}', 'UserController@profile')->name('profile');
        Route::get('/{username}.{id}/edit', 'UserController@editProfileForm')->name('user_edit_profile_form');
        Route::post('/{username}.{id}/edit', 'UserController@editProfile')->name('user_edit_profile');
        Route::post('/{username}.{id}/photo', 'UserController@changePhoto')->name('user_change_photo');
        Route::get('/{username}.{id}/activate/{token}', 'UserController@activate')->name('user_activate');
        Route::post('/{username}.{id}/about', 'UserController@changeAbout')->name('user_change_about');
        Route::post('/{username}.{id}/photo', 'UserController@changeTitle')->name('user_change_title');
        Route::get('/{username}.{id}/warninglog', 'UserController@getWarnings')->name('warninglog');
        Route::get('/deactivateWarning/{id}', 'UserController@deactivateWarning')->name('deactivateWarning');
        Route::get('/deleteWarning/{id}', 'UserController@deleteWarning')->name('deleteWarning');
        Route::get('/{username}.{id}/massDeactivateWarnings', 'UserController@deactivateAllWarnings')->name('massDeactivateWarnings');
        Route::get('/{username}.{id}/massDeleteWarnings', 'UserController@deleteAllWarnings')->name('massDeleteWarnings');
        Route::get('/{username}.{id}/banlog', 'UserController@getBans')->name('banlog');
        Route::get('/restoreWarning/{id}', 'UserController@restoreWarning')->name('restoreWarning');
        Route::post('/{username}.{id}/userFilters', 'UserController@myFilter')->name('myfilter');
        Route::get('/{username}.{id}/downloadHistoryTorrents', 'UserController@downloadHistoryTorrents')->name('download_history_torrents');

        Route::get('/{slug}.{id}/seeds', 'UserController@seeds')->name('user_seeds');
        Route::get('/{slug}.{id}/resurrections', 'UserController@resurrections')->name('user_resurrections');
        Route::get('/{slug}.{id}/requested', 'UserController@requested')->name('user_requested');
        Route::get('/{slug}.{id}/active', 'UserController@active')->name('user_active');
        Route::get('/{slug}.{id}/torrents', 'UserController@torrents')->name('user_torrents');
        Route::get('/{slug}.{id}/uploads', 'UserController@uploads')->name('user_uploads');
        Route::get('/{slug}.{id}/downloads', 'UserController@downloads')->name('user_downloads');
        Route::get('/{slug}.{id}/unsatisfieds', 'UserController@unsatisfieds')->name('user_unsatisfieds');
        Route::get('/{slug}.{id}/topics', 'UserController@topics')->name('user_topics');
        Route::get('/{slug}.{id}/posts', 'UserController@posts')->name('user_posts');
        Route::get('/{slug}.{id}/followers', 'UserController@followers')->name('user_followers');
        Route::get('/{slug}.{id}/achievements', 'UserController@achievements')->name('user_achievements');

        // User Settings
        Route::get('/{slug}.{id}/settings', 'UserController@settings')->name('user_settings');
        Route::get('/{slug}.{id}/settings/privacy{hash?}', 'UserController@privacy')->name('user_privacy');
        Route::get('/{slug}.{id}/settings/profile', 'UserController@profile')->name('user_profile');
        Route::get('/{slug}.{id}/settings/security{hash?}', 'UserController@security')->name('user_security');
        Route::get('/{slug}.{id}/settings/notification{hash?}', 'UserController@notification')->name('user_notification');
        Route::post('/{slug}.{id}/settings/change_settings', 'UserController@changeSettings')->name('change_settings');
        Route::post('/{slug}.{id}/settings/change_password', 'UserController@changePassword')->name('change_password');
        Route::post('/{slug}.{id}/settings/change_email', 'UserController@changeEmail')->name('change_email');
        Route::post('/{slug}.{id}/settings/change_pid', 'UserController@changePID')->name('change_pid');
        Route::post('/{slug}.{id}/settings/change_rid', 'UserController@changeRID')->name('change_rid');
        Route::get('/{slug}.{id}/settings/notification/disable', 'UserController@disableNotifications')->name('notification_disable');
        Route::get('/{slug}.{id}/settings/notification/enable', 'UserController@enableNotifications')->name('notification_enable');
        Route::post('/{slug}.{id}/settings/notification/account', 'UserController@changeAccountNotification')->name('notification_account');
        Route::post('/{slug}.{id}/settings/notification/following', 'UserController@changeFollowingNotification')->name('notification_following');
        Route::post('/{slug}.{id}/settings/notification/forum', 'UserController@changeForumNotification')->name('notification_forum');
        Route::post('/{slug}.{id}/settings/notification/subscription', 'UserController@changeSubscriptionNotification')->name('notification_subscription');
        Route::post('/{slug}.{id}/settings/notification/mention', 'UserController@changeMentionNotification')->name('notification_mention');
        Route::post('/{slug}.{id}/settings/notification/torrent', 'UserController@changeTorrentNotification')->name('notification_torrent');
        Route::post('/{slug}.{id}/settings/notification/bon', 'UserController@changeBonNotification')->name('notification_bon');
        Route::post('/{slug}.{id}/settings/notification/request', 'UserController@changeRequestNotification')->name('notification_request');
        Route::post('/{slug}.{id}/settings/privacy/profile', 'UserController@changeProfile')->name('privacy_profile');
        Route::post('/{slug}.{id}/settings/privacy/forum', 'UserController@changeForum')->name('privacy_forum');
        Route::post('/{slug}.{id}/settings/privacy/torrent', 'UserController@changeTorrent')->name('privacy_torrent');
        Route::post('/{slug}.{id}/settings/privacy/follower', 'UserController@changeFollower')->name('privacy_follower');
        Route::post('/{slug}.{id}/settings/privacy/achievement', 'UserController@changeAchievement')->name('privacy_achievement');
        Route::post('/{slug}.{id}/settings/privacy/request', 'UserController@changeRequest')->name('privacy_request');
        Route::post('/{slug}.{id}/settings/privacy/other', 'UserController@changeOther')->name('privacy_other');
        Route::post('/{slug}.{id}/settings/change_twostep', 'UserController@changeTwoStep')->name('change_twostep');
        Route::get('/{slug}.{id}/settings/hidden', 'UserController@makeHidden')->name('user_hidden');
        Route::get('/{slug}.{id}/settings/visible', 'UserController@makeVisible')->name('user_visible');
        Route::get('/{slug}.{id}/settings/private', 'UserController@makePrivate')->name('user_private');
        Route::get('/{slug}.{id}/settings/public', 'UserController@makePublic')->name('user_public');
        Route::get('/{slug}.{id}/invites', 'InviteController@invites')->name('user_invites');
        Route::post('/accept-rules', 'UserController@acceptRules')->name('accept.rules');

        // User Wishlist
        Route::get('/{slug}.{id}/wishlist', 'UserController@wishes')->name('user_wishlist');
        Route::post('/wish/{uid}', 'WishController@store')->name('wish-store');
        Route::get('/wish/{uid}/delete/{id}', 'WishController@destroy')->name('wish-delete');

        // Follow System
        Route::get('/follow/{user}', 'FollowController@follow')->name('follow');
        Route::get('/unfollow/{user}', 'FollowController@unfollow')->name('unfollow');

        //Thank System
        Route::get('/torrents/{slug}.{id}/thank', 'ThankController@torrentThank')->name('torrentThank');

        // User Language
        Route::get('/{locale}/back', 'LanguageController@back')->name('back');

        // User Seedboxes
        Route::get('/{username}/seedboxes/records', 'SeedboxController@index')->name('seedboxes.index');
        Route::post('/{username}/seedboxes/store', 'SeedboxController@store')->name('seedboxes.store');
        Route::delete('/{username}/seedboxes/destroy/{id}', 'SeedboxController@destroy')->name('seedboxes.destroy');

        // Invite System
        Route::get('/invite', 'InviteController@invite')->name('invite');
        Route::post('/invite', 'InviteController@process')->name('process');
        Route::post('/resendinvite/{id}', 'InviteController@reProcess')->name('reProcess');

        // Poll System
        Route::get('/polls', 'PollController@index')->name('polls');
        Route::get('/poll/{slug}', 'PollController@show')->name('poll');
        Route::post('/poll/vote', 'PollController@vote')->middleware('check_ip');
        Route::get('/poll/{slug}/result', 'PollController@result')->name('poll_results');

        // Graveyard System
        Route::get('/filterGraveyard', 'GraveyardController@faceted');
        Route::get('/graveyard', 'GraveyardController@index')->name('graveyard.index');
        Route::post('/graveyard/{id}', 'GraveyardController@store')->name('graveyard.store');
        Route::delete('/graveyard/{id}', 'GraveyardController@destroy')->name('graveyard.destroy');

        // Notifications System
        Route::get('/filterNotifications', 'NotificationController@faceted');
        Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
        Route::get('/notifications/{id}', 'NotificationController@show')->name('notifications.show');
        Route::get('/notification/update/{id}', 'NotificationController@update')->name('notifications.update');
        Route::get('/notification/updateall', 'NotificationController@updateAll')->name('notifications.updateall');
        Route::get('/notification/destroy/{id}', 'NotificationController@destroy')->name('notifications.destroy');
        Route::get('/notification/destroyall', 'NotificationController@destroyAll')->name('notifications.destroyall');

        // Gallery System
        Route::get('/gallery', 'AlbumController@index')->name('gallery');
        Route::get('/createalbum', 'AlbumController@addForm')->name('create_album_form');
        Route::post('/createalbum', 'AlbumController@add')->name('create_album');
        Route::get('/deletealbum/{id}', 'AlbumController@destroy')->name('delete_album');
        Route::get('/album/{id}', 'AlbumController@getAlbum')->name('show_album');
        Route::get('/addimage/{id}', 'ImageController@addForm')->name('add_image');
        Route::post('/addimage', 'ImageController@add')->name('add_image_to_album');
        Route::get('/deleteimage/{id}', 'ImageController@destroy')->name('delete_image');
        Route::get('/image/download/{id}', 'ImageController@download')->name('image_download');

        // Playlist System
        Route::get('/playlists', 'PlaylistController@index')->name('playlists.index');
        Route::get('/playlists/create', 'PlaylistController@create')->name('playlists.create');
        Route::post('/playlists', 'PlaylistController@store')->name('playlists.store');
        Route::get('/playlists/{id}', 'PlaylistController@show')->name('playlists.show');
        Route::get('/playlists/{id}/edit', 'PlaylistController@edit')->name('playlists.edit');
        Route::patch('/playlists/{id}', 'PlaylistController@update')->name('playlists.update');
        Route::delete('/playlists/{id}', 'PlaylistController@destroy')->name('playlists.destroy');

        Route::post('/playlists/attach', 'PlaylistTorrentController@store')->name('playlists.attach');
        Route::delete('/playlists/{id}/detach', 'PlaylistTorrentController@destroy')->name('playlists.detach');
    });

    /*
    |------------------------------------------
    | ChatBox Routes Group (when authorized)
    |------------------------------------------
    */
    Route::group(['prefix' => 'chatbox', 'middleware' => ['auth', 'twostep', 'banned'], 'namespace' => 'API'], function () {
        Route::get('/', 'ChatController@index');
        Route::get('chatrooms', 'ChatController@fetchChatrooms');
        Route::post('change-chatroom', 'ChatController@changeChatroom');
        Route::get('messages', 'ChatController@fetchMessages');
        Route::post('messages', 'ChatController@sendMessage');
    });

    /*
    |------------------------------------------
    | Community Routes Group (when authorized)
    |------------------------------------------
    */
    Route::group(['prefix' => 'forums', 'middleware' => ['auth', 'twostep', 'banned']], function () {
        // Display Forum Index
        Route::get('/', 'ForumController@index')->name('forum_index');

        // Search Forums
        Route::get('/subscriptions', 'ForumController@subscriptions')->name('forum_subscriptions');
        Route::get('/latest/topics', 'ForumController@latestTopics')->name('forum_latest_topics');
        Route::get('/latest/posts', 'ForumController@latestPosts')->name('forum_latest_posts');

        Route::get('/search', 'ForumController@search')->name('forum_search');
        Route::get('/search', 'ForumController@search')->name('forum_search_form');

        // Display Forum Categories
        Route::get('/category/{slug}.{id}', 'ForumController@category')->name('forum_category');
        // Display Topics
        Route::get('/forum/{slug}.{id}', 'ForumController@display')->name('forum_display');
        // Create New Topic
        Route::get('/forum/{slug}.{id}/new-topic', 'ForumController@addForm')->name('forum_new_topic_form');
        Route::post('/forum/{slug}.{id}/new-topic', 'ForumController@newTopic')->name('forum_new_topic');
        // View Topic
        Route::get('/topic/{slug}.{id}', 'ForumController@topic')->name('forum_topic');
        // Close Topic
        Route::get('/topic/{slug}.{id}/close', 'ForumController@closeTopic')->name('forum_close');
        // Open Topic
        Route::get('/topic/{slug}.{id}/open', 'ForumController@openTopic')->name('forum_open');
        //
        Route::post('/posts/{slug}.{id}/tip_poster', 'BonusController@tipPoster')->name('tip_poster');
        // Edit Post
        Route::get('/posts/{slug}.{id}/post-{postId}/edit', 'ForumController@postEditForm')->name('forum_post_edit_form');
        Route::post('/posts/{postId}/edit', 'ForumController@postEdit')->name('forum_post_edit');
        // Delete Post
        Route::get('/posts/{postId}/delete', 'ForumController@postDelete')->name('forum_post_delete');
        // Reply To Topic
        Route::post('/topic/{slug}.{id}/reply', 'ForumController@reply')->name('forum_reply');
        // Edit Topic
        Route::get('/topic/{slug}.{id}/edit', 'ForumController@editForm')->name('forum_edit_topic_form');
        Route::post('/topic/{slug}.{id}/edit', 'ForumController@editTopic')->name('forum_edit_topic');
        // Delete Topic
        Route::get('/topic/{slug}.{id}/delete', 'ForumController@deleteTopic')->name('forum_delete_topic');
        // Pin Topic
        Route::get('/topic/{slug}.{id}/pin', 'ForumController@pinTopic')->name('forum_pin_topic');
        // Unpin Topic
        Route::get('/topic/{slug}.{id}/unpin', 'ForumController@unpinTopic')->name('forum_unpin_topic');

        // Like - Dislike System
        Route::any('/like/post/{postId}', 'LikeController@store')->name('like');
        Route::any('/dislike/post/{postId}', 'LikeController@destroy')->name('dislike');

        // Subscription System
        Route::get('/subscribe/topic/{route}.{topic}', 'SubscriptionController@subscribeTopic')->name('subscribe_topic');
        Route::get('/unsubscribe/topic/{route}.{topic}', 'SubscriptionController@unsubscribeTopic')->name('unsubscribe_topic');
        Route::get('/subscribe/forum/{route}.{forum}', 'SubscriptionController@subscribeForum')->name('subscribe_forum');
        Route::get('/unsubscribe/forum/{route}.{forum}', 'SubscriptionController@unsubscribeForum')->name('unsubscribe_forum');

        // Topic Label System
        Route::get('/topic/{slug}.{id}/approved', 'ForumController@approvedTopic')->name('forum_approved')->middleware('modo');
        Route::get('/topic/{slug}.{id}/denied', 'ForumController@deniedTopic')->name('forum_denied')->middleware('modo');
        Route::get('/topic/{slug}.{id}/solved', 'ForumController@solvedTopic')->name('forum_solved')->middleware('modo');
        Route::get('/topic/{slug}.{id}/invalid', 'ForumController@invalidTopic')->name('forum_invalid')->middleware('modo');
        Route::get('/topic/{slug}.{id}/bug', 'ForumController@bugTopic')->name('forum_bug')->middleware('modo');
        Route::get('/topic/{slug}.{id}/suggestion', 'ForumController@suggestionTopic')->name('forum_suggestion')->middleware('modo');
        Route::get('/topic/{slug}.{id}/implemented', 'ForumController@implementedTopic')->name('forum_implemented')->middleware('modo');
    });

    /*
    |-----------------------------------------------------------------
    | Staff Dashboard Routes Group (when authorized and a staff group)
    |-----------------------------------------------------------------
    */
    Route::group(['prefix' => 'staff_dashboard', 'middleware' => ['auth', 'twostep', 'modo', 'banned'], 'namespace' => 'Staff'], function () {

        // BOT Hooks
        Route::get('/bots/{id}/disable', 'BotsController@disable')->name('Staff.bots.disable');
        Route::get('/bots/{id}/enable', 'BotsController@enable')->name('Staff.bots.enable');

        // RSS CRUD
        Route::resource('rss', 'RssController')->except([
            'show',
        ])->names([
            'create' => 'Staff.rss.create',
            'index' => 'Staff.rss.index',
            'edit' => 'Staff.rss.edit',
            'update' => 'Staff.rss.update',
            'store' => 'Staff.rss.store',
            'destroy' => 'Staff.rss.destroy',
        ]);

        // Bots CRUD
        Route::resource('bots', 'BotsController')->except([
            'show',
            'create',
            'store',
        ])->names([
            'index' => 'Staff.bots.index',
            'edit' => 'Staff.bots.edit',
            'update' => 'Staff.bots.update',
            'destroy' => 'Staff.bots.destroy',
        ]);

        // Staff Dashboard
        Route::get('/', 'HomeController@home')->name('staff_dashboard');

        // Codebase Version Check
        Route::get('/check-update', 'VersionController@checkVersion');

        // Ban
        Route::get('/bans', 'BanController@getBans')->name('getBans');
        Route::post('/ban/{username}.{id}', 'BanController@ban')->name('ban');
        Route::post('/unban/{username}.{id}', 'BanController@unban')->name('unban');

        // Flush Ghost Peers
        Route::get('/flush', 'FlushController@deleteOldPeers')->name('flush');

        // User Tools
        Route::get('/user_search', 'UserController@members')->name('user_search');
        Route::get('/user_results', 'UserController@userSearch')->name('user_results');
        Route::get('/user_edit/{username}.{id}', 'UserController@userSettings')->name('user_setting');
        Route::post('/user_edit/{username}.{id}/edit', 'UserController@userEdit')->name('user_edit');
        Route::post('/user_edit/{username}.{id}/permissions', 'UserController@userPermissions')->name('user_permissions');
        Route::get('/user_delete/{username}.{id}', 'UserController@userDelete')->name('user_delete');
        Route::post('/user_edit/{username}.{id}/password', 'UserController@userPassword')->name('user_password');

        // Moderation
        Route::get('/torrents', 'TorrentController@index')->name('staff_torrent_index');
        Route::get('/moderation', 'ModerationController@moderation')->name('moderation');
        Route::get('/moderation/{slug}.{id}/approve', 'ModerationController@approve')->name('moderation_approve');
        Route::post('/moderation/reject', 'ModerationController@reject')->name('moderation_reject');
        Route::post('/moderation/postpone', 'ModerationController@postpone')->name('moderation_postpone');
        Route::get('/torrent_search', 'TorrentController@search')->name('torrent-search');

        // Request section
        Route::get('/request/{id}/reset', 'ModerationController@resetRequest')->name('resetRequest');

        // User Staff Notes
        Route::get('/notes', 'NoteController@getNotes')->name('getNotes');
        Route::post('/note/{username}.{id}', 'NoteController@postNote')->name('postNote');
        Route::get('/note/{id}', 'NoteController@deleteNote')->name('deleteNote');

        // Reports
        Route::get('/reports', 'ReportController@getReports')->name('getReports');
        Route::get('/reports/{report_id}', 'ReportController@getReport')->name('getReport');
        Route::post('/reports/{report_id}/solve', 'ReportController@solveReport')->name('solveReport');

        // Categories
        Route::get('/categories', 'CategoryController@index')->name('staff.categories.index');
        Route::get('/categories/create', 'CategoryController@create')->name('staff.categories.create');
        Route::post('/categories', 'CategoryController@store')->name('staff.categories.store');
        Route::get('/categories/{slug}.{id}/edit', 'CategoryController@edit')->name('staff.categories.edit');
        Route::patch('/categories/{slug}.{id}', 'CategoryController@update')->name('staff.categories.update');
        Route::delete('/categories/{slug}.{id}', 'CategoryController@destroy')->name('staff.categories.destroy');

        // Types
        Route::get('/types', 'TypeController@index')->name('staff_type_index');
        Route::get('/types/new', 'TypeController@addForm')->name('staff_type_add_form');
        Route::post('/types/new', 'TypeController@add')->name('staff_type_add');
        Route::get('/types/edit/{slug}.{id}', 'TypeController@editForm')->name('staff_type_edit_form');
        Route::post('/types/edit/{slug}.{id}', 'TypeController@edit')->name('staff_type_edit');
        Route::get('/types/delete/{slug}.{id}', 'TypeController@delete')->name('staff_type_delete');

        // Forum
        Route::get('/forums', 'ForumController@index')->name('staff_forum_index');
        Route::get('/forums/new', 'ForumController@addForm')->name('staff_forum_add_form');
        Route::post('/forums/new', 'ForumController@add')->name('staff_forum_add');
        Route::get('/forums/edit/{slug}.{id}', 'ForumController@editForm')->name('staff_forum_edit_form');
        Route::post('/forums/edit/{slug}.{id}', 'ForumController@edit')->name('staff_forum_edit');
        Route::get('/forums/delete/{slug}.{id}', 'ForumController@delete')->name('staff_forum_delete');

        //Pages
        Route::get('/pages', 'PageController@index')->name('staff_page_index');
        Route::get('/pages/new', 'PageController@addForm')->name('staff_page_add_form');
        Route::post('/pages/new', 'PageController@add')->name('staff_page_add');
        Route::get('/pages/edit/{slug}.{id}', 'PageController@editForm')->name('staff_page_edit_form');
        Route::post('/pages/edit/{slug}.{id}', 'PageController@edit')->name('staff_page_edit');
        Route::get('/pages/delete/{slug}.{id}', 'PageController@delete')->name('staff_page_delete');

        // Articles
        Route::get('/articles', 'ArticleController@index')->name('staff_article_index');
        Route::get('/articles/new', 'ArticleController@addForm')->name('staff_article_add_form');
        Route::post('/articles/new', 'ArticleController@add')->name('staff_article_add');
        Route::get('/articles/edit/{slug}.{id}', 'ArticleController@editForm')->name('staff_article_edit_form');
        Route::post('/articles/edit/{slug}.{id}', 'ArticleController@edit')->name('staff_article_edit');
        Route::get('/articles/delete/{slug}.{id}', 'ArticleController@delete')->name('staff_article_delete');

        // Groups
        Route::get('/groups', 'GroupsController@index')->name('staff_groups_index');
        Route::get('/groups/add', 'GroupsController@addForm')->name('staff_groups_add_form');
        Route::post('/groups/add', 'GroupsController@add')->name('staff_groups_add');
        Route::get('/groups/edit/{group}.{id}', 'GroupsController@editForm')->name('staff_groups_edit_form');
        Route::post('/groups/edit/{group}.{id}', 'GroupsController@edit')->name('staff_groups_edit');

        // Warnings
        Route::get('/warnings', 'WarningController@getWarnings')->name('getWarnings');

        // Invites
        Route::get('/invites', 'InviteController@getInvites')->name('getInvites');

        // Failed Logins
        Route::get('/failedlogin', 'FailedLoginController@getFailedAttemps')->name('getFailedAttemps');

        // Polls
        Route::get('/polls', 'PollController@polls')->name('getPolls');
        Route::get('/poll/{id}', 'PollController@poll')->name('getPoll');
        Route::get('/polls/create', 'PollController@create')->name('getCreatePoll');
        Route::post('/polls/create', 'PollController@store')->name('postCreatePoll');

        // Activity Log
        Route::get('/activity', 'ActivityLogController@index')->name('activity.index');
        Route::get('/activity/{id}/delete', 'ActivityLogController@destroy')->name('activity.destroy');

        // System Gifting
        Route::get('/systemgift', 'GiftController@index')->name('systemGift');
        Route::post('/systemgift/send', 'GiftController@gift')->name('sendSystemGift');

        // MassPM
        Route::get('/masspm', 'MassPMController@massPM')->name('massPM');
        Route::post('/masspm/send', 'MassPMController@sendMassPM')->name('sendMassPM');

        // Backup Manager
        Route::get('/backup', 'BackupController@index')->name('backupManager');
        Route::post('/backup/create-full', 'BackupController@create');
        Route::post('/backup/create-files', 'BackupController@createFilesOnly');
        Route::post('/backup/create-db', 'BackupController@createDatabaseOnly');
        Route::get('/backup/download/{file_name?}', 'BackupController@download');
        Route::post('/backup/delete', 'BackupController@delete');

        // Mass Validate Users
        Route::get('/massValidateUsers', 'UserController@massValidateUsers')->name('massValidateUsers');

        // Chat Management
        Route::get('/chatManager', 'ChatController@index')->name('chatManager');
        Route::post('/chatroom/add', 'ChatController@addChatroom')->name('addChatroom');
        Route::post('/chatroom/edit/{id}', 'ChatController@editChatroom')->name('editChatroom');
        Route::post('/chatroom/delete/{id}', 'ChatController@deleteChatroom')->name('deleteChatroom');
        Route::post('/chatstatus/add', 'ChatController@addChatStatus')->name('addChatStatus');
        Route::post('/chatstatus/edit/{id}', 'ChatController@editChatStatus')->name('editChatStatus');
        Route::post('/chatstatus/delete/{id}', 'ChatController@deleteChatStatus')->name('deleteChatStatus');
        Route::get('/flushchat', 'ChatController@flushChat')->name('flush_chat');

        // Possible Cheaters
        Route::get('/cheaters', 'CheaterController@leechCheaters')->name('leechCheaters');

        // Tag (Genres)
        Route::get('/tags', 'TagController@index')->name('staff_tag_index');
        Route::get('/tag/new', 'TagController@addForm')->name('staff_tag_add_form');
        Route::post('/tag/new', 'TagController@add')->name('staff_tag_add');
        Route::get('/tag/edit/{slug}.{id}', 'TagController@editForm')->name('staff_tag_edit_form');
        Route::post('/tag/edit/{slug}.{id}', 'TagController@edit')->name('staff_tag_edit');

        // Applications System
        Route::get('/applications', 'ApplicationController@index')->name('staff.applications.index');
        Route::get('/applications/{id}', 'ApplicationController@show')->name('staff.applications.show');
        Route::post('/applications/{id}/approve', 'ApplicationController@approve')->name('staff.applications.approve');
        Route::post('/applications/{id}/reject', 'ApplicationController@reject')->name('staff.applications.reject');

        // Registered Seedboxes
        Route::get('/seedboxes', 'SeedboxController@index')->name('staff.seedbox.index');
        Route::delete('/seedboxes/{id}', 'SeedboxController@destroy')->name('staff.seedbox.destroy');

        // Commands
        Route::get('/commands', 'CommandController@index')->name('staff.commands.index');
        Route::get('/command/maintance-enable', 'CommandController@maintanceEnable');
        Route::get('/command/maintance-disable', 'CommandController@maintanceDisable');
        Route::get('/command/clear-cache', 'CommandController@clearCache');
        Route::get('/command/clear-view-cache', 'CommandController@clearView');
        Route::get('/command/clear-route-cache', 'CommandController@clearRoute');
        Route::get('/command/clear-config-cache', 'CommandController@clearConfig');
        Route::get('/command/clear-all-cache', 'CommandController@clearAllCache');
        Route::get('/command/set-all-cache', 'CommandController@setAllCache');
        Route::get('/command/clear-compiled', 'CommandController@clearCompiled');
        Route::get('/command/test-email', 'CommandController@testEmail');
    });
});
