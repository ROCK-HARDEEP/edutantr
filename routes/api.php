<?php

use App\Http\Controllers\AccountActivationController;
use App\Http\Controllers\Api\OfferBannerController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\PlanWiseEnrollController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InstructorFavouriteController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\NewslatterSubscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\CollegeGalleryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and are assigned
| the "api" middleware group. The Vue frontend uses axios with baseURL /api.
|
*/

// Localization
Route::get('/lang/{lang}', function (string $lang) {
    $filePath = base_path("lang/{$lang}.json");

    if (!File::exists($filePath)) {
        $filePath = base_path('lang/en.json');
    }

    if (!File::exists($filePath)) {
        return response()->json(['message' => 'Language file not found'], 404);
    }

    return response()->json(json_decode(File::get($filePath), true));
});

// Public routes
Route::get('/master', [MasterController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/course/list', [CourseController::class, 'index']);
Route::get('/course/show/{id}', [CourseController::class, 'show']);

Route::get('/instructor/list', [InstructorController::class, 'index']);
Route::get('/instructor/show/{id}', [InstructorController::class, 'show']);

Route::get('/home/programs', [HomePageController::class, 'programs']);
Route::get('/home/statistics', [HomePageController::class, 'statistics']);
Route::get('/home/partner-colleges', [HomePageController::class, 'partnerColleges']);
Route::get('/home/placements', [HomePageController::class, 'placements']);
Route::get('/home/partner-logos', [HomePageController::class, 'partnerLogos']);

Route::get('/testimonial/list', [TestimonialController::class, 'index']);

Route::get('/college-gallery/sections', [CollegeGalleryController::class, 'sections']);
Route::get('/college-gallery/colleges', [CollegeGalleryController::class, 'colleges']);
Route::get('/college-gallery/list', [CollegeGalleryController::class, 'index']);
Route::get('/college-gallery/grouped', [CollegeGalleryController::class, 'grouped']);

Route::get('/job/categories', [JobController::class, 'categories']);
Route::get('/job/list', [JobController::class, 'index']);
Route::get('/job/show/{job}', [JobController::class, 'show']);
Route::get('/banner/list', [OfferBannerController::class, 'index']);

Route::get('/plan/list', [PlanController::class, 'index']);
Route::get('/plan/show/{plan}', [PlanController::class, 'show']);

Route::get('/blog/list', [BlogController::class, 'index']);
Route::get('/blog/show/{blog}', [BlogController::class, 'show']);

Route::get('/page/list', [PageController::class, 'index']);
Route::get('/page/show/{slug}', [PageController::class, 'show']);

Route::post('/contact/submit', [ContactMessageController::class, 'submit']);
Route::post('/newslatter/subscribe', [NewslatterSubscriptionController::class, 'subscribe']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::post('/reset-password', [ResetPasswordController::class, 'index']);
Route::post('/reset-password/validate', [ResetPasswordController::class, 'validateOtp']);

Route::get('/coupon/validate', [EnrollController::class, 'verifyCoupon']);
Route::get('/sales-team/validate', [App\Http\Controllers\SalesTeamApiController::class, 'validateCode']);

Route::post('/guest', [GuestController::class, 'store']);

// Payment callbacks (used by payment gateways)
Route::get('/payment/{identifier}', [EnrollController::class, 'paymentView'])->name('payment');
Route::get('/paypal/payment/success/{identifier}', [PaymentController::class, 'paypalPaymentSuccess'])->name('paypal.payment.success');
Route::get('/paypal/payment/cancel', [PaymentController::class, 'paypalPaymentCancel'])->name('paypal.payment.cancel');
Route::get('/stripe/payment/success/{identifier}', [PaymentController::class, 'stripePaymentSuccess'])->name('stripe.payment.success');
Route::get('/stripe/payment/cancel', [PaymentController::class, 'stripePaymentCancel'])->name('stripe.payment.cancel');
Route::post('/aamarpay/payment/success', [PaymentController::class, 'aamarpayPaymentSuccess'])->name('aamrpay.payment.success');
Route::post('/aamarpay/payment/fail', [PaymentController::class, 'aamarpayPaymentFail'])->name('aamrpay.payment.fail');
Route::get('/aamarpay/payment/cancel', [PaymentController::class, 'aamarpayPaymentCancel'])->name('aamrpay.payment.cancel');
Route::match(['get', 'post'], '/razorpay/payment/success/{identifier}', [PaymentController::class, 'razorPaySuccess'])->name('razorpay.payment.success');
Route::post('/razorpay/payment/fail', [PaymentController::class, 'razorpayPaymentFail'])->name('razorpay.payment.fail');
Route::get('/paymob/payment/success', [PaymentController::class, 'paymobPaymentSuccess'])->name('paymob.payment.success');
Route::get('/paymob/payment/fail', [PaymentController::class, 'paymobPaymentFail'])->name('paymob.payment.fail');
Route::get('/paymob/payment/cancel', [PaymentController::class, 'paymobPaymentCancel'])->name('paymob.payment.cancel');

// Certificate verification (public)
Route::get('/certificate/verify/{courseId}/{userId}', [CertificateController::class, 'showCertificate'])->name('show.certificate');
Route::get('/certificate/download/{encodeData}', [CertificateController::class, 'downloadCertificate'])->name('download.certificate');

// Authenticated routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/profile', [UserController::class, 'index']);
    Route::post('/profile/update', [UserController::class, 'update']);
    Route::patch('/update-password', [UserController::class, 'updatePassword']);
    Route::delete('/user/delete', [UserController::class, 'delete']);

    Route::get('/enrolled_courses', [EnrollController::class, 'index']);
    Route::get('/enroll_summary', [EnrollController::class, 'summary']);
    Route::get('/enroll/{course_id}', [EnrollController::class, 'initiateTransaction']);
    Route::get('/free/enroll/{course}', [EnrollController::class, 'freeEnrollment']);
    Route::get('/plan-enroll', [EnrollController::class, 'planWiseTransaction']);
    Route::get('/enroll-plans', [PlanWiseEnrollController::class, 'planWiseEnrollList']);

    Route::get('/transactions', [PaymentController::class, 'index']);

    Route::post('/view_content/{content}', [CourseController::class, 'viewContent']);
    Route::get('/course/{course}/progress', [CourseController::class, 'getProgress']);
    Route::post('/course/{course}/progress', [CourseController::class, 'progress']);

    Route::get('/certificate/list', [CertificateController::class, 'index']);
    Route::get('/certificate/show/{id}', [CertificateController::class, 'show']);

    Route::get('/student-certificate/list', [App\Http\Controllers\StudentCertificateController::class, 'index']);
    Route::get('/student-certificate/show/{studentCertificate}', [App\Http\Controllers\StudentCertificateController::class, 'show']);

    Route::get('/quiz/start/{quiz}', [QuizController::class, 'start']);
    Route::post('/quiz/submit/{quizSession}', [QuizController::class, 'submit']);

    Route::get('/exam/start/{exam}', [ExamController::class, 'start']);
    Route::post('/exam/submit/{examSession}', [ExamController::class, 'submit']);

    Route::post('/course/{course}/review', [ReviewController::class, 'store']);

    Route::get('/favourite/courses', [FavouriteController::class, 'index']);
    Route::post('/favourite/course/{course}', [FavouriteController::class, 'modify']);

    Route::get('/favourite/instructors', [InstructorFavouriteController::class, 'index']);
    Route::post('/favourite/instructor/{instructor}', [InstructorFavouriteController::class, 'modify']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read/{notificationInstance}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAsReadAll']);

    Route::post('/account/activation/send', [AccountActivationController::class, 'sendActivationCode']);
    Route::post('/account/activation', [AccountActivationController::class, 'activateAccount']);

    Route::post('/job/apply/{job}', [JobController::class, 'apply']);
    Route::get('/job/my-applications', [JobController::class, 'myApplications']);
});
