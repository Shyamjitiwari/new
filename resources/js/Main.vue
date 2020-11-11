<template>
    <div>
        <div v-if="!isLoggedIn">
            <router-view></router-view>
        </div>
        <div v-else class="d-flex" id="wrapper" :class="{'toggled' : sideMenuToggle}">
            <!-- Sidebar -->
            <div class="bg-light" id="sidebar-wrapper">
                <router-link tag="div" style="cursor:pointer" :to="{name:'dashboard'}" exact class="sidebar-heading">Dashhboard</router-link>
                <div class="list-group list-group-flush">
                    <router-link tag="a" :to="{ name:'dashboard'}" exact class="list-group-item list-group-item-action bg-light">Dashboard</router-link>
                    <router-link v-if="hasPermission['read-leads']" tag="a" :to="{ name:'leads.index'}" exact class="list-group-item list-group-item-action bg-light">Leads</router-link>
                    <router-link v-if="hasPermission['read-leads']" tag="a" :to="{ name:'userAssignedLeads'}" exact class="list-group-item list-group-item-action bg-light">Assigned Leads</router-link>
                    <router-link v-if="hasPermission['read-leads']" tag="a" :to="{ name:'unattendedLeads'}" exact class="list-group-item list-group-item-action bg-light">Unattended Leads</router-link>
                    <router-link v-if="hasPermission['read-lead-statuses']" tag="a" :to="{ name:'lead.statuses.index'}" exact class="list-group-item list-group-item-action bg-light">Lead Status</router-link>
                    <router-link v-if="hasPermission['read-lead-sources']" tag="a" :to="{ name:'lead.sources.index'}" exact class="list-group-item list-group-item-action bg-light">Lead Source</router-link>
                    <router-link v-if="hasPermission['read-projects']" tag="a" :to="{ name:'projects.index'}" exact class="list-group-item list-group-item-action bg-light">Projects</router-link>
                    <router-link v-if="hasPermission['read-project-units']" tag="a" :to="{ name:'projectUnits.index'}" exact class="list-group-item list-group-item-action bg-light">Project Units</router-link>
                    <router-link v-if="hasPermission['read-builders']" tag="a" :to="{ name:'builders.index'}" exact class="list-group-item list-group-item-action bg-light">Builders</router-link>
                    <router-link v-if="hasPermission['read-locations']" tag="a" :to="{ name:'locations.index'}" exact class="list-group-item list-group-item-action bg-light">Locations</router-link>
                    <router-link v-if="hasPermission['read-activities']" tag="a" :to="{ name:'activities.index'}" exact class="list-group-item list-group-item-action bg-light">Activities</router-link>
                    <router-link v-if="hasPermission['read-users']" tag="a" :to="{ name:'users.index'}" exact class="list-group-item list-group-item-action bg-light">Users</router-link>
                    <router-link v-if="hasPermission['read-user-groups']" tag="a" :to="{ name:'user.groups.index'}" exact class="list-group-item list-group-item-action bg-light">User Groups</router-link>
                    <router-link v-if="hasPermission['read-apis']" tag="a" :to="{ name:'apis.index'}" exact class="list-group-item list-group-item-action bg-light">APIs</router-link>
                    <router-link v-if="hasPermission['read-roles']" tag="a" :to="{ name:'roles.index'}" exact class="list-group-item list-group-item-action bg-light">Roles</router-link>
                    <router-link v-if="hasPermission['read-attendances']" tag="a" :to="{ name:'attendances.index'}" exact class="list-group-item list-group-item-action bg-light">Attendances</router-link>
                    <router-link v-if="hasPermission['read-settings']" tag="a" :to="{ name:'settings'}" exact class="list-group-item list-group-item-action bg-light">Settings</router-link>
                    <div class="accordion accordionSubMenu" v-if="getTeam.length">
                        <div class="card">
                            <div class="card-header headingOne" v-b-toggle.collapse-1 data-toggle="collapse" data-target="#collapseOne" >
                                <a class="btn btn-link collapsed" aria-expanded="true" aria-controls="collapseOne">
                                    Team
                                </a>
                                <span class="float-right">
                                  <i class="material-icons">arrow_drop_down</i>
                              </span>
                            </div>
                            <b-collapse id="collapse-1" class="sub-menu-items-group">
                                <b-list-group>
                                    <b-list-group-item href="#" @click="impersonate(team)" class="sub-menu-item" v-for="team in getTeam" :key="team.id">{{team.name}}</b-list-group-item>
                                </b-list-group>
                            </b-collapse>
                        </div>
                    </div>
                    <a href="#" @click="signOut" class="list-group-item list-group-item-action bg-light">Log Out</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <b-navbar toggleable="lg" type="dark" variant="primary">
                    <i class="material-icons text-white" id="menu-toggle" @click="sideMenuToggle = !sideMenuToggle">menu</i>

                    <b-navbar-toggle target="nav-collapse"> </b-navbar-toggle>

                    <b-collapse id="nav-collapse" is-nav>
                        <b-navbar-nav>
                            <b-nav-item  exact :to="{name:'dashboard'}" >Dashboard</b-nav-item>
                        </b-navbar-nav>

                        <!-- Right aligned nav items -->
                        <b-navbar-nav class="ml-auto">
                            <!--                            <b-nav-item exact :to="{name:'dashboard'}">Contra</b-nav-item>-->
                            <b-nav-item v-if="hasPermission['create-attendances']" exact>

                                    <span class="btn btn-sm btn-danger" v-if="isAbsentToday"> <em >Absent for Today</em></span>
                                   
                             
                                    <span class="btn btn-sm btn-warning" v-else-if="!isAttendanceMarked" @click="markUserAttendance(getAuth.id)"><em>Mark your Attendance</em></span>
                                    
                                
                                    <span class="btn btn-sm btn-warning" v-else-if="!isCheckedOut"  @click="markUserAttendance(getAuth.id)"><em>Checkout</em></span>
                                    
                                 
                                    <span class="btn btn-sm btn-success" v-else > <em  >Checked out for today</em></span>
                                   
                            </b-nav-item>
                            <b-nav-item-dropdown right>
                                <!-- Using 'button-content' slot -->
                                <template v-slot:button-content>
                                    <em>{{getAuth.name}}</em>
                                </template>
                                <b-dropdown-item exact :to="{name:'profile.show'}">View Profile</b-dropdown-item>
                                <b-dropdown-item exact :to="{name:'profile.edit'}">Edit Profile</b-dropdown-item>
                                <b-dropdown-item exact :to="{name:'profile.changepassword'}">Change Password</b-dropdown-item>
                                <b-dropdown-item exact @click="signOut">Sign Out</b-dropdown-item>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>

                <div class="container-fluid">
                    <router-view/>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <apiloader :apiloader="$store.state.apiLoading"> </apiloader>
        <notifications group="notification" />
        <notifications classes="vue-notification error" group="warning" />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        data() {
            return {
              
                sideMenuToggle : false
            };
        },
        computed : {
            ...mapGetters(['getAuth', "getErrors", 'getMessage','isLoggedIn', 'isAttendanceMarked','isAbsentToday','isCheckedOut', 'hasPermission', 'getTeam', 'getCaptionsCheckouts']),
        },
        created() {
            this.showModal = false;
            this.$store.state.showSearchIcon = false;
            this.isLoggedIn ? this.$store.dispatch('fetchPermissions') : null;
            this.isLoggedIn ? this.$store.dispatch('fetchTeam') : null;
            this.isLoggedIn ? this.$store.dispatch('fetchAttendance') : null;
            this.isLoggedIn ? this.$store.dispatch('fetchAbsent') : null;
            this.isLoggedIn ? this.$store.dispatch('fetchCheckout') : null;
        },
        methods: {
            impersonate(team) {
                this.$store.dispatch('impersonateUser', {user_id:team.id});
            },
            signOut() {
                
                if(!this.isCheckedOut && this.isAttendanceMarked){
                    if(confirm("Do you wanna checkout ?")){
                        this.markUserAttendance(this.getAuth.id);
                    }
                    this.$store.dispatch('signOut');
                }else{
                this.$store.dispatch('signOut');
                }
            },
            markUserAttendance(user){
                this.$store.dispatch('markUserAttendance', {user_id:user});
            }
        }
    };
</script>
