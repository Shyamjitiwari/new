<template>
    <section id="comments-section">
        <div class="card">
            <div class="card-body">
                <add-comment table="leads" :id="getLead.id" :parent_id=null> </add-comment>
            </div>
        </div>
        <div v-for="comment in getLead.comments" :key="comment.id">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mb-0">
                                        {{comment.comment}}
                                    </p>
                                    <footer class="blockquote-footer">{{comment.created_at}} <cite title="Source Title">By: {{comment.created_by.name}}</cite></footer>
                                </div>
                                <div class="col-md-12">
                                    <div v-if="comment.children.length">
                                        <div v-for="child in comment.children" :key="child.id">
                                            <div v-if="child.created_id == getAuth.id" class="text-left">
                                                <p class="mb-0">
                                                    <span v-b-modal.modal-1 @click="postReply(child)">{{child.comment}}</span>
                                                </p>
                                                <footer class="blockquote-footer">{{child.created_at}} <cite title="Source Title">By: {{child.created_by.name}}</cite></footer>
                                            </div>
                                            <div v-else class="text-right">
                                                <p class="mb-0">
                                                    <span v-b-modal.modal-1 @click="postReply(child)">{{child.comment}}</span>
                                                </p>
                                                <footer class="blockquote-footer">{{child.created_at}} <cite title="Source Title">By: {{child.created_by.name}}</cite></footer>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span class="float-right btn btn-sm btn-warning" v-b-modal.modal-1 @click="postReply(comment)">Reply</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="modal-1" title="Add Reply">
            <add-comment table="leads" :id="getLead.id" :parent_id=comment.id modal="true" @hideModal="hideModal"> </add-comment>
            <template v-slot:modal-footer><b></b></template>
        </b-modal>
    </section>
</template>

<script>
    import AddComment from "../../components/AddComment";
    import {mapGetters} from "vuex";
    export default {
        components : {
            AddComment
        },
        data(){
            return {
                comment : {},
            }
        },
        computed : {
            ...mapGetters(['getLead', "getAuth", "getErrors"]),
        },
        methods : {
            postReply(comment){
                this.comment = comment;
            },
            hideModal(){
                this.$bvModal.hide('modal-1');
            }
        }
    }
</script>
