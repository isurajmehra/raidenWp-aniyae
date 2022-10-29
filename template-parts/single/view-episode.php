<?php

$notif_id = isset($_GET['n_id']) ? $_GET['n_id'] : false;

if (isset($notif_id)) {
    Kiranime_Notification::delete($notif_id, get_current_user_id());
}

$episode = new Kiranime_Episode(get_the_ID());
$meta = $episode->meta();

if ($meta['parent_id']) {
    $anime_base = new Kiranime_Anime($meta['parent_id']);
    $anime_base->dah_lihat();
    $anime = $anime_base->as_parent();
    $vote = $anime_base->vote_get($meta['parent_id'], );
    $next = $anime_base->next_episode();
}

$players = $meta['players'];
$downloads = $meta['download'];
$images = $episode->get_image();
$type = Kiranime_Utility::get_taxonomy(get_the_ID(), 'episode_type');

// add inline scripts for episode javascripts requires
$ce = $meta['number'] ? $meta['number'] : 0;
$aid = $meta['parent_id'];
$anime_encode = json_encode($anime);
$data_inline = ';const kiranime_set_vote_anime = "' . wp_create_nonce('kiranime_set_vote_anime') . '";const currentEpisode = ' . $ce . ';const currentEpisodeId = ' . get_the_ID() . ';const animeId =' . $aid . ';const visit_anime_id = ' . $aid . ';const anime = ' . $anime_encode . ';const episodeDuration = "' . $meta['duration'] . '";';
wp_add_inline_script('kiranime-vendors', $data_inline, 'before');
?>
<section role="heading" class="relative h-full min-h-100 pt-6 lg:pt-10 pb-5">
    <div class="bg-cover bg-center opacity-30 blur-xl absolute inset-0 z-0"
        style="background-image: url('<?=$anime['featured']?>');">
    </div>
    <div class="w-full h-auto z-10 relative">
        <div class="w-full hidden lg:block">
            <!-- breadcrumb -->
            <nav aria-label="Breadcrumb" class="text-xs font-medium mb-5 px-10">
                <ol class="flex gap-2 items-center flex-wrap">
                    <li>
                        <a href="/">
                            <?php _e('Home', 'kiranime');?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <?php if ($anime['type']): ?>
                    <li>
                        <a href="<?=get_term_link($anime['type']);?>">
                            <?=$anime['type']->name;?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <?php endif;?>
                    <li>
                        <a href="<?=$anime['url'];?>">
                            <?=$anime['title'];?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <li>
                        <a href="<?php the_permalink()?>" aria-current="page" class="text-gray-400">
                            <?php the_title()?>
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- Player and episode list -->
        <div class="xl:flex items-start xl:px-4">
            <div
                class="w-full lg:px-10 <?php if (!$type || is_wp_error($type) || $type[0]->slug !== 'movie') {echo 'xl:w-3/4 lg:pl-90 xl:pl-80';}?> xl:pr-0 relative lg:min-h-500">
                <div class="w-full h-full p-0 bg-gray-900">
                    <div id="player-server">

                    </div>
                </div>
                <?php if (!$type || is_wp_error($type) || $type[0]->slug !== 'movie'): ?>
                <div
                    class="bg-primary lg:absolute inset-y-0 left-10 xl:left-0 lg:max-w-xs w-full h-full overflow-hidden lg:min-h-300">
                    <div
                        class="h-12 bg-overlay bg-opacity-5 lg:bg-darker lg:bg-opacity-100 w-full text-sm font-semibold flex items-center justify-between px-2 lg:px-4 relative z-20">
                        <span><?php _e('Episode List', 'kiranime')?></span>
                        <div class="w-7/12 relative">
                            <input data-episode-number-search type="text" name="episode_number"
                                class="bg-opacity-10 w-full pl-7 bg-primary px-2 py-2 h-full text-xs rounded focus:outline-none outline-none border-none ring-1 ring-gray-600 ring-opacity-70 font-medium text-gray-400"
                                placeholder="<?php _e('Episode number', 'kiranime')?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="w-3 h-3 absolute top-2 left-2">
                                <path fill="currentColor"
                                    d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                            </svg>
                        </div>
                    </div>
                    <div data-episode-list-container class="eplist-container overflow-y-scroll custom-scrollbar">
                        <div class="lg:min-h-screen pb-16">
                                    <?php
                                    foreach (array_reverse($anime['episodes']) as $key => $episode):
                                    $t_output = $episode['metadata']['title'] ? $episode['metadata']['title'] : $episode['title'];?>
                                    
	                            <a data-episode-list-index="<?=$key + 1;?>"
	                                class="relative py-2 lg:py-3 px-4 before:absolute before:inset-y-0 before:left-0 before:bg-accent-3 before:h-full <?php if ($episode['id'] === get_the_ID()): echo 'before:w-2px odd:bg-opacity-20 even:bg-opacity-20';else:echo 'odd:bg-opacity-10 even:bg-opacity-0';endif;?>  bg-white text-sm font-normal lg:font-medium flex gap-5"
	                                href="<?=$episode['url']?>" title="<?=$t_output?>">
	                                <?=$episode['metadata']['number']?>
	                                <span class="max-w-[75%] line-clamp-1"><?=$t_output?></span>
	                                <?php if ($episode['id'] === get_the_ID()): ?>
	                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
	                                    class="w-4 h-4 absolute top-1/2 transform -translate-y-1/2 right-4 text-accent-3">
	                                    <path fill="currentColor"
	                                        d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
	                                </svg>
	                                <?php endif;?>
                            </a>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <!-- Info anime -->
            <div
                class="w-full flex flex-col lg:flex-row xl:flex-col justify-between lg:px-10 px-5 py-10 xl:w-1/4 xl:p-0 xl:pl-5">
                <div
                    class="flex xl:w-full xl:flex-col order-2 lg:order-1 lg:gap-5 gap-2 lg:w-9/12 w-full py-5 lg:py-0 lg:flex-shrink-0">
                    <img src="<?=$anime['featured'];?>" alt="<?=$anime['title']?>" class="w-auto xl:w-1/3 h-44 xl:h-40">
                    <div class="text-xs font-medium pr-5 xl:px-0">
                        <a href="<?=$anime['url']?>">
                            <h3 class="font-semibold text-base xl:text-xl leading-relaxed line-clamp-2 mb-4">
                                <?=$anime['title'];?>
                            </h3>
                        </a>
                        <ul class="flex items-center gap-2 mb-5 text-xs">
                            <li class="space-x-1 text-xs">
                                <?php if ($anime['metadata']['rate']): ?>
                                <span
                                    class="p-1 bg-white rounded text-black font-medium"><?=$anime['metadata']['rate']?></span>
                                <?php endif;?>
                                <?php if ($anime['attribute']): ?>
                                <?php foreach ($anime['attribute'] as $att): ?>
                                <span class="p-1 rounded border border-white font-medium">
                                    <?=$att->name?>
                                </span>
                                <?php endforeach;endif;?>
                            </li>
                            <li>
                                <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                            </li>
                            <?php if ($anime['type']): ?>
                            <li>
                                <a href="<?=get_term_link($anime['type'])?>">
                                    <?=$anime['type']->name?>
                                </a>
                            </li>
                            <li>
                                <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                            </li>
                            <?php endif;?>
                            <li>
                                <span>
                                    <?php if ($anime['metadata']['duration']): echo $anime['metadata']['duration'];else:echo '24m';endif?>
                                </span>
                            </li>
                        </ul>
                        <span class="lg:line-clamp-6 overflow-y-scroll h-20 lg:h-auto inline-block">
                            <?=$anime['synopsis']?>
                        </span>
                    </div>
                </div>
                <div
                    class="w-full xl:mt-5 lg:w-3/12 xl:w-full flex-shrink-0 bg-primary bg-opacity-40 rounded p-4 flex flex-col justify-evenly max-h-max order-1 lg:order-2">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-sm flex items-center gap-2">
                            <svg class="w-6 h-6" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <polygon fill="#FCEA2B" stroke="none"
                                        points="35.9928,10.7363 27.7913,27.3699 9.4394,30.0436 22.7245,42.9838 19.5962,61.2637 36.0084,52.6276 52.427,61.2515 49.2851,42.9739 62.5606,30.0239 44.2067,27.3638" />
                                </g>
                                <g id="hair" />
                                <g id="skin" />
                                <g id="skin-shadow" />
                                <g id="line">
                                    <polygon fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="2"
                                        points="35.9928,10.7363 27.7913,27.3699 9.4394,30.0436 22.7245,42.9838 19.5962,61.2637 36.0084,52.6276 52.427,61.2515 49.2851,42.9739 62.5606,30.0239 44.2067,27.3638" />
                                </g>
                            </svg>
                            <span data-vote-score>
                                <?php $score = $vote['vote_score'] ? $vote['vote_score'] : 0;?>
                                <?=$score;?>
                            </span>
                            <span data-vote-count>
                                (<?php $voted = $vote['voted'] ? $vote['voted'] : 0;?>
                                <?=$voted;?>
                                <?php _e('Voted', 'kiranime')?>)
                            </span>
                        </div>
                        <span class="text-sm font-semibold">
                            <?php _e('Vote Now!', 'kiranime');?>
                        </span>
                    </div>
                    <span class="block w-full text-center text-sm font-semibold leading-loose my-2">
                        <?php _e('Rate this anime!', 'kiranime')?>
                    </span>
                    <div data-vote-status="0" class="flex items-center">
                        <?php $vhtml = $anime_base->vote_html($meta['parent_id'])?>
                        <?=$vhtml;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (get_theme_mod('__show_share_button', 'show') === 'show'): ?>
<div class=" w-full lg:px-10 py-5 bg-darkest relative flex gap-5  items-end">
    <div
        class="w-6/12 lg:w-2/12 pl-5 before:absolute before:hidden lg:before:block before:inset-0 before:h-full before:w-0.5 before:bg-accent-3 relative">
        <span class="text-sm font-semibold block">
            <?php _e('Share This Anime', 'kiranime');?>
        </span>
        <span class="block text-xs font-light">
            <?php _e('to your friends!', 'kiranime');?>
        </span>
    </div>
    <?php Kiranime_Utility::template('share');?>
</div>
<?php endif;?>
<div class="lg:flex gap-10 lg:px-10 md:px-5 py-10">
    <section class="flex-auto lg:w-9/12 w-full">
        <!-- start download -->
        <?php Kiranime_Utility::template('download', 'component/list');?>
        <!-- end download -->

        <?php $afe = get_option('__b_after_download') ? get_option('__b_after_download') : false;if ($afe): ?>
        <div class="container py-5 flex items-center justify-center max-w-full h-auto my-5">
            <?=$afe?>
        </div>
        <?php endif;?>
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
        <!-- Start Recomended Anime -->
        <?php if (get_theme_mod('__show_episode_related', 'show') === 'show'): ?>
        <section>
            <div class="w-full mb-4 flex items-center justify-between mt-10 px-4 md:px-0">
                <div class="mr-4">
                    <h2 class="text-2xl leading-10 font-semibold p-0 m-0 text-sky-400">
                        <?php $title = get_theme_mod('__show_episode_related_label');if ($title) {echo $title;} else {_e('Recomended For You!', 'kiranime');}?>
                    </h2>
                </div>
            </div>

            <div
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-2 md:gap-4 lg:gap-5 justify-evenly w-full flex-auto">
                <?php
$recommendations = new Kiranime_Query(['id' => $meta['parent_id']]);
$recommendations = $recommendations->related();

if ($recommendations->have_posts()):
    while ($recommendations->have_posts()):
        $recommendations->the_post();
        Kiranime_Utility::template('grid');
    endwhile;
endif;
?>
            </div>
        </section>
        <?php endif;?>
        <!-- End Recomended Anime -->
    </section>
    <aside class="w-full lg:w-3/12 flex-shrink-0 min-h-300">
        <?php if (is_active_sidebar('anime-info-sidebar')): dynamic_sidebar('anime-info-sidebar');endif;?>
    </aside>
</div>