<template>
    <div>
        <page-title
            :title="'Builder: '+ getBuilder.name"
            :title_links='title_links'
            :reload="reload"
        > </page-title>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="m-0">Name: {{getBuilder.name}}</p>
                        <p class="m-0">Created: {{getBuilder.created_at}} <span v-if="getBuilder.created_by">By {{getBuilder.created_by.name}}</span></p>
                        <p class="m-0">Last Updated: {{getBuilder.updated_at}} <span v-if="getBuilder.updated_by">By {{getBuilder.updated_by.name}}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        data(){
            return {
                title_links : [
                    {router_name : 'builders.create', router_params: '', router_hover : 'Add Builder', type : 'icon', icon:'add', 'class' : 'text-success'},
                    {router_name : 'builders.edit', router_params: this.$route.params.id, router_hover : 'Edit Builder', type : 'icon', icon:'edit', 'class' : 'text-warning'},
                ],
            }
        },
        computed : {
            ...mapGetters(['getBuilder', "getErrors", "getFolder", "getImageUrl"]),

            reload(){
                return {type : 'fetchShowBuilder', payload : this.$route.params.id};
            }
        },
        created() {
            this.$store.state.showSearchIcon = false;
            this.$store.dispatch("fetchShowBuilder", this.$route.params.id);
        }

    }
</script>
