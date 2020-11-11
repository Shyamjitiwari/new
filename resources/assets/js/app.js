require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios';

//reusable components
Vue.component('pagination', require('./components/Pagination.vue'));
Vue.component('loader-button', require('./components/LoadingButton'));
Vue.component('update-student-topic', require('./components/UpdateStudentTopic'));

Vue.component('example', require('./components/Example.vue'));
Vue.component('login-component', require('./components/Login.vue'));
Vue.component('username-reset', require('./components/ForgotUsername.vue'));
Vue.component('lecture-category', require('./components/LectureCategories.vue'));
Vue.component('lecture-sub-category', require('./components/LectureSubCategories.vue'));
Vue.component('lecture', require('./components/Lectures.vue'));
Vue.component('calendar-component', require('./components/Calendar.vue'));
Vue.component('search-students', require('./components/SearchStudent.vue'));
Vue.component('edit-student-profile', require('./components/EditStudentProfile.vue'));
Vue.component('add-class', require('./components/AddClass.vue'));
Vue.component('topic', require('./components/Topic.vue'));

Vue.component('search-teachers', require('./components/SearchTeacher.vue'));
Vue.component('edit-teacher-profile', require('./components/EditTeacherProfile.vue'));

Vue.component('search-parents', require('./components/SearchParent.vue'));
Vue.component('get-parent-profile', require('./components/ParentProfile.vue'));

Vue.component('free-session-signup', require('./components/FreeSessionSignup.vue'));
Vue.component('free-session-signin', require('./components/FreeSessionSignin.vue'));
Vue.component('parents-students', require('./components/ParentsStudents.vue'));
Vue.component('add-student-by-user', require('./components/AddStudentByUser.vue'));
Vue.component('online-meeting', require('./components/OnlineMeeting.vue'));
Vue.component('free-session-time-slots', require('./components/FreeSessionTimeSlots.vue'));

// Training components with categories and sub categories
Vue.component('lesson-category', require('./components/LessonCategories.vue'));
Vue.component('lesson-sub-category', require('./components/LessonSubCategories.vue'));
Vue.component('lesson', require('./components/Lessons.vue'));
Vue.component('student-updates', require('./components/StudentUpdates'));
Vue.component('student-completed-classes', require('./components/CompletedClasses'));

//Dashboards
Vue.component('teacher-dashboard', require('./components/TeacherDashboard'));
//Bulk Messages Component
Vue.component('bulk-messages', require('./components/BulkMessages'));
//locations
Vue.component('locations', require('./components/Locations'));
//Task Class
Vue.component('task-class-profile', require('./components/TaskClassProfile'));
Vue.component('locations-index', require('./components/locations/Index'));
Vue.component('locations-create', require('./components/locations/Create'));

Vue.component('daily-task-classes', require('./components/DailyTaskClasses'));
Vue.component('ping-parents', require('./components/PingParent'));
Vue.component('mark-absent', require('./components/MarkAbsent'));
Vue.component('archive-student', require('./components/ArchiveStudent'));

//leads
Vue.component('leads', require('./components/Leads'));
Vue.component('add-lead', require('./components/AddLead'));

Vue.component('teacher-available-time-slot', require('./components/TeacherAvailableTimeSlot'));

//Settings
Vue.component('settings', require('./components/Settings'));

//Billing And Payments
Vue.component('billing-history', require('./components/BillingHistory'));
Vue.component('student-schedule-request', require('./components/StudentScheduleRequest'));

//Localization
Vue.component('localization', require('./components/Localization'));

//Credits Calculations 
Vue.component('users_credits', require('./components/UsersCredits'));

Vue.component('completed-classes-teacher', require('./components/CompletedClassesTeacher'));

//Reports
Vue.component('teachers_pay_report', require('./components/TeachersPayReport'));
Vue.component('calendar-students', require('./components/CalendarStudents'));
Vue.component('camps', require('./components/Camps'));
Vue.component('add_billing_products', require('./components/AddBillingProducts'));
Vue.component('parents-subscriptions', require('./components/ParentsSubscriptions'));
Vue.component('student-task-class-reschedule', require('./components/StudentTaskClassReschedule'));
Vue.component('reference-form', require('./components/ReferenceForm'));

window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-145736914-2');
gtag('config', 'AW-716777672');

Vue.use(gtag);

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

// Date Formatter

Vue.filter('timeOnly', function (value) {
    let time = new Date(value);
    return time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
});

Vue.filter('dateOnly', function (value) {
    let time = new Date(value);
    return time.toDateString();
});

Vue.filter('toDayDateString', function (value) {
    let date = new Date(value)
    return date.toDateString();
});

const app = new Vue({
    el: '#app_vue',
    data(){
        return {
            categoryPassword : false,
        }
    },
});

