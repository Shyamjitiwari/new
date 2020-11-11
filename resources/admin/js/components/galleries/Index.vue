<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Add Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addImage()" enctype="multipart/form-data">
                    <div class="modal-body">
                            <div class="form-group">
                                <select  class="option form-control" required v-model="image.category">
                                    <option selected disabled value="">Choose A Category</option>
                                    <option v-for="category in getActiveCategories" v-bind:key="category.id" :value="category.id"> {{ category.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Upload image -</label>
                                <input type="file" class="form-control" multiple @change="getImage" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Add Image</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <span>
            <h3>
                Galleries
                <span data-toggle="modal" data-target="#exampleModalCenter">
                    <add-new-button title="Add New Gallery" ></add-new-button>
                </span>
            </h3>
                <form >
                    <div class="form-group">
                        <select  class="option form-control" @change="onChangeOfCategory($event)" required v-model="category_id">
                            <option selected disabled value="">Choose A Category</option>
                            <option v-for="category in getActiveCategories" v-bind:key="category.id" :value="category.id"> {{ category.name }}</option>
                        </select>
                    </div>
                </form>
                <div v-if="showGallery">
                    <div v-for="gallery in getGalleries" :key="gallery.id">
                        <ul v-if="gallery.category_id == category_id">
                            <li v-for="(image, index) in gallery.images" :key="index" style="display: inline-block">
                                <img v-lazy="'/images2/' + image.folder + '/' + image.name || image.thumb" style="height: 100px" @click="openGallery(index)">
                            </li>
                            <LightBox ref="lightbox" :media="gallery.media" :show-caption="true" :show-light-box="false"  :image_class=" 'img-responsive img-rounded' " :album_class=" 'my-album-class' "/>
                        </ul>
                    </div>
                </div>
        </span>
    </div>
</template>

<script>
    require('vue-image-lightbox/dist/vue-image-lightbox.min.css')

    import Vue from 'vue'
    import VueLazyLoad from 'vue-lazyload'
    import LightBox from 'vue-image-lightbox'
    import { mapGetters } from "vuex"

    Vue.use(VueLazyLoad)

    export default {
        components: {
            LightBox,
        },
        data(){
            return {
                category_id:"",
                showGallery:false,
                image:{
                    image_name : [],
                },
            }
        },
        created() {
            this.showGallery = false;
            this.image.category  = "";
            this.$store.dispatch("fetchActiveCategories");
        },
        computed: {
            ...mapGetters(["getErrors","getGalleries", "getActiveCategories", "showForm"]),
        },
        methods : {
            openGallery(index) {
                this.$refs.lightbox[0].showImage(index)
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
            },
            onChangeOfCategory(e){
                console.log('changed');
                this.$store.dispatch('fetchGalleries');
                this.showGallery = true;
            },
            getImage(e){
                for (let file of e.target.files) {
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload = (file) => {
                        this.image.image_name.push(file.target.result);
                    }
                }
            },
            addImage(){
                this.$store.dispatch("dispatchAddImage", {
                    'image': this.image,
                });
                this.image.image_name = [];
            }
        }
    }
</script>
