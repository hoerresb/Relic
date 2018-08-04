<template>
    <div class="postcontent nobottomargin container-fluid">
         <div v-show="isLoading" id="spinnerContainer">
            <div class="spinner" id="spinner"></div>
            <!--[if lt IE 10]>
                <div class="ie-loading">loading...</div>
                <script type="text/javascript">
                    document.getElementById("spinner").style.display = "none";
                </script>
            <![endif]-->
        </div>
        <div class="row justify-content-md-center" id="posts">
            <app-post-excerpt v-for="post in posts"
                            :key="post.id" :post="post"></app-post-excerpt>
        </div>
    </div><!-- /.container -->
</template>

<script>
    export default {
        data: function(){
            return {
                posts:          [],
                page:           1, 
                loadMore:       true,
                isLoading:      true
            }
        },
        mounted: function(){
            this.get_posts();
        },
        created (){
            window.addEventListener('scroll', this.handleScroll);
        },
        methods:  {
            get_posts: function(){
                // var self = this;
                // this.page               =   parseInt(this.$route.query.page) || this.page;
                if( this.page < 1 ){
                    this.page           =   1;
                }

                jQuery.get( wp_rest_api.base_url + 'posts', { page: this.page }).always((response) => {
                   if(this.posts.length === 0){
                        this.posts          =   response;
                   }else{
                       if(Array.isArray(response)){
                            response.forEach(element => {
                                this.posts.push(element);
                            });
                       }else {
                           this.loadMore = false;
                       }
                   }
                   this.isLoading = false;
                });
            },
            handleScroll: function() {
                let that = this;
               jQuery(function($){
                   if  ($(window).scrollTop() == $(document).height() - $(window).height() && $(window).scrollTop() !== 0){
                       if(that.loadMore){
                            that.updatePage();
                            that.get_posts();
                       }else{
                            window.removeEventListener('scroll', this.handleScroll);
                       }
                    }
               })
            },
            updatePage: function() {
                ++this.page;
            }, 
            aosInit: function() {
                AOS.init({
                    easing: 'ease-in-out-sine'
                });
            }
        },
        watch: {
            '$route': function( to, from ){
                this.page = 1;
                this.get_posts();
            }
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.handleScroll);
            this.page = 1;
            console.log('scrolling Destroyed');
        }
    }
</script>