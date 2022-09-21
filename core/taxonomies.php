<?php

/**
 * registering all required taxonomy
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
function kiranime_register_taxonomy()
{
    $taxs = [
        [
            'name' => 'Genre',
            'slug' => 'genre',
            'post_type' => ['anime'],
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'rest_base' => 'genre',
            'rewrite' => 'genre',
        ],
        [
            'name' => 'Anime Attribute',
            'slug' => 'anime_attribute',
            'post_type' => ['anime'],
            'show_admin_column' => false,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'rest_base' => 'anime_attribute',
            'rewrite' => 'anime_attribute',
        ],
        [
            'name' => 'Episode Type',
            'slug' => 'episode_type',
            'post_type' => ['episode'],
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'rest_base' => 'episode_type',
            'rewrite' => 'episode_type',
        ],
        [
            'name' => 'Producer',
            'slug' => 'producer',
            'post_type' => ['anime'],
            'show_admin_column' => false,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'rest_base' => 'producer',
            'rewrite' => 'producer',
        ],
        [
            'name' => 'Studio',
            'slug' => 'studio',
            'post_type' => ['anime'],
            'show_admin_column' => false,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'rest_base' => 'studio',
            'rewrite' => 'studio',
        ],
        [
            'name' => 'Licensor',
            'slug' => 'licensor',
            'post_type' => ['anime'],
            'show_admin_column' => false,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'rest_base' => 'licensor',
            'rewrite' => 'licensor',
        ],
        [
            'name' => 'Anime Type',
            'slug' => 'type',
            'post_type' => ['anime'],
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'rest_base' => 'anime_type',
            'rewrite' => 'anime-type',
        ],
        [
            'name' => 'Status',
            'slug' => 'status',
            'post_type' => ['anime'],
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'hierarchical' => true,
            'rest_base' => 'anime_status',
            'rewrite' => 'status',
        ],
    ];
    foreach ($taxs as $tax) {
        $labels = [
            'name' => $tax['name'],
            'singular_name' => $tax['name'],
            'menu_name' => __($tax['name']),
        ];

        $config = [
            'hierarchical' => $tax['hierarchical'], // make it hierarchical (like categories)
            'labels' => $labels,
            'show_ui' => $tax['show_ui'],
            'show_admin_column' => $tax['show_admin_column'],
            'query_var' => true,
            'rewrite' => ['slug' => $tax['rewrite']],
            'show_in_rest' => $tax['show_in_rest'],
            'rest_base' => $tax['rest_base'],
        ];

        register_taxonomy($tax['slug'], $tax['post_type'], $config);
    }
}
add_action('init', 'kiranime_register_taxonomy');