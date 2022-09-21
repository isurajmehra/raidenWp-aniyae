<div class="min-h-300 w-full bg-secondary rounded-sm shadow drop-shadow">
    <div class="p-4 text-base leading-4 font-medium text-sky-500"><?php _e('News', 'kiranime');?></div>
    <div>
        <ul class="m-0 p-0">
            <?php $query = new Kiranime_Query();
$query = $query->news();
if ($query->have_posts()): while ($query->have_posts()): $query->the_post();?>
            <li class="odd:bg-tertiary flex gap-4 px-4 py-2">
                <div class=" w-14 h-16 pb-16 rounded shadow flex-shrink-0 relative overflow-hidden bg-primary">
                    <a href="<?php the_permalink()?>">
                        <img class="absolute inset-0 w-full h-full object-cover"
                            src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="<?php the_title()?>"
                            loading="lazy" />
                    </a>
                </div>
                <div class="w-full flex-auto">
                    <h3 class="text-sm line-clamp-2 font-medium leading-6 mb-1">
                        <a href="<?php the_permalink();?>" title="<?php the_title()?>" class="dynamic-name">
                            <?php the_title()?>
                        </a>
                    </h3>
                    <div class="flex items-center text-xs gap-2">
                        <span class="whitespace-nowrap fdi-duration"><?php the_time('F j, Y')?></span>
                    </div>
                </div>
            </li>
            <?php endwhile;endif;?>
        </ul>
    </div>
    <div class="w-full absolute bottom-0">
        <a class=" p-4 text-white text-opacity-90 bg-opacity-10 bg-white hover:bg-opacity-30 font-light flex items-center justify-center gap-2 "
            href="<?=Kiranime_Utility::page_url('pages/news.php')?>">
            <?php _e('View More', 'kiranime');?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="w-5 h-5">
                <path fill="currentColor"
                    d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
            </svg>
        </a>
    </div>
</div>