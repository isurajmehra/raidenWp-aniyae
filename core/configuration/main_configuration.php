<?php

/**
 * anime display list
 * determine how many anime will be displayed on homepage for latest, new, and upcomming.
 */

add_action('admin_menu', 'kiranime_configuration');
function kiranime_configuration()
{
    add_menu_page('Kira Tools', 'Kira Tools', 'edit_posts', 'kira_tools', 'kiranime_tools_setting', 'dashicons-admin-generic', 80);
    add_action('admin_init', 'kiranime_register_setting');
}
function kiranime_register_setting()
{
    register_setting('kiranime_api_setting', '__a_tmdb');
    register_setting('kiranime_api_setting', '__a_jikan');
    register_setting('kiranime_api_setting', '__a_auto_dl');
    register_setting('kiranime_api_setting', '__share_shortcode');
    register_setting('kiranime_api_setting', '__show_spotlight_by');
    register_setting('kiranime_api_setting', '__show_spotlight_count');
    register_setting('kiranime_api_setting', '__show_trending_count');
    register_setting('kiranime_api_setting', '__archive_count');
    register_setting('kiranime_api_setting', '__social_discord');
    register_setting('kiranime_api_setting', '__social_facebook');
    register_setting('kiranime_api_setting', '__social_telegram');
    register_setting('kiranime_api_setting', '__social_tumblr');
    register_setting('kiranime_api_setting', '__social_twitter');
    register_setting('kiranime_api_setting', '__social_reddit');
    register_setting('kiranime_api_setting', '__social_youtube');
}

function kiranime_tools_setting()
{
    $api_key = get_option('__a_tmdb');
    $jikan_endpoint = get_option('__a_jikan');
    $auto_dl = get_option('__a_auto_dl') ? 'true' : 'false';
    $shortcode = get_option('__share_shortcode');
    $spotlight_by = get_option('__show_spotlight_by');
    $spotlight_count = get_option('__show_spotlight_count');
    $trending_count = get_option('__show_trending_count');
    $archive_count = get_option('__archive_count');
    $fb = get_option('__social_facebook');
    $tw = get_option('__social_twitter');
    $tl = get_option('__social_telegram');
    $th = get_option('__social_tumblr');
    $yt = get_option('__social_youtube');
    $rd = get_option('__social_reddit');
    $dc = get_option('__social_discord');

    $localize_js = 'const jikan_endpoint = "' . $jikan_endpoint . '"; const tmdb_api = "' . $api_key . '";const auto_dl = JSON.parse(' . $auto_dl . ');const share ="' . esc_html($shortcode) . '";const spb = "' . $spotlight_by . '";const spc = "' . $spotlight_count . '";const tc = "' . $trending_count . '";const ac = "' . $archive_count . '";const __social_facebook = "' . $fb . '";const __social_twitter = "' . $tw . '";const __social_telegram = "' . $tl . '";const __social_discord = "' . $dc . '";const __social_tumblr = "' . $th . '";const __social_reddit = "' . $rd . '";const __social_youtube = "' . $yt . '";';
    wp_add_inline_script('kiranime-vendors', $localize_js, 'before');
    ?>

<div class="w-full p-5 m-5 lg:max-w-[95%]">
    <div id="kiranime-settings-tool">

    </div>
</div>

<?php }