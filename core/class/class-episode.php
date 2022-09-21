<?php
/**
 * This is class for episode post type related
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Episode
{
    private $episode;
    private $utility;

    public function __construct(int $episode = 0)
    {
        $this->episode = $episode;
        $this->utility = new Kiranime_Utility(0, $episode);
    }

    public function meta(array $exclude = [])
    {
        $keys = ['number', 'title', 'duration', 'released', 'parent_id', 'parent_name', 'parent_slug', 'players', 'download', 'thumbnail'];
        $result = [];

        if ($exclude) {
            $keys = array_filter($keys, function ($val) use ($exclude) {
                return !in_array($val, $exclude);
            });
        }
        foreach ($keys as $key) {
            $result[$key] = $this->utility->get_metadata($key, 'episode');
        }

        return $result;
    }

    public function get_image()
    {

        $thumbnail = get_the_post_thumbnail_url($this->episode, 'full');
        $featured = $this->utility->get_metadata('thumbnail', 'episode');

        return $thumbnail ? $thumbnail : $featured;
    }

    public static function scheduled(int $day, int $month, int $year)
    {

        $posts = get_posts([
            'post_type' => 'episode',
            'post_status' => 'future',
            'order' => 'ASC',
            'orderby' => 'date',
            'posts_per_page' => -1,
            'date_query' => [
                [
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'compare' => '=',
                ],
            ],
        ]);

        $result = [];

        foreach ($posts as $post) {
            $ep = new Self($post->ID);
            $meta = $ep->meta();
            $result[] = [
                'meta' => $meta,
                'parent_url' => get_post_permalink($meta['parent_id']),
                'title' => $post->post_title,
                'scheduled' => get_the_date(DATE_ISO8601, $post),
                'id' => $post->ID,
            ];
        }

        return ['data' => $result, 'status' => 200];
    }

    public static function get(int $id)
    {

        $episode = new Self($id);
        $utility = new Kiranime_Utility(0, $id);

        // set up all metadata if any of above passed
        $episode_meta = $episode->meta();
        $player_data = $utility->get_metadata('players', 'episode');

        $anime = new Kiranime_Anime($episode_meta['parent_id']);

        $next_episode = $anime->next_episode();
        $anime_data = $anime->as_parent();

        $npi = get_theme_mod('__no_player_image_type', 'featured') === 'featured';
        if ($npi) {
            $npi = $episode_meta['thumbnail'];
        } else {
            if (get_theme_mod('__no_player_image')) {
                $npi = get_theme_mod('__no_player_image');
            } else {
                $npi = '';
            }
        }

        $uid = get_current_user_id();
        $autoplay = get_user_meta($uid, 'kiranime_user_auto_play', true);
        $type = Kiranime_Utility::get_taxonomy($id, 'episode_type');
        return [
            'data' => [
                'message' => 'success!',
                'meta' => $episode_meta,
                'next' => $next_episode,
                'anime' => $anime_data,
                'players' => $player_data,
                'noplayer' => '<img src="' . $npi . '" style="object-fit: contain;" />',
                'autoplay' => $autoplay,
                'type' => !is_wp_error($type) ? $type : [['slug' => 'series']],
            ],
            'status' => 200,
        ];
    }
}