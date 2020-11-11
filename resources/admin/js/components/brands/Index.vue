<template>
    <div>
        <brand-create :brand="brand" v-if="showForm" @reset="reset"></brand-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Brands
                <span @click="addBrand">
                    <add-new-button title="Add New Brand" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(brand, index) in getBrands.data" :key="brand.id">
                    <td>{{index + getBrands.from}}</td>
                    <td>
                        {{brand.name}}<br>
                        <small>{{brand.slug}}</small>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(brand.id, 'brands')"
                                type="checkbox"
                                :checked="(brand.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="brand.id"
                            />
                            <label class="custom-control-label" :for="brand.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editBrand(brand)">edit</i>
                        <i class="material-icons text-danger" @click="deleteBrand(brand)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getBrands" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import BrandCreate from './create';
    export default {
        components: { BrandCreate },
        data(){
            return {
                brand : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchBrands", {
                next_page: this.getBrands.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getBrands", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchBrands", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editBrand(brand){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.brand = brand;
            },
            addBrand(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.brand = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.brand = {};
            },
            deleteBrand(brand){
                if(confirm('Are you sure you want to delete this brand?')){
                    this.$store.dispatch('deleteBrand', brand);
                }
            }
        }
    }
</script>
