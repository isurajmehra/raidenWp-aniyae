<section class="overflow-y-scroll" style="height: 27rem;" >
        <?php
            $latino_animes = new Kiranime_Query();
            $latino_animes = $latino_animes->getUltimos();
        if ($latino_animes->have_posts()):
            while ($latino_animes->have_posts()):
                    $latino_animes->the_post();
                    get_template_part('template-parts/display/aniyae/list', 'ultimosCaps');
                endwhile;
        endif;?>
    </section>
    <div class="flex justify-center">
        <a href="<?=Kiranime_Utility::page_url('pages/latest-update.php');?>" class="px-4 py-2 rounded-full w-max max-w-max items-center flex bg-yae-1 dark:bg-gray-800 dark:border-gray-700 hover:bg-sky-700 font-medium text-sm my-5 mx-3">
            Ver mas
            <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </a>
    </div>