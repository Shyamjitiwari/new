<template>
    <div>
        <h3 v-if="!isEditable">Add Product</h3>
        <h3 v-else>Edit Product</h3>
        <form id="createUser" @submit.prevent="createProduct()" enctype="multipart/form-data">
           <div class="row">
               <div class="col-md-8">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Upload Image</label>
                               <input type="file" @change="getImage" class="form-control">
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Image Alt Text</label>
                               <input type="text" v-model="product.alt" class="form-control" placeholder="Image Alt Text..."/>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Name</label>
                               <input type="text" v-model="product.name" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.name" class="text-danger">{{getErrors.name[0]}}</span>
                           </div>
                       </div>

                        <div class="col" v-if="isEditable">
                           <div class="form-group">
                               <label>Slug</label>
                               <input type="text" v-model="product.slug" class="form-control" placeholder="Name..."/>
                               <span v-if="getErrors.slug" class="text-danger">{{getErrors.slug[0]}}</span>
                           </div>
                       </div>

                       <div class="col">
                           <div class="form-group">
                               <label>Category</label>
                               <select class="form-control" v-model="product.category_id">
                                   <option disabled value="">Select Category</option>
                                   <option v-for="category in getActiveCategories" :value="category.id" :key="category.id">{{category.name}}</option>
                               </select>
                               <span v-if="getErrors.category_id" class="text-danger">{{getErrors.category_id[0]}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Created By</label>
                               <select class="form-control" v-model="product.created_id" required>
                                   <option disabled value="">Select User</option>
                                   <option v-for="user in getActiveUsers" :value="user.id" :key="user.id">{{user.name}}</option>
                               </select>
                               <span v-if="getErrors.created_id" class="text-danger">{{getErrors.created_id[0]}}</span>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label>Brand</label>
                                <select class="form-control" v-model="product.brand_id" required>
                                   <option disabled value="">Select Brand</option>
                                   <option v-for="brand in getActiveBrands" :value="brand.id" :key="brand.id">{{brand.name}}</option>
                               </select>
                               <span v-if="getErrors.brand_id" class="text-danger">{{getErrors.brand_id[0]}}</span>
                            </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Description</label>
                               <div>
                                    <tinymce  id="d1"  v-model="product.description"></tinymce>
                               </div>
                               <span v-if="getErrors.description" class="text-danger">{{getErrors.description[0]}}</span>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label>Add Attributes</label>
                               <select @change="updateAttributes(selectAttribute)" class="form-control" v-model="selectAttribute">
                                   <option v-for="attribute in getActiveAttributes" :value="attribute" :key="attribute.id">{{attribute.name}}</option>
                               </select>
                           </div>
                        <span v-if="getErrors.attributes" class="text-danger">{{getErrors.attributes[0]}}</span>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col">
                           <button type="button" class="btn btn-sm bg-primary m-1 text-white" v-for="attribute in product.attributes" :key="attribute.id">
                               {{attribute.name}}
                               <span @click="removeAttributes(attribute)" class="badge badge-dark">x</span>
                           </button>
                       </div>
                   </div>
                    <div class="row">
                        <div class="col-md-12" v-if="product.image">
                            <img :src="'/images2/'+product.image.image.folder+'/'+product.image.image.name" :alt="product.image.image.alt" style="width:100%">
                            <button @click="removeImage()" class="btn btn-sm btn-danger" type="button">Delete Image</button>
                        </div>
                        <div class="col-md-12" v-else>
                            <img src="/images2/default_blog.png" style="width:100%">
                        </div>
                    </div>

                   <div class="row">
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Title</label>
                               <input type="text" v-model="product.meta_title" class="form-control" placeholder="Meta Title..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Keywords</label>
                               <input type="text" v-model="product.meta_keywords" class="form-control" placeholder="Meta Keywords..."/>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Meta Description</label>
                               <textarea rows="5" v-model="product.meta_description" class="form-control" placeholder="Description..."></textarea>
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
</script>
<script>
    import { mapGetters } from "vuex";
    import Vue from 'vue';

    import tinymce from 'vue-tinymce-editor'
    import tinymce1 from 'tinymce/tinymce';

    Vue.component('tinymce', tinymce)

    export default {
        props : ['product'],
        data(){
            return {
                selectAttribute : {}
            }
        },
         mounted(){
                tinymce1.get("d1").setContent(this.product.description);
        },
        created() {
            this.$store.dispatch("fetchActiveCategories");
            this.$store.dispatch("fetchActiveBrands");
            this.$store.dispatch("fetchActiveAttributes");
            this.$store.dispatch("fetchActiveUsers");
        },
        computed: {
            ...mapGetters(["getErrors", 'getActiveCategories','getActiveBrands', 'getActiveAttributes', 'getActiveUsers', "isEditable"]),
        },
        methods : {
             isDuplicate(data, dataArray) {
                for(let i = 0; i < dataArray.length; i++){
                    if(data.name == dataArray[i].name) {
                        alert('Attribute already selected');
                        return true;
                    }
                }
                return false;
            },
            updateAttributes(attribute){
                if(this.product.attributes == undefined){
                    this.product.attributes = [];
                    this.product.attributes.push(attribute);
                } else if(!this.isDuplicate(attribute,  this.product.attributes)) {
                    this.product.attributes.push(attribute);
                }
                this.selectAttribute = {};
            },
            removeAttributes(attribute){
                this.product.attributes.splice(this.product.attributes.indexOf(attribute), 1);
            },
            getImage(e){
                let fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e) => {
                    this.product.image_name = e.target.result;
                }
            },
            removeImage(){
                if(confirm('Are you sure you want to delete this image?')){
                    this.$store.dispatch('removeImage', this.product);
                }
            },
            createProduct() {
                this.$store.dispatch("dispatchCreateProduct", {
                    'product': this.product,
                });
            },
            reset(){
                this.$emit('reset');
            }
        }
    }
</script>
