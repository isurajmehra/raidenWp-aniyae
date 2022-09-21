<?php

/**
 * This is class for user notification
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Notification
{

    public function __construct()
    {}

    public static function notify(int $episode_id = 0, int $anime_id = 0, int $episode_number = 0)
    {
        $anime_id = isset($anime_id) ? (int) $anime_id : (int) get_post_meta($episode_id, 'kiranime_episode_parent_id', true);

        $subscribers = Kiranime_Watchlist::by_anime($anime_id);

        foreach ($subscribers as $subscriber) {
            $get = get_posts([
                'post_type' => 'notification',
                'author' => $subscriber,
            ]);

            if (!$get || count($get) == 0) {
                $create_notification = wp_insert_post([
                    'post_type' => 'notification',
                    'post_title' => 'notification_for_' . $subscriber,
                    'post_status' => 'publish',
                    'post_author' => $subscriber,
                ]);

                update_post_meta($create_notification, 'notification_update', json_encode([['episode_id' => $episode_id, 'status' => false, 'anime_id' => $anime_id, 'notification_id' => $episode_id . $anime_id, 'number' => $episode_number]]));
            } else {
                $meta = get_post_meta($get[0]->ID, 'notification_update', true);
                $meta = $meta ? json_decode($meta) : [];

                $in_array = array_filter($meta, function ($val) use ($episode_id) {
                    return $val->episode_id == $episode_id;
                });

                if (count($in_array) > 0) {
                    return;
                }

                $meta[] = [
                    'episode_id' => $episode_id,
                    'status' => false,
                    'anime_id' => $anime_id,
                    'notification_id' => 'es' . $episode_id . 'nea' . $anime_id,
                    'number' => $episode_number,
                ];

                update_post_meta($get[0]->ID, 'notification_update', json_encode($meta));

            }
        }
    }

    public static function checked(array $notification_id, int $user_id)
    {
        $get = get_posts([
            'post_type' => 'notification',
            'author' => $user_id,
        ]);

        $meta = get_post_meta($get[0]->ID, 'notification_update', true);
        $meta = $meta ? (array) json_decode($meta) : [];

        $new_notif = [];
        foreach ($meta as $n) {
            if (!in_array($n->notification_id, $notification_id)) {
                $new_notif[] = $n;
            }
        }

        update_post_meta($get[0]->ID, 'notification_update', json_encode($new_notif));

        return ['results' => $new_notif];
    }

    public static function get_anime(array $notifications)
    {
        if (count($notifications) == 0) {
            return false;
        }

        $result = [];
        foreach ($notifications as $notif) {
            $episode = get_post($notif->episode_id);
            $anime = get_post($notif->anime_id);

            $result[] = [
                'title' => $anime->post_title,
                'anime_id' => $notif->anime_id,
                'url' => get_post_permalink($episode->ID),
                'published' => human_time_diff(get_the_time('U', $episode)),
                'number' => get_post_meta($episode->ID, 'kiranime_episode_number', true),
            ];
        }

        return $result;
    }

    public static function get(bool $not_fetch = true, int $user_id = 0)
    {
        $user = $user_id ? $user_id : get_current_user_id();

        $get = get_posts([
            'post_type' => 'notification',
            'author' => $user,
        ]);

        $meta = isset($get) && isset($get[0]->ID) ? get_post_meta($get[0]->ID, 'notification_update', true) : false;
        $meta = $meta ? (array) json_decode($meta) : [];

        $results = [];
        foreach ($meta as $notif) {
            $episode = get_post($notif->episode_id);
            $anime = get_post($notif->anime_id);

            $anime_data = new Kiranime_Anime($notif->anime_id);
            $episode_data = new Kiranime_Episode($notif->episode_id);
            $episode_meta = $episode_data->meta();

            $results[] = [
                'title' => $anime->post_title,
                'anime_id' => $notif->anime_id,
                'url' => get_post_permalink($episode->ID),
                'published' => human_time_diff(get_the_time('U', $episode)),
                'number' => $episode_meta['number'],
                'status' => $notif->status,
                'featured' => $anime_data->get_image('featured'),
                'notif_id' => $notif->notification_id,
            ];
        }

        return $results;

    }

    public static function delete(string $notification_id, int $user_id)
    {
        $get = get_posts([
            'post_type' => 'notification',
            'author' => $user_id,
        ]);

        $meta = isset($get) && isset($get[0]->ID) ? get_post_meta($get[0]->ID, 'notification_update', true) : false;
        $meta = $meta ? (array) json_decode($meta) : [];

        $meta = array_filter($meta, function ($val) use ($notification_id) {
            return $notification_id != $val->notification_id;
        });

        if (!$get || count($get) === 0) {
            return ['data' => true, 'status' => 204];
        }
        update_post_meta($get[0]->ID, 'notification_update', json_encode($meta));

        return ['data' => true, 'status' => 204];
    }
}