<?php

use Illuminate\Support\Facades\Route;

$this->get('registration', function () {
    return view('register_options');
})->name('register-options');
$this->get('/', 'HomeController@index')->name('home');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->get('user_login', 'Auth\LoginController@loginFormForUsersExceptParents')->name('except-parents-login-form');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
$this->get('/parentsLogin', 'Auth\LoginController@parentsPhoneNumberForm')->name('parent-phone-number-form');
$this->post('/token', 'Auth\LoginController@parentsLoginTokenForm')->name('login-token-form');
$this->post('/parentlogin', 'Auth\LoginController@parentsLogin')->name('parent-login');

//Custom Registration Routes...
$this->post('register', 'Auth\RegisterController@registrationChecks')->name('register');
$this->get('/admins/register', 'Auth\RegisterController@showRegistrationFormForAdmins')->name('admins-register');
$this->get('/teachers/register', 'Auth\RegisterController@showRegistrationFormForTeachers')->name('teachers-register');
$this->get('/students/register', 'Auth\RegisterController@showRegistrationFormForStudentsPage1');
$this->post('/students/register','Auth\RegisterController@studentsRegistrationPage1')->name('students-register-page1');
$this->get('parents/register', 'Auth\RegisterController@showRegistrationForm')->name('parents-register');

// Password Reset Routes ...
$this->get('/country/callingCodes','UsernameAndPasswordResetController@getCountryCallingCodes');
$this->post('/usernamesUsingPhoneNumber','UsernameAndPasswordResetController@getUserNamesUsingPhoneNumbers');
$this->post('/setPassword','UsernameAndPasswordResetController@setUserPassword');
$this->get('/username/reset','UsernameAndPasswordResetController@forgotUserNameForm')->name('reset-username');
$this->post('/usernames','UsernameAndPasswordResetController@getUserNames');
$this->get('/password/reset','PasswordResetController@showPasswordResetForm')->name('reset-password');
$this->post('/password/reset','PasswordResetController@validateUsername');
$this->post('/password/update','PasswordResetController@validateSecretTokenAndUpdatePassword')->name('validate-security-code');
$this->post('/sendPasswordResetToken','UsernameAndPasswordResetController@sendPasswordResetToken');
$this->post('/resetPassword','UsernameAndPasswordResetController@resetPassword');

// Routes for Dashboards
$this->get('/home', 'HomeController@index')->name('home');
$this->get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
$this->get('/teacher/dashboard', 'TeacherController@index')->name('teacher.dashboard');
$this->get('/parent/dashboard', 'ParentController@index')->name('parent.dashboard');
$this->get('/student/dashboard', 'StudentController@index')->name('student.dashboard');

// Parent Routes ...
$this->get('/parent/updates','ParentController@updates');
$this->get('/parent/update/{phoneNumber}/{updateId}','ViewUpdateController@viewUpdate');
$this->post('/submit_user_feedback','ViewUpdateController@submitUserFeedback')->name('user_feedback');
$this->get('/search_parent_profile_form','ParentController@searchParentProfileForm')->name('search-parent-profile-form');
$this->get('/parent/students','ParentController@studentsListPage');
$this->get('/parent/getStudents/{parentId?}','ParentController@getStudentsList');
$this->post('/get_parent_by_phoneNumber','ParentController@getParentByPhoneNumber')->name('get-parent-by-phonenumber');
$this->post('/get_parent_by_emailId','ParentController@getParentByEmailId')->name('get-parent-by-emailid');
$this->get('/get_parent_profile/{parentId}','ParentController@getParentProfile');

// Student Routes ...
$this->get('/student/updates','StudentController@updates');
$this->get('/student/update','StudentController@newUpdateForm');
$this->post('/student/update','StudentController@writeAnUpdate')->name('write-an-update');

// Teacher Routes ...
$this->get('/teacher/updates','TeacherController@updates');
$this->get('/teacher/update/{taskId?}','TeacherController@newUpdateForm');
$this->post('/teacher/update','TeacherController@writeAnUpdate')->name('teacher-write-an-update');
$this->get('/teacher/calendar','TeacherController@calendarView');

// Admin Routes ...
$this->get('/admin/updates','AdminController@updates');
$this->get('/admin/update/{taskId?}','AdminController@newUpdateForm');
$this->post('/admin/update','AdminController@writeAnUpdate')->name('admin-write-an-update');
$this->get('/admin/calendar','AdminController@calendarView');
Route::get('/admin/daily-task-classes', 'AdminController@dailyTaskClasses')->name('admin.daily-task-classes');
Route::post('/admin/get-daily-task-classes', 'AdminController@getDailyTaskClasses');

// Calendar Routes
$this->post('/calendar/get_calendar_events','CalendarController@getCalendarEvents');
$this->get('/calendar/get_locations','CalendarController@getLocations');

// Student&Class Routes
$this->post('/get_student_by_fullName','StudentAndClassController@getStudentByFullName')->name('get-student-by-fullname');
$this->post('/get_student_by_phoneNumber','StudentAndClassController@getStudentByPhoneNumber')->name('get-student-by-phonenumber');
$this->post('/get_student_by_emailId','StudentAndClassController@getStudentByEmailId')->name('get-student-by-emailid');
$this->get('/edit_student_profile/{studentId?}','StudentAndClassController@editStudentAssignmentToClasses')->name('get-student-profile');
$this->post('/edit_student_profile','StudentAndClassController@editStudentProfile');
$this->post('/get_student_profile','StudentAndClassController@getStudentProfile');
$this->post('/get_assigned_classes','StudentAndClassController@getStudentsClasses');
$this->post('/un_assign_student','StudentAndClassController@unAssignStudent');
$this->post('/get_classes','StudentAndClassController@getClassesForStudentLocationAndDate');
$this->post('/get_classes_for_new_student','StudentAndClassController@getClassesForNewStudentLocationAndDate');
$this->post('/getTeachers', 'StudentAndClassController@getTeachersForTheLocation');
$this->get('/task_class','StudentAndClassController@addTaskClassForm');
$this->post('/add_task_class','StudentAndClassController@addTaskClass')->name('add-task-class');
$this->get('/add_student_form','StudentAndClassController@addStudentForm')->name('add-student-form');
$this->post('/add_student_to_class','StudentAndClassController@addStudentToClass')->name('add-student-to-class');
$this->post('/archive-student','StudentAndClassController@archiveStudent');
$this->post('/add_student_location','StudentAndClassController@addLocationToStudent');
$this->post('/get_student_location','StudentAndClassController@getStudentsLocations');
$this->post('/remove_student_location','StudentAndClassController@removeStudentLocation');

// Category/SubCategory and Lectures Routes ...
$this->get('/category','CategoryController@indexLectureCategories');
$this->get('/getAllLectureCategories','CategoryController@allLectureCategories');
$this->post('/addLectureCategory','CategoryController@storeLectureCategory');
$this->put('/category/edit/{id}','CategoryController@updateLectureCategory');
$this->delete('/category/delete/{id}','CategoryController@destroyLectureCategory');
$this->put('/updateCategoryPriority','CategoryController@updateCategoryPriority');
$this->get('/subcategory','SubCategoryController@indexLectureSubCategories');
$this->get('/getAllLectureSubCategories','SubCategoryController@allLectureSubCategories');
$this->post('/addLectureSubCategory','SubCategoryController@storeLectureSubCategory');
$this->put('/subcategory/edit/{id}','SubCategoryController@updateLectureSubCategory');
$this->delete('/subcategory/delete/{id}','SubCategoryController@destroyLectureSubCategory');
$this->put('/updateSubCategoryPriority','SubCategoryController@updateSubCategoryPriority');
$this->get('/lecture','LectureController@indexLectures');
$this->get('/getAllLectures','LectureController@allLectures');
$this->post('/addLecture','LectureController@storeLecture');
$this->put('/lecture/edit/{id}','LectureController@updateLecture');
$this->delete('/lecture/delete/{id}','LectureController@destroyLecture');
$this->put('/updateLecturePriority','LectureController@updateLecturePriority');

// Topic Routes ...
$this->get('/topics','TopicController@topicsIndexPage');
$this->get('/get_topics','TopicController@getTopics');
$this->post('/add_topic','TopicController@addTopic');
$this->put('/topic/edit/{id}','TopicController@editTopic');
$this->delete('/topic/delete/{id}','TopicController@deleteTopic');

// ViewLecture Routes 
$this->get('/categories', 'ViewLectureController@getLectureCategories');
$this->get('/subCategories/{id?}', 'ViewLectureController@getLectureSubCategories');
$this->get('/lectures/{id?}', 'ViewLectureController@getLectures');
$this->get('/teacher/categories', 'ViewLectureController@getLectureCategories');
$this->get('/teacher/subCategories/{id?}', 'ViewLectureController@getLectureSubCategoriesForTeachers');
$this->get('/teacher/lectures/{id?}', 'ViewLectureController@getLecturesForTeachers');

// Teacher Profile Routes ...
$this->get('/teacher_profile','TeacherProfileController@searchTeachers');
$this->post('/get_teacher_by_fullName','TeacherProfileController@getTeacherByFullName')->name('get-teacher-by-fullname');
$this->post('/get_teacher_by_phoneNumber','TeacherProfileController@getTeacherByPhoneNumber')->name('get-teacher-by-phonenumber');
$this->post('/get_teacher_by_email','TeacherProfileController@getTeacherByEmail')->name('get-teacher-by-email');
$this->get('/get_all_locations','TeacherProfileController@getAllLocations');
$this->post('/get_teacher_location','TeacherProfileController@getTeachersLocations');
$this->post('/add_teacher_location','TeacherProfileController@addLocationToTeacher');
$this->post('/remove_teacher_location','TeacherProfileController@removeTeacherLocation');
$this->post('/get_teacher_topic','TeacherProfileController@getTeachersTopics');
$this->post('/add_teacher_topic','TeacherProfileController@addTopicToTeacher');
$this->post('/remove_teacher_topic','TeacherProfileController@removeTeacherTopic');
$this->post('/get_teacher_profile','TeacherProfileController@getTeacherProfile');
$this->get('/edit_teacher_profile/{teacherId?}','TeacherProfileController@editTeacherProfileForm');
$this->post('/edit_teacher_profile','TeacherProfileController@editTeacherProfile');

// Free Session Routes ...
$this->get('/form_options','FreeSessionController@formOptions')->name('free-session-form-options');
$this->get('/signup_form','FreeSessionController@signUpForm')->name('free-session-signup');
$this->get('/signin_form','FreeSessionController@signInForm')->name('free-session-signin');
$this->post('/find_user_record_for_free_session','FreeSessionController@findStudentRecordForFreeSession');
$this->get('/get_free_session_locations','FreeSessionController@allLocationsForFreeSession');
$this->get('/get_free_session_topics','FreeSessionController@allTopics');
$this->post('/get_available_time_slots','FreeSessionController@getAvailableTimeSlotsForALocation');
$this->post('/add_free_session','FreeSessionController@addFreeSession');
$this->get('/sendSMS', 'FreeSessionController@sendSMS');
$this->get('/get_thankyou_message', 'FreeSessionController@getThankyouMessage');
$this->get('/successful_free_session_registration', 'FreeSessionController@freeSessionSuccessfulRegistration');
$this->get('/free_session/country/callingCodes','FreeSessionController@getCountryCallingCodes');

// Teacher Available Time Slot
$this->post('/get-teacher-time-slots','TeacherAvailabelTimeSlotController@getAvailableTimeSlots');
$this->post('/save-teacher-time-slot','TeacherAvailabelTimeSlotController@storeTeacherTimeSlot');
$this->delete('/delete-teacher-time-slot/{timeSlot}','TeacherAvailabelTimeSlotController@deleteTeacherTimeSlot');


// Add Student Routes ...
$this->get('/add_student_form_by_user','AddStudentController@addStudentForm');
$this->get('/get_parents_phoneNumber','AddStudentController@getParentsPhoneNumber');
$this->get('/get_locations_for_adding_students','AddStudentController@getLocations');
$this->get('/get_timezones_for_adding_students','AddStudentController@getTimezones');
$this->post('/add_student_by_user','AddStudentController@addStudent');

$this->post('/update_student_topic','StudentAndClassController@updateStudentTopic');

//Online Meeting Routes ...
$this->get('/online_meeting_room', 'OnlineMeetingController@onlineMeetingRoom');
$this->get('/get_username_for_online_meeting','OnlineMeetingController@getUsernameForOnlineMeeting');
$this->get('/join_online_meeting_room/{userId?}/{userName?}', 'OnlineMeetingController@joinOnlineMeetingRoom');
$this->post('/create_google_meetlink_for_a_student','OnlineMeetingController@createMeetingLinkForStudent');

//Free Session Time Slots Routes
$this->get('/free_session_time_slots', 'FreeSessionTimeSlotController@freeSessionTimeSlots');
$this->get('/get_locations_for_free_session', 'FreeSessionTimeSlotController@getAllLocationsForFreeSession');
$this->get('/get_days_for_free_session', 'FreeSessionTimeSlotController@getDaysForFreeSession');
$this->get('/get_times_for_free_session', 'FreeSessionTimeSlotController@getTimesForFreeSession');
$this->post('/get_available_timeslots_for_a_location','FreeSessionTimeSlotController@getAvailableTimeSlotsForALocation');
$this->post('/add_timeslot_to_a_location','FreeSessionTimeSlotController@addTimeSlotToALocation');
$this->post('/delete_timeslot_from_a_location','FreeSessionTimeSlotController@deleteTimeSlotFromALocation');

//Billing and Payment Routes
$this->post('/add_parents_email','BillingAndPaymentController@addEmailId')->name('add_parents_email_id');
$this->get('/plans', 'BillingAndPaymentController@plans')->name('plans.index');
$this->get('/plan/{plan}', 'BillingAndPaymentController@showPlan')->name('plans.show');
$this->post('/make-payment', 'BillingAndPaymentController@makePayment');
$this->post('/promo', 'BillingAndPaymentController@showPromo')->name('promos.show');
$this->get('/thankyou', 'BillingAndPaymentController@thankyouPage')->name('thankyou.page');
$this->get('/billing_history', 'BillingAndPaymentController@billingHistory')->name('billing.history');
$this->get('/billing_history_of_subscriptions/{userId?}', 'BillingAndPaymentController@billingHistoryOfSubscriptions');
$this->get('/billing_history_of_one_time_payments/{userId?}', 'BillingAndPaymentController@billingHistoryOfOneTimePayments');
$this->get('/get_all_billing_products', 'BillingAndPaymentController@getAllBillingProducts');
$this->get('/add_billing_product_form', 'BillingAndPaymentController@addNewBillingProductForm');
$this->post('/add_billing_product', 'BillingAndPaymentController@addNewBillingProduct');
$this->put('/billing_product/edit/{id}','BillingAndPaymentController@editBillingProduct');
$this->delete('/billing_product/delete/{id}','BillingAndPaymentController@deleteBillingProduct');
$this->get('/stripe_products_direct_links','BillingAndPaymentController@listOfStripeProductsDirectLinks');
$this->get('/subscriptions_of_a_user','BillingAndPaymentController@subscriptionsOfAUser');
$this->get('/all_active_subscriptions_of_a_user','BillingAndPaymentController@allActiveSubscriptionsOfAUser');
$this->get('/all_freezed_subscriptions_of_a_user','BillingAndPaymentController@allFreezedSubscriptionsOfAUser');
$this->get('/all_cancelled_subscriptions_of_a_user','BillingAndPaymentController@allCancelledSubscriptionsOfAUser');
$this->post('/reactivate_a_subscription','BillingAndPaymentController@reActivateASubscription');
$this->post('/freeze_a_subscription','BillingAndPaymentController@freezeASubscription');
$this->post('/cancel_a_subscription','BillingAndPaymentController@cancelASubscription');
$this->get('/get-students-of-the-parent','BillingAndPaymentController@getStudentsOfTheParent');
$this->post('/send-student-schedule-to-the-cwu-team','BillingAndPaymentController@sendStudentScheduleToTheCwuTeam');

//Training routes with categories and sub categories
Route::get('/training', 'LessonController@index')->name('lessons.index');
Route::get('/training/categories', 'LessonCategoryController@index')->name('lessons.categories');
Route::get('/training/sub-categories', 'LessonSubCategoryController@index')->name('lessons.subcategories');

//Training section - lesson components api routes
Route::get('/teacher/training/categories', 'TeacherController@lessonCategories')->name('teachers.training.categories');
Route::get('/teacher/training/sub-categories/{id}', 'TeacherController@lessonSubCategories')->name('teachers.training.sub.categories');
Route::get('/teacher/training/lessons-sub-categories/{id}', 'TeacherController@lessons')->name('teachers.training.lessons');

//Lesson Controller Routes
Route::get('/training/getAllLessons','LessonController@allLessons');
Route::post('/training/addLesson','LessonController@storeLesson');
Route::put('/training/lesson/edit/{id}','LessonController@updateLesson');
Route::delete('/training/lesson/delete/{id}','LessonController@destroyLesson');
Route::put('/training/updateLessonPriority','LessonController@updateLessonPriority');

//Training section - lesson categories components api routes
Route::get('/training/getAllLessonCategories','LessonCategoryController@allLessonCategories');
Route::post('/training/addLessonCategory','LessonCategoryController@storeLessonCategory');
Route::put('/training/category/edit/{id}','LessonCategoryController@updateLessonCategory');
Route::delete('/training/category/delete/{id}','LessonCategoryController@destroyLessonCategory');
Route::put('/training/updateCategoryPriority','LessonCategoryController@updateCategoryPriority');

//Training section - lesson sub-categories components api routes
Route::get('/training/getAllLessonSubCategories','LessonSubCategoryController@allLessonSubCategories');
Route::post('/training/addLessonSubCategory','LessonSubCategoryController@storeLessonSubCategory');
Route::put('/training/subcategory/edit/{id}','LessonSubCategoryController@updateLessonSubCategory');
Route::delete('/training/subcategory/delete/{id}','LessonSubCategoryController@destroyLessonSubCategory');
Route::put('/training/updateSubCategoryPriority','LessonSubCategoryController@updateSubCategoryPriority');

Route::get('/teacher/time-slots', 'TeacherController@showTeacherTimeSlots')->name('teachers.timeSlot');

//update teacher
Route::post('/teacher/store-students-update', 'TeacherController@storeStudentUpdates');
Route::post('/teacher/show-students-update', 'TeacherController@showStudentUpdates');
//Teachers update
Route::get('/parent/teachers/update/{phoneNumber}/{updateId}','ViewUpdateController@viewStudentUpdate')->name('teachers-update');

Route::get('/completed-task-classes/{id}', 'TeacherController@completedClasses')->name('teachers-completed-classes');

//Teacher route for marking task class as completed
Route::post('/teacher/mark-task-class-competed', 'TeacherController@markClassAsCompleted');
Route::post('/teacher/mark-task-class-incomplete', 'TeacherController@markClassAsInCompleted');
Route::post('/teacher/mark-task-class-absent', 'TeacherController@markClassAsAbsent');
Route::post('/teacher/mark-task-class-present', 'TeacherController@markClassAsPresent');
Route::get('/teacher/get-all-upcoming-classes', 'TeacherController@getAllUpcomingClasses');
Route::post('/get-incomplete-assigned-classes-teacher','TeacherController@getIncompleteTeachersClasses');
Route::get('/completed-task-classes-teacher/{id}', 'AdminController@completedClassesTeacher')->name('completed-classes');

Route::post('/get-completed-assigned-classes-teacher','AdminController@getCompletedClassesTeacher');

Route::post('/get-incomplete-assigned-classes','StudentAndClassController@getIncompleteStudentsClasses');
Route::post('/get-completed-assigned-classes','StudentAndClassController@getCompletedClasses');
//Route::get('/get-all-student-for-task-class/{id}','StudentAndClassController@getAllStudentForTaskClass');

//Mass Contacts
Route::get('/bulk-messages/teachers','BulkMessageController@showMessageFormTeachers')->name('admins.bulk.message.teachers');
Route::get('/bulk-messages/students','BulkMessageController@showMessageFormStudents')->name('admins.bulk.message.students');
Route::get('/bulk-messages/get-bulk-message-data','BulkMessageController@getBulkMessageData');
Route::post('/bulk-messages/send-message','BulkMessageController@sendMessage');

//Ping Student
Route::post('/ping-student','StudentAndClassController@pingParent');
//check if the student has task class marked as first class or not
Route::post('/check-if-first-class','StudentAndClassController@checkIfFirstClass');


//Locations
Route::get('locations', 'LocationController@index')->name('locations.index');
Route::get('get-locations', 'LocationController@getLocations');
Route::post('locations/store', 'LocationController@store');

//Add lecture category to students list
Route::post('add-student-lecture-category','ViewLectureController@addStudentLectureCategory')->name('students.add.lecture.category');

//Task Classes
Route::get('task-classes-profile', 'TaskClassController@taskClassProfile')->name('admin.task_class.profile');
Route::get('task-classes-profile/{id}', 'TaskClassController@taskClassProfileShow')->name('admin.task_class.profile.show');
Route::get('get-task-classes','TaskClassController@index');
Route::get('get-task-class/{id}','TaskClassController@getTaskClass');
Route::delete('task-classes-delete/{id}', 'TaskClassController@destroy');
Route::post('update-task-class', 'TaskClassController@update');
Route::post('update-task-class-data', 'TaskClassController@updateData');

//Ages
Route::get('get-ages','TaskClassController@getAges');

//Task Class Type
Route::get('get-task-class-types', 'TaskClassTypeController@getTaskClassType');

//Artisan command routes
Route::get('/artisan-create-recurring-classes', 'TeacherController@cronRecurringClasses')->name('cron.recurring');

//Settings Routes
Route::get('/settings', 'SettingController@settingsPage')->name('settings_page');
Route::get('/send_reminder_text_and_email_to_the_parents', 'SettingController@sendReminderSMSAndEmail')->name('reminder_for_tomorrow_class');
Route::get('/send_reminder_to_the_parents_one_hour_before_class', 'SettingController@sendReminderSMSAndEmailOneHourBeforeClass')->name('reminder_for_class_in_one_hour');
Route::get('/create_recurring_classes', 'SettingController@createRecurringClasses');
Route::get('/getTodaysPayments','SettingController@getTodaysPayments');
Route::get('/add-localized-strings-for-website-into-database','SettingController@addLocalizedStringsForWebsiteIntoTheTable');

//Locales Routes
Route::get('/localization', 'LocalizationController@localization');
Route::get('/get_locales', 'LocalizationController@getAllLocals');
Route::get('/get-projects-for-locales', 'LocalizationController@getProjectsForLocalization');
Route::post('/get_localized_strings', 'LocalizationController@getLocalizedStrings');
Route::post('/edit_locale_string', 'LocalizationController@editLocaleString');
Route::get('/get-website-localized-strings', 'LocalizationController@getWebsiteStrings');
Route::get('/edit-website-localized-string', 'LocalizationController@editAWebsiteString');


//Credits Calculations
Route::get('/credits_calculation', 'CreditsCalculationController@creditsCalculationIndex')->name('credits_calculations');
Route::get('/credit_calculation/get_locations', 'CreditsCalculationController@getLocations');
Route::post('/credit_calculation/get_users_credits', 'CreditsCalculationController@getUsersCredits');
Route::post('/credit_calculation/get_users_credits_within_a_date_range', 'CreditsCalculationController@getCreditsInADateRange')->name('get_users_credits');
Route::get('/credit_calculation/edit_user/{userId}/{taskClassTypeId}/{lastCreditsUsed}/{totalCreditsUsed}', 'CreditsCalculationController@editUsersCredits')->name('edit_users_credits');
Route::post('/credit_calculation/update_user_credits', 'CreditsCalculationController@updateUserCredits')->name('update_users_credits');
Route::get('/credit_calculation/edit_parent_credits/{userId}', 'CreditsCalculationController@editUserCreditsFormForEachParent')->name('edit_parents_credits');
Route::post('/credit_calculation/update_parent_credits', 'CreditsCalculationController@updateParentCredits')->name('update_parents_credits');

//Survey Routes
Route::get('/survey/{parentId?}/{teacherId?}/{studentId?}', 'SurveyController@getParentsExperienceSurvey');
Route::post('/survey/store/parents_experience', 'SurveyController@storeParentsExperienceSurvey')->name('parents_survey');
Route::get('/surveys', 'SurveyController@getAllSurveys');

//lead related routes routes for admin role only
Route::get('/admin/leads-index', 'LeadController@leads')->name('leads.leads');
Route::get('/admin/lead-sources-index', 'LeadSourceController@leadStatuses')->name('leads.leadsources');
Route::get('/admin/lead-statuses-index', 'LeadStatusController@leadSources')->name('leads.leadstatuses');
Route::get('/admin/lead-activities-index', 'LeadActivityController@leadActivities')->name('leads.leadactivities');

Route::resource('/admin/leads', 'LeadController');
Route::resource('/admin/lead-sources', 'LeadSourceController');
Route::resource('/admin/lead-statuses', 'LeadStatusController');
Route::resource('/admin/lead-activities', 'LeadActivityController');

//general routes
Route::post('/admin/get-all', 'Controller@getAll');
Route::post('/admin/get-all-active', 'Controller@getAllActive');
Route::post('/admin/get-all-active-filtered', 'Controller@getAllActiveFiltered');

//FAQs Routes
Route::get('/faqs', 'FAQsController@getFAQsPage');

//Report Routes
Route::get('/report/get_locations','ReportController@getLocations');
Route::get('/teachers_pay_report','ReportController@generatePayForTeachersForm');
Route::post('/get_teachers_pay_report','ReportController@generatePayReportForTeacher');
Route::get('/ROI-report','ReportController@generateROIReport')->name('roi-report');

Route::get('/student/calendar','ParentStudentController@calendarViewStudent')->name('students.calendar');
Route::get('/parent/calendar','ParentStudentController@calendarViewParent')->name('parents.calendar');
Route::get('/parent/reschedule/{student}/{taskClass}', 'ParentStudentController@reschedule')->name('parents.reschedule');
Route::post('/parent/reschedule/get-available-classes', 'ParentStudentController@getAvailableTaskClasses');

Route::post('/parent/reschedule/store', 'ParentStudentController@rescheduleUpdate');
Route::post('/parent/reschedule/send-mail', 'MailController@reschedule');

Route::post('/get-students-for-parent','ParentStudentController@getStudentsForParent');
Route::post('/student/get-calendar-events','ParentStudentController@getCalendarEvents');

//Country Routes
Route::get('/countries/calling_code','CountryController@getCountryCallingCode');
Route::get('/countries-calling-codes','CountryController@getAllCountriesCallingCodes');

//Camp Routes
Route::get('camps', 'CampController@index')->name('camps');
Route::get('get-all-camps', 'CampController@getCamps');
Route::post('get-camp', 'CampController@getCamp');
Route::post('delete-camp', 'CampController@deleteCamp');
Route::post('camps', 'CampController@store');

//TaskClassFrequency Routes
Route::get('/get_all_frequencies', 'TaskClassFrequencyController@getAllTaskClassFrequencies');

//Currency Routes
Route::get('/get_all_currencies', 'CurrencyController@getAllCurrencies');

//Reference Routes
Route::get('/reference-form', 'ReferenceController@referenceForm');
Route::post('/add-and-send-reference', 'ReferenceController@addAndSendReference');