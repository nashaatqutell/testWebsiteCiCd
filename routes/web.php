<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blade\Dashboard\FaqController;
use App\Http\Controllers\Blade\Dashboard\SeoController;
use App\Http\Controllers\Blade\Dashboard\BlogController;
use App\Http\Controllers\Blade\Dashboard\PageController;
use App\Http\Controllers\Blade\Dashboard\RoleController;
use App\Http\Controllers\Blade\Dashboard\UserController;
use App\Http\Controllers\Blade\Dashboard\WorkController;
use App\Http\Controllers\Blade\Dashboard\AboutController;
use App\Http\Controllers\Blade\Dashboard\OfferController;
use App\Http\Controllers\Blade\Dashboard\SliderController;
use App\Http\Controllers\Blade\Dashboard\ContactController;
use App\Http\Controllers\Blade\Dashboard\CountryController;
use App\Http\Controllers\Blade\Dashboard\GalleryController;
use App\Http\Controllers\Blade\Dashboard\PartnerController;
use App\Http\Controllers\Blade\Dashboard\ProfileController;
use App\Http\Controllers\Blade\Dashboard\ServiceController;
use App\Http\Controllers\Blade\Dashboard\SettingController;
use App\Http\Controllers\Blade\Dashboard\ActivityController;
use App\Http\Controllers\Blade\Dashboard\CategoryController;
use App\Http\Controllers\Blade\Dashboard\EmployeeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Blade\Dashboard\DashboardController;
use App\Http\Controllers\Blade\Dashboard\NewsLetterController;
use App\Http\Controllers\Blade\Dashboard\StaticPageController;
use App\Http\Controllers\Blade\Dashboard\HeroSectionController;
use App\Http\Controllers\Blade\Dashboard\TestimonialController;
use App\Http\Controllers\Blade\Dashboard\JobHierarchyController;
use App\Http\Controllers\Blade\Dashboard\FinancialMenuController;


##----------------------------------- ADMIN ROUTES
Route::name('admin.')->prefix(LaravelLocalization::setLocale() . '/admin')->middleware(
    'localeSessionRedirect',
    'localizationRedirect',
    'localeViewPath'
)->group(function () {
    Route::middleware(['auth:web', 'employeeStatus'])->group(function () {
        ##============================== HOME PAGE
        Route::get('', [DashboardController::class, "index"])->name('index');

        ##============================== BLOGS
        Route::resource("blogs", BlogController::class);

        ##============================== SEOS
        Route::resource("seo", SeoController::class);

        ##============================== SETTINGS
        Route::resource('settings', SettingController::class)->only(["update", "edit"]);

        ##============================== EMPLOYEES
        Route::resource('employees', EmployeeController::class);

        ##============================== GALLERIES
        Route::resource('galleries', GalleryController::class);

        ##============================== USERS
        Route::resource('users', UserController::class);

        ##============================== FAQS
        Route::resource('faqs', FaqController::class);

        ##============================== COUNTRIES
        Route::resource('countries', CountryController::class);

        ##============================== TESTIMONIALS
        Route::resource('testimonials', TestimonialController::class);

        ##============================== ABOUTS
        Route::resource('abouts', AboutController::class)->except(["index", "create", "edit"]);
        Route::get("fetch_abouts/{type}", [AboutController::class, "fetch_abouts"])->name("abouts.fetch_abouts");
        Route::get("create_abouts/{type}", [AboutController::class, "create"])->name("abouts.create");
        Route::get("edit_abouts/{about}/{type}", [AboutController::class, "edit"])->name("abouts.edit");

        ##============================== OFFERS
        Route::resource('offers', OfferController::class);

        ##============================== SERVICES
        Route::get('services/child', [ServiceController::class, "getChildService"])->name("services.getChildService");
        Route::resource('services', ServiceController::class);

        ##============================== CATEGORIES
        Route::resource('categories', CategoryController::class);

        ##============================== WORKS
        Route::resource('works', WorkController::class);

        ##============================== PARTNERS
        Route::resource('partners', PartnerController::class);

        ##============================== HERO SCTION
        Route::resource('hero_sections', HeroSectionController::class);

        ##============================== PAGES
        Route::resource('pages', PageController::class);

        ##============================== Financial Menu
        Route::resource('financial_menus', FinancialMenuController::class);

        ##============================== JOBS
        Route::resource('jobs', JobHierarchyController::class)->except('show');
        // child jobs
        Route::get('jobs/child', [JobHierarchyController::class, "getChildJob"])->name("jobs.ChildJob");
        ##============================== CONTACTS
        Route::resource('contacts', ContactController::class)->only(['index', 'destroy']);

        ##============================== ROLES
        Route::resource('roles', RoleController::class);

        ##============================== PROFILE
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/show/{user}', [ProfileController::class, 'show'])->name('profile.show');

        ##============================== SLIDER
        Route::resource('sliders', SliderController::class);

        ##============================== StaticPages
        Route::resource('static_pages', StaticPageController::class)->except('show');

        ##============================== NewsLetters
        Route::get('fetch_news_letters', [NewsLetterController::class, 'index'])->name('fetch_news_letters');
        ##============================== ACTIVITY LOGS
        Route::get('fetch_activity_log', [ActivityController::class, 'index'])->name('fetch_activity');
        ##============================================== Change Status
        Route::group(['prefix' => 'change_status'], function () {
            Route::get('offers/{offer}', [OfferController::class, 'changeStatus']);
            Route::post("seo/{seo}", [SeoController::class, 'changeStatus'])->name('seo.changeStatus');
            Route::post("blogs/{blog}", [BlogController::class, 'changeStatus'])->name('blogs.changeStatus');
            Route::post("countries/{country}", [CountryController::class, 'changeStatus'])->name('countries.changeStatus');
            Route::post("categories/{category}", [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
            Route::post("jobs/{job}", [JobHierarchyController::class, 'changeStatus'])->name('jobs.changeStatus');
            Route::post("financial_menus/{financial_menu}", [FinancialMenuController::class, 'changeStatus'])->name(
                'financial_menus.changeStatus'
            );
            Route::post("testimonials/{testimonial}", [TestimonialController::class, 'changeStatus'])->name('testimonials.changeStatus');
            Route::post("abouts/{about}", [AboutController::class, 'changeStatus'])->name('abouts.changeStatus');
            Route::post("faqs/{faq}", [FaqController::class, 'changeStatus'])->name('faqs.changeStatus');
            Route::get('services/{service}', [ServiceController::class, 'changeStatus']);
            Route::post("employees/{employee}", [EmployeeController::class, 'changeStatus'])->name('employees.changeStatus');
            Route::post("contacts/{contact}", [ContactController::class, 'changeStatus'])->name('contacts.changeStatus');
            Route::get('works/{work}', [WorkController::class, 'changeStatus']);
            Route::post('galleries/{gallery}', [GalleryController::class, 'changeStatus'])->name('galleries.changeStatus');
            Route::get('partners/{partner}', [PartnerController::class, 'changeStatus']);
            Route::get('pages/{page}', [PageController::class, 'changeStatus']);
            Route::post("roles/{role}", [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
            Route::get('static_pages/{staticpage}', [StaticPageController::class, 'changeStatus']);
            Route::get('sliders/{slider}', [SliderController::class, 'changeStatus']);
            Route::post("users/{user}", [UserController::class, 'changeStatus'])->name("users.changeStatus");

        });

        Route::group(['prefix' => 'change_show'], function () {
            Route::get('services/{service}', [ServiceController::class, 'changeStatusFront'])->name('services.change_show');
        });

        Route::group(['prefix' => 'change_order'], function () {
            Route::get('services/{service}', [ServiceController::class, 'changeOrder'])->name('services.change_order');
            Route::get('abouts/{about}', [AboutController::class, 'changeOrder'])->name('abouts.change_order');

        });
    });


    require __DIR__ . '/auth.php';
});
