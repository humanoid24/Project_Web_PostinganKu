<?php

use App\Http\Controllers\AdminReportBlogger;
use App\Http\Controllers\AdminReportCommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReportCommentController;
use App\Http\Controllers\SavedController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'login'])->name('login');

// Register
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register/action', [AuthController::class, 'actionRegister'])->name('actionRegister');


// Login
Route::post('actionlogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::get('actionlogout', [AuthController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::resource('bloggers', BlogController::class);
    Route::post('/bloggers/{id}/report', [BlogController::class, 'reportblogger'])->name('bloggers.report');
    
    // Report Postingan Blogger Admin
    Route::get('/reportblogger', [AdminReportBlogger::class, 'index'])->name('admin.report.blogger');
    Route::post('/admin/laporan-blogger/{id}/update-status', [AdminReportBlogger::class, 'updateStatus'])->name('laporan.updateStatus.blogger');



    // Komentar
    Route::resource('komentars', CommentController::class);
    Route::post('/komentars/{id}/report', [CommentController::class, 'reportcomment'])->name('komentars.report');

    // Report Komentar dan Blogger Admin
    Route::get('/reportkomentar', [AdminReportCommentController::class, 'index'])->name('admin.report');
    Route::post('/admin/laporan-komentar/{id}/update-status', [AdminReportCommentController::class, 'updateStatus'])->name('laporan.updateStatus');
    


    // Postingan
    Route::get('/user/{userId}/posts', [BlogController::class, 'userPosts'])->name('user.posts');
    Route::post('/like', [LikeController::class, 'store'])->name('like.store');
    Route::post('/saved', [SavedController::class, 'store'])->name('saved.store');
    Route::get('/savedshow', [SavedController::class, 'show'])->name('saved.show');



    // Chat
    Route::get('chattemplate', [ChatController::class, 'index'])->name('chatting');
    Route::get('/chat', [ChatController::class, 'chat'])->name('chat');


    // Edit Profile
    Route::get('/EditProfile', [EditProfileController::class, 'index'])->name('editprofile');
    Route::put('/EditProfile/{user}', [EditProfileController::class, 'update'])->name('profile.update');
});
