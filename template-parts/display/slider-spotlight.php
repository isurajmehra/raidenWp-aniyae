<div class="w-full sm:mt-17 lg:mt-9 sm:mb-5  bg-sky-500 bg-opacity-0 flex items-center relative justify-center">
    <div class="swiper swiper-spotlight">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php get_template_part('template-parts/view/view', 'spotlight')?>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <div class="swiper-navigation absolute bottom-5 right-5 z-10 hidden sm:block">
        <div class="mb-2 bg-primary rounded-sm shadow-sm p-2 nav-next hover:bg-accent-3" tabindex="0" role="button"
            aria-label="Next slide">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-6 h-6">
                <path fill="currentColor"
                    d="M187.8 264.5L41 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 392.7c-4.7-4.7-4.7-12.3 0-17L122.7 256 4.2 136.3c-4.7-4.7-4.7-12.3 0-17L24 99.5c4.7-4.7 12.3-4.7 17 0l146.8 148c4.7 4.7 4.7 12.3 0 17z" />
            </svg>
        </div>
        <div class="bg-primary rounded-sm shadow-sm p-2 nav-prev hover:bg-accent-3" tabindex="0" role="button"
            aria-label="Previous slide">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" class="w-6 h-6">
                <path fill="currentColor"
                    d="M4.2 247.5L151 99.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17L69.3 256l118.5 119.7c4.7 4.7 4.7 12.3 0 17L168 412.5c-4.7 4.7-12.3 4.7-17 0L4.2 264.5c-4.7-4.7-4.7-12.3 0-17z" />
            </svg>
        </div>
    </div>
</div>