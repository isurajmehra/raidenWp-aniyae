</main>
<div
    class="px-5 max-w-full relative z-39 bg-cover after:absolute after:w-full after:inset-0 after:bg-gradient-to-tr after:from-primary after:to-primary/70">
    <div class="py-8 relative z-40">
        <div
            class="mb-5 pb-5 sm:border-b border-gray-400 border-opacity-40 max-w-max sm:mx-auto lg:mx-0 lg:justify-start sm:flex hidden">
            <a href="/" id="logo" class="inline-block mr-10">
                <?php if (get_theme_mod('custom_logo')) {
    ?>
                <img style="width: 150px;" src="<?php $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    echo $image['0']?>" alt="<?php echo get_bloginfo('name') ?>">
                <?php } else {
    echo get_bloginfo('name');
}?>
            </a>
            <div class="pl-8 border-l border-gray-400 border-opacity-40 flex gap-5 items-center">
                <div class="w-max">
                    <span class="block text-xs"><?php _e('Tambien en: ', 'kiranime')?></span>
                </div>
                <div class="flex items-center justify-start gap-4">
                    <?php if (get_theme_mod('__show_social_link', 'show') === 'show'):
    $socials = Kiranime_Utility::social();
    foreach ($socials as $key => $val): if ($val['link']): ?>
		                    <div>
		                        <a href="<?php echo $val['link'] ?>"
		                            class="w-10 h-10 flex items-center justify-center rounded-sm" target="_blank"
		                            style="background: <?=$val['color'];?>;">
		                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="<?=$val['vbox']?>">
		                                <path fill="currentColor" d="<?=$val['icon']?>" />
		                            </svg>
		                        </a>
		                    </div>
		                    <?php endif;endforeach;endif;?>
                </div>
            </div>
        </div>
        <div class="mb-3 hidden sm:block sm:text-center lg:text-left">
            <div class="block mb-3">
                <span
                    class="inline-block pr-5 mr-5 border-r border-gray-400 border-opacity-40 leading-4 text-xl font-semibold"><?php _e('Busqueda de la A a la Z', 'kiranime')?></span>
                <span class="text-xs"><?php _e('Busca de la A a la Z.', 'kiranime');?></span>
            </div>
            <ul class="mt-2 m-0 p-0 list-none">
                <?php
$alphabet = ['All', '#', '0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
$page_url = Kiranime_Utility::page_url('pages/az-list.php');
foreach ($alphabet as $key => $value) {
    if ($key == 0) {
        echo '<li class="mr-3 mb-3 inline-block"><a class="text-sm py-1 px-2 bg-opacity-4 hover:bg-accent-3 bg-secondary rounded-sm" href="' . $page_url . '">All</a></li>';
    } elseif ($key == 1) {
        echo '<li class="mr-3 mb-3 inline-block"><a class="text-sm py-1 px-2 bg-opacity-4 hover:bg-accent-3 bg-secondary rounded-sm" href="' . $page_url . '?letter=other">#</a></li>';
    } else {
        echo '<li class="mr-3 mb-3 inline-block"><a class="text-sm py-1 px-2 bg-opacity-4 hover:bg-accent-3 bg-secondary rounded-sm" href="' . $page_url . '?letter=' . $value . '">' . $value . '</a></li>';
    }
}
?>
            </ul>
        </div>
        <?php if (Kiranime_Utility::is_social_active()): ?>
        <div class="flex md:hidden w-full mx-auto items-center gap-2 mb-5 justify-center px-4 ">
            <?php foreach ($socials as $key => $val): if (!empty($val['link'])): ?>
	            <a href="<?php echo $val['link'] ?>" class="w-10 h-10 flex items-center justify-center rounded-sm"
	                target="_blank" style="background: <?=$val['color'];?>;">
	                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="<?=$val['vbox']?>">
	                    <path fill="currentColor" d="<?=$val['icon']?>" />
	                </svg>
	            </a>
	            <?php endif;endforeach;?>
        </div>
        <?php endif;?>
        <?php if (has_nav_menu('footer')): ?>
        <div class="flex items-center gap-5 mb-3 justify-center md:justify-start">
            <?php wp_nav_menu([
    'theme_location' => 'footer',
    'container_class' => 'w-full',
    'menu_class' => 'flex text-sm p-0 m-0',
])?>
        </div>
        <?php endif;?>
        <div class="text-xs  text-gray-400 text-opacity-80 text-center md:text-left">
            <?php printf(esc_html__('Ningun video se encuentra alojado en nuestro servidor o en servidores bajo contrato de Analitica. Todos los videos estan alojados en servidores de terceros.', 'kiranime'), get_bloginfo('name'));?>
        </div>
        <p class="text-xs  text-gray-400 text-opacity-80 mb-3 text-center md:text-left">©
            Analitica</p>
    </div>
</div>
<!-- Ads start -->
<script type='text/javascript' src='//pl17592734.highperformancecpmgate.com/00/8f/4f/008f4ff556fb433f90ff83fd9220b616.js'></script>
<script data-cfasync="false" type="text/javascript" src="//onclickprediction.com/a/display.php?r=6457226"></script>
<!-- End Ads -->
<script id="chatBroEmbedCode">/* Chatbro Widget Embed Code Start */function ChatbroLoader(chats,async){async=!1!==async;var params={embedChatsParameters:chats instanceof Array?chats:[chats],lang:navigator.language||navigator.userLanguage,needLoadCode:'undefined'==typeof Chatbro,embedParamsVersion:localStorage.embedParamsVersion,chatbroScriptVersion:localStorage.chatbroScriptVersion},xhr=new XMLHttpRequest;xhr.withCredentials=!0,xhr.onload=function(){eval(xhr.responseText)},xhr.onerror=function(){console.error('Chatbro loading error')},xhr.open('GET','https://www.chatbro.com/embed.js?'+btoa(unescape(encodeURIComponent(JSON.stringify(params)))),async),xhr.send()}/* Chatbro Widget Embed Code End */ChatbroLoader({encodedChatId: '38ifi'});</script>
<?php wp_footer();?>
</body>

</html>