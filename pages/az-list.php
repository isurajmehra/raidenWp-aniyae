<?php

/**
 * Template Name: A-Z List
 *
 * @package Kiranime
 */

get_header('single');
$id = isset($_GET['letter']) ? $_GET['letter'] : 'All';
$page = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;

$anime = new Kiranime_Anime();

$get_posts = $anime->letter($id, $page);
$alphabet = ['All', '#', '0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
?>
<section class="mt-17 px-4 lg:px-10">
    <!-- breadcrumb -->
    <nav aria-label="Breadcrumb" class="text-xs font-medium mb-5">
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
                <a href="?" class="text-gray-500">
                    <?php _e('Lista - AZ', 'kiranime');?>
                </a>
            </li>
        </ol>
    </nav>
</section>
<section>
    <h2 class="font-semibold text-2xl leading-10 mb-4 text-accent-3 px-4 lg:px-10">
        <?php _e('Acorta tu busqueda mediante letras', 'kiranime');?>
    </h2>
    <div class="p-2 mb-5 h-auto font-montserrat">
        <ul class="w-full lg:px-10 grid grid-cols-6 lg:flex gap-x-1 flex-wrap gap-y-4">
            <?php foreach ($alphabet as $alpha): ?>
            <?php if ($alpha != '#'): ?>
            <li>
                <a class="px-4 py-2 w-full inline-block text-center col-span-1 leading-5 font-light rounded-sm shadow <?php echo $id == $alpha ? 'bg-accent-3' : 'bg-secondary'; ?>"
                    style="font-size: 0.925rem" href="?letter=<?php echo $alpha ?>"><?php echo $alpha; ?></a>
            </li>
            <?php else: ?>
            <li>
                <a class="px-4 py-2 w-full inline-block text-center col-span-1 leading-5 font-light rounded-sm shadow <?php echo $id == 'other' ? 'bg-accent-3' : 'bg-secondary'; ?>"
                    style="font-size: 0.925rem" href="?letter=other"><?php echo $alpha; ?></a>
            </li>
            <?php endif;endforeach;?>
        </ul>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 md:gap-4 lg:gap-5 lg:px-10">
        <?php if ($get_posts->have_posts()): while ($get_posts->have_posts()): $get_posts->the_post();?>
		        <div class="col-span-1">
		            <?php Kiranime_Utility::template('archive');?>
		        </div>
		        <?php endwhile;endif;?>
    </div>
</section>
<?php echo paginate_links(array(
    'base' => @add_query_arg('cpage', '%#%'),
    'format' => '&cpage=%#%',
    'prev_text' => __('&laquo;'),
    'next_text' => __('&raquo;'),
    'total' => $get_posts->max_num_pages,
    'current' => $page,
    'type' => 'list',
)); ?>
<div class="mb-17">
</div>
<?php get_footer();?>