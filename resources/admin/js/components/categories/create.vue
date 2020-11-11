<template>
    <div>
        <h3 v-if="!isEditable">Add Category</h3>
        <h3 v-else>Edit Category</h3>
        <form id="createUser" @submit.prevent="createCategory()" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" v-model="category.name" class="form-control" placeholder="Name..."/>
                        <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                    </div>
                </div>
                <div class="col" v-if="isEditable">
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" v-model="category.slug" class="form-control" placeholder="Name..."/>
                        <span v-if="getErrors.slug" class="text-danger">{{getErrors.slug[0]}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea v-model="category.description" class="form-control" placeholder="Description..."></textarea>
                        <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                    </div>
                </div>
            </div>
            <submit-button v-if="!isEditable" label="Add"> </submit-button>
            <update-button v-else label="Update"> </update-button>
            <span v-on:click="reset()">
                <reset-button label="Close"></reset-button>
            </span>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ['category'],
        data(){
            return {

            }
        },
        created() {

        },
        computed: {
            ...mapGetters(["getErrors", "getCategories", "isEditable"]),
        },
        methods : {
            createCategory() {
                let _this = this;
                _this.$store.dispatch("dispatchCreateCategory", {
                    'category': _this.category
                })

            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
