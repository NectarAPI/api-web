<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('web');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', 'Auth\LoginController@userServiceLogin')->name('login');
Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/health-check', function() {
    return response('Healthy', 200);
})->name('health-check');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('show.register');
Route::post('register', 'Auth\RegisterController@register')->name('perform.register');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('/dashboard', 'PagesController@dashboard')->name('dashboard');
Route::get('/utilities', 'PagesController@utilities')->name('utilities');
Route::get('/meters', 'PagesController@meters')->name('meters');
Route::get('/subscribers', 'PagesController@subscribers')->name('subscribers');
Route::get('/requests', 'PagesController@requests')->name('requests');
Route::get('/credentials', 'PagesController@credentials')->name('credentials');
Route::get('/public-keys', 'PagesController@publicKeys')->name('public-keys');
Route::get('/configurations', 'PagesController@configurations')->name('configurations');
Route::get('/credits', 'PagesController@credits')->name('credits');
Route::get('/notifications', 'PagesController@notifications')->name('notifications');
Route::get('/profile', 'PagesController@profile')->name('profile');
Route::get('/simulators', 'PagesController@simulators')->name('simulators');
Route::get('/terms_and_conditions', 'PagesController@termsAndConditions')->name('terms_and_conditions');
Route::get('/privacy_policy', 'PagesController@privacyPolicy')->name('privacy_policy');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/verify', 'Auth\VerificationController@verify')->name('verify');

Route::get('email/forgot-password', 'Auth\VerificationController@showForgotPasswordForm')->name('verification.forgot-password');
Route::post('email/forgot-password', 'Auth\VerificationController@generateResetPasswordEmailLink')->name('verification.forgot-password');

Route::get('/password/reset', 'Auth\ResetPasswordController@showResetPasswordForm')->name('verification.reset-password');
Route::post('/password/reset', 'Auth\ResetPasswordController@resetPassword')->name('verification.reset-password');

Route::get('/user', 'UserController@getUser')->name('user.get');
Route::post('/user', 'UserController@updateUser')->name('user.update');

Route::get('/pkeys', 'PublicKeysController@getKeys')->name('pkeys');
Route::post('/pkeys', 'PublicKeysController@setKey')->name('pkeys.set');
Route::post('/pkeys/{key_ref}', 'PublicKeysController@activateDeactivateKey')->name('pkeys.update');

Route::get('/configs', 'STSConfigurationsController@getConfigs')->name('configs.get');
Route::post('/configs', 'STSConfigurationsController@addConfig')->name('configs.add');
Route::post('/configs/{config_ref}', 'STSConfigurationsController@setConfigStatus')->name('configs.activate');

Route::get('/utility', 'UserController@getUtilities')->name('utility.get');
Route::post('/utility', 'UtilityController@addUtility')->name('utility.post');
Route::post('/utility/{utility_ref}/activateDeactivate', 'UtilityController@activateDeactivateUtility')->name('utility.activateDeactivate');
Route::post('/utility/{utility_ref}', 'UtilityController@updateUtility')->name('utility.update');

Route::get('/subscriberMeters', 'MetersController@getSubscriberMeters')->name('subscribers-meters.get');
Route::get('/subscriberMeters/utilities', 'MetersController@getUtilities')->name('subscribers-meters.getutilities');
Route::get('/subscriberMeters/meterTypes', 'MetersController@getMeterTypes')->name('subscribers-meters.getmetertypes');
Route::get('/subscriberMeters/subscribers', 'MetersController@getSubscribers')->name('subscribers-meters.getsubscribers');
Route::post('/subscriberMeters/createMeter', 'MetersController@createMeter')->name('subscribers-meters.createmeter');
Route::post('/subscriberMeters/{meter_ref}/activateDeactivate', 'MetersController@activateDeactivateMeter')->name('subscriber-meters.activateDeactivate');
Route::post('/subscriberMeters/updateMeter', 'MetersController@updateMeter')->name('subscriber-meters.updateMeter');

Route::get('/subscriber', 'SubscribersController@getSubscribers')->name('subscribers.getsubscribers');
Route::post('/subscriber', 'SubscribersController@createSubscriber')->name('subscriber->createSubscriber');
Route::post('/subscriber/{subscriber_ref}/activateDeactivate', 'SubscribersController@activateDeactivateSubscriber')->name('subscriber.activateDeactivate');
Route::post('/subscriber/updateSubscriber', 'SubscribersController@updateSubscriber')->name('subscriber.updateSubscriber');

Route::get('/creds', 'CredentialsController@getCredentials')->name('creds.get');
Route::post('/creds', 'CredentialsController@addCredentials')->name('creds.add');
Route::post('/creds/{credential_ref}', 'CredentialsController@setCredentialStatus')->name('creds.activate');
Route::get('/permissions', 'CredentialsController@getPermissions')->name('permissions.get');

Route::get('/notif', 'NotificationsController@getNotifications')->name('notifications.get');
Route::put('/notif', 'NotificationsController@setReadNotifications')->name('notifications.read');

Route::get('/timelineRequests', 'TokensController@getTimelineRequests')->name('tokens.timeline-requests');
Route::get('/noOfConfigurations', 'TokensController@getNoOfConfigurations')->name('tokens.no-of-configurations');
Route::get('/noOfGeneratedTokens', 'TokensController@getNoOfGeneratedTokens')->name('tokens.no-of-generated-tokens');
Route::get('/noOfCredentials', 'TokensController@getNoOfCredentials')->name('tokens.no-of-credentials');
Route::get('/noOfCredits', 'TokensController@getNoOfCredits')->name('tokens.no-of-credits-used');
Route::get('/typesOfTokens', 'TokensController@getTypesOfTokens')->name('tokens.types-of-tokens');
Route::get('/noOfUniqueMeters', 'TokensController@getNoOfUniqueMeters')->name('tokens.no-of-unique-meters');
Route::get('/tokenRequests', 'TokensController@getTokenRequests')->name('token.requests');

Route::get('/tokensPaymentsTotal', 'PaymentsController@getPaymentsTotal')->name('payments.value');
Route::get('/tokensTypesDetails', 'TokensController@getTokenTypesDetails')->name('tokens.types-of-tokens-details');
Route::get('/paymentResultsDistribution', 'PaymentsController@getPaymentsResultsDistribution')->name('payments.payments-results-distribution');
Route::get('/timelineCreditsCreditsConsumption', 'PaymentsController@getTimelineCreditsCreditsConsumption')->name('payments.timeline-credits-consumption');
Route::get('/getActivityLog', 'UserController@getActivityLog')->name('user.activity-log');

Route::get('/getCredits', 'PaymentsController@getCreditsConsumption')->name('payments.get-credits-consumption');

Route::get('/decodeToken', 'TokensController@decodeToken')->name('decode-token');
Route::post('/generateToken', 'TokensController@generateToken')->name('generate-token');

Route::post('/schedulePayment', 'PaymentsController@schedulePayment')->name('schedule-payment');
Route::get('/getPaymentStatus', 'PaymentsController@getPaymentStatus')->name('get-payment-status');

Route::get('/docs', function () {
    return view('docs');
})->name('docs');
