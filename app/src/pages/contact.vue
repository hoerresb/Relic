<template>
    <div class="grid th-gallery">
        <div class="row">
            <div class="col-sm-8" style="margin: 0 auto; position:relative;">
   
                <div v-html="post.content.rendered"></div>
                 <form @submit.prevent="submit()">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1"
                                  v-model="user_email" />
                    <div class="form-group">
                        <label for="exampleTextarea">Description</label>
                        <textarea class="form-control" id="exampleTextarea" rows="3" maxlength="100" v-model="user_description"></textarea>
                    </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"
                                :disabled="is_submitted">Submit</button>
                    </div>
                </form>
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
                    content:        {
                        rendered:   ''
                    },
                },
                is_submitted:   false,
                user_email: '',
                user_description: '',
                spotlightDiameter: 150
            }
        },
        methods: {
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
            submit(){
                
               // console.log(this.user_email);
                
                jQuery.ajax({
                    url:            wp_rest_api.spa_url + 'contact',
                    method:         'POST',
                    beforeSend:     function( xhr ){
                        xhr.setRequestHeader( 'X-WP-Nonce', wp_rest_api.nonce );
                    },
                    data: {
                        userEmail: this.user_email,
                    }
                }).always( (response) => { 
                    console.log(response);
                
                }); 
            },
            createSpotlight: function(){
                var that = this;
                jQuery(function($){
                     $('.spotlight').width(that.spotlightDiameter + 'px')
                        .height(that.spotlightDiameter + 'px')
                        .css({borderRadius: (that.spotlightDiameter >> 1) + 'px'});
                });
            }
        },
         updated: function() {
            this.showGrid();
            var that = this;
            jQuery(function($){
                console.log($('.content'));
                $('.content').on('mousemove', function(e){
                    console.log('moved');
                    var center = {x: e.pageX - this.offsetLeft,
                                y: e.pageY - this.offsetTop};
                    var x = center.x - (that.spotlightDiameter >> 1) -250;
                    var y = center.y - (that.spotlightDiameter >> 1);

                    $('.spotlight').css({left: x + 'px', top: y + 'px',
                                        backgroundPosition: -x + 'px ' + -y + 'px'}).show();
                });

                $('.content').on('mouseout', function(e){
                    console.log(this);
                    $('.spotlight').hide();
                });


              
                that.createSpotlight();
            })
        },
        mounted: function(){

             jQuery.get( wp_rest_api.base_url + 'pages?slug=contact').always((response) => {
                this.post       =   response[0];
                console.log('posts loaded');
            });
        },
    }
</script>

<style>
   
</style>
