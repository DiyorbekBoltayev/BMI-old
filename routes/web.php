<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HemisController,
    TeacherController,
    ThemeController,
    ProcessController,
    MudirController,
    StatisticController,
    ChatController,
    MixController,
    SifatController,
    SuperUserController,
};


Route::middleware('web')->group(function (){
    Route::get('/', [MixController::class, 'firstPage'])->name('first-page');
    Route::get('login', [HemisController::class, 'login'])->name('login-student');
    Route::post('login-student-user', [HemisController::class, 'loginUser'])->name('login-student-user');
});


Route::middleware('hemis')->group(function () {

    Route::middleware('without_mudir')->group(function (){
        Route::get('logout-student', [HemisController::class, 'logout'])->name('logout-student');
        Route::get('student-profile', [HemisController::class, 'profile'])->name('student-profile');
        Route::get('student-themes', [ThemeController::class, 'themes'])->name('student-themes');
        Route::get('filtered-student-themes', [ThemeController::class, 'themesFilter'])->name('filtered-student-themes');
        Route::get('get-theme/{id}', [ThemeController::class, 'getTheme'])->name('get-theme');
        Route::get('cancel-theme/{id}', [ThemeController::class, 'cancelTheme'])->name('cancel-theme');
        Route::get('cancel-confirm/{id}', [ThemeController::class, 'cancelConfirmTheme'])->name('cancel-confirm');
        Route::get('process', [ProcessController::class, 'student_index'])->name('process');
        Route::post('update-process', [ProcessController::class, 'update'])->name('update-process');
        Route::get('show-process/{id}', [ProcessController::class, 'showProcess'])->name('show-process');
        Route::post('send-message', [ChatController::class, 'create'])->name('send-message');
        Route::get('chat-student',[ChatController::class, 'showChatForStudent'])->name('chat-student');
        Route::get('examples',[MixController::class, 'examples'])->name('examples');
    });


    Route::middleware('mudir')->group(function(){
        Route::resource('teachers',TeacherController::class);
        Route::get('mudir-themes', [MudirController::class, 'themes'])->name('mudir-themes');
        Route::get('filtered-themes', [MudirController::class, 'filteredThemes'])->name('filtered-themes');
        Route::get('statistics-teacher', [StatisticController::class, 'teachers'])->name('statistics-teacher');
        Route::get('statistics-student', [StatisticController::class, 'students'])->name('statistics-student');

    });

    Route::middleware('teacher')->group(function(){
        Route::get('themes', [ThemeController::class, 'index'])->name('themes');
        Route::get('filtered-teacher-themes', [ThemeController::class, 'filter'])->name('filtered-teacher-themes');
        Route::post('store-theme', [ThemeController::class, 'store'])->name('store-theme');
        Route::post('update-theme', [ThemeController::class, 'update'])->name('update-theme');
        Route::post('delete-theme', [ThemeController::class, 'delete'])->name('delete-theme');
        Route::get('chat/{id}', [ChatController::class, 'show'])->name('chat');

    });

    Route::middleware('sifat_bolimi')->group(function (){
        Route::get('sifat-bolimi/statistika',[SifatController::class,'statisticsAll'])->name('sifat-bolimi-statistika');
        Route::get('sifat-bolimi/statistika/print',[SifatController::class,'generateFile'])->name('sifat-bolimi-print');
    });
    Route::middleware('super')->group(function (){

        Route::get('mudirlar',[SuperUserController::class,'mudirlar'])->name('mudirlar');
        Route::post('mudirlar/create',[SuperUserController::class,'mudirCreate'])->name('create-mudir');
        Route::put('mudirlar/update/{id}',[SuperUserController::class,'mudirUpdate'])->name('update-mudir');
        Route::delete('mudirlar/delete/{id}',[SuperUserController::class,'mudirDelete'])->name('delete-mudir');

    });
    Route::middleware('auth')->group(function (){
        Route::get('profile',[MixController::class,'profile'])->name('profile');
        Route::post('update-profile/{user}',[MixController::class,'updateProfile'])->name('update-profile');
        Route::post('update-password/{user}',[MixController::class,'updatePassword'])->name('update-password');
    });






});
Route::get('oauth',[\App\Http\Controllers\OAuthController::class,'index'])->name('oauth');
Route::get('oauth/callback',[\App\Http\Controllers\OAuthController::class,'callback'])->name('oauth.callback');

require_once __DIR__ . '/auth.php';


