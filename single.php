<?php

get_header('single');

if (have_posts()): the_post();
    $post_type = get_post_type(get_the_ID()) === 'post' ? 'news' : get_post_type(get_the_ID());
    $template = 'single-' . $post_type;
    Kiranime_Utility::template($template);
endif;

get_footer();