<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CohortController as AdminCohortController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Site\BookingController;
use App\Http\Controllers\Site\CommunityController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\InsightController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\SubscriberController;
use App\Http\Controllers\Site\WorkController;
use Illuminate\Support\Facades\Route;

/*
| Public site
*/
Route::get('/', HomeController::class)->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{project}', [WorkController::class, 'show'])->name('work.show');

Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/cohorts/{cohort}', [CommunityController::class, 'cohort'])->name('community.cohort');
Route::get('/community/courses/{course}', [CommunityController::class, 'course'])->name('community.course');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{post}', [InsightController::class, 'show'])->name('insights.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [BookingController::class, 'create'])->name('contact');
Route::post('/contact', [BookingController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');
Route::post('/subscribe', [SubscriberController::class, 'store'])->middleware('throttle:10,1')->name('subscribe');

/*
| Admin
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->middleware('throttle:6,1');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('services', AdminServiceController::class)->except('show');
        Route::resource('projects', AdminProjectController::class)->except('show');
        Route::resource('cohorts', AdminCohortController::class)->except('show');
        Route::resource('courses', AdminCourseController::class)->except('show');
        Route::resource('testimonials', AdminTestimonialController::class)->except('show');
        Route::resource('posts', AdminPostController::class)->except('show');

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
        Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

        Route::get('subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});

// Laravel redirects unauthenticated users to the route named "login".
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
