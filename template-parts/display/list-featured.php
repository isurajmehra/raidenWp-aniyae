<?php
$anime = new Kiranime_Anime(get_the_ID());
$meta = $anime->meta();
$latest = $anime->latest_episode();
$image = $anime->get_image('featured');
$type = wp_get_post_terms(get_the_ID(), 'type');
?>
<li class="odd:bg-tertiary flex gap-4 px-4 py-2">
    <div data-tippy-featured-id="<?php the_ID()?>"
        class=" w-12 h-16 pb-16 rounded shadow flex-shrink-0 relative overflow-hidden bg-primary 						">
        <a href="<?php the_permalink();?>">
            <img class="absolute inset-0 w-full h-full" src="<?=$image;?>" alt="<?php the_title()?>" />
        </a>
    </div>
    <div data-tippy-featured-content-for="<?php the_ID()?>"
        class="relative p-4 max-w-xs min-w-[17rem] w-full bg-secondary shadow-md rounded-md drop-shadow-sm text-sm ">
        <div class="font-medium line-clamp-2 leading-loose mb-3">
            <?php the_title()?>
        </div>
        <div class="flex items-center justify-between mb-3 text-xs">
            <div class="flex items-center gap-4">
                <span class="inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                        class="w-4 h-4 inline-block text-yellow-500">
                        <path fill="currentColor"
                            d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" />
                    </svg>
                    <?php echo $meta && $meta['score'] ? $meta['score'] : 'N/A'; ?>
                </span>
                <span class="whitespace-nowrap" v-if="anime.latest && anime.latest.meta">
                    Ep
                    <?php echo $latest ? $latest['metadata']['number'] : '?' ?>/<?php echo $meta && $meta['episodes'] ? $meta['episodes'] : ''; ?>
                </span>
            </div>
            <span class="px-2 py-1 text-xs rounded bg-accent-3">
                <?php echo !is_wp_error($type) && count($type) != 0 ? $type[0]->name : 'TV'; ?>
            </span>
        </div>
        <span class=" w-full block text-sm font-montserrat font-light line-clamp-4 ">
            <?php the_content();?>
        </span>
        <div class="mb-2 mt-4 flex items-center gap-6">
            <a href="<?php the_permalink();?>"
                class=" flex items-center bg-accent-3 text-base font-light px-3 py-2 gap-2 rounded-full w-9/12 shadow drop-shadow justify-center ">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor"
                        d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
                </svg>
                <?php _e('Watch Now', 'kiranime');?>
            </a>
        </div>
    </div>
    <div class="w-full flex-auto">
        <h3 class="text-sm line-clamp-2 font-medium leading-6 mb-1">
            <a href="<?php the_permalink();?>" title="<?php the_title();?>" class="dynamic-name"><?php the_title()?></a>
        </h3>
        <div class="flex items-center text-xs gap-2">
            <span class="whitespace-nowrap">
                <?php echo !is_wp_error($type) && count($type) != 0 ? $type[0]->name : 'TV';
?>
            </span>
            <span class="w-1 h-1 rounded-full bg-white bg-opacity-25 inline-block"></span>
            <span class="whitespace-nowrap">
                Ep
                <?php echo $latest ? $latest['metadata']['number'] : '?' ?>/<?php echo $meta && $meta['episodes'] ? $meta['episodes'] : ''; ?>
            </span>
            <span class=" w-1 h-1 rounded-full bg-white bg-opacity-25 inline-block "></span>
            <span
                class="whitespace-nowrap fdi-duration"><?php echo $meta['duration'] ? $meta['duration'] : '24m'; ?></span>
        </div>
    </div>
</li>