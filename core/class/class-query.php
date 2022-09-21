<?php

/**
 * This is class for query post needed by kiranime theme.
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Query
{

    private $archive;
    private $base;
    private $id;
    private $tax;
    private $tax_id;
    private $per_page;
    private $paged;

    public function __construct(array $params = [])
    {
        $this->archive = isset($params['archive']) ? $params['archive'] : false;
        $this->id = isset($params['id']) ? $params['id'] : null;
        $this->tax = isset($params['taxonomy']) ? $params['taxonomy'] : '';
        $this->tax_id = isset($params['tax_id']) ? $params['tax_id'] : '';
        $this->per_page = isset($params['per_page']) ? $params['per_page'] : get_option('__archive_count', 20);
        $this->paged = isset($params['page']) ? $params['page'] : 1;

        $this->base = [
            'post_type' => 'anime',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'date',
            'meta_key' => '',
            'posts_per_page' => $this->per_page,
            'paged' => $this->paged,
        ];
    }

    public function latest()
    {
        $mode = get_option('__show_latest_by', 'anime');
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 12;
        $this->base['post_type'] = $mode;

        if ($mode === 'anime') {
            $this->base['orderby'] = 'meta_value_num';
            $this->base['meta_key'] = 'kiranime_anime_updated';
            $this->base['tax_query'] = [
                [
                    'taxonomy' => 'status',
                    'field' => 'slug',
                    'terms' => ['airing', 'completed'],
                ],
            ];
        }

        return new WP_Query($this->base);
    }

    public function news()
    {
        $this->base['post_type'] = 'post';
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 7;

        return new WP_Query($this->base);
    }

    public function trending()
    {
        $this->base['meta_key'] = date('mY') . '_kiranime_views';
        $this->base['posts_per_page'] = get_option('__show_trending_count', 10);

        return new WP_Query($this->base);
    }

    public function spotlight()
    {
        $this->base['posts_per_page'] = get_option('__show_spotlight_count', 10);
        $mode = get_option('__show_spotlight_by', 'popular');
        switch ($mode) {
            case 'popular':
                $this->base['meta_key'] = date('mY') . '_kiranime_views';
                $this->base['orderby'] = 'meta_value_num';
                break;

            case 'manual':
                $this->base['meta_key'] = 'kiranime_anime_updated';
                $this->base['orderby'] = 'meta_value_num';
                $this->base['meta_query'] = [
                    'relation' => 'AND',
                    [
                        'key' => 'kiranime_anime_spotlight',
                        'value' => 'true',
                    ],
                ];
                break;
        }

        return new WP_Query($this->base);
    }

    function new () {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 12;
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['airing', 'completed'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function upcomming()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 12;
        $this->base['orderby'] = 'date';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['upcomming', 'not-yet-aired'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function related()
    {
        $this->base['posts_per_page'] = 8;
        $this->base['post__not_in'] = [$this->id];
        $this->base['orderby'] = 'rand';
        $genres = Kiranime_Utility::get_taxonomy($this->id, 'genre');
        if (!is_wp_error($genres) && $genres) {
            $this->base['tax_query'] = [
                [
                    'taxonomy' => 'genre',
                    'field' => 'term_id',
                    'terms' => array_map(function ($val) {
                        return $val->term_id;
                    }, $genres),
                ],
            ];
        }

        return new WP_Query($this->base);
    }

    public function popular()
    {
        $this->base['meta_key'] = 'total_kiranime_views';
        $this->base['orderby'] = 'meta_value_num';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['airing', 'completed'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function taxonomy()
    {

        $this->base['tax_query'] = [
            [
                'taxonomy' => $this->tax,
                'field' => 'term_id',
                'terms' => $this->tax_id,
            ],
        ];
        $this->base['orderby'] = 'meta_value_num';
        $this->base['suppress_filters'] = true;
        $this->base['meta_key'] = 'kiranime_anime_updated';

        return new WP_Query($this->base);
    }
}