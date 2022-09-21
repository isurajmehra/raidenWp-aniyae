<?php
$query = new Kiranime_Query();
$query = $query->spotlight();
if ($query->have_posts()): while ($query->have_posts()): $query->the_post();
        $anime = new Kiranime_Anime(get_the_ID());
        $meta = $anime->meta();
        $type = Kiranime_Utility::get_taxonomy(get_the_ID(), 'type');
        $latest = $anime->latest_episode();
        $index = $query->current_post;
        ?>
		<div class="swiper-slide">
		    <div style="background: url('<?php echo !empty($meta['background']) ? $meta['background'] : $meta['featured']; ?>');background-size: cover;background-position-x: 50%;background-position-y: 100%;"
		        class="w-full py-10 sm:pb-5 sm:pt-0 md:py-17 sm:mt-0 lg:h-500 xl:min-h-[80vmin] text-5xl flex bg-no-repeat bg-right sm:bg-auto md:bg-cover relative items-center sm:items-end lg:items-center before:absolute before:-inset-1 after:absolute after:-inset-1 gradient-after gradient-before">
		        <div class="text-sm z-20 max-w-3xl px-2 sm:pr-0 sm:pl-10 w-full max-h-96 mt-10">
		            <div class="text-xs sm:text-lg mb-3 sm:mb-5 text-left text-sky-500">
		                #<?php echo $index + 1 ?> <?php _e('Spotlight', 'kiranime');?>
		            </div>

		            <div
		                class="text-white sm:text-4xl text-base sm:mb-5 text-left font-semibold line-clamp-2 leading-tight max-h-32">
		                <?php the_title()?>
		            </div>
		            <div class="gap-2 items-center mb-3 hidden sm:flex">
		                <div class="flex items-center gap-1">
		                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
		                        <path fill="currentColor"
		                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z" />
		                    </svg>
		                    <?php echo !is_wp_error($type) && count($type) != 0 ? $type[0]->name : 'TV'; ?>
		                </div>
		                <div class="flex items-center gap-1">
		                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
		                        <path fill="currentColor"
		                            d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm92.49,313h0l-20,25a16,16,0,0,1-22.49,2.5h0l-67-49.72a40,40,0,0,1-15-31.23V112a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16V256l58,42.5A16,16,0,0,1,348.49,321Z" />
		                    </svg>
		                    <?php echo $meta && $meta['duration'] ? $meta['duration'] : '24m' ?>
		                </div>
		                <div class="flex items-center gap-1 m-hide">
		                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-3 h-3">
		                        <path fill="currentColor"
		                            d="M12 192h424c6.6 0 12 5.4 12 12v260c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V204c0-6.6 5.4-12 12-12zm436-44v-36c0-26.5-21.5-48-48-48h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v36c0 6.6 5.4 12 12 12h424c6.6 0 12-5.4 12-12z" />
		                    </svg>
		                    <?php echo !empty($meta['premiered']) && $meta['premiered'] !== 'null null' ? trim($meta['premiered']) : $meta['aired'] ?>
		                </div>
		                <?php $attributes = Kiranime_Utility::get_taxonomy(get_the_ID(), 'anime_attribute');
        if (!is_wp_error($attributes)):
            foreach ($attributes as $key => $attr):
            ?>
			                <div class="flex items-center gap-1 mr-1">
			                    <?php if ($key == 0): ?>
			                    <span class="text-xs p-1 leading-none bg-sky-500 rounded"><?php echo $attr->name ?></span>
			                    <?php else: ?>
		                    <span
		                        class="text-xs p-1 leading-none text-gray-900 rounded bg-white"><?php echo $attr->name ?></span>
		                    <?php endif;?>
	                </div>
	                <?php endforeach;endif;?>
            </div>

            <div class="line-clamp-3 sm:line-clamp-4 text-xs font-light leading-6 mb-8 text-left">
                <?php the_content()?>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo isset($latest) ? $latest['url'] : the_permalink(); ?>"
                    class="flex items-center gap-2 px-3 py-2 bg-accent-3 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
                        <path fill="currentColor"
                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z" />
                    </svg>
                    <?php _e('Watch Now', 'kiranime');?>
                </a>
                <a href="<?php the_permalink()?>"
                    class="flex items-center gap-2 px-3 py-2 bg-primary rounded-md hover:bg-gray-700">
                    <?php _e('Details', 'kiranime');?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="w-3 h-3">
                        <path fill="currentColor"
                            d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endwhile;endif;?>