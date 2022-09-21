<?php

/**
 * This is class for anime post type related
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Anime
{
    private $anime = 0;
    private $episode = null;
    private $utility = null;

    public function __construct(int $anime_id = 0, int $episode_id = 0)
    {
        $this->anime = $anime_id;

        $this->episode = new Kiranime_Episode($episode_id);
        $this->utility = new Kiranime_Utility($anime_id, $episode_id);
    }

    /**
     * to get all anime metadata with ability to exclude not used meta in the current need.
     * @param array $exclude metadata to exclude
     *
     * @return Array
     */
    public function meta(array $exclude = [])
    {
        $keys = ['spotlight', 'rate', 'native', 'synonyms', 'aired', 'premiered', 'duration', 'episodes', 'score', 'background', 'featured', 'updated', 'download'];

        $result = [];

        if ($exclude) {
            $keys = array_filter($keys, function ($val) use ($exclude) {
                return !in_array($val, $exclude);
            });
        }

        foreach ($keys as $key) {
            $result[$key] = $this->utility->get_metadata($key);
        }

        return $result;
    }

    /**
     * get Anime featured image and background image or only one by passing $return parameter
     *
     * @param string $return if exist then return only this field.
     * @return string|array string if $return is passed, array if $return null
     */
    public function get_image(string $return = null)
    {

        $thumbnail = get_the_post_thumbnail_url($this->anime, 'full');
        $featured = $this->utility->get_metadata('featured');
        $background = $this->utility->get_metadata('background');

        $result = [
            'featured' => $thumbnail ? $thumbnail : $featured,
            'background' => $background ? $background : $featured,
        ];

        return $return ? $result[$return] : $result;
    }

    public function synopsis()
    {
        $post = get_post($this->anime);

        return !is_null($post) ? $post->post_content : '';
    }

    public function dah_lihat()
    {
        $suffix = '_kiranime_views';
        $dates = [
            'day' => date('dmY') . $suffix,
            'week' => date('WY') . $suffix,
            'month' => date('mY') . $suffix,
            'total' => 'total' . $suffix,
        ];

        foreach ($dates as $date => $value) {
            $current = $this->berapa($this->anime);
            if ($current) {
                update_post_meta($this->anime, $value, $current + 1);
            } else {
                update_post_meta($this->anime, $value, 1);
            }
        }
    }

    /**
     * get anime views
     * @param int $post_id anime id to get view from
     * @param string $type view type to get from
     *
     * @return int|false int if meta exist, false if meta_key not exist
     */
    public static function berapa(int $post_id, string $type = 'day')
    {
        $suffix = '_kiranime_views';
        $meta_key = '';

        if ($type == 'month') {
            $meta_key = date('mY') . $suffix;
        } elseif ($type == 'week') {
            $meta_key = date('WY') . $suffix;
        } elseif ($type == 'day') {
            $meta_key = date('dmY') . $suffix;
        } else {
            $meta_key = 'total' . $suffix;
        }

        if ($meta_key) {
            return get_post_meta($post_id, $meta_key, true);
        } else {
            return false;
        }
    }

    /**
     * create views meta for anime
     * @param int $post_id anime id to create meta
     *
     * @return void
     */
    public static function bikin(int $post_id)
    {
        $suffix = '_kiranime_views';
        $screens = [
            'day' => date('dmY') . $suffix,
            'week' => date('WY') . $suffix,
            'month' => date('mY') . $suffix,
            'total' => 'total' . $suffix,
        ];
        foreach ($screens as $screen => $data) {
            if (!get_post_meta($post_id, $data, true)) {
                add_post_meta($post_id, $data, 0);
            } else {
                update_post_meta($post_id, $data, 0);
            }
        }
    }

    /**
     * get all episode list in the current anime
     *
     * @return array|\WP_Query array if query false, instance of wp_query if true.
     */
    public function episodes(bool $query = false, string $order = 'desc', int $limit = -1)
    {
        if ($query) {
            return new WP_Query([
                'post_type' => 'episode',
                'post_status' => 'publish',
                'order' => $order,
                'orderby' => 'meta_value_num',
                'meta_key' => 'kiranime_episode_number',
                'meta_query' => [
                    [
                        'key' => 'kiranime_episode_parent_id',
                        'value' => $this->anime,
                        'compare' => '=',
                    ],
                ],
                'posts_per_page' => $limit,
            ]);
        }
        $episodes = new WP_Query([
            'post_type' => 'episode',
            'post_status' => 'publish',
            'order' => $order,
            'orderby' => 'meta_value_num',
            'meta_key' => 'kiranime_episode_number',
            'meta_query' => [
                [
                    'key' => 'kiranime_episode_parent_id',
                    'value' => $this->anime,
                    'compare' => '=',
                ],
            ],
            'posts_per_page' => $limit,
        ]);

        $result = [];
        if ($episodes->have_posts()):
            foreach ($episodes->posts as $episode):
                $utl = new Kiranime_Episode($episode->ID);
                $result[] = [
                    'title' => $episode->post_title,
                    'metadata' => $utl->meta(['players']),
                    'id' => $episode->ID,
                    'url' => get_post_permalink($episode->ID),
                    'published' => human_time_diff(get_the_time('U', $episode)) . ' Ago',
                ];
            endforeach;
        endif;

        wp_reset_postdata();

        return $result;
    }

    public function next_episode()
    {
        $episode = get_posts([
            'post_type' => 'episode',
            'post_status' => 'future',
            'meta_query' => [
                [
                    'key' => 'kiranime_episode_parent_id',
                    'value' => $this->anime,
                    'compare' => '=',
                ],
            ],
            'posts_per_page' => 1,
            'no_found_rows' => true,
        ]);

        if (!isset($episode) || empty($episode)) {
            return false;
        }

        return [
            'scheduled' => isset($episode[0]->post_date_gmt) ? $episode[0]->post_date_gmt : '',
        ];
    }

    /**
     * get the latest episode of current anime
     *
     * @return null|Array null if doesn't have episodes, array if has episode. array data => metadata, title, id, url
     */
    public function latest_episode()
    {
        $latest = get_posts([
            'post_type' => 'episode',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'meta_value_num',
            'meta_key' => 'kiranime_episode_number',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => 'kiranime_episode_parent_id',
                    'value' => $this->anime,
                ],
            ],
        ]);

        if (!$latest || count($latest) == 0) {
            return null;
        }

        $this->episode = new Kiranime_Episode($latest[0]->ID);
        $thumb = $this->episode->get_image();

        return [
            "metadata" => $this->episode->meta(),
            'title' => $latest[0]->post_title,
            'featured' => $thumb ? $thumb : $this->get_image('featured'),
            'url' => get_post_permalink($latest[0]),
        ];
    }

    /**
     * use for A-Z list withr regex search
     *
     * @param string $letter letter to get from
     * @param int $page page to get
     *
     * @return \WP_Query
     */
    public function letter(string $letter, int $page)
    {
        $params = '';
        $limit = get_theme_mod('__archive_count', 20);

        if ($letter == '0-9') {
            $params = "^[0-9]";
        } else if ($letter == 'other') {
            $params = "^[^a-zA-Z0-9]";
        } else if ($letter != 'All') {
            $params = "^[" . strtolower($letter) . $letter . "]";
        }

        $currentpage = $page - 1;

        add_filter('posts_where', [$this, 'regex'], 10, 2);
        $main = new WP_Query([
            'search_title' => $params,
            'post_type' => 'anime',
            'post_status' => 'publish',
            'order' => 'ASC',
            'orderby' => 'title',
            'posts_per_page' => $limit,
            'paged' => $currentpage,
        ]);
        remove_filter('posts_where', [$this, 'regex'], 10, 2);

        return $main;
    }

    /**
     * get anime by view count
     *
     * @param string $type view type to get from
     * @param int $total total anime to get
     *
     * @return array
     */

    public static function by_view(string $type = 'day', int $total = 10)
    {
        $suffix = '_kiranime_views';
        $meta_key = '';

        if ($type == 'month') {
            $meta_key = date('mY') . $suffix;
        } elseif ($type == 'week') {
            $meta_key = date('WY') . $suffix;
        } elseif ($type == 'total') {
            $meta_key = 'total' . $suffix;
        } else {
            $meta_key = date('dmY') . $suffix;
        }

        $args = [
            'post_type' => 'anime',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'meta_value_num',
            'meta_key' => $meta_key,
            'no_found_rows' => true,
            'posts_per_page' => $total,
        ];

        $queried = get_posts($args);
        $results = [];

        foreach ($queried as $index => $value) {
            $anime = new Self($value->ID);
            $results[] = [
                'featured' => $anime->get_image('featured'),
                'index' => $index,
                'title' => $value->post_title,
                'views' => get_post_meta($value->ID, $meta_key, true),
                'type' => Kiranime_Utility::get_taxonomy($value->ID, 'type'),
                'meta' => $anime->meta(),
                'slug' => $value->post_name,
                'id' => $value->ID,
                'url' => get_post_permalink($value->ID),
            ];
        }

        return $results;
    }

    /**
     * get anime from episode page using parent id
     *
     * @return array
     */
    public function as_parent()
    {
        $anime = get_post($this->anime);
        $meta = $this->meta();
        $type = Kiranime_Utility::get_taxonomy($this->anime, 'type');
        $attr = Kiranime_Utility::get_taxonomy($this->anime, 'anime_attribute');
        $image = $this->get_image();
        $result = [
            'title' => $anime->post_title,
            'synopsis' => $anime->post_content,
            'url' => get_post_permalink($this->anime),
            'featured' => $image['featured'],
            'metadata' => $meta,
            'type' => !is_wp_error($type) && count($type) != 0 ? $type[0] : null,
            'attribute' => !is_wp_error($attr) ? $attr : [],
            'episodes' => $this->episodes(),
            'id' => $anime->ID,
        ];

        return $result;
    }

    public static function by_title(string $query)
    {

        $search = new WP_Query([
            'keyword' => $query,
            'post_type' => 'anime',
            'order' => 'ASC',
            'orderby' => 'title',
            'posts_per_page' => 10,
        ]);

        $results = [];
        foreach ($search->posts as $post) {
            $utl = new Kiranime_Utility($post->ID);
            $anime_id = $utl->get_metadata('id');

            $results[] = [
                'title' => $post->post_title,
                'id' => $post->ID,
                'slug' => $post->post_name,
                'anime_id' => $anime_id,
                'episodes' => $utl->get_metadata('episodes'),
            ];
        }

        return ['data' => $results, 'status' => 200];
    }

    public static function search(string $query)
    {
        $search = new WP_Query([
            'post_type' => 'anime',
            'post_status' => 'publish',
            'keyword' => $query,
            'posts_per_page' => 10,
        ]);
        $data = '';
        foreach ($search->posts as $post) {
            $ann = new self($post->ID);
            $link = get_post_permalink($post);
            $images = $ann->get_image();
            $meta = $ann->meta();

            $featured = $images['featured'];
            $type = Kiranime_Utility::get_taxonomy($post->ID, 'type');

            $type = is_wp_error($type) ? 'TV' : $type[0]->name;
            $released = isset($meta) && isset($meta['aired']) ? $meta['aired'] : '?';
            $duration = isset($meta) && isset($meta['duration']) ? $meta['duration'] : '24m';
            $en = isset($meta) && isset($meta['native']) ? $meta['native'] : '-';

            $data .= '<a href="' . $link . '" class="w-full p-2 border-b border-dashed border-gray-400 border-opacity-30 flex gap-2">
                <div class="pb-17 relative overflow-hidden w-12 md:w-1/5 flex-shrink-0 flex-grow-0">
                    <img alt="' . $post->post_title . '" src="' . $featured . '" class="w-full h-full inset-0 absolute object-cover">
                </div>
                <div class="flex-auto group">
                    <h3 class="text-sm font-semibold line-clamp-1 leading-6 group-hover:text-sky-400">' . $post->post_title . '</h3>
                    <div class="text-xs text-opacity-90 line-clamp-1">' . $en . '</div>
                    <div class="flex items-center gap-1 text-xs">
                        <span>' . $released . '</span><i class="dot"></i>' . $type . '<i class="dot"></i><span>' . $duration . '</span>
                    </div>
                </div>
            </a>';
        }

        return ['data' => ['result' => $data], 'status' => 200];
    }

    public function regex($where, $wp_query)
    {
        global $wpdb;
        if ($search_term = $wp_query->get('search_title')) {
            $where .= ' AND ' . $wpdb->posts . '.post_title REGEXP ' . "'" . $search_term . "'";
        }
        return $where;
    }

    public static function featured(bool $archive = false, string $type = null, int $page = 1)
    {
        $total = $archive ? get_theme_mod('__featured_archive_count', 20) : get_theme_mod('__featured_count', 7);
        $queries = [
            'airing' => [
                'post_type' => 'anime',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => date('mY') . '_kiranime_views',
                'posts_per_page' => $total,
                'paged' => $page,
                'no_found_rows' => true,
                'tax_query' => [
                    [
                        'taxonomy' => 'status',
                        'field' => 'slug',
                        'terms' => ['airing'],
                    ],
                ],
            ],
            'favorite' => [
                'post_type' => 'anime',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'bookmark_count',
                'posts_per_page' => $total,
                'paged' => $page,
                'no_found_rows' => true,
            ],
            'popular' => [
                'post_type' => 'anime',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'total_kiranime_views',
                'posts_per_page' => $total,
                'paged' => $page,
                'no_found_rows' => true,
                'tax_query' => [
                    [
                        'taxonomy' => 'status',
                        'field' => 'slug',
                        'terms' => ['airing', 'completed'],
                    ],
                ],
            ],
        ];

        if (!$type) {
            $results = [];
            foreach ($queries as $name => $query) {
                $results[$name] = new WP_Query($query);
            }
            return $results;
        } else {
            return new WP_Query($queries[$type]);
        }
    }

    public static function __rest_vote_add(int $user_id = 0, int $anime_id = 0, int $value = 0)
    {
        $anime_vote_data = (string) get_post_meta($anime_id, 'kiranime_anime_vote_data', true);
        $result = [];

        if (!isset($anime_vote_data) || empty($anime_vote_data)) {
            $data = [];
            $data[] = [
                'user' => $user_id,
                'value' => $value,
            ];
            update_post_meta($anime_id, 'kiranime_anime_vote_data', json_encode($data));
            update_post_meta($anime_id, 'kiranime_anime_vote_sum', $value);
            $result = [
                'voted' => 1,
                'vote_score' => $value,
            ];

            return $result;
        }

        $parsed = json_decode($anime_vote_data);
        $total_voted = 0;
        $calculated = 0;
        $filter = array_filter($parsed, function ($val) use (&$user_id) {
            return $val->user == $user_id;
        });

        if (!empty($filter) || 0 < count($filter)) {
            $parsed = array_map(function ($val) use (&$user_id, &$value) {
                if ($val->user == $user_id) {
                    return [
                        'user' => $user_id,
                        'value' => $value,
                    ];
                } else {
                    return $val;
                }
            }, $parsed);
        } else {
            array_push($parsed, [
                'user' => $user_id,
                'value' => $value,
            ]);
        }

        $total_voted = count($parsed);
        foreach ($parsed as $vote) {
            $v = isset($vote->value) ? $vote->value : $vote['value'];
            $calculated = $calculated + $v;
        }

        update_post_meta($anime_id, 'kiranime_anime_vote_data', json_encode($parsed));
        update_post_meta($anime_id, 'kiranime_anime_vote_sum', round($calculated / $total_voted, 2));
        $result = [
            'voted' => $total_voted,
            'vote_score' => round($calculated / $total_voted, 2),
        ];

        return $result;
    }

    public static function vote_get(int $id)
    {
        $sum = get_post_meta($id, 'kiranime_anime_vote_sum', true);
        $voted = get_post_meta($id, 'kiranime_anime_vote_data', true);
        $voted = isset($voted) && $voted != '[]' ? json_decode($voted) : [];
        return [
            'vote_score' => isset($sum) ? $sum : 0,
            'voted' => isset($voted) && !empty($voted) ? count($voted) : 0,
        ];
    }

    public static function vote_check(int $id)
    {
        $user = get_current_user_id();
        if (!$user) {
            return ['status' => false];
        }

        $data = get_post_meta($id, 'kiranime_anime_vote_data', true);
        $data = isset($data) && $data != '[]' ? json_decode($data) : [];
        $search = isset($data) && !empty($data) ? array_values(array_filter($data, function ($val) use ($user) {
            return $val->user == $user;
        })) : [];

        if ($search && count($search) > 0) {
            return [
                'status' => true,
                'vote_data' => $search[0],
            ];
        } else {
            return [
                'status' => false,
                'vote_data' => false,
            ];
        }
    }

    public static function vote_html(int $id)
    {
        $check = Self::vote_check($id);
        $arr = [
            '1' => '<svg class="w-8 h-8" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path fill="#FCEA2B"
                            d="M36,13c-12.6823,0-23,10.3177-23,23c0,12.6822,10.3177,23,23,23c12.6822,0,23-10.3178,23-23 C59,23.3177,48.6822,13,36,13z" />
                    </g>
                    <g id="hair" />
                    <g id="skin" />
                    <g id="skin-shadow" />
                    <g id="line">
                        <circle cx="36" cy="36" r="23" fill="none" stroke="#000000" stroke-miterlimit="10"
                            stroke-width="2" />
                        <line x1="27" x2="45" y1="43" y2="43" fill="none" stroke="#000000"
                            stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                            stroke-width="2" />
                        <line x1="25" x2="30" y1="31" y2="31" fill="none" stroke="#000000"
                            stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                            stroke-width="2" />
                        <line x1="43" x2="48" y1="31" y2="31" fill="none" stroke="#000000"
                            stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                            stroke-width="2" />
                    </g>
                </svg>',
            '2' => '<svg class="w-8 h-8" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="36.0001" cy="36" r="22.9999" fill="#FCEA2B" />
                    </g>
                    <g id="hair" />
                    <g id="skin" />
                    <g id="skin-shadow" />
                    <g id="line">
                        <circle cx="36" cy="36" r="23" fill="none" stroke="#000000" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                        <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M45.8149,44.9293 c-2.8995,1.6362-6.2482,2.5699-9.8149,2.5699s-6.9153-0.9336-9.8149-2.5699" />
                        <path
                            d="M30,31c0,1.6568-1.3448,3-3,3c-1.6553,0-3-1.3433-3-3c0-1.6552,1.3447-3,3-3C28.6552,28,30,29.3448,30,31" />
                        <path
                            d="M48,31c0,1.6568-1.3447,3-3,3s-3-1.3433-3-3c0-1.6552,1.3447-3,3-3S48,29.3448,48,31" />
                    </g>
                </svg>',
            '3' => '<svg class="w-8 h-8" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <circle cx="36" cy="36" r="23" fill="#fcea2b" />
                    <path fill="#fff"
                        d="M50.595,41.64a11.5554,11.5554,0,0,1-.87,4.49c-12.49,3.03-25.43.34-27.49-.13a11.4347,11.4347,0,0,1-.83-4.36h.11s14.8,3.59,28.89.07Z" />
                    <path fill="#ea5a47"
                        d="M49.7251,46.13c-1.79,4.27-6.35,7.23-13.69,7.23-7.41,0-12.03-3.03-13.8-7.36C24.2951,46.47,37.235,49.16,49.7251,46.13Z" />
                </g>
                <g id="hair" />
                <g id="skin" />
                <g id="skin-shadow" />
                <g id="line">
                    <circle cx="36" cy="36" r="23" fill="none" stroke="#000" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" />
                    <ellipse cx="28.5684" cy="30.818" rx="3" ry="5.4038" />
                    <ellipse cx="43.4316" cy="30.8216" rx="3" ry="5.4038" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M50.595,41.64a11.5554,11.5554,0,0,1-.87,4.49c-12.49,3.03-25.43.34-27.49-.13a11.4347,11.4347,0,0,1-.83-4.36h.11s14.8,3.59,28.89.07Z" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M49.7251,46.13c-1.79,4.27-6.35,7.23-13.69,7.23-7.41,0-12.03-3.03-13.8-7.36C24.2951,46.47,37.235,49.16,49.7251,46.13Z" />
                </g>
                </svg>',
            '4' => '<svg class="w-8 h-8" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <circle cx="36" cy="36" r="23" fill="#fcea2b" />
                    <path fill="#fff"
                        d="M50.595,41.64a11.5554,11.5554,0,0,1-.87,4.49c-12.49,3.03-25.43.34-27.49-.13a11.4347,11.4347,0,0,1-.83-4.36h.11s14.8,3.59,28.89.07Z" />
                    <path fill="#fff"
                        d="M49.7251,46.13c-1.79,4.27-6.35,7.23-13.69,7.23-7.41,0-12.03-3.03-13.8-7.36C24.2951,46.47,37.235,49.16,49.7251,46.13Z" />
                </g>
                <g id="hair" />
                <g id="skin" />
                <g id="skin-shadow" />
                <g id="line">
                    <circle cx="36" cy="36" r="23" fill="none" stroke="#000" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M50.595,41.64a11.5554,11.5554,0,0,1-.87,4.49c-12.49,3.03-25.43.34-27.49-.13a11.4347,11.4347,0,0,1-.83-4.36h.11s14.8,3.59,28.89.07Z" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M49.7251,46.13c-1.79,4.27-6.35,7.23-13.69,7.23-7.41,0-12.03-3.03-13.8-7.36C24.2951,46.47,37.235,49.16,49.7251,46.13Z" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-miterlimit="10"
                        stroke-width="2" d="M31.6941,32.4036a4.7262,4.7262,0,0,0-8.6382,0" />
                    <path fill="none" stroke="#000" stroke-linecap="round" stroke-miterlimit="10"
                        stroke-width="2" d="M48.9441,32.4036a4.7262,4.7262,0,0,0-8.6382,0" />
                </g>
                </svg>',
            '5' => '<svg class="w-8 h-8" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <circle cx="36" cy="36" r="23" fill="#FCEA2B" />
                    <path fill="#D22F27"
                        d="M26.4992,27.4384c-1.2653-3.3541-6.441-3.5687-6.1168,1.3178c0.0431,0.6485,0.281,1.2724,0.6414,1.8135 l5.3179,6.4224l0,0l5.2212-6.266c0.5796-0.6964,0.9224-1.5779,0.905-2.4853c-0.0863-4.3523-5.0509-4.0351-6.1274-0.8036" />
                    <path fill="#D22F27"
                        d="M45.8012,27.4384c-1.2547-3.3541-6.3873-3.5687-6.0658,1.3178c0.0428,0.6485,0.2787,1.2724,0.6361,1.8135 l5.2737,6.4224l0,0l5.1777-6.266c0.5747-0.6964,0.9147-1.5779,0.8974-2.4853c-0.0856-4.3523-5.0089-4.0351-6.0763-0.8036" />
                    <path fill="#FFFFFF"
                        d="M48.5859,42.6735c0,5.6296-4.1784,10.1046-12.5541,10.1046c-8.3738,0-12.6069-4.4888-12.6069-10.1047 C23.4249,42.6734,36.4503,45.7045,48.5859,42.6735z" />
                </g>
                <g id="hair" />
                <g id="skin" />
                <g id="skin-shadow" />
                <g id="line">
                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10" stroke-width="2" d="M48.1113,44.5467" />
                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10" stroke-width="2" d="M23.934,44.5467" />
                    <circle cx="36" cy="36" r="23" fill="none" stroke="#000000" stroke-linecap="round"
                        stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" />
                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10" stroke-width="2"
                        d="M48.5859,42.6735c0,5.6296-4.1784,10.1046-12.5541,10.1046c-8.3738,0-12.6069-4.4888-12.6069-10.1047 C23.4249,42.6734,36.4503,45.7045,48.5859,42.6735z" />
                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10" stroke-width="2"
                        d="M26.4992,27.4384c-1.2653-3.3541-6.441-3.5687-6.1168,1.3178c0.0431,0.6485,0.281,1.2724,0.6414,1.8135l5.3179,6.4224l0,0 l5.2212-6.266c0.5796-0.6964,0.9224-1.5779,0.905-2.4853c-0.0863-4.3523-5.0509-4.0351-6.1274-0.8036" />
                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10" stroke-width="2"
                        d="M45.8012,27.4384c-1.2547-3.3541-6.3873-3.5687-6.0658,1.3178c0.0428,0.6485,0.2787,1.2724,0.6361,1.8135l5.2737,6.4224l0,0 l5.1777-6.266c0.5747-0.6964,0.9147-1.5779,0.8974-2.4853c-0.0856-4.3523-5.0089-4.0351-6.0763-0.8036" />
                </g>
                </svg>',
        ];

        $result = '';
        foreach ($arr as $key => $val):
            if (empty($check['vote_data'])) {
                $result .= '<span data-vote-anime="' . $key . '" data-vote-anime-id="' . $id . '"class="p-2 w-1/5 hover:bg-white hover:bg-opacity-10 cursor-pointer flex items-center justify-center ">' . $val . '</span>';
            } else {
                if ($key == $check['vote_data']->value) {
                    $result .= '<span data-vote-anime="' . $key . '" data-vote-anime-id="' . $id . '"class="p-2 w-1/5 bg-white bg-opacity-20 cursor-pointer flex items-center justify-center ">' . $val . '</span>';
                } else {
                    $result .= '<span data-vote-anime="' . $key . '" data-vote-anime-id="' . $id . '"class="p-2 w-1/5 hover:bg-white hover:bg-opacity-10 opacity-30 cursor-pointer flex items-center justify-center ">' . $val . '</span>';
                }
            }
        endforeach;

        return $result;
    }
}