<template>
    <div>
        <h3> Reply Enquiry</h3>
        <form id="createUser" @submit.prevent="replyEnq()">
           <div class="row">
               <div class="col">
                   <div class="form-group">
                        <label>Rely Text</label>
                        <input type="text" v-model="reply" class="form-control" placeholder="Reply..." required/>
                    </div>
               </div>
           </div>
            <submit-button label="Reply"> </submit-button>
            <span @click="reset()">
                <reset-button label="Close"></reset-button>
            </span>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import Vue from 'vue';

    export default {
        props : ['enquiry'],
        data(){
            return {
                reply: "",
            }
        },
        created() {

        },
        computed: {
            ...mapGetters(["getErrors"]),
        },
        methods : {
            replyEnq() {
                console.log(this.enquiry);
                this.$store.dispatch("replyEnquiry", {
                    'parent_id': this.enquiry.id,
                    'enquiry_user_name': this.enquiry.name,
                    'email': this.enquiry.email,
                    'reply' :this.reply,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
