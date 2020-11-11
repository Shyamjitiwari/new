<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');

//route for posting Roof F Floor leads
Route::post('/post-leads-url', 'RoofFloorController@postLeadProcess');
Route::get('/post-leads-url', 'RoofFloorController@getLeadProcess');

Route::middleware(['auth:api', 'settings'])->group(function()
{
    Route::post('/impersonate', 'AuthController@impersonate');
    Route::get('/user', 'AuthController@authUser');
    Route::post('/permissions', 'AuthController@userPermissions');
    Route::post('/get-team', 'AuthController@getTeam');
    Route::post('/logout', 'AuthController@logout');

    //general routes
    Route::post('status-change', 'Controller@statusChange');
    Route::post('delete-image', 'Controller@deleteimage');
    Route::post('get-all-active', 'Controller@getAllActive');
    Route::post('get-all-active-filtered', 'Controller@getAllActiveFiltered');
    Route::get('getall/{table}', 'Controller@getAll');

    //Roles & Permissions
    Route::resource('roles', 'RoleController');

    // Setting routes
    Route::post('get-app-settings', 'Controller@appSettings');
    Route::resource('settings', 'SettingController');
    Route::put('settings/edit/{id}', 'SettingController@update');

    // Profile routes
    Route::get('profile/edit', 'UserController@profileedit');
    Route::post('profile/update', 'UserController@profileupdate');
    Route::post('profile/change-password', 'UserController@changeprofilepassword');

    // Users routes
    Route::get('users/get-users-for-team-selection', 'UserController@getUsersForTeamSelection');
    Route::resource('users', 'UserController');
    Route::put('users/change-password/{id}', 'UserController@changepassword');

    // User Groups routes
    Route::resource('user-groups', 'UserGroupController');
     
    // Leads routes
    Route::resource('leads', 'LeadController');
    Route::get('user-assigned-leads','LeadController@userAssignedLeads');
    Route::get('unattended-leads','LeadController@unattendedLeads');
    Route::post('leads-change-owner', 'LeadController@changeOwner');
    Route::post('leads-change-owner-bulk', 'LeadController@changeOwnerBulk');
    Route::post('leads-assignment-bulk', 'LeadController@leadAssignmentBulk');
    Route::post('lead-children', 'LeadController@leadChildren');
    Route::get('leads-for-today', 'LeadController@currentDayLeads');

    //leads imports
    Route::post('/leads-imports', 'LeadController@import')->name('leads.imports');

    // Lead Source routes
    Route::resource('lead-sources', 'LeadSourceController');

    // Lead Status routes
    Route::resource('lead-statuses', 'LeadStatusController');
    Route::post('get-parent-lead-statuses', 'LeadStatusController@getParentLeadStatus');
    Route::post('get-active-lead-statuses', 'LeadStatusController@getActiveLeadStatuses');

    //Comment routes
    Route::post('comments', 'CommentController@store');

    //Project routes
    Route::resource('projects', 'ProjectController');

    //Project-Unit routes
    Route::resource('projectUnits', 'ProjectUnitController');

    //Builder routes
    Route::resource('builders', 'BuilderController');

    //Location routes
    Route::resource('locations', 'LocationController');
    Route::post('get-parent-locations', 'LocationController@getParentLocations');

    //Lead History Routes
    Route::post('lead-histories', 'LeadHistoryController@store');
    Route::post('lead-histories-projects', 'LeadHistoryController@storeProjectHistory');

    //Activities Routes
    Route::get('activities', 'ActivityController@index');
    //APIs Routes
    Route::Resource('apis', 'ApiController');

    //Reports Routes
    Route::POST('user-lead-status-wise', 'DashboardController@userLeadStatusWise');
    Route::POST('user-lead-source-wise', 'DashboardController@userLeadSourceWise');
    Route::POST('user-lead-project-wise', 'DashboardController@userLeadProjectWise');
    Route::POST('qualified-leads-user-wise', 'DashboardController@qualifiedLeadsUserWise');
    Route::POST('dead-leads-user-wise', 'DashboardController@deadLeadsUserWise');
    Route::POST('user-daily-reports', 'DashboardController@dailyReport');
    //Attendances routes
    Route::resource('attendances','AttendanceController');
    Route::POST('user-attendance-mark', 'AttendanceController@markUserAttendance');
    Route::POST('user-attendance', 'AttendanceController@userAttendance');
    Route::POST('user-absent', 'AttendanceController@userAbsent');
    Route::POST('user-checkout', 'AttendanceController@userCheckout');
    Route::POST('attendance-mark-admin', 'AttendanceController@markUserAttendanceByAdmin');
    Route::POST('mark-absent', 'AttendanceController@markAbsent');

});
