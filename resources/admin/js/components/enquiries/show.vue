<template>
    <div>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Enquiry Details
                </div>
                <div class="card-body">
                    
                    <h5 >Name</h5>
                    <p >{{enquiry.name}}</p>
                    <h5 >Email</h5>
                    <p >{{enquiry.email}}</p>

                    <h5 >Contact</h5>
                    <p >{{enquiry.mobile}}</p>

                    <h5 >Subject</h5>
                    <p >{{enquiry.subject}}</p>

                    <h5 >Description</h5>
                    <p >{{enquiry.description}}</p>
                    
                    <h5 >Read At</h5>
                    <p >{{enquiry.read_at}}</p>

                    <h5 v-if="enquiry.children">Conversation to this enquiry</h5>
                    <div v-for="child in enquiry.children" :key="child.id">
                        <div class="row" v-if="!child.created_id">
                             <div class="col-6" >
                                 name - {{child.name}} <br>
                                 reply -{{child.description}}<br>
                                 reply at - {{child.created_at}}
                             </div>
                            <div class="col-6" ></div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-6" ></div>
                            <div class="col-6" >
                                name - {{child.name}} <br>
                                 reply -{{child.description}}<br>
                                 reply at - {{child.created_at}}
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from "vuex";
    import Vue from 'vue';
    
export default {
    props : ['enquiry'],
    data(){
        return{

        }
    },
    methods : {
        reset(){
            this.$emit('reset');
        }
    }
}
</script>