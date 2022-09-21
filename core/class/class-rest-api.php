<?php

/**
 * This is class for kiranime rest api endpoint
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */

class Kiranime_Endpoint extends WP_REST_Controller
{

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        $version = '1';
        $namespace = 'kiranime/v' . $version;
        register_rest_route($namespace, '/watchlist', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_watchlist'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'default' => 0,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                        'required' => true,
                    ],
                    'type' => [
                        'type' => 'string',
                        'default' => 'all',
                    ],
                    'per_page' => [
                        'type' => 'integer',
                        'default' => 20,
                    ],
                    'page' => [
                        'type' => 'integer',
                        'default' => 1,
                    ],
                ],
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'add_watchlist'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'type' => [
                        'type' => 'string',
                        'default' => 'all',
                    ],
                    'anime_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_watchlist'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'anime_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/auth/login', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'try_login'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'username' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_text_field($value);
                        },
                    ],
                    'password' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_text_field($value);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/auth/register', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'try_register'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'username' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_text_field($value);
                        },
                    ],
                    'password' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_text_field($value);
                        },
                    ],
                    'email' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_email($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_email($value);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/auth/logout', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'logout'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [],
            ],
        ]);
        register_rest_route($namespace, '/profile', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'change_avatar'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'avatar' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/anime/title', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_anime_title'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'query' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/anime/search', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'search_anime'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'query' => [
                        'type' => 'string',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_string($val);
                        },
                        'sanitize_callback' => function ($value, $request, $param) {
                            return sanitize_text_field($value);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/anime/vote', [
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'add_vote'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'anime_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'value' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/episode', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_current_episode'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($param, $request, $key) {
                            return is_numeric($param);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/episode/scheduled', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_scheduled_episode'],
                'permission_callback' => function () {
                    return true;
                },
                'args' => [
                    'day' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'month' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'year' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/notification', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_notification'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'check_notification'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'notification_id' => [
                        'type' => 'array',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_array($val);
                        },
                    ],
                ],
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_notification'],
                'permission_callback' => [$this, 'is_allowed'],
                'args' => [
                    'user_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                    'notification_id' => [
                        'type' => 'integer',
                        'required' => true,
                        'validate_callback' => function ($val) {
                            return is_numeric($val);
                        },
                    ],
                ],
            ],
        ]);
        register_rest_route($namespace, '/setting', [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'save_setting'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
                'args' => [],
            ],
        ]);
    }

    private function get_params(WP_REST_Request $request)
    {
        return !empty($request->get_json_params()) ? $request->get_json_params() : (!empty($request->get_query_params()) ? $request->get_query_params() : $request->get_body_params());
    }

    public function add_watchlist(WP_REST_Request $request)
    {
        ['user_id' => $user_id, 'anime_id' => $anime_id, 'type' => $type] = $this->get_params($request);

        $result = Kiranime_Watchlist::__rest_add_watchlist($user_id, $type, $anime_id);

        return new WP_REST_Response($result, 200);
    }

    public function get_watchlist(WP_REST_Request $request)
    {
        $params = $this->get_params($request);

        $watchlist = Kiranime_Watchlist::__rest_get_watchlist($params['user_id'], $params['type'], $params['page'], $params['per_page']);

        $result = null;
        $status = 500;
        if ($watchlist) {
            $result = $watchlist;
            $status = 200;
        }
        return new WP_REST_Response($result, $status);
    }

    public function delete_watchlist(WP_REST_Request $request)
    {
        ['user_id' => $user_id, 'anime_id' => $anime_id] = $this->get_params($request);

        $results = Kiranime_Watchlist::__rest_delete_watchlist($user_id, $anime_id);

        return new WP_REST_Response($results, 200);
    }

    public function try_login(WP_REST_Request $request)
    {
        $params = $this->get_params($request);

        $login = Kiranime_User::login($params['username'], $params['password']);

        return new WP_REST_Response($login['data'], $login['status']);
    }

    public function try_register(WP_REST_Request $request)
    {
        ['username' => $username, 'email' => $email, 'password' => $password, 'nonce' => $nonce] = $this->get_params($request);

        $register = Kiranime_User::register($email, $username, $password);

        return new WP_REST_Response($register['data'], $register['status']);
    }

    public function logout()
    {
        $l = Kiranime_User::logout();

        return new WP_REST_Response($l);
    }

    public function change_avatar(WP_REST_Request $request)
    {
        ['avatar' => $avatar, 'user_id' => $user_id] = $this->get_params($request);

        $change = Kiranime_User::set_avatar($avatar, $user_id);

        return new WP_REST_Response(['success' => $change['data']], $change['status']);
    }

    /**
     * anime REST Handler
     */
    public function add_vote(WP_REST_Request $request)
    {
        $params = $this->get_params($request);

        $set = Kiranime_Anime::__rest_vote_add($params['user_id'], $params['anime_id'], $params['value']);

        return new WP_REST_Response($set, 200);
    }

    public function get_anime_title(WP_REST_Request $request)
    {
        ['query' => $query] = $this->get_params($request);

        $results = Kiranime_Anime::by_title($query);

        return new WP_REST_Response($results['data'], $results['status']);
    }

    public function search_anime(WP_REST_Request $request)
    {
        ['query' => $query] = $this->get_params($request);

        $results = Kiranime_Anime::search($query);

        return new WP_REST_Response($results['data'], $results['status']);
    }

    /**
     * Episode REST Handler
     */

    public function get_current_episode(WP_REST_Request $request)
    {
        ['id' => $id] = $this->get_params($request);

        $data = Kiranime_Episode::get($id);
        return new WP_REST_Response($data['data'], $data['status']);

    }

    public function get_scheduled_episode(WP_REST_Request $request)
    {
        ['day' => $day, 'month' => $month, 'year' => $year] = $this->get_params($request);

        $scheduled = Kiranime_Episode::scheduled($day, $month, $year);

        return new WP_REST_Response($scheduled['data'], $scheduled['status']);
    }

    /**
     * Notifications REST Handler
     */

    public function get_notification(WP_REST_Request $request)
    {
        ['user_id' => $user_id] = $this->get_params($request);

        $nt = Kiranime_Notification::get(true, $user_id);

        return new WP_REST_Response($nt, 200);
    }

    public function check_notification(WP_REST_Request $reques)
    {
        ['user_id' => $user_id, 'notification_id' => $notification_id] = $this->get_params($reques);

        $nt = Kiranime_Notification::checked($notification_id, $user_id);

        return new WP_REST_Response($nt, 200);
    }

    public function delete_notification(WP_REST_Request $reques)
    {
        ['user_id' => $user_id, 'notification_id' => $notification_id] = $this->get_params($reques);

        $delete = Kiranime_Notification::delete($notification_id, $user_id);

        return new WP_REST_Response($delete['data'], $delete['status']);
    }

    public function save_setting(WP_REST_Request $request)
    {
        $params = $this->get_params($request);

        $result = Kiranime_Utility::save_setting($params);

        return new WP_REST_Response($result['data'], $result['status']);
    }

    public function is_allowed()
    {
        return current_user_can('read');
    }
}