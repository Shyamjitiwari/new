<template>
    <div>
        <form id="createLeadSource" @submit.prevent="addComment()" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea required id="comment" class="form-control" v-model="comment"> </textarea>
                        <span v-if="getErrors.comment !== ''" class="text-danger">{{getErrors.comment}}</span>
                    </div>
                </div>
            </div>
            <submit-button status="Add Comment"> </submit-button>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ['table','id', 'parent_id', 'modal'],
        data(){
            return {
                comment : ''
            }
        },
        computed: {
            ...mapGetters(["getErrors", "getMessage"]),
        },
        created() {},
        methods:{
            addComment(){
                this.$store.dispatch('dispatchCreateComment', {
                    'id' : this.id,
                    'type' : this.table,
                    'comment' : this.comment,
                    'parent_id' : this.parent_id
                })
                this.$store.dispatch('fetchShowLead', this.$route.params.id)
                this.comment = '';
                if(this.modal) {
                    this.$emit('hideModal');
                };
            }
        }
    }
</script>
