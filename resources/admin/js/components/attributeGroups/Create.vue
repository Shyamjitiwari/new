<template>
    <div>
        <h3 v-if="!isEditable">Add Attribute Group</h3>
        <h3 v-else>Edit Attribute Group</h3>
        <form id="createUser" @submit.prevent="createAttributeGroup()" enctype="multipart/form-data">
           <div class="row">
               <div class="col-md-12">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="attributeGroup.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="attributeGroup.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Sort</label>
                               <input type="number" v-model="attributeGroup.sort" class="form-control" placeholder="Sort..."/>
                               <span v-if="getErrors.sort" class="text-danger">{{getErrors.sort[0]}}</span>
                           </div>
                       </div>
                    </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Description</label>
                               <div>
                                    <tinymce  id="d1"  v-model="attributeGroup.description"></tinymce>
                               </div>
                               <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            <submit-button v-if="!isEditable" label="Add"> </submit-button>
            <update-button v-else label="Update"> </update-button>
            <span @click="reset()">
                <reset-button label="Close"></reset-button>
            </span>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import Vue from 'vue';

    import tinymce from 'vue-tinymce-editor'
    import tinymce1 from 'tinymce/tinymce';

    Vue.component('tinymce', tinymce)

    export default {
        props : ['attributeGroup'],
        data(){
            return {
            }
        },
         mounted(){
                tinymce1.get("d1").setContent(this.attributeGroup.description);
        },
        created() {
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveUsers', "isEditable"]),
        },
        methods : {

            createAttributeGroup() {
                this.$store.dispatch("dispatchCreateAttributeGroup", {
                    'attributeGroup': this.attributeGroup,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
