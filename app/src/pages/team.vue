<template>
    <div class="grid th-gallery relic-team-container">
        <div class="row">
            <div class="col-sm-12">
                <div class="th-grid"  v-html="post.content.rendered"></div>
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
            openPanel() {
                var classname = document.getElementsByClassName("panel-item");
                var open = function() {
                    var name = this.id.toString();
                    var riderName = this.id.split("_")[1];
                    var panel = document.getElementsByClassName("panel_"+riderName);
                    panel[0].classList.add("open");
                    var body = document.getElementsByTagName('body')[0];
                    body.classList.add('overflow-hidden');
                };

                for (var i = 0; i < classname.length; i++) {
                    classname[i].addEventListener('click', open, false);
                }
            }, 
            closePanel() {
                var classname = document.getElementsByClassName("panel__button");

                var close = function() {
                    console.log('close clicked');
                    var panel = document.getElementsByClassName("panel__container open");
                    panel[0].classList.remove("open");
                    var body = document.getElementsByTagName('body')[0];
                    body.classList.remove('overflow-hidden');
                };

                for (var i = 0; i < classname.length; i++) {
                    classname[i].addEventListener('click', close, false);
                }

            }
        },
        mounted: function(){
            jQuery.get( wp_rest_api.base_url + 'pages?slug=team').always((response) => {
                this.post       =   response[0];
            });
        },
         created (){
           this.showGrid();
            this.openPanel();
            this.closePanel();
        },
        updated: function(){
            this.showGrid();
            this.openPanel();
            this.closePanel();
        },
          beforeDestroy() {
            var classname = document.getElementsByClassName("panel-item");

            for (var i = 0; i < classname.length; i++) {
                classname[i].removeEventListener('click', open);
            }

            console.log('click even removed');
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
    .relic-team-container img{
        max-width: 100%;
        width:100%;
        height:auto;
    }
</style>