import Vue from "vue";
import axios from 'axios';

Vue.component("comment-reply", require('./components/replyToComment').default);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var app = new Vue({
    el: '#app',
    data: {
        contact : {},
        comment : {},
        parent_id: "",
        msg : '',
        loader : false,
        reply_form: false
    },
    methods:{
        submitForm(){
            let _this = this;
            _this.loader = true;
            axios.post('/api/send-enquiry-email', _this.contact)
            .then(function (response) {
                // handle success
                console.log(response.data.data);
                _this.msg = response.data.message;
                _this.loader = false;
                _this.contact = {}
                setTimeout(function(){
                    _this.msg = '';
                    }, 3000);
            })
        },
        showReplyForm(parent_id){
            let _this = this;
            _this.parent_id  = parent_id;
            _this.reply_form = true;
        },
        postComment(blog_id){
            console.log(blog_id);

            let _this = this;
            _this.loader = true;
            _this.comment.blog_id = blog_id
            axios.post('/api/post-a-comment', _this.comment)
            .then(function (response) {
                // handle success
                console.log(response.data.data);
                _this.msg = response.data.message;
                _this.comment = {}
                _this.loader = false;
                setTimeout(function(){
                    _this.msg = '';
                    }, 3000);
            })
        },
        reply(comment_id){
            console.log(comment_id);
            let _this = this;
            _this.reply_form = true;
            _this.comment.parent_id = comment_id
            axios.post('/api/post-a-comment', _this.comment)
            .then(function (response) {
                // handle success
                console.log(response.data.data);
                _this.msg = response.data.message;
                _this.comment = {};
                _this.reply_form = false;
                setTimeout(function(){
                    _this.msg = '';
                    }, 3000);
            })
        }
    }
})
