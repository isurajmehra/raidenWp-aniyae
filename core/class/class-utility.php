<?php

/**
 * This is class for various use needed by kiranime theme.
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */
class Kiranime_Utility
{
    private $anime = 0;
    private $episode = 0;

    public function __construct(int $anime_id = 0, int $episode_id = 0)
    {
        $this->anime = $anime_id;
        $this->episode = $episode_id;
    }

    public function get_metadata(string $meta, string $type = 'anime')
    {
        $data_type = $type === 'anime' ? 'kiranime_anime_' : 'kiranime_episode_';
        $data = '';
        $id = $type === 'anime' ? $this->anime : $this->episode;

        switch ($meta) {
            case 'download':
                $dl = get_post_meta($id, 'kiranime_download_data', true);
                $data = $dl ? json_decode($dl, true) : [];
                break;
            case 'players':
                $players = get_post_meta($id, 'kiranime_episode_players', true);
                $data = isset($players) ? json_decode(stripslashes($players), true) : [];
                break;
            default:
                $data = get_post_meta($id, $data_type . $meta, true);
                break;
        }

        return $data;
    }

    public static function get_taxonomy(int $id, string $tax = 'genre')
    {
        return wp_get_post_terms($id, $tax);
    }

    public static function page_url(string $template)
    {
        $url = null;
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template,
        ));
        if (isset($pages[0])) {
            $url = get_page_link($pages[0]->ID);
        }
        return $url;
    }

    public static function page_slug(string $template)
    {
        $pages = get_pages([
            'meta_key' => '_wp_page_template',
            'meta_value' => $template,
        ]);

        if (isset($pages[0])) {
            return $pages[0]->post_name;
        }

        return null;
    }

    public static function template(string $name, string $part = null)
    {
        if (!$name) {
            return null;
        }

        $templates = [
            'homepage' => ['template-parts/view/view', 'homepage'],
            'spotlight' => ['template-parts/display/slider', 'spotlight'],
            'trending' => ['template-parts/display/slider', 'trending'],
            'latest-anime' => ['template-parts/display/list', 'latest-anime'],
            'featured' => ['template-parts/display/list', 'featured'],
            'featured-news' => ['template-parts/display/list', 'featured-news'],
            'newly-added' => ['template-parts/display/list', 'newly-added'],
            'scheduled' => ['template-parts/display/list', 'scheduled'],
            'upcomming' => ['template-parts/display/list', 'upcomming'],
            'site' => ['template-parts/component/heading', 'site'],
            'user' => ['template-parts/component/heading', 'user'],
            'genre' => ['template-parts/component/list', 'genre'],
            'over-login' => ['template-parts/component/overlay', 'login'],
            'over-regis' => ['template-parts/component/overlay', 'register'],
            'share' => ['template-parts/component/share', 'button'],
            'grid' => ['template-parts/view/view', 'grid'],
            'archive' => ['template-parts/view/view', 'archive'],
            'news' => ['template-parts/view/view', 'news'],
            'single-anime' => ['template-parts/single/view', 'anime'],
            'single-episode' => ['template-parts/single/view', 'episode'],
            'single-news' => ['template-parts/single/view', 'news'],
            'ultimaData' => ['template-parts/view/view', 'ultimaData'],
        ];

        if ($part) {
            return get_template_part('template-parts/' . $part, $name);
        }

        return get_template_part($templates[$name][0], $templates[$name][1]);
    }

    public static function social()
    {
        $socials = [
            'telegram' => [
                'link' => get_option('__social_telegram'),
                'color' => '#0088cc',
                'vbox' => '0 0 496 512',
                'icon' => 'M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z',
            ],
            'discord' => [
                'link' => get_option('__social_discord'),
                'color' => '#7289da',
                'vbox' => '0 0 640 512',
                'icon' => 'M297.216 243.2c0 15.616-11.52 28.416-26.112 28.416-14.336 0-26.112-12.8-26.112-28.416s11.52-28.416 26.112-28.416c14.592 0 26.112 12.8 26.112 28.416zm-119.552-28.416c-14.592 0-26.112 12.8-26.112 28.416s11.776 28.416 26.112 28.416c14.592 0 26.112-12.8 26.112-28.416.256-15.616-11.52-28.416-26.112-28.416zM448 52.736V512c-64.494-56.994-43.868-38.128-118.784-107.776l13.568 47.36H52.48C23.552 451.584 0 428.032 0 398.848V52.736C0 23.552 23.552 0 52.48 0h343.04C424.448 0 448 23.552 448 52.736zm-72.96 242.688c0-82.432-36.864-149.248-36.864-149.248-36.864-27.648-71.936-26.88-71.936-26.88l-3.584 4.096c43.52 13.312 63.744 32.512 63.744 32.512-60.811-33.329-132.244-33.335-191.232-7.424-9.472 4.352-15.104 7.424-15.104 7.424s21.248-20.224 67.328-33.536l-2.56-3.072s-35.072-.768-71.936 26.88c0 0-36.864 66.816-36.864 149.248 0 0 21.504 37.12 78.08 38.912 0 0 9.472-11.52 17.152-21.248-32.512-9.728-44.8-30.208-44.8-30.208 3.766 2.636 9.976 6.053 10.496 6.4 43.21 24.198 104.588 32.126 159.744 8.96 8.96-3.328 18.944-8.192 29.44-15.104 0 0-12.8 20.992-46.336 30.464 7.68 9.728 16.896 20.736 16.896 20.736 56.576-1.792 78.336-38.912 78.336-38.912z',
            ],
            'reddit' => [
                'link' => get_option('__social_reddit'),
                'color' => '#ff4500',
                'vbox' => '0 0 512 512',
                'icon' => 'M201.5 305.5c-13.8 0-24.9-11.1-24.9-24.6 0-13.8 11.1-24.9 24.9-24.9 13.6 0 24.6 11.1 24.6 24.9 0 13.6-11.1 24.6-24.6 24.6zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-132.3-41.2c-9.4 0-17.7 3.9-23.8 10-22.4-15.5-52.6-25.5-86.1-26.6l17.4-78.3 55.4 12.5c0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.3 24.9-24.9s-11.1-24.9-24.9-24.9c-9.7 0-18 5.8-22.1 13.8l-61.2-13.6c-3-.8-6.1 1.4-6.9 4.4l-19.1 86.4c-33.2 1.4-63.1 11.3-85.5 26.8-6.1-6.4-14.7-10.2-24.1-10.2-34.9 0-46.3 46.9-14.4 62.8-1.1 5-1.7 10.2-1.7 15.5 0 52.6 59.2 95.2 132 95.2 73.1 0 132.3-42.6 132.3-95.2 0-5.3-.6-10.8-1.9-15.8 31.3-16 19.8-62.5-14.9-62.5zM302.8 331c-18.2 18.2-76.1 17.9-93.6 0-2.2-2.2-6.1-2.2-8.3 0-2.5 2.5-2.5 6.4 0 8.6 22.8 22.8 87.3 22.8 110.2 0 2.5-2.2 2.5-6.1 0-8.6-2.2-2.2-6.1-2.2-8.3 0zm7.7-75c-13.6 0-24.6 11.1-24.6 24.9 0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.1 24.9-24.6 0-13.8-11-24.9-24.9-24.9z',
            ],
            'facebook' => [
                'link' => get_option('__social_facebook'),
                'color' => '#1877f2',
                'vbox' => '0 0 512 512',
                'icon' => 'M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z',
            ],
            'twitter' => [
                'link' => get_option('__social_twitter'),
                'color' => '#1da1f2',
                'vbox' => '0 0 512 512',
                'icon' => 'M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z',
            ],
            'youtube' => [
                'link' => get_option('__social_youtube'),
                'color' => '#ff0000',
                'vbox' => '0 0 576 512',
                'icon' => 'M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z',
            ],
            'tumblr' => [
                'link' => get_option('__social_tumblr'),
                'color' => '#35465c',
                'vbox' => '0 0 320 512',
                'icon' => 'M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z',
            ],
        ];

        return $socials;
    }

    public static function is_social_active()
    {
        $s = ['telegram', 'facebook', 'twitter', 'tumblr', 'reddit', 'discord', 'youtube'];

        $active = false;
        foreach ($s as $a) {
            if (get_option('__social_' . $a)) {
                $active = true;
            }
        }

        return $active;
    }

    /**
     * get javascript translation
     */
    public static function get_js_translation()
    {
        return [
            'app_js' => [
                'app:64' => __('- Ver menos', 'kiranime'),
                'app:68' => __('+ Ver mas', 'kiranime'),
                'app:112' => __('Cargando...', 'kiranime'),
                'app:137' => __('Conectarme', 'kiranime'),
                'app:161' => __('La contraseña no coincide!', 'kiranime'),
                'app:181' => __('Algo malir sal..', 'kiranime'),
                'app:184' => __('Registro', 'kiranime'),
                'app:205' => __('Registro completo!', 'kiranime'),
                'app:206' => __('Iniciando..!', 'kiranime'),
                'app:209' => __('Regargando..', 'kiranime'),
                'app:441' => __('${1} - Episodio ${2} disponible AHORA!', 'kiranime'),
                'app:563' => __('Anime añadido a la lista.', 'kiranime'),
                'app:565' => __('Error al intentar añadirlo a la lista.', 'kiranime'),
                'app:591' => __('Configuracion guardada.', 'kiranime'),
                'app:608' => __('Identificado corectamente, redireccionando!', 'kiranime'),
            ],
            'avatar_upload_js' => [
                'avatar_upload:83' => __('Subiendo...', 'kiranime'),
                'avatar_upload:102' => __('Perdon, algo malir sal.', 'kiranime'),
                'avatar_upload:112' => __('El avatar ha sido cambiado.', 'kiranime'),
            ],
            'mal_import_js' => [
                'mal_import:12' => __('Error al conectar co MyAnimeList.', 'kiranime'),
                'mal_import:13' => __('Intenta de nuevo mas tarde.', 'kiranime'),
                'mal_import:71' => __('Importando...', 'kiranime'),
                'mal_import:84' => __('Importando...', 'kiranime'),
            ],
            'vote_js' => [
                'vote:31' => __('Error al enviar tu voto :(', 'kiranime'),
                'vote:51' => __('( ${1} Votaste)', 'kiranime'),
                'vote:52' => __('Voto enviado!', 'kiranime'),
            ],
            'vue_js' => [
                'vue_js:w9' => __('Todo', 'kiranime'),
                'vue_js:w32' => __('Anime no encontrado.', 'kiranime'),
                'vue_js:p37' => __('Modo teatro', 'kiranime'),
                'vue_js:p118' => __('Viendo ahora el', 'kiranime'),
                'vue_js:p122' => __('Episodio ${1}', 'kiranime'),
                'vue_js:p131' => __('Si el player no funciona, prueba con otro.', 'kiranime'),
                'vue_js:p157' => __('Sub titulado', 'kiranime'),
                'vue_js:p191' => __('Doblado', 'kiranime'),
                'vue_js:p218' => __('Se estima que el próximo episodio llegará a las', 'kiranime'),
                'vue_js:p384' => __('El anime ha sido eliminado.', 'kiranime'),
                'vue_js:wg181' => __('El anime ha sido eliminado.', 'kiranime'),
                'vue_js:wg183' => __('El anime ha sido movido.', 'kiranime'),
                'vue_js:wg187' => __('Se produjo un error!', 'kiranime'),
            ],
            'user_locale' => [
                'unit' => __('millisecond:|s,second:|s,minute:|s,hour:|s,day:|s,week:|s,month:|s,year:|s', 'kiranime'),
                'months' => __('Jan:uary|,Feb:ruary|,Mar:ch|,Apr:il|,May,Jun:e|,Jul:y|,Aug:ust|,Sep:tember|t|,Oct:ober|,Nov:ember|,Dec:ember|', 'kiranime'),
                'weekdays' => __('Sun:day|,Mon:day|,Tue:sday|,Wed:nesday|,Thu:rsday|,Fri:day|,Sat:urday|+weekend', 'kiranime'),
                'code' => __('en', 'kiranime'),
            ],
        ];
    }

    /**
     * translatable meta string
     */
    private static function translatable_meta_string()
    {
        $anime_meta = [
            __('Destacados', 'kiranime'),
            __('Calificado', 'kiranime'),
            __('Nativo', 'kiranime'),
            __('Sinónimos', 'kiranime'),
            __('Emitido', 'kiranime'),
            __('Estrenado', 'kiranime'),
            __('Duración', 'kiranime'),
            __('Episodios', 'kiranime'),
            __('Puntuación', 'kiranime'),
            __('Actualizado', 'kiranime'),
            __('Perfil', 'kiranime'),
            __('Continua viendo', 'kiranime'),
            __('Generos', 'kiranime'),
            __('Mi lista', 'kiranime'),
            __('Notificación', 'kiranime'),
            __('Importar de MAL', 'kiranime'),
        ];
    }

    public static function save_setting(array $param = [])
    {
        if (!$param) {
            return ['data' => ['saved' => false, 'error' => 'no options'], 'status' => 400];
        }

        foreach ($param as $key => $value) {
            update_option($key, $value);
        }

        return ['data' => ['saved' => true], 'status' => 200];
    }

    public static function download_and_save_remote_image(string $image_url, string $meta_name, int $post_id, string $type)
    {
        if (!$image_url) {
            return null;
        }

        if (strpos($image_url, get_bloginfo('wpurl')) === 0) {
            update_post_meta($post_id, $meta_name, $image_url);
        }

        $upload_dir = wp_upload_dir();
        $img_name = time() . '.jpg' . basename($image_url, '__kira_thumb');
        $img = wp_remote_get($image_url);
        if (is_wp_error($img)) {
            return null;
        } else {
            $img = wp_remote_retrieve_body($img);
            $fp = fopen($upload_dir['path'] . '/' . $img_name, 'w');
            fwrite($fp, $img);
            fclose($fp);

            $wp_filetype = wp_check_filetype($img_name, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $img_name),
                'post_content' => '',
                'post_status' => 'inherit',
            );

            //require for wp_generate_attachment_metadata which generates image related meta-data also creates thumbs
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $attach_id = wp_insert_attachment($attachment, $upload_dir['path'] . '/' . $img_name, $post_id);
            //Generate post thumbnail of different sizes.
            $attach_data = wp_generate_attachment_metadata($attach_id, $upload_dir['path'] . '/' . $img_name);
            wp_update_attachment_metadata($attach_id, $attach_data);

            if ($type === 'featured') {
                //Set as featured image.
                delete_post_meta($post_id, '_thumbnail_id');
                update_post_meta($post_id, '_thumbnail_id', $attach_id, true);
            } else {
                $attach_url = wp_get_attachment_url($attach_id);
                // update Background image
                delete_post_meta($post_id, $meta_name);
                update_post_meta($post_id, $meta_name, $attach_url);
            }

            return wp_get_attachment_url($attach_id);
        }
    }
}