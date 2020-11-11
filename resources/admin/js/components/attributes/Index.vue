<template>
    <div>
        <attribute-create :attribute="attribute" v-if="showForm" @reset="reset"></attribute-create>
        <br v-if="showForm">
        <span v-else>
            <h3>
                Attributes
                <span @click="addAttribute">
                    <add-new-button title="Add New Attribute" ></add-new-button>
                </span>
            </h3>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Description</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(attribute, index) in getAttributes.data" :key="attribute.id">
                    <td>{{index + getAttributes.from}}</td>
                    <td>
                        {{attribute.name}}<br>
                    </td>
                    <td>
                        <span class="label bg-secondary text-white">{{attribute.attribute_group.name}}</span>
                    </td>
                   <td>{{ attribute.description}} </td>
                   <td>
                        {{attribute.sort}}<br>
                    </td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input
                                @click="statusChange(attribute.id, 'attributes')"
                                type="checkbox"
                                :checked="(attribute.status === 'active' ? true : false)"
                                class="custom-control-input"
                                :id="attribute.id"
                            />
                            <label class="custom-control-label" :for="attribute.id"></label>
                        </div>
                    </td>
                    <td>
                        <i class="material-icons text-warning" @click="editAttribute(attribute)">edit</i>
                        <i class="material-icons text-danger" @click="deleteAttribute(attribute)">delete</i>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination show=4 :data="getAttributes" @updatePagination="updatePagination"></pagination>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";
    import AttributeCreate from './create';
    export default {
        components: { AttributeCreate },
        data(){
            return {
                attribute : {},
                pagination: {},
                search : {
                    name: "",
                }
            }
        },
        created() {
            this.$store.dispatch("fetchAttributes", {
                next_page: this.getAttributes.current_page,
                search: this.search
            });
        },
        computed: {
            ...mapGetters(["getErrors", "getAttributes", "isEditable", "showForm"]),
        },
        methods : {
            statusChange(id, table) {
                this.$store.dispatch("statusChange", { id, table });
            },
            updatePagination(pagination) {
                this.pagination = pagination;
                this.$store.dispatch("fetchAttributes", {
                    next_page: this.pagination.current_page,
                    search: this.search
                });
            },
            editAttribute(attribute){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', true);
                this.attribute = attribute;
            },
            addAttribute(){
                this.$store.commit('showForm', true);
                this.$store.commit('isEditable', false);
                this.attribute = {};
            },
            reset(){
                this.$store.commit('showForm', false);
                this.$store.commit('isEditable', false);
                this.attribute = {};
            },
            deleteAttribute(attribute){
                if(confirm('Are you sure you want to delete this attribute?')){
                    this.$store.dispatch('deleteAttribute', attribute);
                }
            }
        }
    }
</script>
