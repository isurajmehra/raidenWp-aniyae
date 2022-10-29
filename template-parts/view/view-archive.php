<?php
$anime = new Kiranime_Anime(get_the_ID());
$meta = $anime->meta(['download', 'background', 'updated', 'spotlight', 'featured']);
$latest = $anime->latest_episode();
$image = $anime->get_image('featured');
$attr = Kiranime_Utility::get_taxonomy(get_the_ID(), 'anime_attribute');
$status = Kiranime_Utility::get_taxonomy(get_the_ID(), 'status');
$type = Kiranime_Utility::get_taxonomy(get_the_ID(), 'type');
?>

<div class="w-full bg-gradient-to-t from-primary rounded shadow">
    <div class="block relative w-full group pb-72 md:pb-60 lg:pb-80 xl:pb-60">
        <img src="<?=$image;?>" loading="lazy" alt="<?php the_title();?>"
            class="absolute inset-0 object-cover w-full h-full rounded shadow" />

        <div class="absolute inset-0 top-1/4" style="
					background: linear-gradient(0deg, #2a2c31 0, rgba(42, 44, 49, 0) 76%);
				"></div>
        <div class="flex items-center justify-between px-2 absolute bottom-0 inset-x-0">
            <!-- attribute -->
            <?php if ($attr): ?>
            <div class="min-w-max">
                <?php foreach ($attr as $att): ?>
                <span
                    class="text-black bg-white rounded-md text-xs p-1 mr-1 font-medium"><?php echo $att->name; ?></span>
                <?php endforeach;?>
            </div>
            <?php endif;?>
            <!-- episode -->
            <span class="text-xs px-2 py-1 rounded-md font-semibold text-white bg-accent-3" v-if="anime.latest">
                Ep <?php echo !empty($latest['metadata']['number']) ? $latest['metadata']['number'] : '?'; ?>
            </span>
        </div>
        <span class="absolute top-0 right-0 text-xs px-2 py-1 rounded-md font-semibold text-white bg-accent-3"><?=!is_wp_error($status) && count($status) > 0 && $status[0] ? $status[0]->name : 'Finalizado';?></span>
        <a data-tippy-trigger data-tippy-content-to="<?php the_ID();?>" href="<?php the_permalink();?>"
            class="group-hover:bg-opacity-75 bg-overlay hidden group-hover:flex items-center justify-center absolute inset-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-8 h-8">
                <path fill="currentColor"
                    d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
            </svg>
        </a>
    </div>

    <div style="min-height: 10rem" class="flex h-auto flex-col justify-between p-2 bg-overlay">
        <!-- Title -->
        <a href="<?php the_permalink();?>" class="text-sm line-clamp-2 font-medium leading-snug lg:leading-normal">
            <?php the_title()?>
        </a>
        <div class="text-xs text-white text-opacity-75 line-clamp-3 my-2">
            <?php the_content()?>
        </div>
        <!-- type and length -->
        <div class="text-xs text-white w-full line-clamp-1 py-1 sm:py-0 md:my-auto text-opacity-75">
            <span class="inline-block md:my-3"><?=isset($type[0]) ? $type[0]->name : 'TV';?></span>
            <span class="inline-block bg-gray-600 w-1 h-1 mx-2"></span>
            <span class="inline-block md:my-3"><?=isset($meta['duration']) ? $meta['duration'] : '24m'?></span>
        </div>
    </div>
</div>