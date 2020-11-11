<template>
    <div>
        <h3 v-if="!isEditable">Add Attribute</h3>
        <h3 v-else>Edit Attribute</h3>
        <form id="createUser" @submit.prevent="createAttribute()" enctype="multipart/form-data">
           <div class="row">
               <div class="col-md-12">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="attribute.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Group</label>                          
                               <select class="form-control" v-model="attribute.attribute_group_id">
                                   <option disabled value="">Select Group</option>
                                   <option v-for="attribute_group in getActiveAttributeGroups" :value="attribute_group.id" :key="attribute_group.id">{{attribute_group.name}}</option>
                               </select>
                               <span v-if="getErrors.attribute_group_id" class="text-danger">{{getErrors.attribute_group_id[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="attribute.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Sort</label>
                               <input type="number" v-model="attribute.sort" class="form-control" placeholder="Sort..."/>
                               <span v-if="getErrors.sort" class="text-danger">{{getErrors.sort[0]}}</span>
                           </div>
                       </div>
                    </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Description</label>
                               <div>
                                    <tinymce  id="d1"  v-model="attribute.description"></tinymce>
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
        props : ['attribute'],
        data(){
            return {
            }
        },
         mounted(){
                tinymce1.get("d1").setContent(this.attribute.description);
        },
        created() {
            this.$store.dispatch("fetchActiveAttributeGroups");
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveAttributeGroups', 'getActiveUsers', "isEditable"]),
        },
        methods : {
            createAttribute() {
                this.$store.dispatch("dispatchCreateAttribute", {
                    'attribute': this.attribute,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
