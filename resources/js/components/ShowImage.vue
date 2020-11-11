<template>
    <div class="text-center">
        <div style="position: relative" v-if="size == 100" >
            <img width="100" height="auto" class="img-thumbnail" :src="getImageUrl + folder + '/' + image_name">
            <div class="text-danger" style="position:absolute; top:0; left:1%">
                <span @click="deleteImage()" class="badge badge-danger" style="border-radius:50%; cursor:pointer" title="Delete Image">x</span>
            </div>
        </div>
        <div style="position: relative" v-else-if="size == 50">
            <img width="50" height="auto" class="img-thumbnail" :src="getImageUrl + folder + '/' + image_name">
            <div class="text-danger" style="position:absolute; top:0; left:15%">
                <span @click="deleteImage()" class="badge badge-danger" style="border-radius:50%; cursor:pointer" title="Delete Image">x</span>
            </div>
        </div>
        <div style="position: relative" v-else-if="size == 'none'">
            <img class="img-thumbnail" :src="getImageUrl + folder + '/' + image_name">
            <div class="text-danger" style="position:absolute; top:0; left:15%">
                <span @click="deleteImage()" class="badge badge-danger" style="border-radius:50%; cursor:pointer" title="Delete Image">x</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        props : ["folder", "image_name", "size"],
        computed: {
            ...mapGetters(["getImageUrl"])
        },
        methods:{
            deleteImage() {
                // TODO: make a proper modal confirmation box component
                let confirm_delete = confirm('Are you sure you want to delete this image?');
                if(confirm_delete){
                    this.$store.dispatch('dispatchDeleteImage',
                        {
                            'image' : this.image_name,
                            'folder' : this.folder
                        }
                    )
                    if(this.from !== 'profile') {
                        this.$store.dispatch('fetchUsers', 1);
                    } else {
                        this.$store.dispatch('fetchProfile');
                    }
                }
            }
        }
    }
</script>
