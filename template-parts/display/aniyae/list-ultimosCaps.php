<?php
$anime = new Kiranime_Anime(get_the_ID());
$meta = $anime->meta();
$latest = $anime->latest_episode();
$image = $anime->get_image('featured');
$type = wp_get_post_terms(get_the_ID(), 'type');
?>
<a href="<?php echo $latest && $latest['url'] ? $latest['url'] : the_permalink(); ?>" title="<?php the_title();?>">
    <li class="flex gap-4 px-4 py-2 w-full max-w-sm rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mb-2" style="background-color: rgb(255 255 255 / 16%);">
        <div data-tippy-featured-id="<?php the_ID()?>"
            class=" w-12 h-16 pb-16 rounded shadow flex-shrink-0 relative overflow-hidden bg-primary">
                <img class="absolute inset-0 w-full h-full" src="<?=$image;?>" alt="<?php the_title()?>" />
        </div>
        <div class="w-full flex-auto">
            <h3 class="text-sm line-clamp-2 font-medium leading-6 mb-1">
                <?php the_title()?>
            </h3>
            <div class="flex items-center text-xs gap-2">
                <span class="whitespace-nowrap">
                    <?php echo !is_wp_error($type) && count($type) != 0 ? $type[0]->name : 'TV';?>
                </span>
                <span class="w-1 h-1 rounded-full bg-white bg-opacity-25 inline-block"></span>
                <span class="whitespace-nowrap">
                    Episodio:
                    <?php echo $latest ? $latest['metadata']['number'] : '?' ?>
                </span>
                <span class=" w-1 h-1 rounded-full bg-white bg-opacity-25 inline-block "></span>
                <span
                    class="whitespace-nowrap fdi-duration"><?php echo $meta['duration'] ? $meta['duration'] : '24m'; ?></span>
            </div>
        </div>
    </li>
</a>