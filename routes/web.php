<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\Gateways\PaytmController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\ManageBookingController;
use App\Http\Controllers\Admin\ManageGatewayController;
use App\Http\Controllers\Admin\ManageLanguageController;
use App\Http\Controllers\Admin\ManageProviderController;
use App\Http\Controllers\Admin\ManageSectionController;
use App\Http\Controllers\Admin\ManageServiceController;
use App\Http\Controllers\Admin\ManageSubscriptionController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageWithdrawController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('demo')->group(function(){
    Route::get('/admin',function(){
        return redirect()->route('admin.login');
        });
        
        Route::name('admin.')->prefix('admin')->group(function () {
        
            Route::get('login', [LoginController::class, 'login'])->name('login');
            Route::post('login', [LoginController::class, 'loggedIn'])->withoutMiddleware('demo');
        
            Route::get('forgot/password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
            Route::post('forgot/password', [ForgotPasswordController::class, 'sendVerification']);
            Route::get('verify/code', [ForgotPasswordController::class, 'verify'])->name('auth.verify');
            Route::post('verify/code', [ForgotPasswordController::class, 'verifyCode']);
            Route::get('reset/password', [ForgotPasswordController::class, 'reset'])->name('reset.password');
            Route::post('reset/password', [ForgotPasswordController::class, 'resetPassword']);
        
            
        
            Route::middleware(['admin'])->group(function () {
                Route::get('dashboard', [AdminController::class, 'home'])->name('dashboard');
        
                Route::get('change/lang/{code?}',[AdminController::class,'changeLang'])->name('change');
        
                Route::post('clear/database',[AdminController::class,'clearDatabase'])->name('db.clear');
                
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        
                Route::get('profile', [AdminController::class, 'profile'])->name('profile');
                Route::post('profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
        
        
                Route::get('login/setting', [AdminController::class, 'loginPage'])->name('login.setting');
                Route::post('login/setting', [AdminController::class, 'loginPageUpdate']);
        
                Route::post('change/password', [AdminController::class, 'changePassword'])->name('change.password');
        
                // Providers 
        
                Route::get('providers', [ManageProviderController::class, 'index'])->name('provider');
                Route::post('provider/send/mail/{provider}', [ManageProviderController::class, 'sendProviderMail'])->name('send.provider.mail');
                Route::post('provider/update/{provider}', [ManageProviderController::class, 'providerUpdate'])->name('provider.update');
        
                Route::get('providers/details/{provider}', [ManageProviderController::class, 'providerDetails'])->name('provider.details');
                Route::get('providers/search', [ManageProviderController::class, 'index'])->name('provider.search');
                Route::get('providers/featured', [ManageProviderController::class, 'featuredProvider'])->name('provider.featured');
               
        
                // User
        
                Route::get('users',[ManageUserController::class,'index'])->name('user');
                Route::get('users/details/{user}', [ManageUserController::class, 'userDetails'])->name('user.details');
                Route::post('users/update/{user}', [ManageUserController::class, 'userUpdate'])->name('user.update');
                Route::post('users/mail/{user}', [ManageUserController::class, 'sendUserMail'])->name('user.mail');
                Route::get('users/search', [ManageUserController::class, 'index'])->name('user.search');
                Route::get('users/disabled', [ManageUserController::class, 'disabled'])->name('user.disabled');
        
                // Manage Service
        
                Route::get('service',[ManageServiceController::class,'index'])->name('service');
                Route::get('service/search',[ManageServiceController::class,'index'])->name('service.search');
                Route::get('service/review/{service}',[ManageServiceController::class,'reviewMessage'])->name('service.message');
                Route::post('service/review/{service}',[ManageServiceController::class,'reviewMessageUpdate']);
                Route::post('service/accept/{service}',[ManageServiceController::class,'acceptService'])->name('service.accept');
                Route::post('service/reject/{service}',[ManageServiceController::class,'rejectService'])->name('service.reject');
        
                Route::get('blog/comments',[AdminController::class,'blogComment'])->name('blog.comment');
                Route::post('blog/comments/{comment}',[AdminController::class,'blogCommentUpdate'])->name('blog.comment.update');
        
                // bookings
        
                Route::get('bookings',[ManageBookingController::class,'index'])->name('bookings');
                Route::get('bookings/search',[ManageBookingController::class,'index'])->name('bookings.search');
                Route::get('bookings/completed',[ManageBookingController::class,'completed'])->name('bookings.completed');
                Route::get('bookings/incomplete',[ManageBookingController::class,'inCompleted'])->name('bookings.incomplete');
                Route::post('bookings/complete/{booking}',[ManageBookingController::class,'bookingComplete'])->name('bookings.complete'); 
                Route::post('bookings/delete/{booking}',[ManageBookingController::class,'bookingDelete'])->name('bookings.delete');
                Route::get('bookings/job/end',[ManageBookingController::class,'endJobs'])->name('bookings.end.job');
                
                Route::post('booking/contract/{booking}',[ManageBookingController::class,'bookingEndContract'])->name('bookings.end.contract');
        
                // Category
                Route::resource('category', CategoryController::class);
        
        
                // frontend section
        
                Route::get('pages', [PagesController::class, 'index'])->name('frontend.pages');
                Route::get('pages/create',[PagesController::class,'pageCreate'])->name('frontend.pages.create');
                Route::post('pages/create',[PagesController::class,'pageInsert']);
                Route::get('pages/edit/{page}', [PagesController::class, 'pageEdit'])->name('frontend.pages.edit');
                Route::post('pages/edit/{page}', [PagesController::class, 'pageUpdate']);
                Route::get('pages/search', [PagesController::class, 'index'])->name('frontend.search');
                Route::post('pages/delete/{page}', [PagesController::class, 'pageDelete'])->name('frontend.pages.delete');
        
        
                Route::get('manage/section', [ManageSectionController::class, 'index'])->name('frontend.section');
        
                Route::get('manage/section/{name}', [ManageSectionController::class, 'section'])->name('frontend.section.manage');
                Route::post('manage/section/{name}', [ManageSectionController::class, 'sectionContentUpdate']);
        
                Route::get('manage/element/{name}', [ManageSectionController::class, 'sectionElement'])->name('frontend.element');
        
                Route::get('manage/element/{name}/search', [ManageSectionController::class, 'section'])->name('frontend.element.search');
        
                Route::post('manage/element/{name}', [ManageSectionController::class, 'sectionElementCreate']);
                Route::get('edit/{name}/element/{element}', [ManageSectionController::class, 'editElement'])->name('frontend.element.edit');
                Route::post('edit/{name}/element/{element}', [ManageSectionController::class, 'updateElement']);
        
                Route::post('delete/{name}/element/{element}', [ManageSectionController::class, 'deleteElement'])->name('frontend.element.delete');
        
                Route::get('blog-category',[ManageSectionController::class,'blogCategory'])->name('frontend.blog');
                Route::post('blog-category',[ManageSectionController::class,'blogCategoryStore']);
                Route::post('blog-category/{blog}',[ManageSectionController::class,'blogCategoryUpdate'])->name('frontend.blog.update');
                Route::post('blog-category/delete/{blog}',[ManageSectionController::class,'blogCategoryDelete'])->name('frontend.blog.delete');
                
                Route::get('faq-category',[ManageSectionController::class,'faqCategory'])->name('frontend.faq');
                Route::post('faq-category',[ManageSectionController::class,'faqCategoryStore']);
                Route::post('faq-category/{faq}',[ManageSectionController::class,'faqCategoryUpdate'])->name('frontend.faq.update');
                Route::post('faq-category/delete/{faq}',[ManageSectionController::class,'faqCategoryDelete'])->name('frontend.faq.delete');
        
                Route::get('general/setting', [GeneralSettingController::class, 'index'])->name('general.setting');
                Route::post('general/setting', [GeneralSettingController::class, 'generalSettingUpdate']);
        
                Route::get('general/preloader', [GeneralSettingController::class, 'preloader'])->name('general.preloader');
                Route::post('general/preloader', [GeneralSettingController::class, 'preloaderUpdate']);
        
                Route::get('general/analytics', [GeneralSettingController::class, 'analytics'])->name('general.analytics');
                Route::post('general/analytics', [GeneralSettingController::class, 'analyticsUpdate']);
        
        
                Route::get('general/cookie/consent', [GeneralSettingController::class, 'cookieConsent'])->name('general.cookie');
                Route::post('general/cookie/consent', [GeneralSettingController::class, 'cookieConsentUpdate']);
        
                Route::get('general/google/rechaptcha', [GeneralSettingController::class, 'rechaptcha'])->name('general.rechaptcha');
                Route::post('general/google/rechaptcha', [GeneralSettingController::class, 'rechaptchaUpdate']);
        
                Route::get('general/live/chat', [GeneralSettingController::class, 'liveChat'])->name('general.live.chat');
                Route::post('general/live/chat', [GeneralSettingController::class, 'liveChatUpdate']);
        
        
                Route::get('general/seo/manage', [GeneralSettingController::class, 'seoManage'])->name('general.seo');
                Route::post('general/seo/manage', [GeneralSettingController::class, 'seoManageUpdate']);
        
        
                // payment Section
        
                Route::get('gateway/bank', [ManageGatewayController::class, 'bank'])->name('payment.bank');
                Route::post('gateway/bank', [ManageGatewayController::class, 'bankUpdate']);
        
                Route::get('gateway/paypal', [ManageGatewayController::class, 'paypal'])->name('payment.paypal');
                Route::post('gateway/paypal', [ManageGatewayController::class, 'paypalUpdate']);
        
                Route::get('gateway/stripe', [ManageGatewayController::class, 'stripe'])->name('payment.stripe');
                Route::post('gateway/stripe', [ManageGatewayController::class, 'stripeUpdate']);
        
        
                Route::get('manual/payments',[ManageGatewayController::class, 'manualPayment'])->name('manual');
                Route::get('manual/payments/{trx}',[ManageGatewayController::class, 'manualPaymentDetails'])->name('manual.trx');
                Route::post('manual/payments/accept/{trx}',[ManageGatewayController::class, 'manualPaymentAccept'])->name('manual.accept');
                Route::post('manual/payments/reject/{trx}',[ManageGatewayController::class, 'manualPaymentReject'])->name('manual.reject');
        
                // withdraw Module
        
                Route::get('withdraw/method',[ManageWithdrawController::class,'index'])->name('withdraw');
                Route::get('withdraw/method/search',[ManageWithdrawController::class,'index'])->name('withdraw.search');
                Route::post('withdraw/method',[ManageWithdrawController::class,'withdrawMethodCreate']);
                Route::post('withdraw/edit/{method}',[ManageWithdrawController::class,'withdrawMethodUpdate'])->name('withdraw.update');
                Route::post('withdraw/delete/{method}',[ManageWithdrawController::class,'withdrawMethodDelete'])->name('withdraw.delete');
        
                Route::get('withdraw/pending',[ManageWithdrawController::class,'pending'])->name('withdraw.pending');
                Route::get('withdraw/accepted',[ManageWithdrawController::class,'accepted'])->name('withdraw.accepted');
                Route::get('withdraw/rejected',[ManageWithdrawController::class,'rejected'])->name('withdraw.rejected');
                
                Route::post('withdraw/accept/{withdraw}',[ManageWithdrawController::class,'withdrawAccept'])->name('withdraw.accept');
                Route::post('withdraw/reject/{withdraw}',[ManageWithdrawController::class,'withdrawReject'])->name('withdraw.reject');
        
                //Email Configure Section
        
                Route::get('email/config', [EmailTemplateController::class, 'emailConfig'])->name('email.config');
                Route::post('email/config', [EmailTemplateController::class, 'emailConfigUpdate']);
        
                Route::get('email/templates', [EmailTemplateController::class, 'emailTemplates'])->name('email.templates');
        
                Route::get('email/templates/{template}', [EmailTemplateController::class, 'emailTemplatesEdit'])->name('email.templates.edit');
                Route::post('email/templates/{template}', [EmailTemplateController::class, 'emailTemplatesUpdate']);
        
                // transaction 
        
                Route::get('transaction',[AdminController::class, 'transaction'])->name('transaction');
                
                // Subscription
        
                Route::get('subscription',[ManageSubscriptionController::class,'index'])->name('subscription');
                Route::post('subscription/email/all',[ManageSubscriptionController::class,'sendEmailToAll'])->name('subscription.all');
                Route::post('subscription/email/single/{id}',[ManageSubscriptionController::class,'sendEmailSubscriber'])->name('subscription.single');
                Route::post('subscription/delete/{id}',[ManageSubscriptionController::class,'deleteSubscriber'])->name('subscription.delete');
        
                Route::get('navbar',[ManageLanguageController::class, 'navbarText'])->name('language.navbar');
                Route::post('navbar',[ManageLanguageController::class, 'navbarTextUpdate']);
                Route::get('website-text',[ManageLanguageController::class, 'websiteText'])->name('language.website');
                Route::post('website-text',[ManageLanguageController::class, 'websiteTextUpdate']); 
                
                Route::get('validation-text',[ManageLanguageController::class, 'validationText'])->name('language.validation');
                Route::post('validation-text',[ManageLanguageController::class, 'validationTextUpdate']);
        
            });
        });
        
        
        Route::name('user.')->prefix('user')->group(function () {
        
            Route::middleware('guest')->group(function () {
                Route::get('register', [RegisterController::class, 'index'])->name('register')->middleware('reg_off');
                Route::post('register', [RegisterController::class, 'register'])->middleware('reg_off');
        
                Route::get('login', [AuthLoginController::class, 'index'])->name('login');
                Route::post('login', [AuthLoginController::class, 'login'])->withoutMiddleware('demo');
        
                Route::get('forgot/password', [AuthForgotPasswordController::class, 'index'])->name('forgot.password');
                Route::post('forgot/password', [AuthForgotPasswordController::class, 'sendVerification']);
                Route::get('verify/code', [AuthForgotPasswordController::class, 'verify'])->name('auth.verify');
                Route::post('verify/code', [AuthForgotPasswordController::class, 'verifyCode']);
                Route::get('reset/password', [AuthForgotPasswordController::class, 'reset'])->name('reset.password');
                Route::post('reset/password', [AuthForgotPasswordController::class, 'resetPassword']);
        
                Route::get('verify/email',[AuthLoginController::class,'emailVerify'])->name('email.verify');
                Route::post('verify/email',[AuthLoginController::class,'emailVerifyConfirm'])->name('email.verify');
            });
        
        
            Route::middleware(['auth','profile_is_update','inactive'])->group(function () {
                Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
                Route::get('logout', [RegisterController::class, 'signOut'])->name('logout')->withoutMiddleware('profile_is_update');
        
                Route::get('profile/setting', [UserController::class, 'profile'])->name('profile')->withoutMiddleware('profile_is_update');
                Route::post('profile/setting', [UserController::class, 'profileUpdate'])->withoutMiddleware('profile_is_update');
        
                Route::get('change/password', [UserController::class, 'changePassword'])->name('change.password');
                Route::post('change/password', [UserController::class, 'changePasswordUpdate']);
        
                Route::post('booking/{service}',[BookingController::class,'booking'])->name('booking');
        
                Route::get('bookings',[BookingController::class,'allBookings'])->name('bookings');
                Route::get('bookings/search',[BookingController::class,'allBookings'])->name('bookings.search');
                Route::post('bookings/complete/{id}',[BookingController::class,'bookingCompleted'])->name('bookings.complete');
        
                Route::get('payment/{booking}',[PaymentController::class,'gateways'])->name('pay.bill');
                Route::post('payment/{booking}',[PaymentController::class,'payment']);
        
                Route::post('payment/{booking}/{stripe}',[PaymentController::class,'stripePost'])->name('stripe.post');
                Route::post('paypal/payment/{booking}/{paypal}',[PaymentController::class,'paypalPost'])->name('paypal.post');
        
                Route::get('paypal', [PaypalPaymentController::class,'ipn'])->name('paypal');
        
                Route::get('transaction',[UserController::class, 'transaction'])->name('transaction');
        
                Route::post('bank/payment/{booking}/{bank}',[PaymentController::class,'bankPayment'])->name('bank.post');
        
                Route::get('chat/provider/{transaction}',[UserController::class, 'chatProvider'])->name('chat.provider');
                Route::post('chat/provider/{transaction}',[UserController::class, 'chatSendProvider'])->name('chat.provider');
        
        
                Route::middleware('service_provider')->group(function () {
                    Route::get('service/all', [ServiceProviderController::class, 'index'])->name('service');
                    Route::get('service/create', [ServiceProviderController::class, 'createService'])->name('service.create');
                    Route::post('service/create', [ServiceProviderController::class, 'storeService']);
        
                    Route::get('service/edit/{service}', [ServiceProviderController::class, 'serviceEdit'])->name('service.edit');
                    Route::post('service/edit/{service}', [ServiceProviderController::class, 'serviceUpdate']);
                    Route::post('service/delete/{service}', [ServiceProviderController::class, 'serviceDelete'])->name('service.delete');
                    
                    Route::get('service/search', [ServiceProviderController::class, 'index'])->name('service.search');
        
                    Route::get('service/schedule', [ServiceProviderController::class, 'schedule'])->name('service.schedule');
                    Route::post('service/schedule', [ServiceProviderController::class, 'scheduleCreate']);
                    Route::post('service/schedule/{schedule}/update', [ServiceProviderController::class, 'scheduleUpdate'])->name('service.schedule.update');
                    Route::post('service/schedule/{schedule}/delete', [ServiceProviderController::class, 'scheduleDelete']);
        
                    Route::get('service/booking',[BookingController::class, 'serviceBooking'])->name('provider.booking');
                    Route::get('service/booking/search',[BookingController::class, 'serviceBooking'])->name('provider.booking.search');
                    Route::post('service/booking/{booking}/accept',[BookingController::class, 'serviceBookingAccept'])->name('service.booking.accept');
                    Route::post('service/booking/{booking}/reject',[BookingController::class, 'serviceBookingReject'])->name('service.booking.reject');
                    Route::post('contract/end/{booking}',[BookingController::class,'endContract'])->name('end.contract');
        
        
        
                    Route::get('withdraw',[UserController::class, 'withdraw'])->name('withdraw');
                    Route::get('withdraw/all',[UserController::class, 'allWithdraw'])->name('withdraw.all');
                    Route::get('withdraw/pending',[UserController::class, 'pendingWithdraw'])->name('withdraw.pending');
                    Route::post('withdraw',[UserController::class, 'withdrawCompleted']);
                    Route::get('withdraw/fetch/{id}',[UserController::class,'withdrawFetch'])->name('withdraw.fetch');
        
                    Route::get('chat/{transaction}',[UserController::class, 'chat'])->name('chat');
                    Route::post('chat/{transaction}',[UserController::class, 'chatSend'])->name('chat');
                });
            });
        });
        
        
        Route::get('/', [HomeController::class, 'index'])->name('home');
        
        Route::post('subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
        
        Route::get('contact', [HomeController::class, 'contact'])->name('contact');
        
        Route::post('contact', [HomeController::class, 'contactSend'])->name('contact');
        
        
        Route::get('experts/{user}', [HomeController::class, 'userDetails'])->name('service.provider.details');
        
        Route::get('blog/{blog}', [HomeController::class, 'blogDetails'])->name('blog.details');
        Route::get('blog/category/{category}', [HomeController::class, 'blogCategory'])->name('blog.category');
        Route::post('blog/comment/{id}', [HomeController::class, 'blogComment'])->name('blog.comment');
        
        
        
        Route::get('service/{id}/{slug}', [HomeController::class, 'serviceDetails'])->name('service.details');
        
        
        Route::get('search/experts', [HomeController::class, 'searchExperts'])->name('experts.search');
        
        Route::get('category', [HomeController::class, 'categoryAll'])->name('category.all');
        
        
        Route::get('policy/{policy}', [HomeController::class, 'policy'])->name('policy');
        
        Route::get('category/{slug}', [HomeController::class, 'categoryDetails'])->name('category.details');
        
        
        
        Route::post('send/provider/{id}', [HomeController::class, 'sendproviderMail'])->name('send.provider.email');
        
        Route::post('write/review/{service}', [HomeController::class, 'writeReview'])->name('review');
        
        Route::get('{pagename}', [HomeController::class, 'pages'])->name('pages');
        
});

