<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
        <script data-cfasync="false" type="text/javascript" src="//onclickprediction.com/a/display.php?r=6379934"></script>
        <script data-cfasync="false" src="//ashcdn.com/script/ippg.js" data-adel="inpage" zid="6379930" rr="30" mads="2"></script>
</head>

<body <?php body_class('bg-primary text-white antialiased font-montserrat');?>>
    <?php wp_body_open();?>
    <header id="header-data" style="height: 70px;"
        class="bg-opacity-0 bg-primary text-white text-sm fixed inset-0 z-999 leading-5 p-0 text-left transition-all duration-200">
        <?php Kiranime_Utility::template('site')?>
    </header>

    <!-- login modal -->
    <?php if (!is_user_logged_in()) {?>
    <div id="login-form" class="fixed inset-0 hidden items-center justify-center z-50">
        <div data-login-overlay class="bg-black bg-opacity-80 fixed inset-0"></div>
        <div data-login-template>
            <?php Kiranime_Utility::template('over-login');?>
        </div>
        <div data-register-template class="hidden" style="min-width: 400px;">
            <?php Kiranime_Utility::template('over-regis')?>
        </div>
    </div>
    <?php }?>

    <!-- overlay for menu sidebar when active -->
    <div data-sidebar-overlay class="hidden fixed inset-0 bg-primary bg-opacity-50 z-39"></div>

    <!-- Menu sidebar -->
    <div data-sidebar
        class="w-full max-w-xs lg:w-72 fixed inset-0 transform -translate-x-full transition-transform duration-150 ease-in-out h-full bg-primary z-999 overflow-y-auto overflow-x-hidden">
        <div data-sidebar-closer
            class="cursor-pointer px-4 py-2 rounded-full w-max max-w-max flex items-center gap-3 bg-white bg-opacity-20 font-medium text-sm my-5 mx-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4">
                <path fill="currentColor"
                    d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z" />
            </svg>
            <?php _e('Cerrar', 'kiranime')?>
        </div>
        <div class="flex">
            <a href="/advanced-search" class="cursor-pointer px-4 py-2 rounded-md w-max max-w-max flex items-center gap-3 bg-white bg-opacity-20 font-medium text-sm my-5 mx-3 hover:bg-sky-700 ">Archivo</a>
            <a href="/haniyae" class="cursor-pointer px-4 py-2 rounded-md w-max max-w-max flex items-center gap-3 bg-white bg-opacity-20 font-medium text-sm my-5 mx-3 hover:bg-sky-700 ">Haniyae +18</a>
        </div>
        <div class="flex">
            <a href="/horarios" class="cursor-pointer px-4 py-2 rounded-md w-max max-w-max flex items-center gap-3 bg-white bg-opacity-20 font-medium text-sm my-5 mx-3 hover:bg-sky-700 ">Calendary</a>
            <a href="/contact" class="cursor-pointer px-4 py-2 rounded-md w-max max-w-max flex items-center gap-3 bg-white bg-opacity-20 font-medium text-sm my-5 mx-3 hover:bg-sky-700 ">Contacto</a>
        </div>
        <div class="mt-5 min-h-full">
            <?php if (has_nav_menu('header_side')): wp_nav_menu([
                'theme_location' => 'header_side',
                'container_class' => 'w-full',
                'menu_class' => 'flex flex-col text-sm p-0 m-0',
                ]);endif?>
            <div class="mt-5 border-t border-secondary">
                <?php get_template_part('template-parts/component/list', 'genre');?>
            </div>
        </div>
    </div>
    <main class="max-w-screen min-h-screen overflow-visible overflow-x-hidden z-40 mb-10" style="margin-top: 4.25rem;">