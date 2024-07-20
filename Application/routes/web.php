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
// Check if website alredy install
Route::group(['middleware' => 'IsInstalled'], function () {
    // Install routes
    Route::get('/install/install', [App\Http\Controllers\Install\InstallController::class, 'index'])->name('install/install');
    Route::get('/install/step1', [App\Http\Controllers\Install\InstallController::class, 'step1'])->name('install/step1');
    Route::post('/install/step1/set_database', [App\Http\Controllers\Install\InstallController::class, 'set_database'])->name('install/step1/set_database');
    Route::get('/install/step2', [App\Http\Controllers\Install\InstallController::class, 'step2'])->name('install/step2');
    Route::post('/install/step2/import_database', [App\Http\Controllers\Install\InstallController::class, 'import_database'])->name('install/step2/import_database');
    Route::get('/install/step3', [App\Http\Controllers\Install\InstallController::class, 'step3'])->name('install/step3');
    Route::post('/install/step3/set_siteinfo', [App\Http\Controllers\Install\InstallController::class, 'set_siteinfo'])->name('install/step3/set_siteinfo');
    Route::get('/install/step4', [App\Http\Controllers\Install\InstallController::class, 'step4'])->name('install/step4');
    Route::post('/install/step4/set_admininfo', [App\Http\Controllers\Install\InstallController::class, 'set_admininfo'])->name('install/step4/set_admininfo');
});

// Check if website is installed
Route::group(['middleware' => 'check.installation'], function () {
    // If auth is admin
    Route::group(['middleware' => 'adminredirect'], function () {
        // Home page routes
        Route::get('/', [App\Http\Controllers\Pages\HomeController::class, 'index']);
        Route::post('/upload', [App\Http\Controllers\Pages\UploadController::class, 'Upload'])->name('upload');
        // Download file
        Route::get('download/{file_id}', [App\Http\Controllers\Pages\DownloadController::class, 'index'])->name('download.file');
        // Pages routes
        Route::get('page/{slug}', [App\Http\Controllers\Pages\PagesController::class, 'index']);
        Route::post('page/contact/send', [App\Http\Controllers\Pages\ContactController::class, 'sendMsg'])->name('send.msg');
    });
    // Login routes
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    // Register routes
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    // Password routes
    Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
    // Confirm routes
    Route::get('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
    // Verify email routes
    Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');
    // Social logins routes
    Route::get('third-party/{provider}', [App\Http\Controllers\Auth\SocialController::class, 'redirectToProvider'])->name('third-party.action');
    Route::get('third-party/{provider}/callback', [App\Http\Controllers\Auth\SocialController::class, 'handleProviderCallback']);
    // download files
    Route::get('download/file/request/{file_id}', [App\Http\Controllers\Pages\DownloadController::class, 'downloadFile'])->name('download.action');
    // Route group when user login
    Route::group(['middleware' => 'auth'], function () {
        // If user already has email and pasword
        Route::group(['middleware' => 'CheckForDetailsExists'], function () {
            // Social login setpassword
            Route::get('addition/password', [App\Http\Controllers\Addition\AddPasswordController::class, 'index']);
            Route::post('addition/password', [App\Http\Controllers\Addition\AddPasswordController::class, 'update'])->name('addition.password');
            // Social login setemail if there is no email
            Route::get('addition/email', [App\Http\Controllers\Addition\AddEmailController::class, 'index']);
            Route::post('addition/email', [App\Http\Controllers\Addition\AddEmailController::class, 'update'])->name('addition.email');
        });

        // If auth is admin
        Route::group(['middleware' => 'adminredirect'], function () {
            // Middleware for check if user has email and password
            Route::group(['middleware' => 'CheckFordetails'], function () {
                // User routes
                Route::get('user/dashboard', [App\Http\Controllers\Pages\User\DashboardController::class, 'index']);
                Route::get('user/dashboard/charts/uploads', [App\Http\Controllers\Pages\User\DashboardController::class, 'getDailyUploadData'])->middleware('only.ajax');

                Route::get('user/files', [App\Http\Controllers\Pages\User\FilesController::class, 'index']);
                Route::delete('user/files/delete/{id}', [App\Http\Controllers\Pages\User\FilesController::class, 'deleteFile']);

                Route::get('user/settings', [App\Http\Controllers\Pages\User\SettingsController::class, 'index']);
                Route::post('user/settings/update/info', [App\Http\Controllers\Pages\User\SettingsController::class, 'updateInfo'])->name('update.info');
                Route::post('user/settings/update/password', [App\Http\Controllers\Pages\User\SettingsController::class, 'updatePassword'])->name('update.password');
            });
        });

        Route::group(['middleware' => 'CheckFordetails'], function () {
            // If auth is admin
            Route::group(['middleware' => 'admin'], function () {
                // Admin routes
                Route::get('admin', [App\Http\Controllers\Admin\DashboardController::class, 'RedirectToDashboard']);
                Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
                Route::get('admin/dashboard/charts/uploads', [App\Http\Controllers\Admin\DashboardController::class, 'getDailyUploadsData'])->middleware('only.ajax');
                Route::get('admin/dashboard/charts/users', [App\Http\Controllers\Admin\DashboardController::class, 'getDailyUsersData'])->middleware('only.ajax');

                Route::get('admin/users', [App\Http\Controllers\Admin\UsersController::class, 'index']);
                Route::post('admin/user/add', [App\Http\Controllers\Admin\UsersController::class, 'addAdmin']);
                Route::get('admin/users/{id}', [App\Http\Controllers\Admin\UsersController::class, 'viewUser'])->name('view.user');
                Route::get('admin/user/ban/{id}', [App\Http\Controllers\Admin\UsersController::class, 'banUser'])->middleware('only.ajax');
                Route::get('admin/user/unban/{id}', [App\Http\Controllers\Admin\UsersController::class, 'unbanUser'])->middleware('only.ajax');

                Route::get('admin/uploads', [App\Http\Controllers\Admin\UploadsController::class, 'index'])->name('uploads');
                Route::get('admin/uploads/{id}', [App\Http\Controllers\Admin\UploadsController::class, 'viewFile'])->name('view.file');
                Route::delete('admin/uploads/delete/{id}', [App\Http\Controllers\Admin\UploadsController::class, 'deleteAdminFile']);

                Route::get('admin/amazon', [App\Http\Controllers\Admin\AmazonS3Controller::class, 'index']);
                Route::post('admin/amazon/update/store', [App\Http\Controllers\Admin\AmazonS3Controller::class, 'amazons3Store'])->name('amazon.store');

                Route::get('admin/wasabi', [App\Http\Controllers\Admin\WasabiController::class, 'index']);
                Route::post('admin/wasabi/update/store', [App\Http\Controllers\Admin\WasabiController::class, 'wasabiStore'])->name('wasabi.store');

                Route::get('admin/backblaze', [App\Http\Controllers\Admin\BackblazeController::class, 'index']);
                Route::post('admin/backblaze/update/store', [App\Http\Controllers\Admin\BackblazeController::class, 'backblazeStore'])->name('backblaze.store');

                Route::get('admin/ads', [App\Http\Controllers\Admin\AdsController::class, 'index']);
                Route::post('admin/ads/update/store', [App\Http\Controllers\Admin\AdsController::class, 'adsStore'])->name('ads.store');

                Route::get('admin/messages', [App\Http\Controllers\Admin\MessagesController::class, 'index']);
                Route::get('admin/messages/{id}', [App\Http\Controllers\Admin\MessagesController::class, 'viewMsg'])->name('view.message');;
                Route::delete('admin/message/delete/{id}', [App\Http\Controllers\Admin\MessagesController::class, 'deleteMsg']);

                Route::get('admin/pages', [App\Http\Controllers\Admin\PagesController::class, 'index']);
                Route::get('admin/pages/add', [App\Http\Controllers\Admin\PagesController::class, 'addPageIndex'])->name('add.page');
                Route::post('admin/pages/add/store', [App\Http\Controllers\Admin\PagesController::class, 'addPageStore']);
                Route::get('admin/pages/edit/{id}', [App\Http\Controllers\Admin\PagesController::class, 'editPage']);
                Route::post('admin/pages/edit/store', [App\Http\Controllers\Admin\PagesController::class, 'editPageStore']);
                Route::delete('admin/pages/delete/{id}', [App\Http\Controllers\Admin\PagesController::class, 'deletePage']);

                Route::get('admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index']);
                Route::post('admin/settings/info/update', [App\Http\Controllers\Admin\SettingsController::class, 'UpdateInfo']);
                Route::post('admin/settings/logofav/update', [App\Http\Controllers\Admin\SettingsController::class, 'UpdateLogoAndFavicon']);
                Route::post('admin/settings/api/update', [App\Http\Controllers\Admin\SettingsController::class, 'UpdateApi']);
                Route::post('admin/settings/seo/update', [App\Http\Controllers\Admin\SettingsController::class, 'UpdateSeo']);

                Route::get('admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
                Route::post('admin/profile/update/info', [App\Http\Controllers\Admin\ProfileController::class, 'updateInfo']);
                Route::post('admin/profile/update/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword']);
            });
        });
    });
});
