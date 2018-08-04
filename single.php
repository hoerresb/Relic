<?php get_header(); ?>
 
 <div class="grid single" id="image-grid">
        <div class="postcontent post-top-margin clearfix">
         
        <?php 
        if(have_posts())
        {
            while(have_posts())
            {
                the_post();
                $author_ID = get_the_author_meta("ID");
                $author_url = get_author_posts_url($author_ID);
                ?>
                <div class="single-post">
                    <div class="entry-title">
                      <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    </div>
                    <div class="entry-meta clearfix">
                      <span><?php echo get_the_date();?></span>
                    </div>

                    <?php 
                    if(has_post_thumbnail()){
                    ?>
                    <div class="entry-image">
                      <a href="<?php the_permalink();?>" data-lightbot="imgage">
                        <?php the_post_thumbnail('full', array('class' => 'image_fade')); ?>
                      </a>
                    </div>
                    <?php 
                    }
                    ?>
                   
                    <div class="entry-content">
                      <?php 
                        the_content();
                        //add <!-- nextpage --> quicktags 
                        /*wp_link_pages(array(
                          'next_or_number' => 'next',
                          'nextpagelink' => 'next &gt;&gt;',
                          'previouspagelink' => '&lt;&lt; previous'
                      ) );*/
                      ?>
                    </div>

                    <!-- Previous/Next Links -->
                    <ul class="pager nomargin">
                        <li class="previous">
                        <?php previous_post_link('%link', '&#8249;', false);?>
                        </li>
                        <li class="next"><?php next_post_link('%link','&#8250;', false);?></li>
                    </ul>

                    <div class="previous-scroll">
                      <?php previous_post_link('%link', 'Scoll to see previous post <br/> %title', false);?>
                      <div class="trigger-line" style="height: 368px; opacity: 0.326948;"></div>
                      <div id="trigger" style="min-height:1px;"></div>
                    </div>
                      
                </div>

                <?php
            }
        }

        ?>
    </div>
</div>

<?php get_footer(); ?>