<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ComplaintsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VideoSessionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Landing page
Route::get('/', [HomeController::class, 'index'])->middleware('detectCountry')->name('home');

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verifyEmail');

Route::get('/registration-success', function() {
	return view('auth.emailVerificationSent');
})->name('auth.emailVerificationSent');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordPage'])->name('resetPassword');
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);

// For guests
Route::group(['middleware' => 'guest'], function() {
	Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
	Route::post('/login', [AuthController::class, 'login']);
	Route::get('/register', [AuthController::class, 'registrationForm'])->name('register');
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login-by-google', [AuthController::class, 'loginByGoogle'])->name('loginByGoogle');
	Route::post('/login-by-facebook', [AuthController::class, 'loginByFacebook'])->name('loginByFacebook');
	Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
});


// Account
Route::group(['middleware' => 'auth'], function() {
	Route::post('/auth/send-email-verification', [AuthController::class, 'sendEmailVerification'])->name('auth.sendEmailVerification');

	Route::get('/account', [AccountController::class, 'index'])->name('account');
	Route::get('/account/video-sessions', [AccountController::class, 'index'])->name('account.videoSessions');
	Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
	Route::get('/account/matches', [AccountController::class, 'matches'])->name('account.matches');
	Route::get('/account/wallet', [AccountController::class, 'wallet'])->name('account.wallet');
	Route::get('/account/search', [AccountController::class, 'search'])->name('account.search');
	Route::post('/account/profile/save', [AccountController::class, 'saveProfile'])->name('account.saveProfile');

	Route::get('account/complaint/{id}', [AccountController::class, 'complaintDetails'])->name('account.complaint');


	Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/video-sessions/get-auth-message', [AuthController::class, 'getAuthMessage'])->name('videoSessions.auth');
});


// Admin panel
Route::group(['middleware' => 'permission:accessAdminPanel'], function () {
	Route::get('/admin', [AdminController::class, 'home'])->name('admin');

	Route::post('/admin/set-maintenance', [AdminController::class, 'setMaintenance'])->name('admin.setMaintenance');

	Route::get('/admin/video-sessions', [VideoSessionsController::class, 'list'])->name('admin.videoSessions');
	Route::get('/admin/video-sessions/talks/{videoSessionId}/{userId}', [VideoSessionsController::class, 'talks']);

	// Users
	Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
	Route::get('/admin/users/edit/{id}', [UsersController::class, 'editForm'])->name('admin.users.edit');
	Route::get('/admin/users/create', [UsersController::class, 'creationForm'])->name('admin.users.create');
	Route::post('/admin/users/save', [UsersController::class, 'save'])->name('admin.users.save');
	Route::post('/admin/users/delete', [UsersController::class, 'delete'])->name('admin.users.delete');
	Route::post('/admin/users/ban', [UsersController::class, 'ban'])->name('admin.users.ban');
	Route::post('/admin/users/unban', [UsersController::class, 'unban'])->name('admin.users.unban');
	Route::post('/admin/users/verify-email', [UsersController::class, 'verifyEmail'])->name('admin.users.verifyEmail');
	Route::post('/admin/users/fill-up-balance', [UsersController::class, 'fillUpBalance'])->name('admin.users.fillUpBalance');

	// Roles
	Route::get('/admin/roles', [RolesController::class, 'list'])->name('admin.roles');
	Route::get('/admin/roles/create', [RolesController::class, 'creationForm'])->name('admin.roles.create');
	Route::get('/admin/roles/edit/{id}', [RolesController::class, 'editForm'])->name('admin.roles.edit');
	Route::post('/admin/roles/save', [RolesController::class, 'save'])->name('admin.roles.save');

	// News
	Route::get('/admin/news', [AdminNewsController::class, 'list'])->name('admin.news');
	Route::get('/admin/news/create', [AdminNewsController::class, 'creationForm'])->name('admin.news.create');
	Route::get('/admin/news/edit/{id}', [AdminNewsController::class, 'editForm'])->name('admin.news.edit');
	Route::post('/admin/news/save', [AdminNewsController::class, 'save'])->name('admin.news.save');
	Route::post('/admin/news/publish', [AdminNewsController::class, 'publish'])->name('admin.news.publish');
	Route::post('/admin/news/cancel-publication', [AdminNewsController::class, 'cancelPublication'])->name('admin.news.cancelPublication');
	Route::post('/admin/news/delete', [AdminNewsController::class, 'delete'])->name('admin.news.delete');

	// News
	Route::get('/admin/blog', [AdminBlogController::class, 'list'])->name('admin.blog');
	Route::get('/admin/blog/create', [AdminBlogController::class, 'creationForm'])->name('admin.blog.create');
	Route::get('/admin/blog/edit/{id}', [AdminBlogController::class, 'editForm'])->name('admin.blog.edit');
	Route::post('/admin/blog/save', [AdminBlogController::class, 'save'])->name('admin.blog.save');
	Route::post('/admin/blog/publish', [AdminBlogController::class, 'publish'])->name('admin.blog.publish');
	Route::post('/admin/blog/cancel-publication', [AdminBlogController::class, 'cancelPublication'])->name('admin.blog.cancelPublication');
	Route::post('/admin/blog/delete', [AdminBlogController::class, 'delete'])->name('admin.blog.delete');

	Route::get('/admin/complaints', [ComplaintsController::class, 'list'])->name('admin.complaints');
	Route::get('/admin/complaints/view/{id}', [ComplaintsController::class, 'view'])->name('admin.complaints.view');
	Route::post('/admin/complaints/make-resolving', [ComplaintsController::class, 'makeResolving']);
	Route::post('/admin/complaints/make-resolved', [ComplaintsController::class, 'makeResolved']);

	Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
});


Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'article'])->name('news.article');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'post'])->name('blog.post');


Route::get('/about-us', function() { return view('staticPages.aboutUs'); })->name('aboutUs');
Route::get('/terms-of-use', function() { return view('staticPages.termsOfUse'); })->name('termsOfUse');
Route::get('/privacy-policy', function() { return view('staticPages.privacyPolicy'); })->name('privacyPolicy');
Route::get('/beta-version', function() { return view('staticPages.betaVersion'); })->name('betaVersion');
Route::get('/contact-us', function() { return view('contactUs.form'); })->name('contactUs');
Route::post('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/faq', function() { return view('staticPages.faq'); })->name('faq');


Route::get('/social/fb/delete-my-data', function() { return view('auth.fbDataDeletion'); });
