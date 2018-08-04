<template>
    <div class="grid postcontent">
        <div class="row single-post">
            <div class="col-sm-12">
               <h2 class="main-post-title">{{ post.title.rendered }}</h2>
                <p>
                    {{ moment(post.date) }} by
                    <router-link :to="'/author/' + post.author">{{ post.th_meta.user_nicename }}</router-link>
                </p>
                <img :src="post.th_meta.thumbnail">
                <div v-html="post.content.rendered"></div>

                <hr>

               <!-- <h2>Submit Comment</h2>
                <div class="alert" v-show="show_alert"
                     :class="alert_classes">{{ alert_message }}</div>
                <form @submit.prevent="submit_comment()">
                    <div class="form-group">
                        <textarea class="form-control"
                                  v-model="comment_body"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"
                                :disabled="is_submitted">Submit Comment</button>
                    </div>
                </form>

                <h2>Read Comment(s)</h2>

                <div class="panel panel-default" v-for="comment in comments">
                    <div class="panel-heading">
                        <h3 class="panel-title">Submitted by {{ comment.author_name }}</h3>
                    </div>
                    <div class="panel-body" v-html="comment.content.rendered"></div>
                </div> -->
            </div><!-- /.blog-main -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</template>

<script>
    export default {
        data: function(){
            return{
                post:               {
                    title:          {
                        rendered:   '',
                    },
                    date_:          '',
                    th_meta:       {
                        user_nicename: '',
                        thumbnail: ''
                    },
                    content:        {
                        rendered:   ''
                    }
                },
                comments:           [],
                is_submitted:       false,
                alert_classes:      {
                    'alert-info':   false,
                    'alert-warning':false,
                    'alert-danger': false
                },
                alert_message:      '',
                show_alert:         false,
                comment_body:       ''
            }
        },
        mounted: function(){
            jQuery.get( wp_rest_api.base_url + 'posts/' + this.$route.params.id ).always((response) => {
                this.post       =   response;
                console.log('single post called');
               // this.get_comments();
            });
        },
        updated: function() {
            this.showGrid();
        },
        methods: {
            get_comments: function(){
                jQuery.get( wp_rest_api.base_url + 'comments', { post: this.post.id } ).always((response) => {
                    this.comments       =   response;
                });
            },
             showGrid(){
                jQuery(function($) {
                    $('.grid').show();
                    var $grid = $('.th-grid').masonry({
                    itemSelector: '.grid-item'
                });
                if(!!$grid){
                    $grid.imagesLoaded(function(){
                        $grid.masonry();
                    })
                }
                })
            },
            submit_comment: function(){
                this.is_submitted                       =   true;
                this.show_alert                         =   true;
                this.alert_classes['alert-info']        =   true;
                this.alert_classes['alert-warning']     =   false;
                this.alert_classes['alert-success']     =   false;
                this.alert_message                      =   'Please wait!';

                jQuery.ajax({
                    url:            wp_rest_api.base_url + 'comments',
                    method:         'POST',
                    beforeSend:     function( xhr ){
                        xhr.setRequestHeader( 'X-WP-Nonce', wp_rest_api.nonce );
                    },
                    data: {
                        post: this.post.id,
                        content: this.comment_body
                    }
                }).always( (response) => {
                    this.is_submitted       =   false;

                    if( response.id ){
                        this.alert_classes['alert-info']        =   false;
                        this.alert_classes['alert-warning']     =   false;
                        this.alert_classes['alert-success']     =   true;
                        this.alert_message                      =   'Success!';
                        this.comment_body                       =   '';

                        this.get_comments();
                    }else{
                        this.alert_classes['alert-info']        =   false;
                        this.alert_classes['alert-warning']     =   true;
                        this.alert_classes['alert-success']     =   false;
                        this.alert_message                      =   'Error! Please make sure you ' +
                                                                    'input a comment and that you ' +
                                                                    'are logged in.';
                    }
                });
            }
        }
    }
</script>

<style>
   .postcontent img{
        max-width: 100%;
        width: 100%;
        height: auto;
        display: block;
        margin-bottom:1rem;
    }

</style>