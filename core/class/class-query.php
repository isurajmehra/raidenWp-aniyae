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
                $this->base['post_type'] = 'anime';
                $this->base['meta_key'] = 'kiranime_anime_updated';
                $this->base['orderby'] = 'meta_value_num';
                $this->base['tax_query'] = [
                    [
                        'taxonomy' => 'type',
                        'field' => 'slug',
                        'terms' => ['tv', 'ona', 'mitico', 'movie', 'ova', 'music'],
                    ],
                ];
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
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => ['tv', 'ona', 'mitico', 'movie', 'ova', 'music'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function upcomming()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
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

    
    public function latino()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
        $this->base['orderby'] = 'kiranime_anime_updated';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'anime_attribute',
                'field' => 'slug',
                'terms' => ['latino'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function latino2()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
        $this->base['orderby'] = 'rand';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'anime_attribute',
                'field' => 'slug',
                'terms' => ['latino'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function haniyae()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 12;
        $this->base['meta_key'] = 'kiranime_anime_updated';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => ['animeh'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function haniyae2()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 12;
        $this->base['meta_key'] = 'rand';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => ['animeh'],
            ],
        ];

        return new WP_Query($this->base);
    }

    public function mitico()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
        $this->base['orderby'] = 'rand';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => ['mitico'],
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
    
    public function getUltimos()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 15;
        $this->base['orderby'] = 'meta_value_num';
        $this->base['meta_key'] = 'kiranime_anime_updated';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['airing', 'currently-airing'],
            ],
        ];

        return new WP_Query($this->base);
    }
    
    public function lastMovies()
    {
        $this->base['posts_per_page'] = $this->archive ? get_option('__archive_count', 20) : 8;
        $this->base['orderby'] = 'rand';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => ['movie'],
            ],
        ];

        return new WP_Query($this->base);
    }
    
    public function lunes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['lunes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function martes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['martes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function miercoles(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['miercoles'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function jueves(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['jueves'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function viernes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['viernes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function sabado(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['sabado'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function domingo(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['domingo'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_lunes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-lunes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_martes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-martes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_miercoles(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-miercoles'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_jueves(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-jueves'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_viernes(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-viernes'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_sabado(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-sabado'],
            ],
        ];

        return new WP_Query($this->base);
    }
    public function latino_domingo(){
        $this->base['posts_per_page'] = 20;
        $this->base['orderby'] = 'DESC';
        $this->base['tax_query'] = [
            [
                'taxonomy' => 'status',
                'field' => 'slug',
                'terms' => ['latino-domingo'],
            ],
        ];

        return new WP_Query($this->base);
    }
}