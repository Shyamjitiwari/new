<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/token-login', 'ApiAuthController@tokenLogin');
// Route::post('/login', 'ApiAuthController@login');

Route::middleware('auth:api')->group(function()
{
    Route::get('/free_session/country/callingCodes', 'FreeSessionController@getCountryCallingCodes');
    Route::get('/get_thankyou_message', 'FreeSessionController@getThankyouMessage');
    Route::get('/get_free_session_locations', 'FreeSessionController@allLocationsForFreeSession');
    Route::get('/get-locations-for-camps', 'CampController@getLocationsForCamps');
    Route::get('/get_free_session_topics','FreeSessionController@allTopics');
    Route::post('/get_available_time_slots','FreeSessionController@getAvailableTimeSlotsForALocation');
    Route::post('/add_free_session','FreeSessionController@addFreeSession');

    Route::post('/make-payment', 'BillingAndPaymentController@makePayment');
    Route::post('make-registration-payment', 'BillingAndPaymentController@makeRegistrationPayment');

    Route::post('get-camp-signup-form-data', 'CampController@getCampsSignUpFormData');
    Route::post('add-student-to-camp', 'CampController@addStudentToCamp');

    Route::post('send-partner-email', 'MailController@sendPartnerMail');
    Route::post('send-custom-request-email', 'MailController@sendCustomRequestMail');

});
