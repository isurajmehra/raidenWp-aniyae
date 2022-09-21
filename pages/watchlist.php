<?php

/**
 * Template Name: User Watch List Page
 *
 * @package Kiranime
 */
get_header('single');

$scripts = 'let animewatchlistparam = "all";';
wp_add_inline_script('kiranime-vendors', $scripts, 'before');
?>
<?php Kiranime_Utility::template('user');?>
<section class="w-full lg:w-9/12 mx-auto">
    <h2 class="text-2xl px-5 lg:px-0 leading-10 font-medium mb-5 flex items-center gap-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-7 h-7">
            <path fill="currentColor"
                d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z" />
        </svg>

        <?php the_title()?>
    </h2>
    <div id="watchlist-content" class="my-5"></div>
</section>

<?php get_footer()?>