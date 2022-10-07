<!-- Start Ads 1 -->
<?php if (get_theme_mod('__ads_after_trending')) {?>
<div class="container flex items-center justify-center max-w-full h-auto my-5">
    <?php echo get_theme_mod('__ads_after_trending') ?>
</div>
<?php }?>
<!-- End Ads -->
<div class="lg:flex justify-between md:px-5 gap-5 sm:px-4">
    <section class="lg:w-9/12 w-full">
        <div class="w-full lg:px-5 py-5 bg-opacity-100 hidden md:flex gap-5 items-end">
        <!-- Spotlight start -->
        <?php Kiranime_Utility::template('spotlight');?>
        <!-- Spotlight End -->
        </div>
    </section>
    <aside class="w-full lg:w-3/12 flex-shrink-0 min-h-300 pr-5">
        <!-- Ultimos caps list -->
        <?php Kiranime_Utility::template('ultimosCaps');?>
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
    <?php
$show_sidebar = get_theme_mod('__show_sidebar', 'show');
?>
    <section class="<?=$show_sidebar === 'show' ? 'lg:w-9/12' : '';?> w-full">
        <!-- Newly Added Anime -->
        <?php Kiranime_Utility::template('newly-added');?>
        <!-- Scheduled Anime -->
        <?php Kiranime_Utility::template('latino');?>
        <!-- Upcomming Anime -->
        <?php Kiranime_Utility::template('upcomming');?>
    </section>
    <aside class="w-full <?=$show_sidebar === 'show' ? 'lg:w-3/12' : 'hidden';?> flex-shrink-0 min-h-300 pr-5">
        <?php if (is_active_sidebar('homepage-sidebar')): dynamic_sidebar('homepage-sidebar');endif;?>
    </aside>
</div>