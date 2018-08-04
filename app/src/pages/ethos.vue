<template>
    <div class="container ethos-container">
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
                })
            },
        },
        mounted: function(){
            jQuery.get( wp_rest_api.base_url + 'pages?slug=ethos').always((response) => {
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
    .ethos-container img{
        max-width: 100%;
        width:100%;
        height:auto;
    }
</style>