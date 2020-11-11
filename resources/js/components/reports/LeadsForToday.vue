<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body p-1 m-1">
                        <span data-toggle="collapse" href="#multiCollapseExample1">
                            <h5 class="cursor-pointer">Leads For Today</h5>
                        </span>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <ul class="list-group">
                                        <li class="list-group-item cursor-pointer" v-for="(lead,index) in getLeadsForToday" :key="index" @click="$router.push('/leads')">
                                            <span class="front-weight-bolder">Name:</span> {{lead.name}},
                                            <span class="front-weight-bolder">Mobile:</span> {{lead.mobile}}
                                        </li>
                                    </ul>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from "vuex";
    export default {
        data(){
            return {
                date : {}
            }
        },
        computed : {
          ...mapGetters(['getLeadsForToday','hasPermission'])
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch('fetchLeadsForToday');
        },
        methods:{
            
        }
    }
</script>