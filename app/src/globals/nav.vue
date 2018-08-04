<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="http://relic.cloudaccess.host/wp-content/uploads/2018/06/logo-white.jpg" width="40" height="40" alt="Relic Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                    <li v-for="item in menu_items" class="nav-item">
                        <router-link :to="remove_base(item.url)" class="nav-link">{{ item.title }} </router-link>
                    </li>
            </ul>
        </div>
    </nav>

   
</template>

<script>
    export default {
        data: function(){
            return {
                menu_items: [],
                site_name: wp_rest_api.site_name,
                isOpen: false
            }
        },
        mounted: function(){
            jQuery.get( wp_rest_api.spa_url + 'menus/primary' ).always((response) => {
                this.menu_items             =   response;
            });
        },
        methods: {
            remove_base: function(url){
                return url.replace( "http://localhost/spa", "" );
            },
            toggleMenu: function(){
                this.isOpen = !this.isOpen;
            }
        },
         watch: {
            '$route'(newSlug, oldSlug) {
               jQuery(function($) {
                   $('#navbarNav').removeClass('show');
                });
            }
        }
    }
</script>