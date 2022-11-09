<!-- Start Ads 1 -->
<div class="container flex items-center justify-center max-w-full h-auto my-5">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9500151085329576"  crossorigin="anonymous"></script> <!-- Unidad de prueba --> <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9500151085329576" data-ad-slot="3209437212" data-ad-format="auto" data-full-width-responsive="true"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>
</div>
<!-- End Ads -->
<div class="lg:flex justify-between md:px-5 gap-5 sm:px-4">
    <section class="lg:w-9/12 ml-2 mr-2 mb-8">
        <!-- Spotlight start -->
        <?php Kiranime_Utility::template('newly-added');?>
        <!-- Spotlight End -->
    </section>
    <aside class="w-full ml-2 max-w-sm rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700" style="background-color: rgb(255 255 255 / 16%); padding-inline: 1vh; padding-bottom: 1vh; margin-bottom: 9vh;">
            <h2 class="inline-block p-4 leading-10 text-white font-semibold">
                <?php _e('Ultimos Episodios!', 'kiranime');?>
            </h2>
            <!-- Ultimos caps list -->
            <?php Kiranime_Utility::template('lastEpisodes');?>
            <!-- End Ultimos caps list -->
    </aside>
</div>
<!-- Ads 2 -->
<div class="container flex items-center justify-center max-w-full h-auto my-5">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9500151085329576"  crossorigin="anonymous"></script> <!-- Unidad de prueba --> <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9500151085329576" data-ad-slot="3209437212" data-ad-format="auto" data-full-width-responsive="true"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>
</div>
<!-- End Ads 2 -->

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
        <!-- Newly Added Anime -->
        <?php Kiranime_Utility::template('lastMovies');?>
        <!-- End Newly Added Anime -->
        <!-- Haniyae -->
        <?php Kiranime_Utility::template('haniyae');?>
        <!-- End Haniyae -->
        <!-- Upcomming Anime -->
        <?php Kiranime_Utility::template('upcomming');?>
        <!-- End Upcomming Anime -->
    </section>
    <aside class="w-full <?=$show_sidebar === 'show' ? 'lg:w-3/12' : 'hidden';?> flex-shrink-0 min-h-300 pr-5 mt-10">
                <!-- Sidebar -->
                <?php if (is_active_sidebar('homepage-sidebar')): dynamic_sidebar('homepage-sidebar');endif;?>
            <!-- End Sidebar -->
    </aside>
</div>