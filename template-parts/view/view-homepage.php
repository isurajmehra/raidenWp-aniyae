<!-- Start Ads 1 -->
<?php if (get_theme_mod('__ads_after_trending')) {?>
<div class="container flex items-center justify-center max-w-full h-auto my-5">
    <?php echo get_theme_mod('__ads_after_trending') ?>
</div>
<?php }?>
<!-- End Ads -->
<div class="lg:flex justify-between md:px-5 gap-5 sm:px-4">
    <section class="lg:w-9/12 ml-2 mr-2 mb-8">
        <!-- Spotlight start -->
        <?php Kiranime_Utility::template('spotlight');?>
        <!-- Spotlight End -->
    </section>
    <aside class="w-full ml-2 max-w-sm rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700" style="background-color: rgb(255 255 255 / 16%); padding-inline: 1vh; padding-bottom: 1vh;">
            <h2 class="inline-block p-4 leading-10 text-white font-semibold">
                <?php _e('Ultimos Episodios!', 'kiranime');?>
            </h2>
            <!-- Ultimos caps list -->
            <?php Kiranime_Utility::template('lastEpisodes');?>
            <!-- End Ultimos caps list -->
    </aside>
</div>
<?php $afe = get_theme_mod('__ads_after_featured');if ($afe): ?>
<div class="container flex items-center justify-center max-w-full h-auto my-5">
    <?php echo $afe ?>
</div>
<?php endif;?>
<!-- End Featured -->

<div class="lg:flex justify-between md:px-5 gap-5 sm:px-4">
    <section class="lg:w-9/12 ml-2 mr-2 mb-8">
        <!-- Spotlight start -->
        <?php Kiranime_Utility::template('latino');?>
        <!-- Spotlight End -->
    </section>
    <aside class="w-full lg:w-3/12 flex-shrink-0 min-h-300 pr-5 mt-10">
            <div class="rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mt-2" style="background-color: rgb(255 255 255 / 16%); padding-inline: 1vh; padding-bottom: 1vh;">
                <h2 class="inline-block p-4 leading-10 text-white font-semibold">
                    <?php _e('Mas de Aniyae', 'kiranime');?>
                </h2>
                <!-- Mas de Aniyae -->
                <?php Kiranime_Utility::template('aniyae');?>
                <!-- End Mas de Aniyae -->
            </div>
    </aside>
</div>

<div class="lg:flex justify-between md:px-5 gap-5 sm:px-4">
    <?php
$show_sidebar = get_theme_mod('__show_sidebar', 'show');
?>
    <section class="<?=$show_sidebar === 'show' ? 'lg:w-9/12' : '';?> w-full">
        <!-- Scheduled Anime -->
        <?php Kiranime_Utility::template('newly-added');?>
        <!-- End Scheduled Anime -->
        <!-- Haniyae -->
        <?php Kiranime_Utility::template('lastMovies');?>
        <!-- End Haniyae -->
        <!-- Upcomming Anime -->
        <?php Kiranime_Utility::template('haniyae');?>
        <!-- End Upcomming Anime -->
    </section>
    <aside class="w-full <?=$show_sidebar === 'show' ? 'lg:w-3/12' : 'hidden';?> flex-shrink-0 min-h-300 pr-5 mt-10">
                <!-- Sidebar -->
                <?php if (is_active_sidebar('homepage-sidebar')): dynamic_sidebar('homepage-sidebar');endif;?>
            <!-- End Sidebar -->
    </aside>
</div>