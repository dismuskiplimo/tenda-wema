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

Route::get('/', 'FrontController@showHomePage')->name('homepage');
Route::get('/auth/logout', 'FrontController@logout')->name('front.logout');

Route::get('/donate-item', 'FrontController@showDonateItemPage')->name('donate-item');
Route::post('/donate-item', 'UserController@postDonateItem');

Route::get('/contact-us', 'FrontController@showContactUsPage')->name('contact-us');
Route::post('/contact-us', 'FrontController@postContactUs');

Route::get('/about-us', 'FrontController@showAboutUsPage')->name('about-us');
Route::get('/how-it-works', 'FrontController@showHowItWorksPage')->name('how-it-works');

Route::get('/privacy-policy', 'FrontController@showPrivacyPolicyPage')->name('privacy-policy');

Route::post('/donated-items/{slug}/update', 'UserController@updateDonatedItem')->name('user.donated-item.update');
Route::post('/donated-items/{slug}/delete', 'UserController@deleteDonatedItem')->name('user.donated-item.delete');

Route::post('/donated-items/{slug}/review', 'UserController@reviewDonatedItem')->name('user.donated-item.review');
Route::post('/donated-items/review/{id}/update', 'UserController@updateDonatedItemReview')->name('user.donated-item.review.update');

Route::post('/donated-items/{slug}/images/add', 'UserController@addDonatedItemImage')->name('user.donated-item.image.add');
Route::post('/donated-items/{slug}/images/{id}/delete', 'UserController@deleteDonatedItemImage')->name('user.donated-item.image.delete');

Route::get('/donated-items/{slug}/purchase', 'UserController@purchaseDonatedItem')->name('user.donated-item.purchase');

Route::post('/donated-items/{slug}/confirm-delivery', 'UserController@confirmDonatedItemDelivery')->name('user.donated-item.confirm-delivery');
Route::post('/donated-items/{slug}/cancel', 'UserController@cancelPurchasedOrder')->name('user.donated-item.order.cancel');

Route::get('/report-a-good-deed', 'FrontController@showReportGoodDeedPage')->name('report-a-good-deed');

Route::get('/posts', 'FrontController@showPostsPage')->name('posts');
Route::post('/posts', 'UserController@postNewPost');

Route::get('/posts/{slug}/view', 'FrontController@showPostPage')->name('post');
Route::post('/posts/{slug}/comment', 'UserController@postComment')->name('post.comment');

Route::post('/posts/{slug}/update', 'UserController@updatePost')->name('post.update');
Route::post('/posts/{slug}/delete', 'UserController@deletePost')->name('post.delete');

Route::post('/posts/{slug}/comments/{id}/delete', 'UserController@deleteComment')->name('comment.delete');
Route::post('/posts/{slug}/comments/{id}/update', 'UserController@updateComment')->name('comment.update');

Route::post('/report-a-good-deed', 'UserController@postGoodDeed');

Route::get('/terms-and-conditions', 'FrontController@showTermsAndConditions')->name('terms-and-conditions');

Route::get('/support-the-cause', 'FrontController@showSupportCause')->name('support-the-cause');
Route::post('/support-the-cause', 'FrontController@postSupportCause');

Route::get('/good-deeds', 'FrontController@showGoodDeeds')->name('good-deeds');

Route::get('/community-shop', 'FrontController@showCommunityShopPage')->name('community-shop');
Route::get('/community-shop/item/{slug}/view', 'FrontController@showDonatedItem')->name('donated-item.show');

Route::get('/user/{username}/profile/view', 'FrontController@showUserTimeline')->name('user.show');
Route::get('/user/{username}/profile/about', 'FrontController@showUserAbout')->name('user.about-me.show');
Route::get('/user/{username}/profile/donated-items', 'FrontController@showUserDonatedItems')->name('user.donated-items.show');
Route::get('/user/{username}/profile/good-deeds', 'FrontController@showUserGoodDeeds')->name('user.good-deeds.show');
Route::get('/user/{username}/profile/items-bought', 'FrontController@showUserItemsBought')->name('user.items-bought.show');

Route::get('/good-deeds/{slug}/view', 'FrontController@showGoodDeed')->name('good-deed.show');

Route::get('/user/{username}/profile/photos', 'FrontController@showUserPhotos')->name('user.photos.show');
Route::post('/user/{username}/profile/photos', 'ImageController@postUserPhoto')->name('user.photos.add');
Route::post('/user/profile/photos/{id}/delete', 'ImageController@deleteUserPhoto')->name('user.photos.delete');

Route::get('/user/{username}/profile/reviews', 'FrontController@showUserReviews')->name('user.reviews.show');
Route::post('/user/{username}/profile/reviews', 'UserController@postUserReview');

Route::get('/user/{username}/message', 'UserController@newMessage')->name('user.message');

Route::get('/dashboard', 'FrontController@showDashboard')->name('dashboard');

Route::get('/account/suspended', 'FrontController@showSuspendedAccount')->name('account.suspended');
Route::get('/account/closed', 'FrontController@showClosedAccount')->name('account.closed');
Route::get('/account/inactive', 'FrontController@showInactiveAccount')->name('account.inactive');
Route::get('/email/unverified', 'FrontController@showEmailUnverified')->name('email.unverified');

Route::post('/password/update', 'BackController@updateUserPassword')->name('password.update');
Route::post('/account/update', 'BackController@updateUserProfile')->name('account.update');

Route::group(['prefix' => 'user'], function(){
	Route::get('/', 'UserController@showDashboard')->name('user.dashboard');
	
	Route::get('/balance', 'UserController@showBalance')->name('user.balance');
	Route::get('/coins/purchase', 'UserController@purchaseCoins')->name('user.purchase-coins');
	Route::post('/coins/purchase', 'UserController@postPurchaseCoins');

	Route::get('/notifications', 'UserController@showNotifications')->name('user.notifications');
	Route::get('/notifications/{id}/view', 'UserController@showNotification')->name('user.notification');
	Route::get('/conversations', 'UserController@showConversations')->name('user.messages');
	Route::get('/conversations/{id}/view', 'UserController@showConversation')->name('user.conversation');
	Route::get('/conversations/{id}/ajax', 'UserController@ ')->name('user.conversation.ajax');
	Route::post('/conversations/{id}/message/new', 'UserController@postMessage')->name('user.message.new');

	Route::get('/settings', 'UserController@showSettings')->name('user.settings');
	Route::get('/profile', 'UserController@showMyProfile')->name('user.my-profile');
	
	Route::post('/profile/picture/update', 'ImageController@updateProfilePicture')->name('user.profile-picture.update');

	Route::post('/profile/memberships/add', 'UserController@addMembership')->name('user.membership.add');
	Route::post('/profile/memberships/{id}/update', 'UserController@updateMembership')->name('user.membership.update');
	Route::post('/profile/memberships/{id}/delete', 'UserController@deleteMembership')->name('user.membership.delete');

	Route::post('/profile/education/add', 'UserController@addEducation')->name('user.education.add');
	Route::post('/profile/education/{id}/update', 'UserController@updateEducation')->name('user.education.update');
	Route::post('/profile/education/{id}/delete', 'UserController@deleteEducation')->name('user.education.delete');

	Route::post('/profile/work-experiences/add', 'UserController@addWorkExperience')->name('user.work-experience.add');
	Route::post('/profile/work-experiences/{id}/update', 'UserController@updateWorkExperience')->name('user.work-experience.update');
	Route::post('/profile/work-experiences/{id}/delete', 'UserController@deleteWorkExperience')->name('user.work-experience.delete');

	Route::post('/profile/skills/add', 'UserController@addSkill')->name('user.skill.add');
	Route::post('/profile/skills/{id}/update', 'UserController@updateSkill')->name('user.skill.update');
	Route::post('/profile/skills/{id}/delete', 'UserController@deleteSkill')->name('user.skill.delete');

	Route::post('/profile/awards/add', 'UserController@addAward')->name('user.award.add');
	Route::post('/profile/awards/{id}/update', 'UserController@updateAward')->name('user.award.update');
	Route::post('/profile/awards/{id}/delete', 'UserController@deleteAward')->name('user.award.delete');

	Route::post('/profile/hobbies/add', 'UserController@addHobby')->name('user.hobby.add');
	Route::post('/profile/hobbies/{id}/update', 'UserController@updateHobby')->name('user.hobby.update');
	Route::post('/profile/hobbies/{id}/delete', 'UserController@deleteHobby')->name('user.hobby.delete');

	Route::post('/profile/achievments/add', 'UserController@addAchievement')->name('user.achievment.add');
	Route::post('/profile/achievments/{id}/update', 'UserController@updateAchievement')->name('user.achievment.update');
	Route::post('/profile/achievments/{id}/delete', 'UserController@deleteAchievement')->name('user.achievment.delete');

	Route::post('/profile/about-me/update', 'UserController@updateAboutMe')->name('user.about-me.update');

	Route::post('/report', 'UserController@postReport')->name('user.report');

});

Route::group(['prefix' => 'admin'], function(){
	Route::get('/', 'AdminController@showDashboard')->name('admin.dashboard');

	Route::get('/account', 'AdminController@showAccount')->name('admin.account');
	Route::get('/account/settings', 'AdminController@showAccountSettings')->name('admin.account.settings');
	
	Route::get('/notifications', 'AdminController@showNotifications')->name('admin.notifications');

	// Deeds
	Route::get('/deeds/{type}', 'AdminController@showDeeds')->name('admin.deeds');
	Route::get('/deeds/{id}/view', 'AdminController@showDeed')->name('admin.deed');

	Route::post('/deeds/{id}/approve', 'AdminController@approveDeed')->name('admin.deed.approve');
	Route::post('/deeds/{id}/disapprove', 'AdminController@disapproveDeed')->name('admin.deed.disapprove');
	

	// Donated Items
	Route::get('/donated-items/{type}', 'AdminController@showDonatedItems')->name('admin.donated-items');
	Route::get('/donated-items/{id}/view', 'AdminController@showDonatedItem')->name('admin.donated-item');

	Route::post('/donated-items/{id}/approve-purchase', 'AdminController@approveDonatedItemPurchase')->name('admin.donated-item.approve');
	Route::post('/donated-items/{id}/disapprove-purchase', 'AdminController@disapproveDonatedItemPurchase')->name('admin.donated-item.disapprove');
	Route::post('/donated-items/{id}/delete', 'AdminController@deleteDonatedItem')->name('admin.donated-item.delete');
	Route::get('/donated-items/{id}/delete', 'AdminController@deleteDonatedItem')
	;
	Route::post('/donated-items/{id}/confirm-delivery', 'AdminController@confirmDonatedItemDelivery')->name('admin.donated-item.delivery.approve');
	Route::post('/donated-items/{id}/dispute', 'AdminController@disputeDonatedItem')->name('admin.donated-item.dispute');

	// Users
	Route::get('/users/{type}', 'AdminController@showUsers')->name('admin.users');
	Route::get('/admins/{type}', 'AdminController@showAdmins')->name('admin.admins');
	Route::get('/users/{id}/view', 'AdminController@showUser')->name('admin.user');
	Route::post('/users/{id}/close', 'AdminController@closeAccount')->name('admin.user.close-account');
	Route::post('/users/{id}/verify', 'AdminController@verifyUser')->name('admin.user.verify');

	Route::get('/users/{id}/donated-items', 'AdminController@showUserDonatedItems')->name('admin.user.donated-items');
	Route::get('/users/{id}/transactions', 'AdminController@showUserTransactions')->name('admin.user.transactions');
	Route::get('/users/{id}/bought-items', 'AdminController@showUserBoughtItems')->name('admin.user.bought-items');
	Route::get('/users/{id}/reviews', 'AdminController@showUserReviews')->name('admin.user.reviews');
	Route::get('/users/{id}/photos', 'AdminController@showUserPhotos')->name('admin.user.photos');
	Route::get('/users/{id}/good-deeds', 'AdminController@showUserGoodDeeds')->name('admin.user.good-deeds');
	Route::get('/users/{id}/simba-coin-logs', 'AdminController@showUserSimbaCoinLogs')->name('admin.user.simba-coin-logs');

	// Transactions
	Route::get('/transactions/{type}', 'AdminController@showTransactions')->name('admin.transactions');

	// Escrow
	Route::get('/escrow/{type}', 'AdminController@showEscrow')->name('admin.escrow');
	

	// Messages
	Route::get('/messages/compose', 'AdminController@showComposeMessageForm')->name('admin.message.compose');
	Route::get('/messages/{type}', 'AdminController@showMessages')->name('admin.messages');
	Route::get('/messages/{id}/new', 'AdminController@newMessage')->name('admin.message.new');
	Route::get('/messages/{id}/view', 'AdminController@showMessage')->name('admin.message.view');
	Route::post('/messages/{id}/view', 'AdminController@postMessage');
	
	Route::get('/messages/{id}/ajax', 'AdminController@getAjaxConversation')->name('admin.message.ajax');

	// Support Cause Requests
	Route::get('/support-the-cause', 'AdminController@showSupportCausesPage')->name('admin.support-causes');
	Route::get('/support-the-cause/{id}/show', 'AdminController@showSupportCausePage')->name('admin.support-cause');
	Route::post('/support-the-cause/{id}/confirm', 'AdminController@postConfirmCause')->name('admin.support-cause.confirm');
	Route::post('/support-the-cause/{id}/dismiss', 'AdminController@postDismissCause')->name('admin.support-cause.dismiss');

	// Contact Form

	Route::get('/contact-forms', 'AdminController@showContactFormPage')->name('admin.contact-forms');
	Route::get('/contact-forms/{id}/show', 'AdminController@showContactFormMessage')->name('admin.contact-form');

	//Site Settings
	Route::get('/site-settings', 'AdminController@showSiteSettings')->name('admin.site-settings');

	// Reports 
	Route::get('/reports/{type}', 'AdminController@getReportedUsers')->name('admin.users.reported');
	Route::get('/reports/{id}/view', 'AdminController@getReportedUserSingle')->name('admin.users.reported-single');

	Route::post('/reports/{id}/approve', 'BackController@approveReport')->name('admin.users.reported.approve');
	Route::post('/reports/{id}/dismiss', 'BackController@dismissReport')->name('admin.users.reported.dismiss');
});

Route::group(['prefix' => 'auth'], function(){
	Route::get('/login', 'AuthController@showLoginForm')->name('auth.login');
	Route::post('/login', 'AuthController@postLogin');

	Route::get('/signup', 'AuthController@showSignupForm')->name('auth.signup');
	Route::post('/signup', 'AuthController@postSignup');

	Route::get('/logout', 'AuthController@logout')->name('auth.logout');
	Route::post('/logout', 'AuthController@logout');
});

Route::group(['prefix' => 'payments'], function(){
	Route::post('/payment/paypal/{type}/request', 'PaymentsController@makePaypalPayment')->name('paypal.request');
	Route::get('/payment/paypal/{type}/verify', 'PaymentsController@verifyPaypalPayment')->name('paypal.verify');

	Route::post('/payment/mpesa/{type}/request', 'PaymentsController@makeMpesaPayment')->name('mpesa.request');
	Route::post('/payment/mpesa/{id}/{type}/save', 'PaymentsController@saveMpesaRequest')->name('mpesa.save');
});

Auth::routes();

Route::get('/logout', 'AuthController@logout');

Route::get('/messages/new/count', 'BackController@getNewMessagesCount')->name('messages.count');
Route::get('/notifications/new/count', 'BackController@getNewNotificationsCount')->name('notifications.count');
Route::get('/all/new/count', 'BackController@getAllNewCount')->name('all.count');
