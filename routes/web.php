<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAdmin\LoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Org\Auth\RegisterController;
use App\Http\Controllers\Org\Home\HomeController;

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

// ============================================
// AUTHENTICATION ROUTES (Guest)
// ============================================
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');

Route::get('/instructor/register', [LoginController::class, 'instructorRegister'])->name('instructor.register')->middleware('guest');
Route::post('/instructor/register', [LoginController::class, 'instructorAuthenticate'])->name('instructor.authenticate');

Route::get('/organization/register', [RegisterController::class, 'register'])->name('org.register')->middleware('guest');
Route::post('/organization/register', [RegisterController::class, 'authenticate'])->name('org.authentication');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES (Authenticated)
// ============================================
Route::prefix('admin')->middleware(['auth', 'restrict_sales_counselor', 'adminauth'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\WebAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [App\Http\Controllers\WebAdmin\DashboardController::class, 'statistics'])->name('statistics');
    
    // Profile
    Route::get('/profile/{user}', [App\Http\Controllers\WebAdmin\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{user}', [App\Http\Controllers\WebAdmin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/image/update', [App\Http\Controllers\WebAdmin\ProfileController::class, 'updateImage'])->name('profile.image.update');
    
    // Admin Users
    Route::get('/root/sup-admin/list', [App\Http\Controllers\WebAdmin\UserController::class, 'admin'])->name('index');
    Route::get('/root/assistant-admin/list', [App\Http\Controllers\WebAdmin\UserController::class, 'subAdmin'])->name('assistant.index');
    Route::get('/admin-users/create', [App\Http\Controllers\WebAdmin\UserController::class, 'create'])->name('create');
    Route::post('/admin-users', [App\Http\Controllers\WebAdmin\UserController::class, 'store'])->name('store');
    
    // Organizations Management
    Route::resource('organizations', App\Http\Controllers\WebAdmin\AdminOrgManagementController::class);
    Route::get('/organizations/{organization}/subscribers', [App\Http\Controllers\WebAdmin\AdminOrgManagementController::class, 'subscribers'])->name('organizations.subscribers');
    Route::resource('organizations/plan', App\Http\Controllers\WebAdmin\PlanController::class)->names([
        'index' => 'organizations.plan.index',
        'create' => 'organizations.plan.create',
        'store' => 'organizations.plan.store',
        'edit' => 'organizations.plan.edit',
        'update' => 'organizations.plan.update',
        'destroy' => 'organizations.plan.destroy'
    ]);
    
    // Settings
    Route::get('/setting', [App\Http\Controllers\WebAdmin\SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [App\Http\Controllers\WebAdmin\SettingController::class, 'store'])->name('setting.store');
    Route::put('/setting', [App\Http\Controllers\WebAdmin\SettingController::class, 'update'])->name('setting.update');
    Route::get('/setting/home-page-setup', [App\Http\Controllers\WebAdmin\SettingController::class, 'homePageSetup'])->name('setting.home.page.setup');
    Route::post('/setting/home-page-setup', [App\Http\Controllers\WebAdmin\SettingController::class, 'homePageSetupStore'])->name('setting.home.page.setup.store');
    Route::get('/setting/smtp-setup', [App\Http\Controllers\WebAdmin\SettingController::class, 'smtpSetup'])->name('setting.smtp.setup');
    Route::post('/setting/smtp-setup', [App\Http\Controllers\WebAdmin\SettingController::class, 'smtpSetupStore'])->name('setting.smtp.setup.store');
    Route::get('/setting/social-media', [App\Http\Controllers\WebAdmin\SettingController::class, 'socialMediaSetup'])->name('setting.social.media.setup');
    Route::post('/setting/social-media', [App\Http\Controllers\WebAdmin\SettingController::class, 'update'])->name('setting.social.media.store');
    
    // Server Configuration
    Route::resource('server', App\Http\Controllers\WebAdmin\ServerConfigurationController::class)->only(['index', 'store']);
    
    // Storage Link
    Route::post('/storage-link', [App\Http\Controllers\WebAdmin\StorageLinkController::class, 'store'])->name('link.storage');
    
    // Cache Clear
    Route::post('/cache-clear', [App\Http\Controllers\WebAdmin\SettingController::class, 'clearCache'])->name('cache.clear');
});

// ============================================
// INSTRUCTOR ROUTES (Authenticated)
// ============================================
Route::prefix('instructor')->middleware(['auth', 'restrict_sales_counselor'])->name('instructor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\WebAdmin\DashboardController::class, 'instructorDashboard'])->name('dashboard');
    
    // Instructor CRUD (Admin access)
    Route::middleware('adminauth')->group(function () {
        Route::get('/', [App\Http\Controllers\WebAdmin\InstructorController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\WebAdmin\InstructorController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\WebAdmin\InstructorController::class, 'store'])->name('store');
        Route::get('/{instructor}/edit', [App\Http\Controllers\WebAdmin\InstructorController::class, 'edit'])->name('edit');
        Route::put('/{instructor}', [App\Http\Controllers\WebAdmin\InstructorController::class, 'update'])->name('update');
        Route::delete('/{instructor}', [App\Http\Controllers\WebAdmin\InstructorController::class, 'destroy'])->name('destroy');
        Route::post('/{instructor}/restore', [App\Http\Controllers\WebAdmin\InstructorController::class, 'restore'])->name('restore');
        Route::get('/featured', [App\Http\Controllers\WebAdmin\InstructorController::class, 'featured'])->name('featured');
        Route::get('/promote/{user}', [App\Http\Controllers\WebAdmin\InstructorController::class, 'promote'])->name('promote');
        Route::post('/migrate/{user}', [App\Http\Controllers\WebAdmin\InstructorController::class, 'migrate'])->name('migrate');
    });
});

// ============================================
// SALES COUNSELOR ROUTES (Authenticated)
// ============================================
Route::prefix('sales')->middleware(['auth', 'sales_counselor'])->name('sales.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Sales\SalesCounselorController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [App\Http\Controllers\Sales\SalesStudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [App\Http\Controllers\Sales\SalesStudentController::class, 'create'])->name('students.create');
    Route::post('/students', [App\Http\Controllers\Sales\SalesStudentController::class, 'store'])->name('students.store');
    Route::get('/students/{user}/edit', [App\Http\Controllers\Sales\SalesStudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{user}', [App\Http\Controllers\Sales\SalesStudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{user}', [App\Http\Controllers\Sales\SalesStudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/courses', [App\Http\Controllers\Sales\SalesCounselorController::class, 'courses'])->name('courses');
    Route::get('/leaderboard', [App\Http\Controllers\Sales\SalesCounselorController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/leaderboard/data', [App\Http\Controllers\Sales\SalesCounselorController::class, 'leaderboardData'])->name('leaderboard.data');
    Route::get('/profile', [App\Http\Controllers\Sales\SalesCounselorController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\Sales\SalesCounselorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/image', [App\Http\Controllers\Sales\SalesCounselorController::class, 'updateProfileImage'])->name('profile.image.update');
});

// ============================================
// ORGANIZATION ROUTES (Authenticated)
// ============================================
Route::prefix('organizations')->middleware(['auth', 'restrict_sales_counselor', 'org_check'])->name('org.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/chart/revenue-data', [HomeController::class, 'revenue'])->name('chart.revenue');
    
    // Profile
    Route::get('/profile/{user}', [App\Http\Controllers\WebAdmin\ProfileController::class, 'index'])->name('profile');
    
    // Site Settings
    Route::get('/site-settings', [App\Http\Controllers\Org\OrganizationSiteSettingsController::class, 'index'])->name('site.setting.index');
    Route::post('/site-settings', [App\Http\Controllers\Org\OrganizationSiteSettingsController::class, 'store'])->name('site.setting.store');
    
    // DNS Configuration
    Route::get('/dns-configuration', [App\Http\Controllers\Org\DnsConfigController::class, 'index'])->name('dns.index');
    Route::post('/dns-configuration', [App\Http\Controllers\Org\DnsConfigController::class, 'store'])->name('dns.store');
    
    // Pricing Plans
    Route::get('/pricing', [App\Http\Controllers\Org\OrgDnsPricingController::class, 'index'])->name('pricing.index');
    Route::post('/pricing/payment/{plan}', [App\Http\Controllers\PaymentController::class, 'initiatePlanPayment'])->name('pricing.payment.initiate');
    
    // Plan Management
    Route::get('/plan', [App\Http\Controllers\Org\PlanManagementController::class, 'index'])->name('plan.index');
    Route::get('/plan/billing-history', [App\Http\Controllers\Org\PlanManagementController::class, 'billingHistory'])->name('plan.billing.history');
    Route::get('/plan-expired', function() { return view('organization.plan-expired'); })->name('plan.expired');
    
    // Transaction
    Route::get('/transactions', [App\Http\Controllers\WebAdmin\TransactionController::class, 'orgIndex'])->name('transaction');
});

// ============================================
// SHARED ROUTES (Admin & Organization)
// ============================================
Route::middleware(['auth', 'restrict_sales_counselor'])->group(function () {
    // Categories
    Route::post('/categories/sort', [App\Http\Controllers\WebAdmin\CategoryController::class, 'sort'])->name('category.sort');
    Route::resource('categories', App\Http\Controllers\WebAdmin\CategoryController::class)->names([
        'index' => 'category.index',
        'create' => 'category.create',
        'store' => 'category.store',
        'edit' => 'category.edit',
        'update' => 'category.update',
        'destroy' => 'category.destroy'
    ]);
    
    // Courses
    Route::get('/courses/restore/list', [App\Http\Controllers\WebAdmin\CourseController::class, 'restoreCourse'])->name('course.restore.list');
    Route::post('/courses/restore/{course}', [App\Http\Controllers\WebAdmin\CourseController::class, 'restore'])->name('course.restore');
    Route::post('/courses/free/{course}', [App\Http\Controllers\WebAdmin\CourseController::class, 'freeCourse'])->name('course.free');
    Route::resource('courses', App\Http\Controllers\WebAdmin\CourseController::class)->names([
        'index' => 'course.index',
        'create' => 'course.create',
        'store' => 'course.store',
        'show' => 'course.show',
        'edit' => 'course.edit',
        'update' => 'course.update',
        'destroy' => 'course.destroy'
    ]);
    
    // Chapters
    Route::get('/chapter/select-course', [App\Http\Controllers\WebAdmin\ChapterController::class, 'selectCourse'])->name('chapter.select_course');
    Route::get('/chapter/course/{course}', [App\Http\Controllers\WebAdmin\ChapterController::class, 'index'])->name('chapter.index');
    Route::get('/chapter/course/{course}/create', [App\Http\Controllers\WebAdmin\ChapterController::class, 'create'])->name('chapter.create');
    Route::resource('chapter', App\Http\Controllers\WebAdmin\ChapterController::class)->except(['index', 'create']);
    
    // Exams
    Route::get('/exam/select-course', [App\Http\Controllers\WebAdmin\ExamController::class, 'selectCourse'])->name('exam.select_course');
    Route::get('/exam/course/{course}', [App\Http\Controllers\WebAdmin\ExamController::class, 'index'])->name('exam.index');
    Route::get('/exam/course/{course}/create', [App\Http\Controllers\WebAdmin\ExamController::class, 'create'])->name('exam.create');
    Route::resource('exam', App\Http\Controllers\WebAdmin\ExamController::class)->except(['index', 'create']);
    
    // Quizzes
    Route::get('/quiz/select-course', [App\Http\Controllers\WebAdmin\QuizController::class, 'selectCourse'])->name('quiz.select_course');
    Route::get('/quiz/course/{course}', [App\Http\Controllers\WebAdmin\QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/course/{course}/create', [App\Http\Controllers\WebAdmin\QuizController::class, 'create'])->name('quiz.create');
    Route::resource('quiz', App\Http\Controllers\WebAdmin\QuizController::class)->except(['index', 'create']);
    
    // Users
    Route::get('/user/import/sample', [App\Http\Controllers\WebAdmin\UserController::class, 'downloadImportSample'])->name('user.import.sample');
    Route::post('/user/import', [App\Http\Controllers\WebAdmin\UserController::class, 'import'])->name('user.import');
    Route::resource('user', App\Http\Controllers\WebAdmin\UserController::class);
    
    // Enrollments
    Route::get('/enrollment/export-csv', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'exportCSV'])->name('enrollment.exportCSV');
    Route::get('/enrollment/generate-pdf', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'generatePdf'])->name('enrollment.generate.pdf');
    Route::get('/enrollment/{id}/restore', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'restore'])->name('enrollment.restore');
    Route::get('/enrollment/{enrollment}/suspended', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'suspended'])->name('enrollment.suspended');
    Route::delete('/enrollment/{enrollment}', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'delete'])->name('enrollment.destroy');
    Route::post('/enrollment/{enrollment}/update-certificate-name', [App\Http\Controllers\WebAdmin\EnrollmentController::class, 'nameUpdate'])->name('enrollment.enrollment.update_certificate_name');
    Route::resource('enrollment', App\Http\Controllers\WebAdmin\EnrollmentController::class)->only(['index']);
    
    // Reviews
    Route::resource('review', App\Http\Controllers\WebAdmin\ReviewController::class)->only(['index', 'destroy']);
    
    // Subscription Plans
    Route::get('/plan/trash/all', [App\Http\Controllers\WebAdmin\PlanController::class, 'trash'])->name('plan.trash');
    Route::post('/plan/publish', [App\Http\Controllers\WebAdmin\PlanController::class, 'publish'])->name('plan.publish');
    Route::post('/plan/restore/{plan}', [App\Http\Controllers\WebAdmin\PlanController::class, 'restore'])->name('plan.restore');
    Route::post('/plan/delete/{plan}', [App\Http\Controllers\WebAdmin\PlanController::class, 'delete'])->name('plan.delete');
    Route::resource('plan', App\Http\Controllers\WebAdmin\PlanController::class)->except(['show', 'destroy']);
    
    // Coupons
    Route::resource('coupon', App\Http\Controllers\WebAdmin\CouponController::class);
    
    // Transactions
    Route::get('/transaction', [App\Http\Controllers\WebAdmin\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/failed', [App\Http\Controllers\WebAdmin\TransactionController::class, 'failedTransaction'])->name('transaction.failed');
    Route::get('/transaction/courses', [App\Http\Controllers\WebAdmin\TransactionController::class, 'courseWiseTransaction'])->name('transaction.courses');
    Route::get('/transaction/invoices', [App\Http\Controllers\WebAdmin\TransactionController::class, 'invoiceWiseTransaction'])->name('transaction.invoices');
    Route::get('/transaction/subscriptions', [App\Http\Controllers\WebAdmin\TransactionController::class, 'subscriptionWiseTransaction'])->name('transaction.subscriptions');
    Route::get('/transaction/dns-plans', [App\Http\Controllers\WebAdmin\TransactionController::class, 'dnsWiseTransaction'])->name('transaction.dns.plans');
    
    // Invoices
    Route::resource('invoice', App\Http\Controllers\WebAdmin\InvoicesController::class);
    Route::get('/invoice/trash/all', [App\Http\Controllers\WebAdmin\InvoicesController::class, 'trash'])->name('invoice.trash');
    
    // Banners
    Route::resource('banner', App\Http\Controllers\WebAdmin\BannerController::class)->only(['index', 'store', 'update']);
    Route::post('/banner/publish', [App\Http\Controllers\WebAdmin\BannerController::class, 'publish'])->name('banner.publish');
    Route::get('/banner/{id}/delete', [App\Http\Controllers\WebAdmin\BannerController::class, 'delete'])->name('banner.delete');
    
    // Testimonials
    Route::resource('testimonial', App\Http\Controllers\WebAdmin\TestimonialController::class);

    // Home page content
    Route::resource('home-program', App\Http\Controllers\WebAdmin\HomeProgramController::class);
    Route::resource('home-statistic', App\Http\Controllers\WebAdmin\HomeStatisticController::class);
    Route::resource('partner-college', App\Http\Controllers\WebAdmin\PartnerCollegeController::class);
    Route::resource('home-placement', App\Http\Controllers\WebAdmin\HomePlacementController::class);
    Route::resource('partner-logo', App\Http\Controllers\WebAdmin\PartnerLogoController::class);
    Route::resource('college-gallery', App\Http\Controllers\WebAdmin\CollegeGalleryItemController::class)->except(['show']);

    // Career Portal
    Route::resource('job-category', App\Http\Controllers\WebAdmin\JobCategoryController::class);
    Route::resource('job-post', App\Http\Controllers\WebAdmin\JobPostController::class);
    Route::get('/job-post/{job_post}/close', [App\Http\Controllers\WebAdmin\JobPostController::class, 'close'])->name('job-post.close');
    Route::resource('job-application', App\Http\Controllers\WebAdmin\JobApplicationController::class)->only(['index', 'show', 'update']);
    
    // Contact Messages
    Route::resource('contact', App\Http\Controllers\WebAdmin\ContactController::class)->only(['index', 'destroy']);
    
    // Pages
    Route::resource('page', App\Http\Controllers\WebAdmin\PageController::class)->only(['index', 'edit', 'update']);
    
    // Certificates
    Route::get('/certificate', [App\Http\Controllers\WebAdmin\ManageCertificateController::class, 'index'])->name('certificate.index');
    Route::post('/certificate', [App\Http\Controllers\WebAdmin\ManageCertificateController::class, 'update'])->name('certificate.update');
    Route::get('/certificate/frame/{id}/delete', [App\Http\Controllers\WebAdmin\ManageCertificateController::class, 'delete'])->name('certificate.delete');
    
    // Roles & Permissions
    Route::resource('role', App\Http\Controllers\WebAdmin\UserRoleController::class);
    Route::post('/role/assign-permission', [App\Http\Controllers\WebAdmin\UserRoleController::class, 'assignRoleToPermission'])->name('role.assign_roletopermission');
    Route::get('/role/get-permission/{role}', [App\Http\Controllers\WebAdmin\UserRoleController::class, 'getPermission'])->name('role.get_permission');
    Route::post('/role/assign-user', [App\Http\Controllers\WebAdmin\UserRoleController::class, 'assignRoleToUser'])->name('role.assign_roletouser');
    Route::post('/role/dispatch/{user}', [App\Http\Controllers\WebAdmin\UserRoleController::class, 'dispatchRole'])->name('role.dispatchRole');
    
    // Language Management
    Route::get('/language/default/{language}', [App\Http\Controllers\LanguageController::class, 'setDefaultLanguage'])->name('language.default');
    Route::get('/language/delete/{langId}', [App\Http\Controllers\LanguageController::class, 'delete'])->name('language.delete');
    Route::post('/language/import/{langId}', [App\Http\Controllers\LanguageController::class, 'import'])->name('language.import');
    Route::post('/language/export/{langId}', [App\Http\Controllers\LanguageController::class, 'export'])->name('language.export');
    Route::resource('language', App\Http\Controllers\LanguageController::class);
    Route::post('/change-language', [App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('change.language');
    
    // Subscribers
    Route::resource('subscriber', App\Http\Controllers\WebAdmin\SubscribersController::class)->only(['index', 'destroy']);
    
    // Notifications
    Route::get('/notification', [App\Http\Controllers\WebAdmin\NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/custom', [App\Http\Controllers\WebAdmin\CustomNotificationController::class, 'index'])->name('notification.custom.index');
    Route::post('/notification/custom/send', [App\Http\Controllers\WebAdmin\CustomNotificationController::class, 'sendMessage'])->name('custom.send.message');
    Route::post('/notification/read/{id}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notification.read');
    Route::post('/notification/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notification.read.all');
    
    // Newsletter
    Route::resource('newslatter', App\Http\Controllers\WebAdmin\NewslatterController::class)->only(['index', 'destroy']);
    
    // Reports
    Route::get('/report', [App\Http\Controllers\WebAdmin\ReportController::class, 'index'])->name('report.index');

    // Sales Teams & Revenue Leaderboard
    Route::resource('sales-team', App\Http\Controllers\WebAdmin\SalesTeamController::class)->except(['show']);
    Route::get('/revenue-leaderboard', [App\Http\Controllers\WebAdmin\RevenueLeaderboardController::class, 'index'])->name('revenue-leaderboard.index');
    Route::get('/revenue-leaderboard/data', [App\Http\Controllers\WebAdmin\RevenueLeaderboardController::class, 'data'])->name('revenue-leaderboard.data');
    
    // Payment Gateway
    Route::resource('payment_gateway', App\Http\Controllers\WebAdmin\PaymentGatewayController::class);
    
    // Blogs
    Route::resource('blog', App\Http\Controllers\WebAdmin\BlogController::class);
});

// ============================================
// PUBLIC/FRONTEND ROUTES (Vue.js SPA)
// ============================================
// Exclude admin, instructor, organization paths from Vue catch-all
Route::get('/', [FrontendController::class, 'spa']);
Route::get('/{any}', [FrontendController::class, 'spa'])
    ->where('any', '^(?!admin|instructor|organization|organizations|sales).*$');
