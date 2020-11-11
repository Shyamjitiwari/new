<!-- Contact US -->
<section id="stayconnect" class="bglight position-relative">
    <div class="container">
        <div class="contactus-wrapp" style="background-color:#ff6666ff;">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class=" wow fadeInUp text-center text-md-left" data-wow-delay="300ms">
                        <h4 class="heading-title bottom30 whitecolor"><em>We'd love to hear from you ! Just give us
                                a few details and hit "Call Me Soon"</em></h4>
                        <span style="display:block;  margin-bottom: 50px;"></span>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12" id="contact">
                    <form class="wow fadeInUp" @submit.prevent="submitForm()" data-wow-delay="400ms">
                        <div class="row">
                            <div class="col-md-12 text-white" v-if="msg">@{{msg}}</div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="userName" class="d-none"></label>
                                    <input class="form-control" type="text" placeholder="Name" required
                                           id="userName" name="userName" v-model="contact.name">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="number" class="d-none"></label>
                                    <input class="form-control" type="text" placeholder="Phone Number" id="number"
                                           name="number" v-model="contact.number">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="email" class="d-none"></label>
                                    <input class="form-control" type="email" placeholder="Email" required id="email"
                                           name="" v-model="contact.email">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <button v-if="!loader" type="submit" class="button gradient-btn w-100">Call Me Soon
                                </button>
                                <button v-else type="submit" class="button gradient-btn w-100" id="submit_btn">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact US ends -->
