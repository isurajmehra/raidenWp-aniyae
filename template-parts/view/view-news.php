<div class="w-full lg:flex gap-10 py-5 border-b border-gray-400 border-opacity-75">
    <a href="<?php the_permalink()?>" class="w-full lg:w-1/4 lg:min-w-25 h-auto max-h-60 lg:max-h-full ">
        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title();?>"
            class=" object-cover w-full h-full">
    </a>
    <div class="w-full lg:w-3/4 space-y-5 lg:space-y-2 mt-5 lg:mt-0">
        <a href="<?php the_permalink()?>">
            <h3 class="text-2xl font-semibold"><?php the_title()?></h3>
        </a>
        <div class="text-sm font-normal">
            <?php echo wp_trim_excerpt('', get_the_ID()) ?>
        </div>
        <span class="inline-block text-sm text-gray-400"><?php echo human_time_diff(get_the_time('U')) ?> Ago.</span>
    </div>
</div>