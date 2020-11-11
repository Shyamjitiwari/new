const state = {
    captions: {
        app: {
            app_name: 'Leads Management',
            app_short_name: 'Managing leads is a breeze'
        },
        users: {
            delete_message: 'Are you sure you want to delete this user. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        user_groups: {
            delete_message: 'Are you sure you want to delete this user group. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        apis: {
            delete_message: 'Are you sure you want to delete this API. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        lead_sources: {
            delete_message: 'Are you sure you want to delete this lead source. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        lead_statuses: {
            delete_message: 'Are you sure you want to delete this lead status. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        leads: {
            delete_message: 'Are you sure you want to delete this lead. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        roles: {
            delete_message: 'Are you sure you want to delete this role. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        projects: {
            delete_message: 'Are you sure you want to delete this project. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        project_units: {
            delete_message: 'Are you sure you want to delete this project Unit. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        locations: {
            delete_message: 'Are you sure you want to delete this location. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        builders: {
            delete_message: 'Are you sure you want to delete this builder. Once delete the data cannot be recovered!',
            delete_button: 'Yes, delete!'
        },
        checkouts: {
            delete_message: 'Do  you want to checkout before leaving??.',
            delete_button: 'Yes, check me out!'
        },
        login: {
            login: 'Login',
            email_placeholder: 'Email address',
            password_placeholder: 'Password',
            sub_title: 'Log In',
            remember_me: 'Remember Me',
            forgot_password: 'Forgot Password?',
        },
        forgot_password: {
            submit_link: 'Submit Request',
            email_placeholder: 'Email address',
            sub_title: 'Send password reset link',
            back_to_login: 'Back To Login Page'
        },
        dashboard: {
            title: 'dashboard',
            page_title: 'dashboard',
        }
    }
};

const getters = {
    getCaptions(state) {
        return state.captions
    },
    getCaptionsLogin(state) {
        return state.captions.login
    },
    getCaptionsForgotPassword(state) {
        return state.captions.forgot_password
    },
    getCaptionsApp(state) {
        return state.captions.app
    },
    getCaptionsDashboard(state) {
        return state.captions.dashboard
    },
    getCaptionsUsers(state) {
        return state.captions.users
    },
    getCaptionsLeadSources(state) {
        return state.captions.lead_sources
    },
    getCaptionsLeadStatuses(state) {
        return state.captions.lead_statuses
    },
    getCaptionsLeads(state) {
        return state.captions.leads
    },
    getCaptionsRoles(state) {
        return state.captions.roles
    },
    getCaptionsProjects(state) {
        return state.captions.projects
    },
    getCaptionsLocations(state) {
        return state.captions.locations
    },
    getCaptionsProjectUnits(state){
        return state.captions.project_units
    },
    getCaptionsBuilders(state) {
        return state.captions.builders
    },
    getCaptionsUserGroups(state){
        return state.captions.user_groups
    },
    getCaptionsApis(state){
        return state.captions.apis
    },
    getCaptionsCheckouts(state){
        return state.captions.checkouts
    }
};

const mutations = {};

const actions = {};

export default {
    state,
    getters,
    mutations,
    actions
}
