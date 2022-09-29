<?php

/**
 * Template Name: Latest update archive
 *
 * @package Kiranime
 */

get_header('single');
$sidebar_active = is_active_sidebar('archive-sidebar');
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$query = new Kiranime_Query(['page' => $page, 'archive' => true]);
$posts = $query->latest();?>


<section class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
    <section class="col-span-full <?php if ($sidebar_active) {echo 'lg:col-span-9';}?>">
        <h3 class="mb-4 text-2xl font-semibold leading-10 text-sky-400">
            <?=get_option('__show_latest_label', 'Ultimos actualizados')?>
        </h3>
        <div
            class="grid grid-cols-2 <?php if ($sidebar_active) {echo 'lg:grid-cols-4 xl:grid-cols-5 3xl:grid-cols-6';} else {echo 'lg:grid-cols-5 xl:grid-cols-6 3xl:grid-cols-7';}?> gap-5">
            <?php if ($posts->have_posts()): while ($posts->have_posts()): $posts->the_post();?>
            <div class="col-span-1">
                <?php if (get_option('__show_latest_by', 'anime') === 'anime'):
            Kiranime_Utility::template('archive');
        else:
            Kiranime_Utility::template('episode', 'view/view');
        endif;?>
            </div>
            <?php endwhile;endif;?>
        </div>
        <?php
echo paginate_links(array(
    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total' => $posts->max_num_pages,
    'current' => max(1, get_query_var('paged', 1)),
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
</section>

<?php get_footer()?>