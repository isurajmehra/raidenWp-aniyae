<div class="grid grid-cols-3 lg:inline-flex shadow-md hover:shadow-lg focus:shadow-lg gap-2 pr-3 md:pr-0" role="group">
    <?php if (get_option('__share_shortcode') && str_contains(get_option('__share_shortcode'), '[')) {
    echo do_shortcode(get_option('__share_shortcode'));
} else {
    echo get_option('__share_shortcode');
}?>
</div>