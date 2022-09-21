<?php

/**
 * This is class for user related function
 *
 * @package   Kiranime
 * @version   1.0.0
 * @link      https://kiranime.moe
 * @author    Dzul Qurnain
 * @license   GPL-2.0+
 */

class Kiranime_User
{
    public function __construct()
    {}

    public static function login(string $username, string $password)
    {
        $info = [];
        $info['user_login'] = $username;
        $info['user_password'] = $password;

        $user_signon = wp_signon($info, '');
        if (is_wp_error($user_signon)) {
            return ['data' => ['status' => false, 'message' => __('Wrong username or password.', 'kiranime')], 'status' => 403];
        }

        return ['data' => ['status' => true, 'message' => __('Login successful, redirecting...', 'kiranime')], 'status' => 200];
    }

    public static function register(string $email, string $username, string $password)
    {
        $username_check = username_exists($username);
        $email_check = email_exists($email);

        $banned_username = ['admin', 'administrator'];

        if (in_array($username, $banned_username)) {
            return ['data' => ['success' => false, 'message' => __('Username not allowed!', 'kiranime')], 'status' => 400];
        }

        if ($username_check || $email_check) {
            return ['data' => ['success' => false, 'message' => __('Username or Email already exist!', 'kiranime')], 'status' => 400];
        }

        $created = wp_create_user($username, $password, $email);

        if (is_wp_error($created)) {
            return ['data' => ['success' => false, 'message' => $created->errors], 'status' => 500];
        }

        add_user_meta($created, 'kiranime_user_avatar', KIRA_URI . '/avatar/dragonball/av-db-1.jpeg');

        return ['data' => ['success' => true, 'message' => __('Register successful.', 'kiranime')], 'status' => 201];
    }

    public static function logout()
    {
        wp_logout();
        ob_clean();

        return ['status' => true, 200];
    }

    public static function save()
    {
        $params = isset($_POST['data']) ? json_decode(stripslashes($_POST['data'])) : [];
        $uid = get_current_user_id();

        if (!$params) {
            return wp_send_json_error(['message' => 'no data!', 'param' => $_POST]);
            wp_die();
        }

        foreach ($params as $data) {
            update_user_meta($uid, $data->name, $data->value);
        }

        return wp_send_json_success(['success' => true]);
        wp_die();
    }

    public static function get_avatar(int $uid = 0)
    {
        if (!$uid || $uid == 0) {
            return KIRA_URI . '/avatar/dragonball/av-db-1.jpeg';
        }

        $avatar = get_user_meta($uid, 'kiranime_user_avatar', true);

        if (!$avatar) {
            return KIRA_URI . '/avatar/dragonball/av-db-1.jpeg';
        } else {
            return $avatar;
        }
    }

    public static function set_avatar(string $avatar, int $user_id)
    {

        $updated = update_user_meta($user_id, 'kiranime_user_avatar', $avatar);
        if (!$updated) {
            return ['data' => false, 'status' => 500];
        } else {
            return ['data' => true, 'status' => 200];
        }
    }

    public static function list_avatar()
    {
        $avatars = [
            'chibi' => range(1, 19),
            'dragonball' => range(1, 6),
            'onepiece' => range(1, 12),
        ];

        $results = [
            'chibi' => [],
            'dragonball' => [],
            'onepiece' => [],
        ];

        foreach ($avatars as $name => $file) {
            $path = '';
            $ext = '';
            switch ($name) {
                case 'chibi':
                    $path = KIRA_URI . '/avatar/chibi/chibi_';
                    $ext = '.png';
                    break;
                case 'dragonball':
                    $path = KIRA_URI . '/avatar/dragonball/av-db-';
                    $ext = '.jpeg';
                    break;
                case 'onepiece':
                    $path = KIRA_URI . '/avatar/onepiece/user-';
                    $ext = '.jpeg';
                    break;
            }
            foreach ($file as $index) {
                $results[$name][] = $path . $index . $ext;
            }
        }

        return $results;
    }
}