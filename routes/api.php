<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Website\FaqController;
use App\Http\Controllers\Api\Website\SeoController;
use App\Http\Controllers\Api\Website\BlogController;
use App\Http\Controllers\Api\Website\PageController;
use App\Http\Controllers\Api\Website\UserController;
use App\Http\Controllers\Api\Website\WorkController;
use App\Http\Controllers\Api\Website\AboutController;
use App\Http\Controllers\Api\Website\OfferController;
use App\Http\Controllers\Api\Website\SliderController;
use App\Http\Controllers\Api\Website\ContactController;
use App\Http\Controllers\Api\Website\CountryController;
use App\Http\Controllers\Api\Website\GalleryController;
use App\Http\Controllers\Api\Website\PartnerController;
use App\Http\Controllers\Api\Website\ServiceController;
use App\Http\Controllers\Api\Website\SettingController;
use App\Http\Controllers\Api\Website\CategoryController;
use App\Http\Controllers\Api\Website\EmployeeController;
use App\Http\Controllers\Api\Website\NewsLetterController;
use App\Http\Controllers\Api\Website\StaticPageController;
use App\Http\Controllers\Api\Website\HeroSectionController;
use App\Http\Controllers\Api\Website\TestimonialController;
use App\Http\Controllers\Api\Website\JobHierarchyController;
use App\Http\Controllers\Api\Website\FinancialMenuController;

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';


Route::group(['middleware' => ['localization'], 'prefix' => 'site'], function () {

    Route::get('blogs', BlogController::class);
    Route::get('employees', EmployeeController::class);
    Route::get('users', UserController::class);
    Route::get('countries', CountryController::class);
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('getMainServices', [ServiceController::class, 'getMainServices']);
    Route::get('getServicesWithChild', [ServiceController::class, 'getServicesWithChild']);
    Route::get('getServiceById/{service}', [ServiceController::class, 'getServiceById']);
    Route::get('partners', PartnerController::class);
    Route::get('sliders', SliderController::class);
    Route::get('testimonials', TestimonialController::class);
    Route::get("galleries", GalleryController::class);
    Route::get('abouts', AboutController::class);
    Route::get('settings', SettingController::class);
    Route::post('contacts', ContactController::class);
    Route::get('offers', OfferController::class);
    Route::get('hero_sections', HeroSectionController::class);
    Route::get('static_pages', StaticPageController::class);
    Route::get('seo', SeoController::class);
    Route::get('works', WorkController::class);
    Route::get('faqs', FaqController::class);
    Route::get('pages', PageController::class);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('job_hierarchy', [JobHierarchyController::class, 'index']);
    Route::get('job_hierarchy/{id}', [JobHierarchyController::class, 'show']);
    ##============================== Download Financial Menu File
    Route::get('financial_menus', FinancialMenuController::class);
    Route::get("financial_menus/download/{financial_menu}", [FinancialMenuController::class, 'downloadFile']);

//    ============================ Website
    Route::get("fetch_static_pages_by_slug", [StaticPageController::class, 'fetchStaticPageBySlug']);
    ##============================== NewsLetters
    Route::post('store_news_letters', [NewsLetterController::class, 'store']);
    Route::get("fetchVision", [AboutController::class, 'fetchVision']);
});
