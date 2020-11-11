<template>
    <div>
        <testimonial-create :testimonial="testimonial" v-if="showForm" @reset="reset"></testimonial-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Testimonials
                <span @click="addTestimonial">
                    <add-new-button title="Add New Testimonial" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(testimonial, index) in getTestimonials.data" :key="index">
                    <td>{{index + getTestimonials.from}}</td>
                    <td>
                        {{testimonial.name}}<br>
                    </td>
                    <td>
                        <span class="label bg-secondary text-white">{{testimonial.company}}</span>
                    </td>
                    <td>
                        <span class="label bg-info text-white">{{testimonial.designation}}</span>
                    </td>
                    <td>
                        <span class="label bg-info text-white">{{testimonial.description}}..</span>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                            @click="statusChange(testimonial.id, 'testimonials')"
                            type="checkbox"
                            :checked="(testimonial.status === 'active' ? true : false)"
                            class="custom-control-input "
                            :id="testimonial.id"
                            />
                            <label class="custom-control-label" :for="testimonial.id"></label>
                            </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editTestimonial(testimonial)">edit</i>
                        <i class="material-icons text-danger" @click="deleteTestimonial(testimonial)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getTestimonials" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import TestimonialCreate from './Create';
    export default {
        components: { TestimonialCreate },
        data(){
            return {
                testimonial : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchTestimonials", {
                next_page: this.getTestimonials.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getTestimonials", "isEditable", "showForm"]),
        },
        methods : {
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchTestimonials", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editTestimonial(testimonial){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.testimonial = testimonial;
            },
            addTestimonial(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.testimonial = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.testimonial = {};
            },
            deleteTestimonial(testimonial){
                if(confirm('Are you sure you want to delete this testimonial?')){
                    this.$store.dispatch('deleteTestimonial', testimonial);
                }
            },
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
        }
    }
</script>
