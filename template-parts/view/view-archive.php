<?php
$anime = new Kiranime_Anime(get_the_ID());
$meta = $anime->meta(['download', 'background', 'updated', 'spotlight', 'featured']);
$latest = $anime->latest_episode();
$image = $anime->get_image('featured');
$attr = Kiranime_Utility::get_taxonomy(get_the_ID(), 'anime_attribute');
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
        <a data-tippy-trigger data-tippy-content-to="<?php the_ID();?>" href="<?php the_permalink();?>"
            class="group-hover:bg-opacity-75 bg-overlay hidden group-hover:flex items-center justify-center absolute inset-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-8 h-8">
                <path fill="currentColor"
                    d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
            </svg>
        </a>
        <div data-tippy-content-for="<?php the_ID();?>"
            class="relative p-4 max-w-xs w-80 min-w-[17rem] bg-secondary shadow-md rounded-md text-sm">
            <div class="font-medium line-clamp-2 leading-loose mb-3">
                <?php the_title()?> </div>
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-4">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                            class="w-4 h-4 inline-block text-yellow-500">
                            <path fill="currentColor"
                                d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" />
                        </svg>
                        <?php if ($meta['score']) {echo $meta['score'];} else {echo '?';}?>
                    </span>
                    <span class="whitespace-nowrap" v-if="anime.latest && anime.latest.meta">
                        Ep
                        <?php echo $latest && $latest['metadata']['number'] ? $latest['metadata']['number'] : '-'; ?>/<?php echo $meta['episodes'] ? $meta['episodes'] : 12; ?>
                    </span>
                </div>
                <span class="px-2 py-1 text-xs rounded bg-accent-3">
                    <?=!is_wp_error($type) && !empty($type[0]) ? $type[0]->name : '-';?>
                </span>
            </div>
            <span class="w-full block text-sm font-montserrat font-light line-clamp-4 mt-5">
                <?php echo the_content(); ?>
            </span>
            <div class="text-xs space-y-1 mt-5">
                <?php foreach ($meta as $k => $v): if ($v && $k !== 'Featured'): ?>
			                <span class="block"><?=ucfirst(__($k, 'kiranime'))?>:
			                    <?php echo $k === 'Updated' ? date('d F Y, h:i:s A', $v) : $v; ?>
			                </span>
			                <?php endif;endforeach;?>
            </div>
            <div class="mb-2 mt-4 flex items-center gap-6">
                <a href="<?php echo $latest && $latest['url'] ? $latest['url'] : the_permalink(); ?>"
                    class="flex items-center bg-accent-3 text-base font-light px-3 py-2 gap-2 rounded-full w-9/12 shadow drop-shadow justify-center">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" />
                    </svg>
                    <?php _e('Watch Now', 'kiranime');?>
                </a>
                <span data-tippy-sub-trigger="<?php the_ID()?>"
                    class="rounded-full cursor-pointer w-10 h-10 flex items-center justify-center bg-white">
                    <svg class="w-5 h-5 text-overlay" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                    </svg>
                </span>
                <div data-tippy-sub-content-for="<?php the_ID()?>" class="w-max h-auto bg-overlay">
                    <?php $lists = Kiranime_Watchlist::get_types();?>
                    <?php foreach ($lists as $list): ?>
                    <span data-add-to-watch-list data-watch-list-key="<?php echo $list['key'] ?>"
                        data-watch-list-id="<?php the_ID()?>"
                        class="block cursor-pointer text-left px-4 py-2 text-sm font-light hover:font-medium <?php echo $list['key'] == 'remove' ? 'text-color-error-accent-3' : ''; ?>"><?php echo $list['name']; ?></span>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <?php if (isset($meta['rate']) && str_contains($meta['rate'], '18')): ?>
        <span class="bg-orange-600 text-white text-sm font-medium px-2 py-1 rounded-md absolute top-2 left-2">
            18+
        </span>
        <?php endif;?>
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