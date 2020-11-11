<template>
    <div class="row" id="page-title">
        <div class="col-sm-12 p-0">
            <div class="card page-title">
                <div class="row align-content-center">
                    <div class="col-md-6">
                        <a style="cursor: pointer" @click="go_back" title="Back" class="badge badge-primary text-white p-1"><i class="material-icons">arrow_back</i></a>&nbsp;
                        <a style="cursor: pointer" @click="go_forward" title="Forward" class="badge badge-primary text-white p-1"><i class="material-icons">arrow_forward</i></a>&nbsp;
                        <a v-if="reload" style="cursor: pointer" @click="reload_dispatch" title="Reload Data" class="badge badge-danger text-white p-1"><i class="material-icons">autorenew</i></a>
                        <span class="ml-3 font-weight-bolder text-uppercase">{{title}}</span>
                    </div>
                    <div class="col-md-6 text-right pr-4">
                        <a @click="toggleSearchFilter" v-if="showSearchIcon">
                            <i class="material-icons text-danger" title="Show Filters">search</i>
                        </a>
                        <router-link
                            style="text-decoration: none"
                            v-for="link in title_links"
                            :key="link.router_name"
                            :to="{ name: link.router_name, params: link.router_params}"
                            :title="link.router_hover">
                            <i v-if="link.type === 'icon'" class="material-icons" :class="link.class">{{link.icon}}  &nbsp;&nbsp;</i>
                            <span v-else-if="link.type === 'label'" class="label text-white" :class="link.class">{{link.router_hover}}</span>
                        </router-link>
                        <a
                        v-for="(link, index) in click_links"
                        :key="index"
                        @click=dispatchEvent(link.click_event)
                        :title="link.click_hover"
                        >
                            <i v-if="link.type === 'icon'" class="material-icons" :class="link.class">{{link.icon}}  &nbsp;&nbsp;</i>
                            <span v-else-if="link.type === 'label'" class="label text-white" :class="link.class">{{link.click_hover}}</span>
                        </a>
                    </div>
                </div>
            </div>

        <!-- components -->
            <div class="modal fade" id="importLeadsModal" tabindex="-1" role="dialog" aria-labelledby="importLeadsModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importLeadsModalLabel">Import Leads</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <leads-import> </leads-import>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import LeadsImport from "./LeadsImport";
    export default {
        components : { LeadsImport },
        props: {
            title : null,
            //click_event methods must be present in the vuex store in actions sections, else they will not work
            click_links : {
                type:Array
            },
            title_links : {
                type:Array
            },
            reload : {
                type: Object
            }
        },
        computed: {
            ...mapState(["showReloadIcon", "showSearchIcon"])
        },
        methods:{
            toggleSearchFilter(){
                this.$store.dispatch("searchFilter");
            },
            go_back(){
                this.$router.go(-1);
            },
            go_forward(){
                this.$router.go(1);
            },
            reload_dispatch(){
                this.$store.dispatch(this.reload.type, this.reload.payload);
            },
            dispatchEvent(dispatchEventFunction){
                this.$store.dispatch(dispatchEventFunction);
            }
        }
    }
</script>

<style>
    .page-title {
        padding: .5rem;
    }

    #page-title{
        padding-bottom: 1rem;
    }

    #page-title .material-icons {
        font-size: 1.15rem
    }
    .label {
        padding: 5px;
        margin: 2px;
        position: relative;
        bottom: 3px;
        text-decoration: none;
    }
</style>
