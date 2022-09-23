<?php
add_action('add_meta_boxes', 'kira_add_anime_meta_box');
function kira_add_anime_meta_box()
{
    add_meta_box(
        'kiranime_anime_fetch',
        'Fetch Anime Info',
        'kiranime_add_fetch_metabox',
        ['anime', 'movie']
    );
    add_meta_box(
        'kiranime_anime_metabox_id',
        'Anime Info',
        'kiranime_add_metabox_html',
        ['anime']
    );
    add_meta_box(
        'kiranime_download_metabox',
        'Download',
        'kiranime_download_metabox',
        ['anime', 'episode', 'movie']
    );
}

/**
 * download metabox for anime and episode
 */
function kiranime_download_metabox($post)
{
    $downloads = json_decode(get_post_meta($post->ID, 'kiranime_download_data', true));
    ?>
<script>
let downloads = <?php echo null !== $downloads && !empty($downloads) ? json_encode($downloads) : json_encode([]); ?>;

downloads = downloads && typeof downloads === 'string' ? JSON.parse(downloads) : downloads;
</script>

<div class="w-full h-auto bg-white space-y-1">
    <input type="hidden" name="download-field-total" value="">
    <input type="hidden" name="download_keys" id="download-keys">
    <div id="data-download-wrapper" data-download-wrapper class="w-full h-auto bg-white space-y-1">

    </div>
    <div data-add-new-download
        class="w-max cursor-pointer text-xs font-semibold px-5 py-2 text-white rounded-sm bg-accent-3">
        Añadir nueva descarga
    </div>
    <template id="dl-link-field">
        <div data-field-dl class="grid grid-cols-7 gap-4">
        <select data-provider name="download_provider"
                class="col-span-full lg:col-span-1 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-none">
                <option value="fembed"><?php _e('Fembed', 'kiranime');?></option>
                <option value="mega"><?php _e('Mega', 'kiranime');?></option>
                <option value="opncion3"><?php _e('Opcion 3', 'kiranime');?></option>

            </select>
            <input data-link type="text" name="download_link" placeholder="Download Link"
                class="px-3 py-3 placeholder-slate-400 text-stone-600 relative bg-white rounded text-sm border-none ring-1 ring-sky-200 shadow outline-none focus:outline-none focus:ring w-full col-span-4"
                value="" />
            <div class="col-span-1 grid grid-cols-2 gap-1">
                <button data-add-link
                    class="outline-none col-span-1 border-none bg-sky-500 text-white rounded-sm px-2 py-1 text-lg font-semibold">
                    +
                </button>
                <button data-remove-link
                    class="outline-none col-span-1 border-none bg-sky-500 text-white rounded-sm px-2 py-1 text-lg font-semibold99">
                    -
                </button>
            </div>
        </div>
    </template>
    <template id="download-fields">
        <div data-download-template class="p-4 mb-3 border border-slate-300">
            <div class="grid grid-cols-7 gap-4">
                <div class="mb-3 pt-0 flex-auto col-span-6">
                <select data-resolution name="resolution[]"
                    class="col-span-full lg:col-span-1 py-2 px-1 outline-none border-0 border-b border-slate-300 text-sm font-medium focus:border-none">
                        <option value="Subtitulado"><?php _e('Subtitulado', 'kiranime');?></option>
                        <option value="Doblado"><?php _e('Doblado', 'kiranime');?></option>
                </select>
                </div>
                <button data-remove-box
                    class="outline-none mb-3 col-span-1 border-none bg-error text-white rounded-sm px-2 py-1">
                    Eliminar
                </button>
            </div>
            <div data-download-field class="space-y-2">

            </div>
        </div>
    </template>
</div>
<?php }

/**
 * save metada on save_post anime
 */
add_action('save_post_anime', 'kiranime_save_metadata', 10, 2);
function kiranime_save_metadata($post_id, $post)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    $quick_edit = isset($_POST['_inline_edit']) ? $_POST['_inline_edit'] : null;
    if ($quick_edit && wp_verify_nonce($quick_edit, 'inlineeditnonce')) {
        return $post_id;
    }

    if (!current_user_can('edit_posts')) {
        return $post_id;
    }

    if ($post && $post->post_type != 'anime') {
        return $post_id;
    }

    $post = $post ? $post : get_post($post_id);

    $params = $_POST;
    $prefix = 'kiranime_anime_';
    $keys = ['spotlight', 'rate', 'native', 'synonyms', 'aired', 'premiered', 'duration', 'episodes', 'score', 'trailer', 'id', 'service_name'];

    $metas = [
        'kiranime_anime_updated' => time(),
        'bookmark_count' => 0,
    ];

    $serialize_download = json_encode([]);
    if (isset($_POST['download_keys']) && !empty($_POST['download_keys'])) {
        $total_downloads = explode(',', $params['download_keys']);
        $download_to_save = [];
        foreach ($total_downloads as $download) {
            $dl_to_push = [
                'resolution' => $params['resolution_' . $download],
                'data' => [],
            ];

            $provider_key = 'download_provider_' . $download;
            $link_key = 'download_link_' . $download;
            foreach ($params[$provider_key] as $index => $provider) {
                $dl_to_push['data'][] = [
                    'provider' => $provider,
                    'url' => $params[$link_key][$index],
                ];
            }
            $download_to_save[] = $dl_to_push;
        }

        $serialize_download = json_encode($download_to_save);
    }

    // save download data
    update_post_meta($post_id, 'kiranime_download_data', $serialize_download);

    if (!metadata_exists('post', $post_id, 'total_kiranime_views')) {
        Kiranime_Anime::bikin($post_id);
    }

    foreach ($keys as $key) {
        if ($key === 'spotlight') {
            $value = isset($params[$prefix . $key]) ? $params[$prefix . $key] : '0';
            update_post_meta($post_id, $prefix . $key, $value);
            continue;
        }
        if (isset($params[$prefix . $key])) {
            update_post_meta($post_id, $prefix . $key, $params[$prefix . $key]);
        }
    }

    if (get_option('__a_auto_dl')) {
        foreach (['featured', 'background'] as $im) {
            if (isset($params[$prefix . $im])) {
                Kiranime_Utility::download_and_save_remote_image($params[$prefix . $im], $prefix . $im, $post_id, $im);
            }
        }
    } else {
        foreach (['featured', 'background'] as $im) {
            if (isset($params[$prefix . $im])) {
                update_post_meta($post_id, $prefix . $im, $params[$prefix . $im]);
            }
        }
    }

    foreach ($metas as $meta => $value) {
        if (!metadata_exists('post', $post_id, $meta)) {
            update_post_meta($post_id, $meta, $value);
        }
    }

    if (!metadata_exists('post', $post_id, 'kiranime_anime_vote_data')) {
        add_post_meta($post_id, 'kiranime_anime_vote_data', json_encode([]));
        add_post_meta($post_id, 'kiranime_anime_vote_sum', 0);
    }
}

/**
 * anime meta info metabox
 */
function kiranime_add_metabox_html($post)
{
    // check if current editor is block editor
    $block = get_current_screen()->is_block_editor();

    $prefix = 'kiranime_anime_';
    $keys = [
        [
            'key' => 'spotlight',
            'detail' => '',
        ],
        [
            'key' => 'rate',
            'detail' => '',
        ],
        [
            'key' => 'native',
            'detail' => '',
        ],
        [
            'key' => 'synonyms',
            'detail' => '',
        ],
        [
            'key' => 'aired',
            'detail' => '',
        ],
        [
            'key' => 'premiered',
            'detail' => '',
        ],
        [
            'key' => 'duration',
            'detail' => '',
        ],
        [
            'key' => 'episodes',
            'detail' => '',
        ],
        [
            'key' => 'score',
            'detail' => '',
        ],
        [
            'key' => 'trailer',
            'detail' => '',
        ],
        [
            'key' => 'featured',
            'detail' => '',
        ],
        [
            'key' => 'background',
            'detail' => '',
        ],
    ];
    $vals = [];

    foreach ($keys as $meta) {
        $meta_key = $prefix . $meta['key'];

        $vals[$meta_key] = [
            'val' => get_post_meta($post->ID, $meta_key, true),
            'detail' => $meta['detail'],
        ];
    }?>
<script>
const is_block = parseInt("<?=$block ? 1 : 0?>");
</script>
<div data-anime-infomation class="w-full h-auto bg-white space-y-1">
    <?php wp_nonce_field('kiranime_anime_save_meta', 'kiranime_anime_nonce')?>
    <?php
foreach ($vals as $key => $val): ?>

    <?php if ($key != 'kiranime_anime_spotlight') {?>
    <div class="w-full h-auto p-2 lg:flex items-center space-y-1 relative">
        <label for="<?php echo $key; ?>"
            class="text-xs font-medium uppercase text-slate-800 active:text-slate-900 hover:text-slate-900 focus-within:text-slate-900 min-w-max lg:w-2/12 flex-shrink-0"><?php echo str_replace($prefix, '', $key); ?></label>
        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
            <?php if ($val['detail']) {echo 'placeholder="' . $val['detail'] . '"';}?>
            class="px-4 py-2 text-sm font-normal text-slate-900 flex-auto"
            <?php if ($val['val']) {echo 'value="' . $val['val'] . '"';}?>>
    </div>
    <?php } else {?>
    <div class="w-full h-auto p-2 lg:flex items-center space-y-1">
        <label for="<?php echo $key; ?>"
            class="text-xs font-medium uppercase text-slate-800 active:text-slate-900 hover:text-slate-900 focus-within:text-slate-900 min-w-max lg:w-2/12 flex-shrink-0"><?php echo str_replace($prefix, '', $key); ?></label>
        <select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
            <option value="1" <?php if ($val == '1') {echo 'selected';}?>>Yes</option>
            <option value="0" <?php if ($val == '0' || !$val) {echo 'selected';}?>>No</option>
        </select>
    </div>
    <?php }?>
    <?php endforeach;?>
    <template id="anime-input-field">
        <div class="hidden">
            <input type="text" name="" id="" class="px-4 py-2 text-sm font-normal text-slate-900 flex-auto" value="">
        </div>
    </template>
</div>
<?php
}

/**
 * fetch anime metabox
 */
function kiranime_add_fetch_metabox($post)
{
    $prefix = 'kiranime_anime_';
    $jikan = get_option('__a_jikan', 'https://api.jikan.moe/v4');
    $tmdb = get_option('__a_tmdb');

    $anime_id = get_post_meta($post->ID, $prefix . 'id', true);
    $tmdb_type = get_post_meta($post->ID, 'kiranime_anime_tmdb_type', true);
    $service_name = get_post_meta($post->ID, $prefix . 'service_name', true);

    wp_add_inline_script('kiranime-vendors', ';const fetch_anime_id=parseInt("' . $anime_id . '");const fetch_tmdb_type = "' . $tmdb_type . '";const fetch_service = "' . $service_name . '"', 'before');
    ?>
<div class="w-full h-auto bg-white space-y-1">
    <input type="hidden" id="jikan_url"
        value="<?=$jikan && strlen($jikan) > 0 ? $jikan : 'https://api.jikan.moe/v4';?>">
    <input type="hidden" id="tmdb_api" value="<?=$tmdb;?>">
    <span data-notifications
        class="w-full block h-auto p-2 lg:flex text-base font-medium items-center space-y-1 text-rose-600">

    </span>
    <div class="w-full h-auto p-2 lg:flex items-center space-y-1 gap-2">
        <label for="kiranime_anime_service_name"
            class="text-xs font-medium uppercase text-slate-800 active:text-slate-900 hover:text-slate-900 focus-within:text-slate-900 min-w-max lg:w-2/12 flex-shrink-0">Choose
            Service</label>
        <select name="kiranime_anime_service_name" id="kiranime_anime_service_name">
            <option value="mal" <?php if ($service_name == 'mal' || !$service_name) {echo 'selected';}?>>MAL</option>
            <option value="tmdb" <?php if ($service_name == 'tmdb') {echo 'selected';}?>>TMDB</option>
        </select>
    </div>
    <div data-tmdb-only class="w-full h-auto p-2 hidden items-center space-y-1 gap-2">
        <label for="kiranime_anime_tmdb_type"
            class="text-xs font-medium uppercase text-slate-800 active:text-slate-900 hover:text-slate-900 focus-within:text-slate-900 min-w-max lg:w-2/12 flex-shrink-0">TMDB
            Type</label>
        <select name="kiranime_anime_tmdb_type" id="kiranime_anime_tmdb_type">
            <option value="tv" <?php if ($tmdb_type && $tmdb_type === 'tv') {echo 'selected';}?>>TV Series</option>
            <option value="movie" <?php if ($tmdb_type && $tmdb_type === 'movie') {echo 'selected';}?>>Movie</option>
        </select>
    </div>
    <div class="w-full h-auto p-2 lg:flex items-center space-y-1 gap-2">
        <label for="kiranime_anime_id"
            class="text-xs font-medium uppercase text-slate-800 active:text-slate-900 hover:text-slate-900 focus-within:text-slate-900 min-w-max lg:w-2/12 flex-shrink-0">Anime
            ID</label>
        <input type="text" name="kiranime_anime_id" id="kiranime_anime_id"
            class="px-4 py-2 text-sm font-normal text-slate-900 flex-auto lg:w-10/12" value="<?php echo $anime_id; ?>">
    </div>
    <div class="w-max h-auto p-2 space-y-1 gap-2">
        <input type="button" name="get-anime" id="get-anime"
            class="px-4 py-2 text-sm font-normal cursor-pointer w-max text-white bg-accent-3 flex-auto"
            title="Get Anime" value="Get Anime" />
    </div>
</div>
<?php }