<?php
/**
 * Episode information
 *
 * @package kiranime
 */

/**
 * add new metabox to episode cpt
 */

function kiranime_add_episode_metabox()
{
    add_meta_box(
        'kiranime_episode_metabox_parent',
        'Anime Info',
        'kiranime_episode_anime_parent',
        ['episode']
    );
    add_meta_box(
        'kiranime_episode_metabox',
        'Episode Information',
        'kiranime_episode_information_meta',
        ['episode'],
    );
    add_meta_box(
        'kiranime_episode_metabox_player',
        'Player Embed',
        'kiranime_episode_video_player',
        ['episode'],
    );

}
add_action('add_meta_boxes', 'kiranime_add_episode_metabox');

/**
 * Save metabox upon saving or updating episode
 */

add_action('save_post_episode', 'kiranime_save_episode_metadata', 10, 3);
function kiranime_save_episode_metadata($post_id, $post, $update)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    $quick_edit = isset($_POST['_inline_edit']) ? $_POST['_inline_edit'] : null;
    if ($quick_edit && wp_verify_nonce($quick_edit, 'inlineeditnonce')) {
        return $post_id;
    }

    $prefix = 'kiranime_episode_';
    $keys = ['number', 'title', 'duration', 'released', 'parent_id', 'parent_name', 'parent_slug', 'thumbnail', 'anime_id', 'anime_season', 'anime_type'];

    $serialize_players = json_encode([]);
    if (isset($_POST['player-keys']) && !empty($_POST['player-keys'])) {
        $arr_ply = explode(",", $_POST['player-keys']);
        $dtype = ['type', 'subtype', 'host', 'code', 'url'];
        $all_players = [];
        foreach ($arr_ply as $ar) {
            $current_player = [];
            foreach ($dtype as $dt) {
                if ($dt === 'code' && $_POST['player_' . $dt . '_' . $ar]) {
                    $current_player[$dt] = esc_html($_POST['player_' . $dt . '_' . $ar]);
                } else {
                    $current_player[$dt] = $_POST['player_' . $dt . '_' . $ar];
                }
            }
            $all_players[] = $current_player;
        }

        $serialize_players = json_encode($all_players);
    }
    // save players
    update_post_meta($post_id, 'kiranime_episode_players', $serialize_players);

    $serialize_download = json_encode([]);

    if (isset($_POST['download_keys']) && !empty($_POST['download_keys'])) {
        $total_downloads = explode(',', $_POST['download_keys']);
        $download_to_save = [];
        foreach ($total_downloads as $download) {
            $dl_to_push = [
                'resolution' => $_POST['resolution_' . $download],
                'data' => [],
            ];

            $provider_key = 'download_provider_' . $download;
            $link_key = 'download_link_' . $download;
            foreach ($_POST[$provider_key] as $index => $provider) {
                $dl_to_push['data'][] = [
                    'provider' => $provider,
                    'url' => $_POST[$link_key][$index],
                ];
            }
            $download_to_save[] = $dl_to_push;
        }

        $serialize_download = json_encode($download_to_save);
    }

    //save download
    update_post_meta($post_id, 'kiranime_download_data', $serialize_download);

    foreach ($keys as $key) {
        $val = isset($_POST[$prefix . $key]) ? $_POST[$prefix . $key] : null;
        $mk = $prefix . $key;

        if ($key == 'parent_id' && $val) {
            update_post_meta($val, 'kiranime_anime_updated', time());

            $is_notified = get_post_meta($post_id, 'notification_sent', true);
            if ($_POST['create_notification'] == 1 && !$is_notified) {
                Kiranime_Notification::notify($post_id, $val, $_POST[$prefix . 'number']);
                update_post_meta($post_id, 'notification_sent', '1');
            }
        }

        if ($key === 'thumbnail') {
            if ($val && get_option('__a_auto_dl')) {
                Kiranime_Utility::download_and_save_remote_image($val, 'kiranime_episode_thumbnail', $post_id, 'thumbnail');
                continue;
            }
        }

        if ($val) {
            update_post_meta($post_id, $mk, $val);
        }
    }
}

/**
 * episode metabox html
 */

function kiranime_episode_information_meta($post)
{
    $prefix = 'kiranime_episode_';
    $keys = ['number', 'title', 'duration', 'thumbnail', 'released'];
    $vals = [];
    $create_notification = get_post_meta($post->ID, 'create_notification', true);
    $create_notification = !empty($create_notification) ? $create_notification : 1;
    foreach ($keys as $key) {
        $meta_key = $prefix . $key;
        if ($key == 'released') {
            $vals[$meta_key] = get_post_meta($post->ID, $meta_key, true) ? get_post_meta($post->ID, $meta_key, true) : $post->post_date;
        } else {
            $vals[$meta_key] = get_post_meta($post->ID, $meta_key, true);
        }
    }?>

<div class="w-full h-auto bg-white space-y-1">
    <input type="hidden" name="create_notification" value="<?php echo json_encode($create_notification); ?>">
    <?php foreach ($vals as $key => $val): ?>
    <div>
        <span
            class="text-xs font-semibold inline-block py-1 px-2 rounded-t text-slate-700 bg-slate-300 uppercase w-2/12 mr-1 flex-shrink-0">
            <?php echo str_replace($prefix, '', $key); ?>
        </span>
        <div class="mb-3 pt-0 flex-auto">
            <input type="text" placeholder="Episode <?php echo str_replace($prefix, '', $key); ?>"
                name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $val; ?>"
                class="px-3 py-3 placeholder-gray-400 text-blueGray-600 relative bg-white rounded text-sm border-none ring-1 ring-sky-200 shadow outline-none focus:outline-none focus:ring w-full" />
        </div>
    </div>
    <?php endforeach;?>
</div>
<?php
}

function kiranime_episode_anime_parent($post)
{
    $prefix = 'kiranime_episode_';
    $keys = ['parent_id', 'parent_name', 'parent_slug'];
    $vals = [];

    foreach ($keys as $key) {
        $meta_key = $prefix . $key;

        $vals[$meta_key] = get_post_meta($post->ID, $meta_key, true);
    }?>

<div class="w-full h-auto bg-white space-y-1">
    <div>
        <span
            class="text-xs font-semibold inline-block py-1 px-2 rounded-t text-slate-700 bg-slate-300 uppercase w-2/12 mr-1 flex-shrink-0">
            Anime title
        </span>
        <div class="mb-3 pt-0 flex-auto relative">
            <input data-anime-name-input type="text" autocomplete="off" name="kiranime_episode_parent_name"
                id="kiranime_episode_parent_name" placeholder="Anime title"
                class="px-3 py-3 placeholder-gray-400 text-blueGray-600 relative bg-white rounded text-sm border-none ring-1 ring-sky-200 shadow outline-none focus:outline-none focus:ring w-full"
                value="<?php echo $vals['kiranime_episode_parent_name']; ?>" />
            <div class="w-full mt-2 p-2 absolute hidden top-full left-0 flex-col gap-2 bg-white z-50"
                data-anime-name-result>

            </div>
            <input type="number" name="kiranime_episode_parent_id"
                value="<?php echo $vals['kiranime_episode_parent_id']; ?>" data-anime-id class="hidden">
            <input type="text" name="kiranime_episode_parent_slug"
                value="<?php echo $vals['kiranime_episode_parent_slug']; ?>" data-anime-slug class="hidden">
        </div>
    </div>


</div>
<?php
}

/**
 * episode player metabox
 */

function kiranime_episode_video_player($post)
{
    $players = get_post_meta($post->ID, 'kiranime_episode_players', true);
    ?>
<script>
let players = <?php echo null !== $players && !empty($players) ? $players : json_encode([]); ?>;

players = players && typeof players === 'string' ? JSON.parse(players) : players;
</script>
<div class="w-full h-auto grid grid-cols-7 bg-white">
    <input type="hidden" name="player-total-count" value="">
    <input type="hidden" name="player-keys" value="">
    <div data-players-wrapper class="space-y-3 col-span-7 mb-4">

    </div>
    <button data-add-player
        class="outline-none col-span-7 sm:col-span-1 border-none bg-accent-3 text-white rounded-sm px-2 py-1 font-medium text-sm">
        Add Player
    </button>
</div>
<template id="player-fields">
    <div data-player-index class="grid grid-cols-7 gap-4 p-2 border-slate-300 border mb-3">
        <select data-player-type name="player_type"
            class="col-span-full lg:col-span-1 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-none">
            <option value="sub">Subtitled</option>
            <option value="dub">Dubbed</option>
        </select>
        <select data-player-subtype name="player_subtype"
            class="col-span-full lg:col-span-1 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-none">
            <option value="url">Full URL</option>
            <option value="code">Code</option>
        </select>
        <input type="text" data-player-host name="player_host"
            class="col-span-full lg:col-span-4 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-0 focus:outline-none border-l"
            placeholder="this embed host, example: Youtube">
        <button data-remove-player
            class="outline-none col-span-full lg:col-span-1 border-none bg-error text-white rounded-sm px-2 py-2">
            Remove
        </button>
        <input type="text" data-subtype-url name="player_url"
            class="col-span-full lg:col-span-7 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-0 focus:outline-none border-l"
            placeholder="Only url to video">
        <textarea data-subtype-code cols="30" rows="4" name="player_code"
            class="col-span-full lg:col-span-7 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-0 focus:outline-none border-t hidden"
            placeholder="full embed code."></textarea>
    </div>
</template>
<?php }