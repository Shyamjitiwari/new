<template>
    <div class="row" style="min-height: 100vh;" v-if="!isLoggedIn">
            <div class="col-md-8 d-sm-none d-md-block" :style="{'background-image': 'url(' + getImageUrl + 'app/app.jpg)'}" style="background-size: cover"></div>
            <div class="col-md-4 bg-primary" style="padding-top:7rem">
                <form class="form-signin" @submit.prevent="submitForm(credentials)">
                    <div>
                        <div>
                            <h2 class="h2 mb-3 font-weight-normal text-center text-white">{{getCaptionsApp.app_name}}</h2>
                            <h4 class="h4 mb-3 font-weight-normal text-center text-white" v-if="!showForgotPasswordPage">{{getCaptionsLogin.sub_title}}</h4>
                            <h4 class="h4 mb-3 font-weight-normal text-center text-white" v-else>{{getCaptionsForgotPassword.sub_title}}</h4>
                            <label for="inputEmail" class="sr-only">{{getCaptionsLogin.email_placeholder}}</label>
                            <input
                                type="email"
                                v-model="credentials.email"
                                id="inputEmail"
                                class="form-control"
                                :placeholder="getCaptionsLogin.email_placeholder"
                                required
                                autofocus
                            />
                            <br>
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input
                                v-if="!showForgotPasswordPage"
                                type="password"
                                v-model="credentials.password"
                                id="inputPassword"
                                class="form-control"
                                :placeholder="getCaptionsLogin.password_placeholder"
                                required
                            />
                            <span v-if="getErrors.message !== ''" class="text-danger" v-text="getErrors.message"> </span>
                            <div class="custom-control custom-checkbox mb-3" v-if="!showForgotPasswordPage">
                                <input type="checkbox" class="custom-control-input" id="rememberme" value="remember-me">
                                <label class="custom-control-label text-white" for="rememberme">{{getCaptionsLogin.remember_me}}</label>
                            </div>
                            <submit-button class="btn-lg btn-dark btn-block" v-if="!showForgotPasswordPage" :status="getCaptionsLogin.login"> </submit-button>
                            <submit-button class="btn-lg btn-dark btn-block" v-else :status="getCaptionsForgotPassword.submit_link"> </submit-button>
                        </div>
                    </div>
                </form>
                <div class="text-center">
                    <a @click="showForgotPasswordPage = !showForgotPasswordPage" class="btn btn-link text-white" v-if="!showForgotPasswordPage">{{getCaptionsLogin.forgot_password}}</a>
                    <a @click="showForgotPasswordPage = !showForgotPasswordPage" class="btn btn-link text-white" v-else>{{getCaptionsForgotPassword.back_to_login}}</a>
                </div>
            </div>
        </div>
</template>

<script>
    import { mapGetters } from "vuex";
    export default {
        data: () => ({
            credentials: {},
            showForgotPasswordPage : false
        }),

        computed: {
            ...mapGetters(["getErrors", "getCaptionsLogin", "getCaptionsForgotPassword", "getCaptionsApp", "getImageUrl", "isLoggedIn"]),
        },

        created(){
            this.$store.state.showSearchIcon = false;
        },
        methods: {
            submitForm(credentials) {
                if(!this.showForgotPasswordPage) {
                    this.$store.dispatch("fetchToken", credentials);
                } else {
                    this.$store.dispatch("dispatchPasswordChange", credentials);
                }
            }
        }
    };
</script>


<style scoped>
    html,
    body {
        height: 100%;
    }
    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>

