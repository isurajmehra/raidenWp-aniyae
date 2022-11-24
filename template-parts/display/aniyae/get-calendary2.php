<div class="container">
  <div class="row">
    <div class="col">
<section style="padding-top: 10vh;">
<h3 class="mb-4 text-2xl font-semibold leading-10 text-sky-400">calendary - Emision en latino</h3>
<div class="heroarea">
    <div class="heromain">

    <?php $page1 = (get_query_var('paged')) ? get_query_var('paged') : 1; $query1 = new Kiranime_Query(['page' => $page1, 'archive' => true]); $posts1 = $query1->latino_lunes();?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Lunes <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="lunes" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts1->have_posts()): while ($posts1->have_posts()): $posts1->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts1->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page2 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query2 = new Kiranime_Query(['page' => $page2, 'archive' => true]);
          $posts2 = $query2->latino_martes(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Martes <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="martes" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts2->have_posts()): while ($posts2->have_posts()): $posts2->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts2->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page3 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query3 = new Kiranime_Query(['page' => $page3, 'archive' => true]);
          $posts3 = $query3->latino_miercoles(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Miercoles <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="miercoles" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts3->have_posts()): while ($posts3->have_posts()): $posts3->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts3->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page4 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query4 = new Kiranime_Query(['page' => $page4, 'archive' => true]);
          $posts4 = $query4->latino_jueves(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Jueves <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="jueves" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts4->have_posts()): while ($posts4->have_posts()): $posts4->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts4->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page5 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query5 = new Kiranime_Query(['page' => $page5, 'archive' => true]);
          $posts5 = $query5->latino_viernes(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Viernes <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="viernes" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts5->have_posts()): while ($posts5->have_posts()): $posts5->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts5->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page6 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query6 = new Kiranime_Query(['page' => $page6, 'archive' => true]);
          $posts6 = $query6->latino_sabado(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Sábado <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="sabado" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts6->have_posts()): while ($posts6->have_posts()): $posts6->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts6->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php $page7 = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $query7 = new Kiranime_Query(['page' => $page7, 'archive' => true]);
          $posts7 = $query7->latino_domingo(); ?>
        <div class="accordionItem close">
            <h1 class="accordionItemHeading">Domingo <div id="chevron-arrow"></div></h1>
            <div class="accordionItemContent">
                <div data-dia="domingo" class="row">
                    <div class="mb-17 grid grid-cols-12 px-5 mx-auto w-full gap-5">
                        <section class="col-span-full lg:col-span-9">
                            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-5">
                                <?php if ($posts7->have_posts()): while ($posts7->have_posts()): $posts7->the_post();
                            ?>
                                    <div class="col-span-1">
                                        <?php Kiranime_Utility::template('view-calendary');?>
                                    </div>
                                <?php endwhile;endif;?>
                            </div>
                            <?php echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total' => $posts7->max_num_pages,
                                'current' => max(1, get_query_var('paged')),
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_next' => false,
                                'add_args' => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script async src="https://aria.js.cdn.aniyae.net/js/Yenwent.js"></script>
</section>
    </div>
  </div>
</div>