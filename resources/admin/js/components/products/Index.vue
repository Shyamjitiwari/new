<template>
    <div>
        <product-create :product="product" v-if="showForm" @reset="reset"></product-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Products
                <span @click="addProduct">
                    <add-new-button title="Add New Product" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in getProducts.data" :key="product.id">
                    <td>{{index + getProducts.from}}</td>
                    <td>
                        {{product.name}}<br>
                        <small>{{product.slug}}</small>
                    </td>
                    <td>
                        <span class="label bg-secondary text-white">{{product.category.name}}</span>
                    </td>
                    <td>
                        <span class="label bg-secondary text-white">{{product.brand.name}}</span>                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(product.id, 'products')"
                                type="checkbox"
                                :checked="(product.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="product.id"
                            />
                            <label class="custom-control-label" :for="product.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editProduct(product)">edit</i>
                        <i class="material-icons text-danger" @click="deleteProduct(product)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getProducts" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import ProductCreate from './create';
    export default {
        components: { ProductCreate },
        data(){
            return {
                product : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchProducts", {
                next_page: this.getProducts.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getProducts", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchProducts", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editProduct(product){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.product = product;
            },
            addProduct(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.product = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.product = {};
            },
            deleteProduct(product){
                if(confirm('Are you sure you want to delete this product?')){
                    this.$store.dispatch('deleteProduct', product);
                }
            }
        }
    }
</script>
