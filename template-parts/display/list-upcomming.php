<div class="w-full mb-4 flex items-center justify-between mt-10 px-4 sm:px-0">
    <div class="mr-4">
        <h2 class="text-2xl leading-10 font-semibold p-0 m-0 text-sky-400">
            <?php $title = get_theme_mod('__show_upcomming_label');if ($title) {echo $title;} else {_e('Lo que se viene!', 'kiranime');}?>
        </h2>
    </div>
    <div class="text-sm font-normal text-opacity-75">
        <a class="px-4 py-2 rounded-full w-max max-w-max items-center flex bg-yae-1 dark:bg-gray-800 dark:border-gray-700 hover:bg-sky-700 font-medium text-sm my-5 mx-3" href="<?=Kiranime_Utility::page_url('pages/anime-upcomming.php');?>">
            <?php _e('Ver otros', 'kiranime');?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="w-5 h-5 inline-block">
                <path fill="currentColor"
                    d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
            </svg>
        </a>
    </div>
</div>
<section
    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-2 sm:gap-4 lg:gap-5 justify-evenly w-full flex-auto">
    <?php
$upcomming = new Kiranime_Query();
$upcomming = $upcomming->upcomming();
if ($upcomming->have_posts()):
    while ($upcomming->have_posts()):
        $upcomming->the_post();
        get_template_part('template-parts/view/view', 'grid');
    endwhile;
endif;?>
</section>