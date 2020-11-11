import Vue from "vue";
import Router from "vue-router";
import store from "../store/store";
import Dashboard from "../views/Dashboard.vue";
import About from "../views/About.vue";
import Settings from "../views/Settings.vue";
import Login from "../views/Login";
// Profile
import profile_show from "../views/profile/show.vue";
import profile_edit from "../views/profile/edit.vue";
import profile_change_password from "../views/profile/change-password.vue";
// Users
import user_index from '../views/users/index';
import user_create from "../views/users/create.vue";
import user_show from "../views/users/show.vue";
import user_edit from "../views/users/edit.vue";
import user_delete from "../views/users/delete.vue";
import user_change_password from "../views/users/change-password";
// User Groups
import user_group_index from '../views/user_groups/index';
import user_group_create from "../views/user_groups/create.vue";
import user_group_show from "../views/user_groups/show.vue";
import user_group_edit from "../views/user_groups/edit.vue";
import user_group_delete from "../views/user_groups/delete.vue";
// APIs
import api_index from '../views/apis/index';
import api_create from "../views/apis/create.vue";
import api_show from "../views/apis/show.vue";
import api_edit from "../views/apis/edit.vue";
import api_delete from "../views/apis/delete.vue";
// Roles
import role_index from '../views/roles/index';
import role_create from "../views/roles/create.vue";
import role_show from "../views/roles/show.vue";
import role_edit from "../views/roles/edit.vue";
import role_delete from "../views/roles/delete.vue";
// Projects
import project_index from '../views/projects/index';
import project_create from "../views/projects/create.vue";
import project_show from "../views/projects/show.vue";
import project_edit from "../views/projects/edit.vue";
import project_delete from "../views/projects/delete.vue";
// Project Units
import project_unit_index from '../views/project_units/index.vue';
import project_unit_create from "../views/project_units/create.vue";
import project_unit_show from "../views/project_units/show.vue";
import project_unit_edit from "../views/project_units/edit.vue";
import project_unit_delete from "../views/project_units/delete.vue";
//Builders
import builder_index from '../views/builders/index';
import builder_create from "../views/builders/create.vue";
import builder_show from "../views/builders/show.vue";
import builder_edit from "../views/builders/edit.vue";
import builder_delete from "../views/builders/delete.vue";
//locations
import location_index from '../views/locations/index';
import location_create from "../views/locations/create.vue";
import location_show from "../views/locations/show.vue";
import location_edit from "../views/locations/edit.vue";
import location_delete from "../views/locations/delete.vue";
// LeadStatuses
import lead_status_index from '../views/lead_status/index';
import lead_status_create from "../views/lead_status/create.vue";
import lead_status_show from "../views/lead_status/show.vue";
import lead_status_edit from "../views/lead_status/edit.vue";
import lead_status_delete from "../views/lead_status/delete.vue";
// LeadSources
import lead_source_index from '../views/lead_sources/index';
import lead_source_create from "../views/lead_sources/create.vue";
import lead_source_show from "../views/lead_sources/show.vue";
import lead_source_edit from "../views/lead_sources/edit.vue";
import lead_source_delete from "../views/lead_sources/delete.vue";
// Leads
import lead_index from '../views/leads/index';
import lead_create from "../views/leads/create.vue";
import lead_show from "../views/leads/show.vue";
import lead_delete from "../views/leads/delete.vue";
import lead_show_comments from '../views/leads/show-comments.vue';
import lead_show_histories from '../views/leads/show-lead-histories.vue';
import lead_create_histories from '../views/leads/show-create-histories.vue';
import lead_update_projects from '../views/leads/show-update-projects.vue';
import lead_children from '../views/leads/show-children-leads.vue';
import user_assigned_leads from '../views/leads/userAssignedLead.vue';
import unattended_leads from '../views/leads/unattendedLeads.vue';
//activities
import activity_index from '../views/activities/index';
//attendances
import attendance_index from '../views/attendances/index';
import attendance_create from '../views/attendances/create';
import attendance_bulk_create from '../views/attendances/leave';

const ifNotAuthenticated = (to, from, next) => {
    if (!store.getters.isLoggedIn) {
        next();
        return
    }
    next('/')
};

const ifAuthenticated = (to, from, next) => {
    if (store.getters.isLoggedIn) {
        next();
        return
    }
    next('/login')
};


Vue.use(Router);

export default new Router({
    linkActiveClass: "active",
    routes: [

        { path: "/login", name: "login", component: Login, beforeEnter: ifNotAuthenticated },
        { path: "/", name: "dashboard", component: Dashboard, beforeEnter: ifAuthenticated, meta: { permission: 'none' } },
        // Catch All Routes TODO: make a 404 page to catch all routes
        { path: "/about", name: "about", component: About, beforeEnter: ifAuthenticated, meta: { permission: 'none' } },
        { path: "/settings", name: "settings", component: Settings, beforeEnter: ifAuthenticated, meta: { permission: 'read-settings' } },

        //Profiles
        { path: "/profile/show", name: "profile.show", component: profile_show, beforeEnter: ifAuthenticated, meta: { permission: 'none' } },
        { path: '/profile/edit', name: "profile.edit", component: profile_edit, beforeEnter: ifAuthenticated, meta: { permission: 'none' } },
        { path: "/profile/change-password", name: "profile.changepassword", component: profile_change_password, beforeEnter: ifAuthenticated, meta: { permission: 'none' } },

        //Users
        { path: "/users", name: "users.index", component: user_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-users' } },
        { path: "/users/:id/show", name: "users.show", component: user_show, beforeEnter: ifAuthenticated, meta: { permission: 'show-users' } },
        { path: "/users/create", name: "users.create", component: user_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-users' } },
        { path: "/users/:id/edit", name: "users.edit", component: user_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-users' } },
        { path: "/users/:id/delete", name: "users.delete", component: user_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-users' } },
        { path: "/users/:id/change-password", name: "users.change_password", component: user_change_password, beforeEnter: ifAuthenticated, meta: { permission: 'update-users' } },
        
        //User Groups
        { path: "/user-groups", name: "user.groups.index", component: user_group_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-user-groups' } },
        { path: "/user-groups/:id/show", name: "user.groups.show", component: user_group_show, beforeEnter: ifAuthenticated, meta: { permission: 'show-user-groups' } },
        { path: "/user-groups/create", name: "user.groups.create", component: user_group_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-user-groups' } },
        { path: "/user-groups/:id/edit", name: "user.groups.edit", component: user_group_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-user-groups' } },
        { path: "/user-groups/:id/delete", name: "user.groups.delete", component: user_group_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-user-groups' } },
        //APIs
        { path: "/apis", name: "apis.index", component:api_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-apis' } },
        { path: "/apis/:id/show", name: "apis.show", component:api_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-apis' } },
        { path: "/apis/create", name: "apis.create", component:api_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-apis' } },
        { path: "/apis/:id/edit", name: "apis.edit", component:api_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-apis' } },
        { path: "/apis/:id/delete", name: "apis.delete", component:api_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-apis' } },
     
        //Roles
        { path: "/roles", name: "roles.index", component: role_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-roles' } },
        { path: "/roles/:id/show", name: "roles.show", component: role_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-roles' } },
        { path: "/roles/create", name: "roles.create", component: role_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-roles' } },
        { path: "/roles/:id/edit", name: "roles.edit", component: role_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-roles' } },
        { path: "/roles/:id/delete", name: "roles.delete", component: role_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-roles' } },

        //Projects
        { path: "/projects", name: "projects.index", component: project_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-projects' } },
        { path: "/projects/:id/show", name: "projects.show", component: project_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-projects' } },
        { path: "/projects/create", name: "projects.create", component: project_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-projects' } },
        { path: "/projects/:id/edit", name: "projects.edit", component: project_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-projects' } },
        { path: "/projects/:id/delete", name: "projects.delete", component: project_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-projects' } },
        
        //ProjectUnits
        { path: "/projectUnits", name: "projectUnits.index", component: project_unit_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-project-units' } },
        //{ path: "/projectUnits/:id/show", name: "projectUnits.show", component: project_unit_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-project-units' } },
        { path: "/projectUnits/create", name: "projectUnits.create", component: project_unit_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-project-units' } },
        { path: "/projectUnits/:id/edit", name: "projectUnits.edit", component: project_unit_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-project-units' } },
        { path: "/projectUnits/:id/delete", name: "projectUnits.delete", component: project_unit_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-project-units' } },
        
        //Builders
        { path: "/builders", name: "builders.index", component: builder_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-builders' } },
        { path: "/builders/:id/show", name: "builders.show", component: builder_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-builders' } },
        { path: "/builders/create", name: "builders.create", component: builder_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-builders' } },
        { path: "/builders/:id/edit", name: "builders.edit", component: builder_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-builders' } },
        { path: "/builders/:id/delete", name: "builders.delete", component: builder_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-builders' } },
          
        //locations
        { path: "/locations", name: "locations.index", component: location_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-locations' } },
        { path: "/locations/:id/show", name: "locations.show", component: location_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-locations' } },
        { path: "/locations/create", name: "locations.create", component: location_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-locations' } },
        { path: "/locations/:id/edit", name: "locations.edit", component: location_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-locations' } },
        { path: "/locations/:id/delete", name: "locations.delete", component: location_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-locations' } },
       
        //LeadStatuses
        { path: "/lead-statuses", name: "lead.statuses.index", component: lead_status_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-lead-statuses' } },
        { path: "/lead-statuses/:id/show", name: "lead.statuses.show", component: lead_status_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-lead-statuses' } },
        { path: "/lead-statuses/create", name: "lead.statuses.create", component: lead_status_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-lead-statuses' } },
        { path: "/lead-statuses/:id/edit", name: "lead.statuses.edit", component: lead_status_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-lead-statuses' } },
        { path: "/lead-statuses/:id/delete", name: "lead.statuses.delete", component: lead_status_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-lead-statuses' } },

        //LeadSources
        { path: "/lead-sources", name: "lead.sources.index", component: lead_source_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-lead-sources' } },
        { path: "/lead-sources/:id/show", name: "lead.sources.show", component: lead_source_show, beforeEnter: ifAuthenticated, meta: { permission: 'read-lead-sources' } },
        { path: "/lead-sources/create", name: "lead.sources.create", component: lead_source_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-lead-sources' } },
        { path: "/lead-sources/:id/edit", name: "lead.sources.edit", component: lead_source_edit, beforeEnter: ifAuthenticated, meta: { permission: 'update-lead-sources' } },
        { path: "/lead-sources/:id/delete", name: "lead.sources.delete", component: lead_source_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-lead-sources' } },

        //activities
        { path: "/activities", name: "activities.index", component: activity_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-activities' } },
        
        //attendances
        { path: "/attendances", name: "attendances.index", component: attendance_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-attendances' } },
        { path: "/mark-attendances/", name: "attendances.create", component: attendance_create, beforeEnter: ifAuthenticated, meta: { permission: 'update-attendances' } },
        { path: "/mark-leave/", name: "attendances.bulk_create", component: attendance_bulk_create, beforeEnter: ifAuthenticated, meta: { permission: 'update-attendances' } },

        //Leads
        { path: "/leads", name: "leads.index", component: lead_index, beforeEnter: ifAuthenticated, meta: { permission: 'read-leads' } },
        { path: "/user-assigned-leads", name: "userAssignedLeads", component: user_assigned_leads, beforeEnter: ifAuthenticated, meta: { permission: 'read-leads' } },
        { path: "/unattended-leads", name: "unattendedLeads", component: unattended_leads, beforeEnter: ifAuthenticated, meta: { permission: 'read-leads' } },
        { path: "/leads/create", name: "leads.create", component: lead_create, beforeEnter: ifAuthenticated, meta: { permission: 'create-leads' } },
        { path: "/leads/:id/edit", name: "leads.edit", component: lead_create, beforeEnter: ifAuthenticated, meta: { permission: 'update-leads' } },
        { path: "/leads/:id/delete", name: "leads.delete", component: lead_delete, beforeEnter: ifAuthenticated, meta: { permission: 'delete-leads' } },
        {
            path: "/leads/:id/show",
            name: "leads.show",
            component: lead_show,
            beforeEnter: ifAuthenticated,
            meta: { permission: 'read-leads' },
            children: [
                { path: "comments", name: "leads.show.comments", component: lead_show_comments, beforeEnter: ifAuthenticated, meta: { permission: 'read-comments' } },
                { path: "history", name: "leads.show.histories", component: lead_show_histories, beforeEnter: ifAuthenticated, meta: { permission: 'read-lead-histories' } },
                { path: "add-history", name: "leads.create.histories", component: lead_create_histories, beforeEnter: ifAuthenticated, meta: { permission: 'create-lead-histories' } },
                { path: "update-projects", name: "leads.update.projects", component: lead_update_projects, beforeEnter: ifAuthenticated, meta: { permission: 'create-lead-histories' } },
                { path: "children", name: "leads.children", component: lead_children, beforeEnter: ifAuthenticated, meta: { permission: 'read-histories' } },
            ]
        },
    ]
});
