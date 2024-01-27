<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', '/login');

Auth::routes();


// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware('is_admin')->group(function () {

    // ----------
    // Dashboard
    // ----------
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    //  -----
    //  user
    //  -----
    Route::prefix('user')->group(function () {

        Route::get('/', [AdminController::class, 'userIndex'])->name('admin.user');
        Route::get('{user}/get', [AdminController::class, 'userGet'])->name('admin.user.get');
        Route::post('store', [AdminController::class, 'userStore'])->name('admin.user.store');
        Route::put('{user}/update', [AdminController::class, 'userUpdate'])->name('admin.user.update');
        Route::delete('{user}/destroy', [AdminController::class, 'userDestroy'])->name('admin.user.destroy');
    });

    //  -----
    //  campaign
    //  -----
    Route::prefix('campaign')->group(function () {

        Route::get('/', [AdminController::class, 'campaignIndex'])->name('admin.campaign');
        Route::get('{campaign}/get', [AdminController::class, 'campaignGet'])->name('admin.campaign.get');
        Route::post('store', [AdminController::class, 'campaignStore'])->name('admin.campaign.store');
        Route::put('{campaign}/update', [AdminController::class, 'campaignUpdate'])->name('admin.campaign.update');
        Route::delete('{campaign}/destroy', [AdminController::class, 'campaignDestroy'])->name('admin.campaign.destroy');
    });

    //  -----
    //  campaign target
    //  -----
    Route::prefix('campaign-target')->group(function () {
        Route::get('/', [AdminController::class, 'campaignTargetIndex'])->name('admin.campaign_target');
        Route::post('store', [AdminController::class, 'campaignTargetStore'])->name('admin.campaign_target.store');
        Route::delete('{campaignTarget}/destroy', [AdminController::class, 'campaigntargetDestroy'])->name('admin.campaign_target.destroy');
        Route::get('import-templates/{filename}', [AdminController::class, 'campaignTargetTemplateImport'])->name('admin.campaign_target.import_templates');
    });

    // Setting
    Route::prefix('pengaturan')->group(function () {
        Route::get('umum', 'AdminController@settingCommonIndex')->name('admin.setting.common');

        Route::group(['middleware' => 'requestAjax'], function () {
            Route::post('common/store', 'AdminController@settingCommonStore')->name('admin.setting.common.store');
        });
    });
});

Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@indexUsers')->name('users');
});
