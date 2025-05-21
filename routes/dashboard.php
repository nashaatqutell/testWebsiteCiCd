<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\FaqController;
use App\Http\Controllers\Api\Dashboard\PdfController;
use App\Http\Controllers\Api\Dashboard\SeoController;
use App\Http\Controllers\Api\Dashboard\BlogController;
use App\Http\Controllers\Api\Dashboard\PageController;
use App\Http\Controllers\Api\Dashboard\RoleController;
use App\Http\Controllers\Api\Dashboard\UserController;
use App\Http\Controllers\Api\Dashboard\WorkController;
use App\Http\Controllers\Api\Dashboard\AboutController;
use App\Http\Controllers\Api\Dashboard\OfferController;
use App\Http\Controllers\Api\Dashboard\SliderController;
use App\Http\Controllers\Api\Dashboard\ContactController;
use App\Http\Controllers\Api\Dashboard\CountryController;
use App\Http\Controllers\Api\Dashboard\GalleryController;
use App\Http\Controllers\Api\Dashboard\PartnerController;
use App\Http\Controllers\Api\Dashboard\ProfileController;
use App\Http\Controllers\Api\Dashboard\ServiceController;
use App\Http\Controllers\Api\Dashboard\SettingController;
use App\Http\Controllers\Api\Dashboard\CategoryController;
use App\Http\Controllers\Api\Dashboard\EmployeeController;
use App\Http\Controllers\Api\Dashboard\PermissionController;
use App\Http\Controllers\Api\Dashboard\StaticPageController;
use App\Http\Controllers\Api\Dashboard\StatisticsController;
use App\Http\Controllers\Api\Dashboard\ExportExcelController;
use App\Http\Controllers\Api\Dashboard\HeroSectionController;
use App\Http\Controllers\Api\Dashboard\TestimonialController;
use App\Http\Controllers\Api\Dashboard\JobHierarchyController;
use App\Http\Controllers\Api\Dashboard\NotificationController;
use App\Http\Controllers\Api\Dashboard\RestPasswordController;
use App\Http\Controllers\Api\Dashboard\FinancialMenuController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post("send_otp", [RestPasswordController::class, 'sendOtp']);
Route::post("check_otp", [RestPasswordController::class, 'checkOtp'])->name("check_otp");
Route::post("rest_password", [RestPasswordController::class, 'resetPassword']);
Route::post("resend_otp", [RestPasswordController::class, 'resendOtp']);

Route::group(['middleware' => ['auth:sanctum', 'localization']], function () {

    //***************************Change SERVICE ORDER ***********************//
    Route::post('/services/update_order/{service}', [ServiceController::class, 'updateOrder'])->name('services.update_order');


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('blogs', BlogController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('users', UserController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('settings', SettingController::class)->only(['index', "update"]);
    Route::resource('abouts', AboutController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('contacts', ContactController::class)->except(['store', 'update']);
    Route::resource('settings', SettingController::class)->only(['index', "update"]);
    Route::resource('offers', OfferController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('hero_sections', HeroSectionController::class)->only(['index', 'update']);
    Route::resource('static_pages', StaticPageController::class);
    Route::resource('seo', SeoController::class);
    Route::resource('works', WorkController::class);
    Route::resource('pages', PageController::class);
    Route::resource('jobs', JobHierarchyController::class);
    Route::resource('financial_menus', FinancialMenuController::class);
    Route::get('statistics', [StatisticsController::class, 'getStatistics']);

    /****************************** Roles And Permissions Routes *****************************/

    // roles
    Route::resource('roles', RoleController::class);
    Route::post("assign_role_to_user", [RoleController::class, 'assignRoleToUser']);

    // fetch all permissions
    Route::get('fetch_all_permissions', [PermissionController::class, 'fetchAllPermissions']);
    Route::get('fetch_permission_for_user', [PermissionController::class, 'fetchPermissionForUser']);
    Route::get("fetch_permission_for_role/{role}", [PermissionController::class, 'fetchPermissionForRole']);
    Route::get("fetch_permission_types", [PermissionController::class, 'fetchPermissionTypes']);

    /****************************** End Roles And Permissions Routes *****************************/

    /***************************** profile routes *****************************/
    Route::post('update_profile', [ProfileController::class, "update"]);
    Route::get("show_profile", [ProfileController::class, 'show']);
    /***************************** End profile routes *************************/

    /******************************** Pdf Export Routes *****************************/
    Route::get("export_users", [PdfController::class, 'exportUsers']);
    Route::get("export_employees", [PdfController::class, 'exportEmployees']);
    Route::get("export_contact_us", [PdfController::class, 'exportContactUs']);
    /******************************** End Pdf Export Routes *****************************/

    //**************************List Routes****************************//
    Route::group(['prefix' => 'list'], function () {
        Route::get('blogs', [BlogController::class, 'list'])->name('blogs.list');
        Route::get('employees', [EmployeeController::class, 'list'])->name('employees.list');
        Route::get('users', [UserController::class, 'list'])->name('users.list');
        Route::get('countries', [CountryController::class, 'list'])->name('countries.list');
        Route::get('testimonials', [TestimonialController::class, 'list'])->name('testimonials.list');
        Route::get('services', [ServiceController::class, 'list'])->name('services.list');
        Route::get('partners', [PartnerController::class, 'list'])->name('partners.list');
        Route::get('galleries', [GalleryController::class, 'list'])->name('galleries.list');
        Route::get('offers', [OfferController::class, 'list'])->name('offers.list');
        Route::get('abouts', [AboutController::class, 'list'])->name('abouts.list');
        Route::get('sliders', [SliderController::class, 'list'])->name('sliders.list');
        Route::get("roles", [RoleController::class, 'list']);
        Route::get('static_pages', [StaticPageController::class, 'list'])->name('static_pages.list');
        Route::get("seo", [SeoController::class, 'list']);
        Route::get('works', [WorkController::class, 'list'])->name('works.list');
        Route::get('pages', [PageController::class, 'list']);
        Route::get('categories', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('jobs', [JobHierarchyController::class, 'list'])->name('jobs.list');
        Route::get('financial_menus', [FinancialMenuController::class, 'list'])->name('financial_menus.list');

    });

    //**************************Change Status Routes********************//

    Route::group(['prefix' => 'change_status'], function () {
        Route::get('countries/{country}', [CountryController::class, 'changeStatus'])->name('country.change_status');
        Route::get('testimonials/{testimonial}', [TestimonialController::class, 'changeStatus'])->name(
            'testimonial.change_status'
        );
        Route::get('blogs/{blog}', [BlogController::class, 'changeStatus'])->name('blogs.change_status');
        Route::get('employees/{employee}', [EmployeeController::class, 'changeStatus'])->name(
            'employees.change_status'
        );Route::get('users/{user}', [UserController::class, 'changeStatus'])->name('users.change_status');
        Route::get('countries/{country}', [CountryController::class, 'changeStatus'])->name('country.change_status');
        Route::get('categories/{category}', [CategoryController::class, 'changeStatus'])->name('category.change_status');
        Route::get('galleries/{gallery}', [GalleryController::class, 'changeStatus'])->name('galleries.change_status');
        Route::get('services/{service}', [ServiceController::class, 'changeStatus'])->name('services.change_status');

        Route::get('jobs/{job}', [JobHierarchyController::class, 'changeStatus'])->name('jobs.change_status');
        Route::get('financial_menus/{financial_menu}', [FinancialMenuController::class, 'changeStatus'])->name(
            'financial_menus.change_status'
        );
    
        Route::get('partners/{partner}', [PartnerController::class, 'changeStatus'])->name('partners.change_status');
        Route::get('offers/{offer}', [OfferController::class, 'changeStatus']);
        Route::get('abouts/{about}', [AboutController::class, 'changeStatus'])->name('abouts.change_status');
        Route::get('faqs/{faq}', [FaqController::class, 'changeStatus'])->name('faqs.change_status');
        Route::get('contacts/{contact}', [ContactController::class, 'changeStatus'])->name('contact.change_status');
        Route::get('partners/{partner}', [PartnerController::class, 'changeStatus'])->name('partners.change_status');
        Route::get('sliders/{slider}', [SliderController::class, 'changeStatus'])->name('sliders.change_status');
        Route::get("seo/{seo}", [SeoController::class, 'changeStatus']);
        Route::get('static_pages/{static_page}', [StaticPageController::class, 'changeStatus'])->name(
            'static_pages.change_status'
        );
        Route::get('pages/{page}', [PageController::class, 'changeStatus']);
        Route::get('works/{work}', [WorkController::class, 'changeStatus'])->name('works.change_status');
    });
    //**************************Export Excel Routes********************//
    Route::group(['prefix' => 'export_excel'], function () {
        Route::get('exportEmployees', [ExportExcelController::class, 'exportEmployees']);
        Route::get('exportUsers', [ExportExcelController::class, 'exportUsers']);
        Route::get('exportContacts', [ExportExcelController::class, 'exportContacts']);
    });

    // **************************Notification Routes********************//
    Route::post("send_notification", [NotificationController::class, 'sendNotification']);

});
