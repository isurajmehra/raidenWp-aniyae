<?php

/**
 * Template Name: News List Page
 *
 * @package Kiranime
 */

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$q = new Kiranime_Query(['page' => $paged]);
$query = $q->news();?>
<div class="pt-17 mt-5"></div>
<div class="md:px-5 lg:px-10 lg:flex gap-5 px-2">
    <section class="w-full lg:w-3/4">
        <!-- breadcrumb -->
        <nav aria-label="Breadcrumb" class="text-sm font-medium mb-5">
            <ol class="flex gap-2 items-center flex-wrap">
                <li>
                    <a href="/">
                        <?php _e('Inicio', 'kiranime');?>
                    </a>
                </li>
                <li>
                    <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                </li>
                <li>
                    <a href="<?=Kiranime_Utility::page_url('pages/news.php')?>" class="text-gray-500">
                        <?php _e('Noticias', 'kiranime');?>
                    </a>
                </li>
            </ol>
        </nav>
        <div>
            <?php
if ($query->have_posts()):
    while ($query->have_posts()):
        $query->the_post();
        get_template_part('template-parts/view/view', 'news');
    endwhile;
endif?>
        </div>
        <?php
echo paginate_links(array(
    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total' => $query->max_num_pages,
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
    <aside class="w-full lg:w-1/4 mt-10 lg:mt-0">
        <?php if (is_active_sidebar('article-sidebar')): dynamic_sidebar('article-sidebar');endif;?>
    </aside>
</div>
<?php get_footer()?>