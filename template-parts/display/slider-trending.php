<div
    class="p-4 <?php if (get_theme_mod('__show_spotlight') === 'hide'): echo 'lg:mt-17';else:echo 'lg:mt-5';endif;?> text-xl lg:text-xl leading-4 lg:leading-10 lg:mt-5 font-semibold text-sky-500">
    <?php _e('Trending', 'kiranime');?>
</div>
<div class="sm:px-4 px-0 mt-2 md:flex justify-between w-full pb-10"
    style="background: linear-gradient(0deg,#121315 0,rgba(18,19,21,0) 99%);">
    <div class="swiper swiper-trending">
        <div class="swiper-wrapper" style="min-width: 100vw;">
            <!-- Slides -->
            <?php get_template_part('template-parts/view/view', 'trending')?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="swiper-navigation ml-5 md:grid hidden">
        <div class="mb-2 bg-gray-700 rounded-sm shadow-sm p-2 trending-nav-next hover:bg-accent-3 flex items-center justify-center"
            tabindex="0" role="button" aria-label="Next slide">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-6 h-6">
                <path fill="currentColor"
                    d="M187.8 264.5L41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z" />
            </svg>
        </div>
        <div class="bg-gray-700 rounded-sm shadow-sm p-2 trending-nav-prev hover:bg-accent-3 flex items-center justify-center"
            tabindex="0" role="button" aria-label="Previous slide">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-6 h-6">
                <path fill="currentColor"
                    d="M4.2 247.5L151 99.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17L69.3 256l118.5 119.7c4.7 4.7 4.7 12.3 0 17L168 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 264.5c-4.7-4.7-4.7-12.3 0-17z" />
            </svg>
        </div>
    </div>
</div>