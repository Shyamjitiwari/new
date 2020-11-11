<template>
    <div>
        <slider-create :slider="slider" v-if="showForm" @reset="reset"></slider-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Sliders
                <span @click="addSlider">
                    <add-new-button title="Add New Slider" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Heading</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
                    <th>Description 3</th>
                    <th>Hyper-link</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(slider, index) in getSliders.data" :key="index">
                    <td>{{index + getSliders.from}}</td>
                    <td>{{slider.heading}} </td>
                    <td>{{slider.description_line1}} </td>
                    <td>{{slider.description_line2}} </td>
                    <td>{{slider.description_line3}} </td>
                    <td>{{slider.hyper_linek}} </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(slider.id, 'sliders')"
                                type="checkbox"
                                :checked="(slider.status === 'active' ? true : false)"
                                class="custom-control-input "
                                :id="slider.id"
                            />
                            <label class="custom-control-label" :for="slider.id"></label>
                        </div>
                                                   
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editSlider(slider)">edit</i>
                        <i class="material-icons text-danger" @click="deleteSlider(slider)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getSliders" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    

    import { mapGetters } from "vuex";
    import SliderCreate from './create';
    export default {
        components: { SliderCreate },
        data(){
            return {
                slider : {
                    image_name : [],
                },
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchSliders", {
                next_page: this.getSliders.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getSliders", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchSliders", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editSlider(slider){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.slider = slider;
                this.slider.image_name = [];
            },
            addSlider(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.slider = {
                    image_name : [],
                };
                

            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.slider = {};
            },
            deleteSlider(slider){
                if(confirm('Are you sure you want to remove this slider?')){
                    this.$store.dispatch('deleteSlider', slider);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
