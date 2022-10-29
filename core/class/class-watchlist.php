<?php
/**
 * This is class for user watchlist handling.
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Watchlist
{
    public function __construct()
    {}

    public static function remove_other(string $type_data, int $anime_id, int $uid)
    {
        $types = ['plan_to_watch', 'watching', 'on_hold', 'completed', 'dropped'];
        $types = array_filter($types, function ($val) use ($type_data) {
            return $val != $type_data;
        });
        $results = false;
        foreach ($types as $type) {
            if (delete_post_meta($anime_id, 'bookmark_' . $type . '_by', $uid)) {
                $results = true;
            }
        }

        return $results;
    }

    public static function __rest_add_watchlist(int $user_id = 0, $type = 'plan_to_watch', int $anime_id = 0)
    {
        $types = self::get_types();
        $get_current_list = get_post_meta($anime_id, 'bookmark_' . $type . '_by', false);
        if (in_array($user_id, $get_current_list)) {
            return ['success' => true, 'message' => __('Ya fue añadido!', 'kiranime'), 'data' => $get_current_list];
        } else {
            $removed = Self::remove_other($type, $anime_id, $user_id);
            $count = (int) get_post_meta($anime_id, 'bookmark_count', true);
            $count = isset($count) ? (int) $count : 0;

            $text = __('Anime añadido a tu lista!', 'kiranime');
            if (!$removed) {
                update_post_meta($anime_id, 'bookmark_count', $count + 1);
            }

            if ($removed) {
                $data_type = array_values(array_filter($types, function ($val) use ($type) {
                    return $val['key'] === $type;
                }));
                $text = sprintf(esc_html__('Anime ha sido movido a %1$s', 'kiranime'), $data_type[0]['name']);
            }

            add_post_meta($anime_id, 'bookmark_' . $type . '_by', $user_id);

            return ['message' => $text, 'translated' => __($data_type[0]['name'], 'kiranime'), 'data' => $data_type, 'types' => $types, 'type' => $type];
        }
    }

    public static function __rest_get_watchlist(int $user_id = 0, $type = 'plan_to_watch', $page = 1, $total = 20)
    {
        if (!$user_id) {
            return null;
        }

        $watchlist = new Self();

        if ($type == 'all') {
            return $watchlist->get($page, $total, $user_id);
        }

        $queried = new WP_Query([
            'post_type' => 'anime',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'meta_value_num',
            'meta_key' => 'kiranime_anime_updated',
            'posts_per_page' => $total,
            'paged' => $page,
            'meta_query' => [
                [
                    'key' => 'bookmark_' . $type . '_by',
                    'value' => $user_id,
                    'compare' => '=',
                ],
            ],
        ]);

        $results = [];

        foreach ($queried->posts as $post) {
            $anime = new Kiranime_Anime($post->ID);
            $type = Kiranime_Utility::get_taxonomy($post->ID, 'type');
            $attr = Kiranime_Utility::get_taxonomy($post->ID, 'anime_attribute');
            $results[] = [
                'title' => $post->post_title,
                'type' => !is_wp_error($type) && count($type) != 0 ? $type[0] : null,
                'metadata' => $anime->meta(['download', 'episodes']),
                'featured' => $anime->get_image('featured'),
                'synopsis' => $post->post_content,
                'name' => $post->post_name,
                'attribute' => !is_wp_error($attr) ? $attr : [],
                'url' => get_the_permalink($post->ID),
                'id' => $post->ID,
            ];

        }

        return ['results' => $results, 'current' => $page];
    }

    public static function __rest_delete_watchlist(int $user_id = 0, int $anime_id = 0)
    {
        $types = ['plan_to_watch', 'watching', 'on_hold', 'completed', 'dropped'];

        foreach ($types as $type) {
            delete_post_meta($anime_id, 'bookmark_' . $type . '_by', $user_id);
        }

        $count = (int) get_post_meta($anime_id, 'bookmark_count', true);
        $new_count = 0;
        if ($count && $count > 0) {
            $new_count = $count - 1;
        }

        update_post_meta($anime_id, 'bookmark_count', $new_count);
        return ['message' => __('Eliminado de tu lista!', 'kiranime')];
    }

    public static function get(int $page = 1, int $total = 20, int $user_id = 0)
    {

        $uid = $user_id ? $user_id : get_current_user_id();

        $posts = [
            'post_type' => 'anime',
            'post_status' => 'publish',
            'order' => 'DESC',
            'posts_per_page' => $total,
            'paged' => $page,
            'meta_query' => [
                'relation' => 'OR',
            ],
        ];

        $types = ['plan_to_watch', 'watching', 'on_hold', 'completed', 'dropped'];
        foreach ($types as $type) {
            $posts['meta_query'][] = [
                'key' => 'bookmark_' . $type . '_by',
                'value' => $uid,
            ];
        }

        $all = new WP_Query($posts);
        // return $all;

        $results = [];
        foreach ($all->posts as $post) {
            $anime = new Kiranime_Anime($post->ID);
            $type = Kiranime_Utility::get_taxonomy($post->ID, 'type');
            $attr = Kiranime_Utility::get_taxonomy($post->ID, 'anime_attribute');
            $results[] = [
                'title' => $post->post_title,
                'type' => !is_wp_error($type) && count($type) != 0 ? $type[0] : null,
                'metadata' => $anime->meta(['download', 'episodes']),
                'featured' => $anime->get_image('featured'),
                'synopsis' => $post->post_content,
                'name' => $post->post_name,
                'attribute' => !is_wp_error($attr) ? $attr : [],
                'url' => get_the_permalink($post->ID),
                'id' => $post->ID,
            ];
        }

        return ['results' => $results, 'max_page' => $all->max_num_pages];
    }

    public static function by_anime(int $anime)
    {
        $data = (array) get_post_meta($anime, 'bookmark_watching_by', false);

        return $data;
    }

    public static function get_types()
    {
        return [
            [
                'key' => 'plan_to_watch',
                'name' => __('Quiero verla', 'kiranime'),
            ],
            [
                'key' => 'watching',
                'name' => __('Viendo ahora', 'kiranime'),
            ],
            [
                'key' => 'on_hold',
                'name' => __('En espera', 'kiranime'),
            ],
            [
                'key' => 'completed',
                'name' => __('Completadas', 'kiranime'),
            ],
            [
                'key' => 'dropped',
                'name' => __('Caidos', 'kiranime'),
            ],
            [
                'key' => 'remove',
                'name' => __('Eliminar', 'kiranime'),
            ],
        ];
    }
}