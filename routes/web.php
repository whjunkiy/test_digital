<?php

use App\Http\Controllers\Admin\HelpArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewFixtureController;
use App\Http\Controllers\ScreenshotController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\ThumbnailController;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Tst;

    Route::get('/', [Tst::class, 'tst'])->name('tst');
    Route::post('/tst-store', [Tst::class, 'store'])->name('tst-store');
    Route::get('/tst-1', [Tst::class, 'exr1'])->name('tst-1');
    Route::get('/tst-2', [Tst::class, 'exr2'])->name('tst-2');