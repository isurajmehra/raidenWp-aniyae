<?php get_header()?>
<div class="md:flex min-h-screen my-17">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <div class="max-w-sm m-8">
            <div class="text-5xl md:text-15xl text-white border-secondary border-b">No encontrado : 404</div>
            <div class="w-16 h-1 bg-accent-3 my-3 md:my-6"></div>
            <p class="text-white text-2xl md:text-3xl font-light mb-8">
                <?php _e('Tenemos un monton de anime, pero lo que buscas no esta disponible', 'kiranime');?></p>
            <a href="<?php echo get_bloginfo('url'); ?>" class="bg-primary px-4 py-2 rounded text-white">
                <?php _e('Vuelve al Inicio', 'kiranime');?>
            </a>
        </div>
    </div>
</div>
<?php get_footer()?>