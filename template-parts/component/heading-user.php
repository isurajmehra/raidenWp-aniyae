<?php

$user_info = get_userdata(get_current_user_id());
$display_name = esc_attr($user_info->user_login);

$user_menu = [
    'Perfil' => ['url' => Kiranime_Utility::page_url('pages/profile.php'), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>'],
    'Sigue viendo' => ['url' => Kiranime_Utility::page_url('pages/continue-watching.php'), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4"><path fill="currentColor" d="M504 255.531c.253 136.64-111.18 248.372-247.82 248.468-59.015.042-113.223-20.53-155.822-54.911-11.077-8.94-11.905-25.541-1.839-35.607l11.267-11.267c8.609-8.609 22.353-9.551 31.891-1.984C173.062 425.135 212.781 440 256 440c101.705 0 184-82.311 184-184 0-101.705-82.311-184-184-184-48.814 0-93.149 18.969-126.068 49.932l50.754 50.754c10.08 10.08 2.941 27.314-11.313 27.314H24c-8.837 0-16-7.163-16-16V38.627c0-14.254 17.234-21.393 27.314-11.314l49.372 49.372C129.209 34.136 189.552 8 256 8c136.81 0 247.747 110.78 248 247.531zm-180.912 78.784l9.823-12.63c8.138-10.463 6.253-25.542-4.21-33.679L288 256.349V152c0-13.255-10.745-24-24-24h-16c-13.255 0-24 10.745-24 24v135.651l65.409 50.874c10.463 8.137 25.541 6.253 33.679-4.21z"/></svg>'],
    'Lista' => ['url' => Kiranime_Utility::page_url('pages/watchlist.php'), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"/></svg>'],
    'Notificaciones' => ['url' => Kiranime_Utility::page_url('pages/notification.php'), 'svg' => '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"/></svg>'],
];
?>
<section class="bg-overlay relative pt-17 mt-5 mb-5">
    <div class="absolute inset-0 bg-cover blur-xl opacity-30 bg-center z-0"
        style="background-image: url(<?=Kiranime_User::get_avatar(get_current_user_id())?>);"></div>
    <div class="container relative z-10">
        <h1 class="w-full hidden lg:block text-3xl font-medium text-center mb-4 leading-relaxed">
            <?php echo $display_name; ?></h1>
        <ul class="flex items-center justify-center gap-4 h-12">
            <?php foreach ($user_menu as $menu => $data): ?>
            <li class="w-max h-auto">
                <a href="<?php echo $data['url'] ?>"
                    class="px-4 py-3 flex items-center gap-2  <?php if (get_bloginfo('url') . $_SERVER['REQUEST_URI'] == $data['url']) {echo 'text-sky-400 border-b-2 border-sky-400';}?>"><?php echo $data['svg'] ?><span
                        class="hidden lg:inline-block"><?php _e($menu, 'kiranime');?></span></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</section>