<?php
$query = new Kiranime_Query();
$query = $query->trending();
?>

<?php if ($query->have_posts()): while ($query->have_posts()): $query->the_post();
        $anime = new Kiranime_Anime(get_the_ID());
        $image = $anime->get_image('featured');
        ?>
<div class="swiper-slide" style="<?=$query->post_count > 5 ? '' : 'min-width: 224px;'?>">
    <a href="<?php echo the_permalink() ?>"
        class="sm:flex hidden relative sm:pb-64 md:pb-56 overflow-hidden lg:max-h-56 xl:max-h-[19rem] xl:pb-[19rem]  shadow-sm min-w-full w-56">
        <div
            class="sm:w-1/5 lg:w-10 h-full flex flex-col items-center gap-2 absolute left-0 bottom-0 font-semibold font-montserrat bg-gradient-to-t from-primary to-gray-700">
            <span
                class="w-36 h-5 line-clamp-1 -rotate-90 transform overflow-hidden overflow-ellipsis text-sm absolute bottom-24 flex items-center"
                style="left: -3.25rem">
                <?php echo the_title() ?>
            </span>
            <span
                class="flex items-center justify-center absolute bottom-0 text-2xl text-sky-400"><?php echo $query->current_post < 9 ? '0' . ($query->current_post + 1) : ($query->current_post + 1) ?></span>
        </div>
        <?php if ($image): ?>
        <img src="<?php echo $image; ?>" alt="<?php the_title();?>"
            class="w-full h-full sm:w-3/4 lg:w-40 lg:h-56 xl:w-52 xl:h-[19rem] absolute sm:left-1/5 lg:left-10 object-cover" />
        <?php else: ?>
        <?php echo $query->current_post; ?>
        <?php endif;?>
    </a>
    <a href="<?php the_permalink();?>" class="relative w-full sm:hidden">
        <div class="relative pb-52 overflow-hidden">
            <img src="<?php echo $image; ?>" alt="<?php the_title();?>"
                class="absolute inset-0 object-cover w-full h-full z-0">
            <div class="absolute left-0 top-0 p-1 z-10 bg-white text-primary py-2 px-4">
                <span
                    class="line-clamp-2 w-full text-center font-semibold text-sm"><?php echo $query->current_post + 1; ?></span>
            </div>
        </div>
    </a>
</div>
<?php endwhile;endif;?>