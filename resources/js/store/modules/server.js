import Vue from 'vue';
import axios from 'axios';
import store from "../store";
import router from "../../router/router";

const actions = {
    dispatch_request(context, { method, url, data, success_callback, error_callback = false }) {
        let api_url = this.state.api_url;
        axios({
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + this.state.token,
                },
                method: method,
                url: api_url + url,
                data: data
            })
            .then(function(response) {
                if(success_callback) {
                    success_callback(response);
                }
                context.commit("setErrors", "");
                context.commit("setMessage", response.data.message);
                if (response.data.message && response.data.message !== 'Unauthenticated' || response.data.message !== null && response.data.message) {
                    Vue.notify({
                        group: 'notification',
                        text: response.data.message,
                    });
                }
            })
            .catch(function(error) {
                if (error_callback) {
                    error_callback(error)
                }
                context.commit("setErrors", error.response.data.errors);
                context.commit("setMessage", error.response.data.message);
                context.commit("getApiLoadingStatus");

                if (error.response.data.message === 'This action is unauthorized.') {
                    Vue.notify({
                        group: 'warning',
                        text: error.response.data.message,
                        duration: 6000
                    });
                    router.go(-1);
                } else if (error.response.data.message === 'Unauthenticated.') {
                    Vue.notify({
                        group: 'warning',
                        text: 'Token expired. Login again!',
                        duration: 6000
                    });
                    store.commit("unSetAuthToken");
                    window.location.href = '/';
                } else if (error.response.data.message !== 'Unauthenticated.' || error.response.data.message !== null) {
                    Vue.notify({
                        group: 'warning',
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
