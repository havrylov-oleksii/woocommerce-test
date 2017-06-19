<div class="socials-share">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>" target="_blank"><i
                class="fa fa-facebook-square" aria-hidden="true"></i></a>
    <a href="https://twitter.com/home?status=<?php the_title(); ?>" target="_blank"><i class="fa fa-twitter-square"
                                                                                       aria-hidden="true"></i></a>
    <a href="https://plus.google.com/share?url=<?php echo get_the_permalink(); ?>" target="_blank"><i
                class="fa fa-google-plus-square"
                aria-hidden="true"></i></a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink(); ?>&title=<?php the_title(); ?>&summary=<?php the_excerpt(); ?>&source="
       target="_blank"><i
                class="fa fa-linkedin-square" aria-hidden="true"></i></a>
    <a href="https://pinterest.com/pin/create/button/?url=&media=<?php echo get_the_post_thumbnail_url(); ?>&description=<?php the_excerpt() ?>"
       target="_blank"><i
                class="fa fa-pinterest-square"
                aria-hidden="true"></i></a>
</div><!--/socials-share-->
