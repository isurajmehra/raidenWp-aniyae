<?php
/**
 * Template Name: Advanced Search Page
 *
 * @package Kiranime
 */

get_header('single');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$per_page = get_option('__archive_count', 20);
$query = [
    'post_type' => 'anime',
    'posts_per_page' => $per_page,
    'paged' => $paged,
    'order' => 'DESC',
    'orderby' => 'meta_value_num',
    'meta_key' => 'kiranime_anime_updated',
];
$kw = get_query_var('s_keyword');
$order = get_query_var('s_order');
$orderby = get_query_var('s_orderby');
$genre = get_query_var('s_genre');
$data_genre = !empty($genre) ? explode(",", $genre) : [];
$type = get_query_var('s_type');
$status = get_query_var('s_status');
$season = get_query_var('s_season');
$year_selected = get_query_var('s_year');
$premiered = '';

if (!empty($season) && $season != 'all') {
    if ($year_selected && $year_selected !== 'all') {
        $premiered = $season . ' ' . $year_selected;
    } else {
        $premiered = $season;
    }
}

if ((isset($year_selected) && $year_selected !== 'all') && (empty($season) || $season === 'all')) {
    $premiered = $year_selected;
}

$years = range(date('Y'), 1990);

if (!empty($kw)) {
    $query['keyword'] = $kw;
}

if (!empty($orderby)) {
    if ($orderby == 'title_a_z') {
        $query['orderby'] = 'title';
        $query['order'] = 'ASC';
    } elseif ($orderby == 'title_z_a') {
        $query['orderby'] = 'title';
        $query['order'] = 'DESC';
    } elseif ($orderby == 'update') {
        $query['orderby'] = 'meta_value_num';
        $query['meta_key'] = 'kiranime_anime_updated';
    } elseif ($orderby == 'viewed') {
        $query['orderby'] = 'meta_value_num';
        $query['meta_key'] = date('mY') . '_kiranime_views';
    }
}

$tax_query = [];
$meta_query = [];
if (!empty($genre)) {
    if ($genre != 'all') {
        $tax_query[] = [
            'taxonomy' => 'genre',
            'field' => 'slug',
            'terms' => explode(",", $genre),
        ];}
}

if (!empty($type)) {
    if ($type != 'all') {
        $tax_query[] = [
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => explode(",", $type),
        ];}
}
if (!empty($status)) {
    if ($status != 'all') {
        $tax_query[] = [
            'taxonomy' => 'status',
            'field' => 'slug',
            'terms' => explode(",", $status),
        ];}
}

if (!empty($premiered)) {
    $meta_query[] = [
        'key' => 'kiranime_anime_premiered',
        'value' => $premiered,
        'compare' => 'LIKE',
    ];
}

if (!empty($tax_query)) {
    if (count($tax_query) > 1) {
        $relation = [
            'relation' => 'AND',
        ];

        $query['tax_query'] = array_merge($relation, $tax_query);
    } else {
        $query['tax_query'] = $tax_query;
    }
}

if (!empty($meta_query)) {
    $query['meta_query'] = $meta_query;
}
$queried = new WP_Query($query);
?>
<section class="mt-17 w-full lg:max-w-[95vw] xxl:max-w-[90vw] mx-auto lg:pt-5 px-10">
    <!-- breadcrumb -->
    <nav aria-label="Breadcrumb" class="text-xs font-medium mb-5">
        <ol class="flex gap-2 items-center flex-wrap">
            <li>
                <a href="/">
                    <?php _e('home', 'kiranime')?>
                </a>
            </li>
            <li>
                <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
            </li>
            <li>
                <a href="?" class="text-gray-500">
                    <?php _e('filter', 'kiranime');?>
                </a>
            </li>
        </ol>
    </nav>
</section>
<div class="mb-17 pt-2 lg:pt-8 lg:grid grid-cols-12 lg:px-10 w-full mx-auto lg:max-w-[95vw] xxl:max-w-[90vw] gap-5">
    <section class="col-span-full">
        <div class="w-full h-auto p-4 bg-gradient-to-b from-tertiary mb-10 rounded shadow-md">
            <form action="<?=Kiranime_Utility::page_url('pages/advanced-search.php')?>" method="GET">
                <div class="text-sm font-medium mb-2 w-full">
                    <?php the_title()?>
                </div>
                <div class="flex items-center flex-wrap gap-5">
                    <input type="text" name="s_keyword" value="<?php echo $kw; ?>"
                        placeholder="<?php _e('Search title here..', 'kiranime')?>"
                        class="py-2 px-4 text-sm w-full lg:w-max lg:min-w-[200px] bg-tertiary bg-opacity-5 ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring-accent-3 focus:ring outline-none border-none rounded ease-in-out duration-200 transition-colors">
                    <div
                        class="w-full lg:w-max  lg:min-w-[200px] flex gap-2 items-center px-2 py-1 border-none ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring rounded-md text-sm">
                        <label for="s_type" class="min-w-max flex-shrink-0">
                            <?php _e('Type', 'kiranime');?>
                        </label>
                        <select name="s_type" id="s_type"
                            class="block w-full pl-3 pr-2 py-1 text-sm outline-none border-none bg-tertiary bg-opacity-0 focus:outline-none text-sky-400 focus:border-none">
                            <?php $data_types = get_terms(['taxonomy' => 'type']);?>
                            <option class="bg-tertiary" value="all"
                                <?php if ($type == '' || $type == 'all') {echo 'selected';}?>>
                                <?php _e('All', 'kiranime');?></option>
                            <?php foreach ($data_types as $fdbtype): ?>
                            <option class="bg-tertiary" value="<?=$fdbtype->slug;?>"
                                <?php if ($type == $fdbtype->slug) {echo 'selected';}?>><?=$fdbtype->name;?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div
                        class="w-full lg:w-max lg:min-w-[200px] flex gap-2 items-center px-2 py-1 border-none ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring rounded-md text-sm">
                        <label for="s_status" class="min-w-max flex-shrink-0"><?php _e('Status', 'kiranime');?></label>
                        <select name="s_status" id="s_status"
                            class="block w-full pl-3 pr-2 py-1 text-sm outline-none border-none bg-tertiary bg-opacity-0 focus:outline-none text-sky-400 focus:border-none">
                            <?php $data_status = get_terms(['taxonomy' => 'status']);?>
                            <option class="bg-tertiary" value="all"
                                <?php if ($status == '' || $status == 'all') {echo 'selected';}?>>
                                <?php _e('All', 'kiranime');?></option>
                            <?php foreach ($data_status as $fdbstatus): ?>
                            <option class="bg-tertiary" value="<?=$fdbstatus->slug;?>"
                                <?php if ($status == $fdbstatus->slug) {echo 'selected';}?>><?=$fdbstatus->name;?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div
                        class="w-full lg:w-max lg:min-w-[200px] flex gap-2 items-center px-2 py-1 border-none ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring rounded-md text-sm">
                        <label for="s_season" class="min-w-max flex-shrink-0">
                            <?php _e('Season', 'kiranime');?>
                        </label>
                        <select name="s_season" id="s_season"
                            class="block w-full pl-3 pr-2 py-1 text-sm outline-none border-none bg-tertiary bg-opacity-0 focus:outline-none text-sky-400 focus:border-none">
                            <option class="bg-tertiary py-2" value="all"
                                <?php if ($season == '' || $season == 'all') {echo 'selected';}?>>
                                <?php _e('All', 'kiranime');?></option>
                            <option class="bg-tertiary py-2" value="winter"
                                <?php if ($season == 'winter') {echo 'selected';}?>>
                                Winter
                            </option>
                            <option class="bg-tertiary py-2" value="spring"
                                <?php if ($season == 'spring') {echo 'selected';}?>>
                                Spring
                            </option>
                            <option class="bg-tertiary py-2" value="summer"
                                <?php if ($season == 'summer') {echo 'selected';}?>>
                                Summer
                            </option>
                            <option class="bg-tertiary py-2" value="fall"
                                <?php if ($season == 'fall') {echo 'selected';}?>>
                                Fall
                        </select>
                    </div>
                    <div
                        class="w-full lg:w-max lg:min-w-[200px] flex gap-2 items-center px-2 py-1 border-none ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring rounded-md text-sm">
                        <label for="s_year" class="min-w-max flex-shrink-0">
                            <?php _e('Year', 'kiranime');?>
                        </label>
                        <select name="s_year" id="s_year"
                            class="block w-full pl-3 pr-2 py-1 text-sm outline-none border-none bg-tertiary bg-opacity-0 focus:outline-none text-sky-400 focus:border-none">
                            <option class="bg-tertiary" value="all"
                                <?php if ($year_selected == '' || $year_selected == 'all') {echo 'selected';}?>>
                                <?php _e('All', 'kiranime');?>
                            </option>
                            <?php foreach ($years as $year): ?>
                            <option class="bg-tertiary" value="<?php echo $year ?>"
                                <?php if ($year == $year_selected) {echo 'selected';}?>><?php echo $year ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div
                        class="w-full lg:w-max  lg:min-w-[200px] flex gap-2 items-center px-2 py-1 border-none ring-1 ring-sky-500 shadow-sm shadow-accent-3 drop-shadow-md focus:ring rounded-md text-sm">
                        <?php $sorts = ['title_a_z' => __('Title ASC', 'kiranime'), 'title_z_a' => __('Title DESC', 'kiranime'), 'update' => __('Update', 'kiranime'), 'date' => __('Published', 'kiranime'), 'viewed' => __('Most Viewed', 'kiranime')]?>
                        <label for="s_orderby"
                            class="min-w-max flex-shrink-0"><?php _e('Sort by', 'kiranime');?></label>
                        <select name="s_orderby" id="s_orderby"
                            class="block w-full pl-3 pr-2 py-1 text-sm outline-none border-none bg-tertiary bg-opacity-0 focus:outline-none text-sky-400 focus:border-none">
                            <option class="bg-tertiary" value="default"
                                <?php if ($orderby == '' || $orderby == 'default') {echo 'selected';}?>>
                                <?php _e('Default', 'kiranime');?></option>
                            <?php foreach ($sorts as $key => $value): ?>
                            <option class="bg-tertiary" value="<?php echo $key ?>"
                                <?php if ($key == $orderby) {echo 'selected';}?>><?php echo $value ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="text-sm font-medium my-3 w-full">
                    <?php _e('Genre', 'kiranime');?>
                </div>
                <div class="flex flex-wrap gap-2 mb-5">
                    <?php $genres = get_terms(['taxonomy' => 'genre']);?>
                    <input type="hidden" name="s_genre" value="<?php echo $genre ?>" data-genre-input>
                    <?php foreach ($genres as $gnr): ?>
                    <div data-genre-slug="<?php echo $gnr->slug; ?>"
                        class="px-3 py-2 ring-1 cursor-pointer text-xs font-medium border-gray-500 rounded <?php if (in_array($gnr->slug, $data_genre)) {echo 'ring-sky-400 text-sky-400';} else {echo 'ring-gray-500';}?>">
                        <?php echo $gnr->name ?>
                    </div>
                    <?php endforeach;?>
                </div>
                <button type="submit"
                    class="outline-none border-none shadow-lg drop-shadow-md rounded-md bg-accent-3 w-full block text-center text-sm font-medium col-span-full py-2 px-4 hover:shadow-xl hover:drop-shadow-lg hover:bg-sky-700 ease-in-out duration-200 transition-colors"><?php _e('Filter', 'kiranime');?></button>
            </form>
        </div>
        <div class="flex items-center justify-between">
            <h3 class="mb-4 text-2xl font-semibold leading-10 text-sky-400">
                <?php _e('Filter Results', 'kiranime');?>
                <?php if ($kw) {printf(__('For <i>%1$s</i>', 'kiranime'), $kw);}?>
            </h3>
            <span
                class="text-sm font-light"><?php printf(esc_html__('%1$d Results', 'kiranime'), $queried->found_posts);?>
            </span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-5">
            <?php if ($queried->have_posts()): while ($queried->have_posts()): $queried->the_post();
        ?>
		            <div class="col-span-1">
		                <?php Kiranime_Utility::template('archive');?>
		            </div>
		            <?php endwhile;endif;?>
        </div>
        <?php
echo paginate_links(array(
    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
    'total' => $queried->max_num_pages,
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
</div>

<?php get_footer();?>