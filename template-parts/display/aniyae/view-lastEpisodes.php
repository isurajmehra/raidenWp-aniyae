    <section class="flex flex-col space-y-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-2 sm:gap-4 lg:gap-5 justify-evenly w-full eplist-container overflow-y-scroll custom-scrollbar">
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
    <a href="<?=Kiranime_Utility::page_url('pages/latest-update.php');?>" class="px-4 py-2 rounded-full w-max max-w-max items-center flex  bg-accent-3 font-medium text-sm my-5 mx-3" style="position: relative; left: 37vh;">
        Ver mas
        <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </a>