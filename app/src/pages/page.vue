<template>
    <div class="">
        <div class="row">
            <div class="col-sm-12">
                <div v-html="post.content.rendered"></div>
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
                    }
                }
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
                 var carousel = $('.carousel');
                 if(!!carousel){
                     console.log('carsoul is called');
                     $('.carousel').carousel({
                        interval: 4000
                    });
                 }
                })
            },
        },
        mounted: function(){
            jQuery.get( wp_rest_api.base_url + 'pages?slug=' + this.$route.params.slug ).always((response) => {
                this.post       =   response[0];
            });
        },
        updated: function(){
            this.showGrid();
        },
         watch: {
            '$route.params.slug'(newSlug, oldSlug) {
                if(typeof newSlug == 'undefined') newSlug = 'home';
                jQuery.get( wp_rest_api.base_url + 'pages?slug=' + newSlug ).always((response) => {
                    this.post       =   response[0]
                });
            }
        }
    }
</script>

<style>
  
</style>