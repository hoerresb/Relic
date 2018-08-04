<template>
    <!--<div class="entry clearfix full-width-item row">
        <div class="full-width-item-inner">
            <div class="entry-meta-content">
                <div class="entry-meta clearfix">
                    <span>
                        {{ moment(post.date) }}
                    </span>
                    <span>
                    <span class="main-post-catagory">
                            <router-link :to="'/author/' + post.author">{{ post.th_meta.user_nicename }}</router-link>
                    </span>
                    </span>
                </div>
                <div class="entry-image">
                    <router-link :to="'post/' + post.slug + '/' + post.id" v-if="post.th_images">
                        <img :src="post.th_images" class="img-responsive image_fade full-width-image">
                    </router-link>
                    <div class="entry-title">
                        <h2 class="main-post-title">
                            <router-link :to="'post/' + post.slug + '/' + post.id">
                                {{ post.title.rendered }}
                            </router-link>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div> /.blog-post -->

    <div class="col col-12 col-sm-6 col-md-6 col-lg-4 post-container post-animate">
        <div class="entry-title">
            <h2 class="main-post-title">
                <router-link :to="'post/' + post.slug + '/' + post.id">
                    {{ post.title.rendered }}
                </router-link>
            </h2>
        </div>
        <div class="main-post-content">
            <div class="main-post-img-container">
                <router-link :to="'post/' + post.slug + '/' + post.id" v-if="post.th_images">
                    <img :src="post.th_images" class="img-fluid max-auto d-block">
                </router-link>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: [ 'post' ]
    }
</script>
