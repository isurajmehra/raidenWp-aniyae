<div class="lg:px-10 md:px-5 py-10 w-full lg:flex gap-5">
    <main class="w-full lg:w-3/4 container">
        <section class="lg:mt-17 mt-10">
            <!-- breadcrumb -->
            <nav aria-label="Breadcrumb" class="text-sm font-medium mb-5">
                <ol class="flex gap-2 items-center flex-wrap">
                    <li>
                        <a href="/">
                            <?php _e('Home', 'kiranime');?>
                        </a>
                    </li>
                    <li>
                        <div class="w-1 h-1 bg-gray-500 rounded-full"></div>
                    </li>
                    <li>
                        <a href="<?=Kiranime_Utility::page_url('pages/news.php');?>">
                            <?php _e('News', 'kiranime');?>
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
            <?php
// If comments are open or we have at least one comment, load up the comment template.
if (comments_open() || get_comments_number()):
    comments_template();
endif;
?>
        </div>
    </main>
    <aside class="w-full lg:w-1/4 mt-10 lg:mt-0 px-2 lg:px-0">
        <?php if (is_active_sidebar('article-sidebar')): dynamic_sidebar('article-sidebar');endif;?>
    </aside>
</div>