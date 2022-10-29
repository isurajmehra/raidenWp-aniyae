<?php

$anime = new Kiranime_Anime(get_the_ID());

$anime->dah_lihat();

$meta = $anime->meta(['featured']);
$type = Kiranime_Utility::get_taxonomy(get_the_ID(), 'type');
$attr = Kiranime_Utility::get_taxonomy(get_the_ID(), 'anime_attribute');
$genre = Kiranime_Utility::get_taxonomy(get_the_ID(), 'genre');
$latest = $anime->latest_episode();
$showMeta = [];
foreach ($meta as $key => $value) {
    if (in_array($key, ['spotlight', 'background', 'updated', 'voted', 'voted_by', 'vote_score', 'download'])) {
        continue;
    }

    $showMeta[$key] = $value;
}

$img = $anime->get_image();

?>
<script>
const visit_anime_id = <?php echo get_the_ID(); ?>;
</script>
<div role="heading" style="padding:70px 0;" class="relative h-full min-h-100">
    <div class="bg-cover bg-center opacity-30 blur-xl absolute inset-0 z-0"
        style="background-image: url('<?php echo $img && $img['background'] ? $img['background'] : $img['featured']; ?>');">
    </div>
    <div
        class="lg:pl-16 px-5 w-full lg:w-9/12 h-auto flex flex-col sm:flex-row items-center justify-center sm:items-start sm:justify-start gap-10 z-10 relative sm:mb-10 lg:mb-0">
        <div class="lg:w-56 w-40 sm:w-1/4 flex-shrink-0">
            <img class="lg:w-52 md:w-48 h-auto rounded-sm shadow-sm " src="<?=$img['featured'];?>"
                alt="<?php the_title()?>">
        </div>
        <div class="lg:w-full w-full sm:w-3/4 md:pr-0 lg:pr-10 text-center sm:text-left">
            <!-- breadcrumb -->
            <nav aria-label="Breadcrumb" class="text-xs font-medium mb-5 hidden lg:block">
                <ol class="flex gap-2 items-center flex-wrap">
                    <li>
                        <a href="/">
                            <?php _e('Home', 'kiranime')?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <?php if ($type && $type[0]) {?>
                    <li>
                        <a href="<?=get_term_link($type[0])?>">
                            <?php echo $type[0]->name ?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <?php }?>
                    <li>
                        <a href="<?php the_permalink()?>" aria-current="page" class="text-gray-400">
                            <?php the_title()?>
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-4xl leading-tight font-medium mb-5">
                <?php the_title();?>
            </h2>
            <ul class="flex items-center justify-center sm:justify-start gap-2 mb-7 text-sm">
                <li class="space-x-1 text-xs">
                    <?php if ($meta['rate']): ?>
                    <span class="p-1 bg-white rounded text-black font-medium"><?php echo $meta['rate'] ?></span>
                    <?php endif;?>
                    <?php if (!is_wp_error($attr)): ?>
                    <?php foreach ($attr as $att): ?>
                    <span class="p-1 rounded border border-white font-medium">
                        <?php echo $att->name ?>
                    </span>
                    <?php endforeach;endif;?>
                </li>
                <li>
                    <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                </li>
                <?php if ($type && $type[0]): ?>
                <li>
                    <a href="<?=get_term_link($type[0])?>">
                        <?php echo $type[0]->name ?>
                    </a>
                </li>
                <li>
                    <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                </li>
                <?php else: ?>
                <li>
                    <a href="/anime-type/tv">
                        TV
                    </a>
                </li>
                <li>
                    <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                </li>
                <?php endif;if ($latest): ?>
                <li>
                    <a href="<?php echo $latest['url'] ?>">
                        Ep <?php echo $latest['metadata']['number'] ?>
                    </a>
                </li>
                <li>
                    <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                </li>
                <?php endif;?>
                <li>
                    <span>
                        <?php if ($meta['duration']): echo $meta['duration'];else:echo '24m';endif?>
                    </span>
                </li>
            </ul>
            <div class="flex items-center justify-center sm:justify-start gap-2 mb-5 relative flex-col md:flex-row">
                <a href="<?php if ($latest): echo $latest['url'];else:the_permalink();endif?>"
                    class="flex items-center gap-1 text-base justify-center md:justify-start px-5 py-2 bg-accent-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-3 h-3">
                        <path fill="currentColor"
                            d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
                    </svg>
                    <?php _e('Watch Now', 'kiranime');?>
                </a>
                <span data-anime-tippy-add-list="<?php the_ID()?>"
                    class="flex items-center gap-1 text-base justify-center md:justify-start px-5 cursor-pointer py-2 text-gray-900 bg-white rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-3 h-3">
                        <path fill="currentColor"
                            d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                    </svg>
                    <?php _e('Add to List', 'kiranime');?>
                </span>
                <div data-anime-tippy-content="<?php the_ID()?>" class="w-max h-auto bg-overlay shadow-md rounded-md">
                    <?php $lists = Kiranime_Watchlist::get_types();?>
                    <?php foreach ($lists as $list): ?>
                    <span data-add-to-watch-list data-watch-list-key="<?php echo $list['key'] ?>"
                        data-watch-list-id="<?php the_ID()?>"
                        class="block cursor-pointer text-left px-4 py-2 text-sm font-light hover:font-medium <?php echo $list['key'] == 'remove' ? 'text-color-error-accent-3' : ''; ?>"><?php echo $list['name']; ?></span>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="font-light text-spec hidden sm:block">
                <div data-synopsis class="line-clamp-3 inline-block">
                    <?php $content = strip_tags(get_the_content());?>
                    <?php echo $content; ?>
                </div>
                <?php if (strlen($content) > 280): ?>
                <span data-more-less data-ismore="true" class="font-medium cursor-pointer">+
                    <?php _e('More', 'kiranime')?></span>
                <?php endif;?>
                <div class="mt-5">
                    <?php printf(esc_html__('%1$s is the best site to watch %2$s SUB online, or you
                    can even watch %2$s DUB in HD quality', 'kiranime'), get_bloginfo('name'), get_the_title(), get_the_title());?>
                </div>
            </div>
            <?php if (get_theme_mod('__show_share_button', 'show') === 'show'): ?>
            <div class="w-full py-5 bg-opacity-100 hidden md:block gap-5 items-end">
                <div
                    class=" w-6/12 text-left pl-5 before:absolute before:hidden lg:before:block before:inset-0 before:h-full before:w-0.5 before:bg-accent-3 relative py-2">
                    <span class="text-sm font-semibold block text-sky-400 mb-2">
                        <?php _e('Share This Anime', 'kiranime');?>
                    </span>
                    <?php Kiranime_Utility::template('share');?>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <section
        class="lg:absolute relative lg:top-0 lg:right-0 w-full py-5 lg:py-0 lgmax-w-xs bottom-0 bg-white bg-opacity-10 lg:w-79 space-y-1 flex flex-col justify-center text-sm font-medium px-7">
        <div class="leading-6 sm:hidden">
            <span class="font-semibold mr-1 block"><?php _e('Overview:', 'kiranime');?></span>
            <span
                class="block w-full max-h-24 overflow-scroll my-3 overflow-x-hidden text-xs text-gray-200"><?php echo $content ?></span>
        </div>
        <section>
            <ul>
                <?php foreach ($showMeta as $datakey => $datavalue): if ($datavalue): ?>
			                <li class="list-none mb-1">
			                    <span class="font-semibold mr-1  leading-6">
			                        <?php echo ucfirst(__($datakey, 'kiranime')); ?>:
			                    </span>
			                    <span class="text-sm font-normal leading-6">
			                        <?php echo $datavalue && !strpos($datavalue, 'null') ? $datavalue : '' ?>
			                    </span>
			                </li>
			                <?php endif;endforeach;?>
                <li class="list-none">
                    <span class="font-semibold mr-1 leading-6">Genres:</span>
                    <span class="leading-6">
                        <?php foreach ($genre as $key => $g): if ($key < count($genre) - 1): ?>
			                        <a href="<?=get_term_link($g)?>"
			                            class="inline-block hover:text-sky-200"><?php echo $g->name ?></a><span>,</span>
			                        <?php else: ?>
                        <a href="<?=get_term_link($g)?>"
                            class="inline-block hover:text-sky-200"><?php echo $g->name ?></a>
                        <?php endif;endforeach;?>
                    </span>
                </li>
            </ul>
        </section>
    </section>
</div>
<div class="lg:flex gap-10 space-y-5 lg:space-y-0 lg:px-10 px-5 lg:py-10 py-5">
    <section class="flex-auto lg:w-9/12 w-full">
        <section>
            <!-- start download -->
            <?php Kiranime_Utility::template('download', 'component/list');?>
            <!-- end download -->
            <?php if (get_theme_mod('__ads_after_download')): ?>
            <div class="container flex items-center justify-center w-full h-auto my-5">
                <?php echo get_theme_mod('__ads_after_download') ?>
            </div>
            <?php endif;?>
        </section>
        <!-- Start comments -->
        <div class="py-5 my-5">
            <?php
// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()):
    comments_template();
endif;
?>
        </div>
        <!-- end comments -->
        <?php if (get_theme_mod('__show_related_anime', 'show') === 'show'): ?>
        <section>
            <!-- Start Recomended Anime -->
            <div class="w-full mb-4 flex items-center justify-between mt-10">
                <div class="mr-4">
                    <h2 class="text-2xl leading-10 font-semibold p-0 m-0 text-sky-400">
                        <?php $title = get_theme_mod('__show_related_anime_label');if ($title) {echo $title;} else {_e('Recomended For You!', 'kiranime');}?>
                    </h2>
                </div>
            </div>

            <section
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-2 md:gap-4 lg:gap-5 justify-evenly w-full flex-auto">
                <?php
$recommendations = new Kiranime_Query(['id' => get_the_ID()]);
$recommendations = $recommendations->related();

if ($recommendations->have_posts()):
    while ($recommendations->have_posts()):
        $recommendations->the_post();
        Kiranime_Utility::template('grid');
    endwhile;
endif;
?>
            </section>
            <!-- End Recomended Anime -->
        </section>
        <?php endif;?>
    </section>

    <!-- start second sidebar -->
    <aside class="w-full lg:w-3/12 flex-shrink-0 min-h-300">
        <?php if (is_active_sidebar('anime-info-sidebar')): dynamic_sidebar('anime-info-sidebar');endif;?>
    </aside>
    <!-- end second sidebar -->
</div>