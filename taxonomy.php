<?php

get_header('single');
$sidebar_active = is_active_sidebar('archive-sidebar');
$current = get_queried_object();
$id = get_queried_object_id();
$tax_name = $current->taxonomy;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = new Kiranime_Query(['page' => $page, 'taxonomy' => $tax_name, 'tax_id' => $id, 'archive' => true]);
$animes = $args->taxonomy();
if ($animes->post_count === 0) {
    $animes = new WP_Query([
        'post_type' => 'anime',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'tax_query' => [
            [
                'taxonomy' => $tax_name,
                'field' => 'term_id',
                'terms' => $id,
            ],
        ],
    ]);
}
?>
<?php if (get_theme_mod('__show_share_button', 'show') === 'show'): ?>
<div class="mt-17 inline-block mb-5 bg-darkest w-full">
    <div class="px-4">
        <div class="py-5 px-0 relative flex items-center gap-5">
            <div class="block text-xs pl-5 py-1 relative border-l-2 border-sky-400">
                <span class="text-sm font-semibold text-sky-400">
                    <?php printf(esc_html__('Share %1$s', 'kiranime'), get_bloginfo('name'))?>
                </span>
                <p class="mb-0"><?php _e('to your friends', 'kiranime');?></p>
            </div>
            <?php Kiranime_Utility::template('share');?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="mt-17"></div>
<?php endif;?>
<div class="mb-17 grid grid-cols-12 px-4 mx-auto w-full gap-5">
    <section class="col-span-full <?php if ($sidebar_active) {echo 'lg:col-span-9';}?>">
        <h3 class="mb-4 text-2xl font-semibold leading-10 text-sky-400"><?php echo ucfirst($current->name) ?> Animes
        </h3>
        <div
            class="grid grid-cols-2 <?php if ($sidebar_active): echo 'md:grid-cols-4 xl:grid-cols-6';else:echo 'md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 xxl:grid-cols-7';endif;?> gap-4">
            <?php if ($animes->have_posts()): while ($animes->have_posts()): $animes->the_post();
        ?>
		            <div class="col-span-1">
		                <?php Kiranime_Utility::template('archive');?>
		            </div>
		            <?php endwhile;endif;?>
        </div>
        <?php
echo paginate_links(array(
    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total' => $animes->max_num_pages,
    'current' => max(1, get_query_var('paged')),
    'format' => '?paged=%#%',
    'show_all' => false,
    'type' => 'list',
    'end_size' => 2,
    'mid_size' => 1,
    'prev_next' => false,
    'add_args' => false,
    'add_fragment' => '',
));
?>
    </section>
    <?php if ($sidebar_active): ?>
    <aside class="col-span-full lg:col-span-3 ">
        <?php dynamic_sidebar('archive-sidebar');?>
    </aside>
    <?php endif;?>
</div>

<?php get_footer()?>