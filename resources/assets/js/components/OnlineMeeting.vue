<template>
   <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <td><h5>Instructions to join class:</h5>
                        <ol>
                            <li>Make sure you are logged out of any google account. (<a href="https://i.insider.com/5ca64aa9569b55635c4d89a3?width=750&format=jpeg&auto=webp" target="_blank">instructions to logout</a>)</li>
                            <li>Use headphone/headset for best experience</li>
                            <li>If on IPad/Tablet you MUST download Meet App (free to download from your iPad or Tablet app store).</li>
                            <li>After joining, please wait up to 5 minutes for your teacher to let you into the class. If you do not get in within 5 minutes, please start a chat at the bottom right of the page or text/call us (408)909-7717.</li>
                            <li>Once you have done all of the above, please click on the name of the student below</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td><h5>Join Meeting as:</h5></td>
                </tr>
            </thead>
             <tbody>
                <tr v-for="userName in userNames" v-bind:key="userName.user_id">
                    <td><a class="btn btn-primary btn-rounded btn-lg btn-block" target="_blank" @click="updateTag" :href="userName.link_to_meeting">{{ userName.user_name }}</a></td>
                </tr>      
            </tbody>
        </table>
    </div>
</template>


<script>
     export default {
        data(){
            return {
                userNames : [],
            };
        },
        methods:{
            updateTag(){
                gtag('event', 'coding_classes', {
                    'event_category' : 'attended_class',
                    'event_label' : 'portal',
                    'value' : '1'
                });
            },
            getUsernames(){
                var _this = this;
                axios.get('/get_username_for_online_meeting').then(function(response){     
                    _this.userNames = response.data.userNames; 
                })
            }
        },
        created() {
            this.getUsernames();
            console.log('VueJS component created.');
        }
    }
</script>
