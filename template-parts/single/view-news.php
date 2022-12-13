<div class="lg:px-10 md:px-5 py-10 w-full lg:flex gap-5">
    <main class="w-full lg:w-3/4 container">
        <section class="lg:mt-17 mt-10">
            <!-- breadcrumb -->
            <nav aria-label="Breadcrumb" class="text-sm font-medium mb-5">
                <ol class="flex gap-2 items-center flex-wrap">
                    <li>
                        <a href="/">
                            <?php _e('Inicio', 'kiranime');?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <li>
                        <a href="<?=Kiranime_Utility::page_url('pages/news.php');?>">
                            <?php _e('Noticias', 'kiranime');?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <li>
                        <a href="<?php the_permalink()?>" class="text-gray-500">
                            <?php the_title()?>
                        </a>
                    </li>
                </ol>
            </nav>
        </section>
        <!-- Ads Native 1 -->
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9500151085329576" crossorigin="anonymous"></script> <!-- Unidad de prueba --> <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9500151085329576" data-ad-slot="3209437212" data-ad-format="auto" data-full-width-responsive="true"></ins> <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>
        <!-- Ads end Native 1 -->
        <article class="w-full">
            <h2 class="text-4xl font-semibold"><?php the_title()?></h2>
            <span class="inline-block mb-5 font-medium text-sm">
                <?php printf(esc_html__('Published %1$s ago.', 'kiranime'), human_time_diff(get_the_time('U')));?>
            </span>
            <main class="text-sm">
                <?php the_content();?>
            </main>
        </article>
        <div class="my-10">
            <?php Kiranime_Utility::template('comentarios');?>
        </div>
    </main>
    <aside class="w-full lg:w-1/4 mt-10 lg:mt-0 px-2 lg:px-0">
        <?php if (is_active_sidebar('article-sidebar')): dynamic_sidebar('article-sidebar');endif;?>
    </aside>
</div>