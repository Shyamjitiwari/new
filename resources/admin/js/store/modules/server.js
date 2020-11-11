import Vue from 'vue';
import axios from 'axios';
import store from "../store";

const actions = {
    dispatch_request(context, { method, url, data, success_callback, error_callback = false }) {
        let api_url = this.state.api_url;
        axios({
            method: method,
            url: api_url + url,
            data: data
        }).then(function(response) {
                if(success_callback) {
                    success_callback(response);
                }
                context.commit("setErrors", "");
                context.commit("setMessage", response.data.message);
                if (response.data.message && response.data.message !== 'Unauthenticated' || response.data.message !== null) {
                    Vue.notify({
                        group: 'notification',
                        text: response.data.message,
                        duration: 6000
                    });
                }

            }).catch(function(error) {
                if (error_callback) {
                    error_callback(error)
                }
                context.commit("setErrors", error.response.data.errors);
                context.commit("setMessage", error.response.data.message);
                context.commit("getApiLoadingStatus");

                if (error.response.data.message === 'This action is unauthorized.') {
                    Vue.notify({
                        group: 'notification',
                        text: error.response.data.message,
                        duration: 6000
                    });
                } else if (error.response.data.message === 'Unauthenticated.') {
                    Vue.notify({
                        group: 'notification',
                        text: 'Token expired. Login again!',
                        duration: 6000
                    });
                } else if (error.response.data.message !== 'Unauthenticated.' || error.response.data.message !== null) {
                    Vue.notify({
                        group: 'notification',
                        text: error.response.data.message,
                        duration: 6000
                    });
                }
            });
    }
};

export default {
    actions
}
