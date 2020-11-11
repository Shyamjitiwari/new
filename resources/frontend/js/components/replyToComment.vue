<template>
    <div>
       <div>
        <form class="getin_form" id="post-a-comment" @submit.prevent="reply(parent_id)">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group bottom35">
                        <label for="first_name1" class="d-none"></label>
                        <input class="form-control" type="text" placeholder="Name:" required  v-model="comment.name">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group bottom35">
                        <label for="email1" class="d-none"></label>
                        <input class="form-control" type="email" placeholder="Email:" required v-model="comment.email">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group bottom35">
                        <label for="message" class="d-none"></label>
                        <textarea class="form-control" placeholder="Your reply..."   required v-model="comment.message"></textarea>
                    </div>
                </div>
                <div class="col-sm-12 bottom5 text-sm-left text-center">
                    <button type="submit" v-if="!loader" class="button gradient-btn">Reply</button>
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
</template>