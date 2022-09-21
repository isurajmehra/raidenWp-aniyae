<?php
$uid = get_current_user_id();
$uif = get_userdata($uid);?>
<div class="pl-4 sm:px-5 md:px-4 relative w-full flex items-center justify-between h-full">
    <div class="relative w-full flex items-center h-full">
        <div data-sidebar-trigger class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6">
                <path fill="currentColor"
                    d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" />
            </svg>
        </div>
        <a href="/" id="logo" class="md:ml-16 ml-8 mr-8 block">
            <?php if (get_theme_mod('custom_logo')) {
    ?>
            <img style="width: 150px;" src="<?php $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    echo $image['0']?>" alt="<?php echo get_bloginfo('name') ?>">
            <?php } else {
    echo get_bloginfo('name');
}?>
        </a>
        <div id="search" class="hidden lg:block">
            <div class="search-content relative">
                <?php
$advanced_search_url = Kiranime_Utility::page_slug('pages/advanced-search.php');
?>
                <form action="/<?=$advanced_search_url?>" method="GET" autocomplete="off" class="relative">
                    <a href="/<?=$advanced_search_url?>"
                        class="absolute top-2 right-2 text-xs bg-primary bg-opacity-80 px-2 py-1 rounded-sm">Filtro</a>

                    <input type="text" data-search-ajax-input
                        class="bg-white rounded-none shadow-sm text-gray-800 font-normal h-10 leading-normal m-0 overflow-visible py-2 pr-20 pl-4 transition-all duration-150 ease-in-out focus:shadow w-full focus:outline-none"
                        name="s_keyword" placeholder="<?php _e('Search anime...', 'kiranime');?>">
                    <button type="submit" class="absolute top-2 right-14 px-2 py-1 w-max text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                        </svg>
                    </button>
                </form>
                <div class="bg-tertiary shadow-lg absolute top-10 inset-x-0 z-10 list-none hidden"
                    data-search-ajax-result>
                    <div class="loading-relative" id="search-loading" style="display: none;">
                        <div class="loading">
                            <div class="span1"></div>
                            <div class="span2"></div>
                            <div class="span3"></div>
                        </div>
                    </div>
                    <div data-search-result-area class="max-h-96 overflow-y-scroll overflow-x-hidden">

                    </div>
                    <a data-search-view-all href="/<?=$advanced_search_url?>"
                        class="flex items-center justify-center w-full p-4 bg-accent-3 text-base">
                        <?php _e('View all results', 'kiranime');?> <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 256 512" class="w-4 h-4 ml-2 inline-block">
                            <path fill="currentColor"
                                d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
                        </svg></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="ml-8 hidden lg:flex items-center gap-2">
            <?php if (get_theme_mod('__show_social_link', 'show') === 'show'):
    $socials = Kiranime_Utility::social();
    foreach ($socials as $key => $val): if ($val['link']): ?>
						            <div>
						                <a href="<?php echo $val['link'] ?>" class="w-10 h-10 flex items-center justify-center rounded-sm"
						                    target="_blank" style="background: <?=$val['color'];?>;">
						                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="<?=$val['vbox']?>">
						                        <path fill="currentColor" d="<?=$val['icon']?>" />
						                    </svg>
						                </a>
						            </div>
						            <?php endif;endforeach;endif;?>
        </div>
    </div>
    <?php if (!is_user_logged_in()) {?>
    <span data-login-toggle
        class="block justify-self-end absolute right-4 md:mr-4 top-1/2 transform -translate-y-1/2 rounded-sm bg-accent-3 md:px-5 md:py-3 px-3 py-2 cursor-pointer"><?php _e('Login', 'kiranime');?></span>
    <?php } else {
    ?>
    <div class="w-40 flex items-center justify-end lg:justify-start gap-5">
        <div class="relative w-max">
            <div data-dropdown-notification-trigger
                class="w-10 h-10 relative leading-10 cursor-pointer rounded-full bg-opacity-0 lg:bg-opacity-10 bg-white flex items-center justify-center">
                <div data-notification-number
                    class="hidden rounded-full absolute -top-1 -right-1 bg-error-1 items-center justify-center overflow-hidden w-5 h-5 text-xs font-medium px-1">
                    0
                </div>
                <svg class="w-7 h-7 sm: lg:w-4 lg:h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor"
                        d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z" />
                </svg>
            </div>
            <div data-dropdown-notification-content="0"
                class="w-72 h-auto transform transition-all duration-200 absolute top-full left-auto right-0 bg-overlay rounded shadow-lg -translate-y-full opacity-0 pointer-events-none"
                aria-labelledby="noti-list">
                <input type="hidden" name="notif-ids" value="">
                <div data-set-all-notification-read class="block w-full mb-2 bg-black bg-opacity-20">
                    <a class="flex items-center gap-2 justify-center w-full bg px-4 py-2  hover:text-sky-400 cursor-pointer"
                        data-position="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
                            <path fill="currentColor"
                                d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" />
                        </svg> <?php _e('Mark all as read', 'kiranime');?></a>
                </div>
                <div data-notification-content-area class="max-h-52 overflow-y-auto overflow-x-hidden"></div>
                <a class="block rounded-b-md shadow-md bg-secondary w-full px-4 py-2 text-sm"
                    href="<?php echo Kiranime_Utility::page_url('pages/notification.php') ?>">
                    <div class="text-center  hover:text-sky-300"><?php _e('View all', 'kiranime');?></div>
                </a>

            </div>
        </div>
        <div style="background-image: url('<?=Kiranime_User::get_avatar(get_current_user_id())?>');"
            class="w-10 h-10 bg-cover bg-center bg-no-repeat rounded-full relative cursor-pointer">
            <div class="absolute inset-0 opacity-0" data-user-menu-dropdown>

            </div>

            <div data-user-menu-content data-user-menu-state="0"
                class="w-80 h-auto overflow-x-hidden transform transition-all duration-150 absolute top-full left-auto right-0 bg-secondary rounded-xl shadow-lg -translate-y-full opacity-0 pointer-events-none"
                style="transform: translate3d(-10px, 10px, 0px);">
                <div class="py-3 px-4">
                    <div class="w-full">
                        <div class="w-full text-sm font-semibold text-sky-400 leading-9">
                            <strong data-current-username><?php if ($uif) {echo $uif->display_name;}?></strong>
                        </div>
                        <div class="w-full text-xs font-light text-gray-200"><?php if ($uif) {echo $uif->user_email;}?>
                        </div>
                    </div>
                </div>
                <div class="mt-1 mx-3 space-y-1">
                    <?php
$profile = Kiranime_Utility::page_url('pages/profile.php');
    $conwatch = Kiranime_Utility::page_url('pages/continue-watching.php');
    $watchlist = Kiranime_Utility::page_url('pages/watchlist.php');
    // $notification = Kiranime_Utility::page_url('pages/notification.php');
    // $mal_import = Kiranime_Utility::page_url('pages/mal-import.php');
    // $setting = Kiranime_Utility::page_url('pages/setting.php');
    ?>
                    <a class="px-4 py-3 flex items-center hover:text-sky-400 gap-2 font-medium text-xs bg-overlay bg-opacity-20 rounded-xl"
                        href="<?=$profile?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                        </svg>
                        <?php _e('Profile', 'kiranime');?></a>
                    <a class="px-4 py-3 flex items-center hover:text-sky-400 gap-2 font-medium text-xs bg-overlay bg-opacity-20 rounded-xl"
                        href="<?=$conwatch?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M504 255.531c.253 136.64-111.18 248.372-247.82 248.468-59.015.042-113.223-20.53-155.822-54.911-11.077-8.94-11.905-25.541-1.839-35.607l11.267-11.267c8.609-8.609 22.353-9.551 31.891-1.984C173.062 425.135 212.781 440 256 440c101.705 0 184-82.311 184-184 0-101.705-82.311-184-184-184-48.814 0-93.149 18.969-126.068 49.932l50.754 50.754c10.08 10.08 2.941 27.314-11.313 27.314H24c-8.837 0-16-7.163-16-16V38.627c0-14.254 17.234-21.393 27.314-11.314l49.372 49.372C129.209 34.136 189.552 8 256 8c136.81 0 247.747 110.78 248 247.531zm-180.912 78.784l9.823-12.63c8.138-10.463 6.253-25.542-4.21-33.679L288 256.349V152c0-13.255-10.745-24-24-24h-16c-13.255 0-24 10.745-24 24v135.651l65.409 50.874c10.463 8.137 25.541 6.253 33.679-4.21z" />
                        </svg>
                        <?php _e('Continue Watching', 'kiranime');?></a>
                    <a class="px-4 py-3 flex items-center hover:text-sky-400 gap-2 font-medium text-xs bg-overlay bg-opacity-20 rounded-xl"
                        href="<?=$watchlist?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z" />
                        </svg>
                        <?php _e('Watch List', 'kiranime');?></a>
                    <a class="px-4 py-3 flex items-center hover:text-sky-400 gap-2 font-medium text-xs bg-overlay bg-opacity-20 rounded-xl"
                        href="<?=$notification?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z" />
                        </svg>
                        <?php _e('Notification', 'kiranime');?></a>
                    <a class="px-4 py-3 flex items-center hover:text-sky-400 gap-2 font-medium text-xs bg-overlay bg-opacity-20 rounded-xl"
                        href="<?=$mal_import?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                            <path fill="currentColor"
                                d="M16 288c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h112v-64zm489-183L407.1 7c-4.5-4.5-10.6-7-17-7H384v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H152c-13.3 0-24 10.7-24 24v264h128v-65.2c0-14.3 17.3-21.4 27.4-11.3L379 308c6.6 6.7 6.6 17.4 0 24l-95.7 96.4c-10.1 10.1-27.4 3-27.4-11.3V352H128v136c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H376c-13.2 0-24-10.8-24-24z" />
                        </svg>
                        <?php _e('MAL Import', 'kiranime');?></a>
                </div>
                <a data-logout-trigger
                    class="p-5 hover:text-sky-400 flex w-full items-center justify-end gap-2 font-medium text-xs rounded-md"
                    href="#"><?php _e('Logout', 'kiranime');?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4">
                        <path fill="currentColor"
                            d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <?php }?>
    <button data-mobile-search-trigger
        class="absolute block pr-5 lg:hidden top-1/2 transform -translate-y-1/2 <?php if (is_user_logged_in()) {echo 'right-32';} else {echo 'right-20';}?> px-2 py-1 w-max ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5">
            <path fill="currentColor"
                d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
        </svg>
    </button>
</div>
<div data-mobile-search-status="0"
    class="w-full pointer-events-none bg-primary bg-opacity-90 pb-2 transform -translate-y-full opacity-0 transition-all duration-200 z-40">
    <div class="relative w-full">
        <form action="/<?=$advanced_search_url?>" autocomplete="off"
            class="w-full flex items-center justify-around relative">
            <a href="/<?=$advanced_search_url?>"
                class="w-10 h-10 rounded-sm flex items-center justify-center bg-overlay"><svg class="w-4 h-4"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M487.976 0H24.028C2.71 0-8.047 25.866 7.058 40.971L192 225.941V432c0 7.831 3.821 15.17 10.237 19.662l80 55.98C298.02 518.69 320 507.493 320 487.98V225.941l184.947-184.97C520.021 25.896 509.338 0 487.976 0z" />
                </svg></a>
            <input data-mobile-search-input type="text" class="w-10/12 p-2 text-sm rounded-sm text-gray-900"
                name="keyword" placeholder="<?php _e('Search anime...', 'kiranime');?>">
            <button type="submit" class="absolute top-1/2 transform -translate-y-1/2 z-50 text-gray-900 right-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5">
                    <path fill="currentColor"
                        d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
                </svg>
            </button>
        </form>
        <div class="bg-tertiary shadow-lg absolute top-10 mt-1 inset-x-0 z-10 list-none hidden"
            data-mobile-search-result>
            <div data-mobile-search-result-area>

            </div>
            <a data-mobile-search-view-all href="/<?=$advanced_search_url?>"
                class="flex items-center justify-center w-full p-4 bg-accent-3 text-base">
                <?php _e('View all results', 'kiranime');?> <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 256 512" class="w-4 h-4 ml-2 inline-block">
                    <path fill="currentColor"
                        d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
                </svg></i>
            </a>
        </div>
    </div>
</div>