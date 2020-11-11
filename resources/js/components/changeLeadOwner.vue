<template>
    <div>
        <form id="createLeadSource" @submit.prevent="changeOwner()">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Active Users</label>
                        <select class="form-control text-capitalize" v-model="user_id">
                            <option :value="user.id" v-for="user in getActiveUsers" :key="user.id">{{user.name}}</option>
                        </select>
                        <span v-if="getErrors.user_id !== ''" class="text-danger">{{getErrors.user_id}}</span>
                    </div>
                </div>
            </div>
            <submit-button status="Change Owner"> </submit-button>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ['lead_id', 'modal', 'search'],
        data(){
            return {
                user_id : ''
            }
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage", "getActiveUsers", "getLeads"]),
        },
        created(){
          this.$store.dispatch('fetchAllActiveUsers');
        },
        methods:{
            changeOwner(){
                this.$store.dispatch('changeLeadOwner', {
                    'lead_id' : this.lead_id,
                    'user_id' : this.user_id,
                });

                if(this.modal) {
                    this.$bvModal.hide('changeLeadOwner');

                    setTimeout(()=>{
                        this.$store.dispatch("fetchLeads", {
                            next_page: this.getLeads.current_page,
                            search: this.search
                        });
                    }, 300)

                }
            }
        }
    }
</script>
