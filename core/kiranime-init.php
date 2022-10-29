<?php

class Kiranime_Init
{
    public function __construct()
    {
        // config
        require_once KIRA_DIR . '/configuration/main_configuration.php';
        require_once KIRA_DIR . '/configuration/comments.php';

        // getter
        require_once KIRA_DIR . '/class/class-anime.php';
        require_once KIRA_DIR . '/class/class-episode.php';
        require_once KIRA_DIR . '/class/class-utility.php';
        require_once KIRA_DIR . '/class/class-query.php';
        require_once KIRA_DIR . '/class/class-watchlist.php';
        require_once KIRA_DIR . '/class/class-user.php';
        require_once KIRA_DIR . '/class/class-notification.php';
        require_once KIRA_DIR . '/class/class-rest-api.php';

        // metadata
        require_once KIRA_DIR . '/metadata/anime-info.php';
        require_once KIRA_DIR . '/metadata/episode-info.php';

        // post-type
        require_once KIRA_DIR . '/posttype.php';

        // taxonomies
        require_once KIRA_DIR . '/taxonomies.php';

        // widget
        require_once KIRA_DIR . '/widget/genre-list.php';
        require_once KIRA_DIR . '/widget/most-popular.php';
        require_once KIRA_DIR . '/widget/popular-list.php';

        // enqueue scripts
        add_action('wp_enqueue_scripts', [$this, '__enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, '__admin_scripts']);

        // add filter
        add_filter('nav_menu_css_class', [$this, '__nav_li_class'], 10, 4);
        add_filter('nav_menu_submenu_css_class', [$this, '__submenu_class'], 10, 3);
        add_filter('wp_nav_menu', [$this, '__nav_ul_class']);

        // remove default images
        add_filter('intermediate_image_sizes_advanced', [$this, '__remove_image_default']);

        // add image size
        add_action('after_setup_theme', [$this, '__setup']);

        // advanced search
        add_filter('query_vars', [$this, '__advanced_search_vars']);

        // add filter for search title
        add_filter('posts_where', [$this, 'title_filter'], 10, 2);

        // add filter for comments link
        add_filter('comment_form_logged_in', [$this, 'comment_link'], 10, 3);

        // redirect non logged in user
        add_action('template_redirect', [$this, 'unauthorized']);

        // initialize widget
        add_action('widgets_init', [$this, '__load_widget']);

        add_action('after_switch_theme', [$this, '__cek_ganti']);

        add_filter('use_block_editor_for_post_type', [$this, 'prefix_disable_gutenberg'], 10, 2);

        add_action('rest_api_init', function () {
            $routes = new Kiranime_Endpoint();
            $routes->register_routes();
        });

        // initialize required class
        new Kiranime_User;
    }

    /**
     * enqueue css and javascipts for kiranime theme
     * not all js is required, some js only required for some page.
     */
    public function __enqueue_scripts()
    {
        $files = ['app', 'tooltip', 'vueapp'];
        $episodes = ['episode', 'vote'];

        // required for entire site
        wp_enqueue_style('kiranime', KIRA_CSS . '/app.css', array(), KIRA_VER);
        wp_enqueue_script('kiranime-vendors', KIRA_JS . '/vendors.js', [], KIRA_VER, true);

        foreach ($files as $file) {
            wp_enqueue_script('kiranime-' . $file, KIRA_JS . '/' . $file . '.js', ['kiranime-vendors'], KIRA_VER, true);
        }

        // required only when slider is needed (homepage)
        if (is_home()) {
            wp_enqueue_script('kiranime-slider', KIRA_JS . '/slider.js', ['kiranime-vendors'], KIRA_VER, true);
        }

        // required only for single episode
        if (is_singular('episode')) {
            foreach ($episodes as $epjs) {
                wp_enqueue_script('kira-e-' . $epjs, KIRA_JS . '/' . $epjs . '.js', ['kiranime-vendors'], KIRA_VER, true);
            }
        }

        $js_translate = json_encode(Kiranime_Utility::get_js_translation());
        $lists = json_encode(Kiranime_Watchlist::get_types());
        $global_nonce = wp_create_nonce('wp_rest');
        $logout_nonce = wp_create_nonce('log-out');
        $loggedIn = is_user_logged_in();
        wp_add_inline_script('kiranime-vendors', 'const kiranime_translation =' . $js_translate . ';const watchlist_types = ' . $lists . ';const kiranime_endpoint = "' . get_bloginfo('url') . '/wp-json/kiranime/v1";const current_user_id = parseInt("' . get_current_user_id() . '");const user_action="' . $global_nonce . '";const logout_nonce="' . $logout_nonce . '";const isloggedIn = ' . json_encode($loggedIn) . ';', 'before');
    }

    public function __admin_scripts($hook)
    {
        preg_match('/kira-tools|toplevel_page/', $hook, $kira_tools, PREG_OFFSET_CAPTURE);
        // load css if $hook is creating anime or episode, or on grabber.
        if ($hook === 'post.php' || $hook === 'post-new.php' || count($kira_tools) !== 0) {
            wp_enqueue_style('kiranime-admin-css', KIRA_CSS . '/app.css', [], KIRA_VER);
            wp_enqueue_script('kiranime-vendors', KIRA_JS . '/vendors.js', [], KIRA_VER, true);
        }

        $global_nonce = wp_create_nonce('wp_rest');
        $js_translate = json_encode(Kiranime_Utility::get_js_translation());
        wp_add_inline_script('kiranime-vendors', 'const kiranime_translation =' . $js_translate . ';const kiranime_endpoint = "' . get_bloginfo('url') . '/wp-json/kiranime/v1";const current_user_id = parseInt("' . get_current_user_id() . '");const user_action = "' . $global_nonce . '";', 'before');

        if (count($kira_tools) !== 0) {
            wp_enqueue_script('kiranime-vue', KIRA_JS . '/vueapp.js', ['kiranime-vendors'], KIRA_VER, true);
        }

        // load vendor js and required javascript meta for new post or edit.
        if ($hook === 'post.php' || $hook === 'post-new.php') {
            global $post;
            if (in_array($post->post_type, ['anime', 'episode'])) {
                wp_enqueue_script('anime-admin', KIRA_JS . '/admin-anime.js', [], KIRA_VER, true);
                wp_enqueue_script('episode-admin', KIRA_JS . '/admin-episode.js', ['kiranime-vendors'], KIRA_VER, true);
            }
        }
    }

    /**
     * Adds option 'li_class' to 'wp_nav_menu'.
     *
     * @param string[]  $classes String of classes.
     * @param mixed   $item The curren item.
     * @param WP_Term $args Holds the nav menu arguments.
     *
     * @return array
     */
    public function __nav_li_class($classes, $item, $args, $depth)
    {
        if (isset($args->li_class)) {
            $classes[] = $args->li_class;
        }

        if (isset($args->{"li_class_$depth"})) {
            $classes[] = $args->{"li_class_$depth"};
        }

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active ';
        }

        if ($args->theme_location == 'header-menu') {
            $classes[] = 'nav-link';
        }

        return $classes;
    }

    /**
     * Adds option submenu class.
     *
     * @param string[]  $classes String of classes.
     * @param WP_Term $args Holds the nav menu arguments.
     * @param mixed   $depth The curren item.
     *
     * @return array
     */
    public function __submenu_class($classes, $args, $depth)
    {
        if (isset($args->submenu_class)) {
            $classes[] = $args->submenu_class;
        }

        if (isset($args->{"submenu_class_$depth"})) {
            $classes[] = $args->{"submenu_class_$depth"};
        }

        return $classes;
    }

    public function __nav_ul_class($ulclass)
    {
        return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
    }

    public function __remove_image_default($sizes)
    {
        unset($sizes['small']); // 150px
        unset($sizes['medium']); // 300px
        unset($sizes['large']); // 1024px
        unset($sizes['medium_large']); // 768px
        return $sizes;
    }

    public function __advanced_search_vars($vars)
    {
        $vars[] = 's_keyword';
        $vars[] = 's_genre';
        $vars[] = 's_type';
        $vars[] = 's_status';
        $vars[] = 's_season';
        $vars[] = 's_year';
        $vars[] = 's_orderby';
        $vars[] = 's_order';

        return $vars;
    }

    public static function title_filter($where, $wp_query)
    {
        global $wpdb;
        if ($search_term = $wp_query->get('keyword')) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\'';
        }
        return $where;
    }

    public function unauthorized()
    {
        if (is_page_template(['pages/notification.php', 'pages/profile.php', 'pages/continue-watching.php', 'pages/mal-import.php', 'pages/user.php', 'pages/watchlist.php', 'pages/setting.php']) && !is_user_logged_in()) {
            wp_redirect(home_url('/'));
            exit();
        }
    }

    public function __setup()
    {
        add_theme_support('title-tag');

        register_nav_menus(
            array(
                'footer' => 'Footer Menu',
                'header_side' => 'Header Side Menu',
                'landing_header' => 'Landing Header',
            )
        );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'caption',
            )
        );
        register_sidebar(array(
            'name' => 'Homepage Sidebar',
            'id' => 'homepage-sidebar',
            'description' => 'Show widget on homepage',
            'before_widget' => '',
            'after_widget' => '<div class="h-5"></div>',
            'before_title' => '<div class="text-2xl leading-10 font-semibold px-5 lg:p-0 m-0 text-accent-3 mb-4">',
            'after_title' => '</div>',
        ));
        register_sidebar(array(
            'name' => 'Anime Info Sidebar',
            'id' => 'anime-info-sidebar',
            'description' => 'Show widget on anime info',
            'before_widget' => '',
            'after_widget' => '<div class="h-5"></div>',
            'before_title' => '<div class="text-2xl leading-10 font-semibold px-5 lg:p-0 m-0 text-accent-3 mb-4">',
            'after_title' => '</div>',
        ));
        register_sidebar(array(
            'name' => 'Archive Sidebar',
            'id' => 'archive-sidebar',
            'description' => 'Show widget on archive',
            'before_widget' => '',
            'after_widget' => '<div class="h-5"></div>',
            'before_title' => '<div class="text-2xl leading-10 font-semibold px-5 lg:p-0 m-0 text-accent-3 mb-4">',
            'after_title' => '</div>',
        ));
        register_sidebar(array(
            'name' => 'Article Sidebar',
            'id' => 'article-sidebar',
            'description' => 'Show widget on article archive and single',
            'before_widget' => '',
            'after_widget' => '<div class="h-5"></div>',
            'before_title' => '<div class="text-2xl leading-10 font-semibold px-5 lg:p-0 m-0 text-accent-3 mb-4">',
            'after_title' => '</div>',
        ));
        add_theme_support('custom-logo', [
            'height' => '60',
            'width' => '300',
        ]);
        add_theme_support('post-thumbnails');

        add_theme_support('align-wide');
        add_theme_support('wp-block-styles');

        add_theme_support('editor-styles');
        add_editor_style('css/editor-style.css');
        load_theme_textdomain('kiranime', get_template_directory() . '/languages');

        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    public function __load_widget()
    {
        register_widget('Kiranime_Popular_List');
        register_widget('Kiranime_Genre_List');
        register_widget('Kiranime_Most_Popular');
    }

    public function __cek_ganti()
    {
        $this->__taxonomies();
        $this->__pages();

        return true;
    }

    private function __taxonomies()
    {
        $required_terms = [
            'status' => [
                'upcomming' => __('Upcomming', 'kiranime'),
                'airing' => __('Currently Airing', 'kiranime'),
                'completed' => __('Finished Airing', 'kiranime'),
                'not-yet-aired' => __('Not Yet Aired', 'kiranime'),
            ],
            'anime_attribute' => [
                'sub' => 'Sub',
                'latino' => 'Latino',
            ],
            'episode_type' => [
                'anime' => __('Anime', 'kiranime'),
                'movie' => __('Pelicula', 'kiranime'),
            ],
            'type' => [
                'ova' => 'OVA',
                'movie' => 'Movie',
                'ona' => 'ONA',
                'tv' => 'TV',
                'animeh' => 'AnimeH',
            ],
        ];

        foreach ($required_terms as $name => $terms) {
            foreach ($terms as $term_slug => $term_name) {
                $exist = get_term_by('slug', $term_slug, $name);

                if (!$exist) {
                    wp_insert_term($term_name, $name, [
                        'slug' => $term_slug,
                    ]);
                }
            }
        }
    }

    private function __pages()
    {
        $pages = [
            'profile' => __('Mi Perfil', 'kiranime'),
            'continue-watching' => __('Historial', 'kiranime'),
            'watchlist' => __('Listas', 'kiranime'),
            'setting' => __('Configuración', 'kiranime'),
            'notification' => __('Notifys', 'kiranime'),
            'recent-add' => __('Animes Recien Añadidos', 'kiranime'),
            'anime-upcomming' => __('Lo que se viene', 'kiranime'),
            'latest-update' => __('Ultimos capitulos', 'kiranime'),
            'advanced-search' => __('Busqueda avanzada', 'kiranime'),
            'top-airing' => __('Top Currently Airing', 'kiranime'),
            'most-popular' => __('Most Popular Anime', 'kiranime'),
            'most-favorite' => __('Most Favorite Anime', 'kiranime'),
            'az-list' => __('Busqueda de la A-Z', 'kiranime'),
            'homepage' => __('Inicio', 'kiranime'),
            'news' => __('Noticias', 'kiranime'),
        ];

        foreach ($pages as $page_template => $page_name) {
            $template = 'pages/' . $page_template . '.php';
            $exist = Kiranime_Utility::page_url($template);

            if (!$exist) {
                wp_insert_post([
                    'post_title' => $page_name,
                    'post_type' => 'page',
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_name' => $page_template,
                    'page_template' => $template,
                ]);
            }
        }
    }

    public function comment_link($html, $commenter, $user_identity)
    {
        $profile_page = Kiranime_Utility::page_url('pages/profile.php');
        $url = '<a href="' . $profile_page . '">$1</a>';
        return preg_replace('#<a href="[^"]*" aria-label="[^"]*">([^<]*)</a>#', $url, $html, 1);
    }

    public function prefix_disable_gutenberg($current_status, $post_type)
    {
        if (in_array($post_type, ['anime', 'episode'])) {
            return false;
        }

        return $current_status;
    }
}