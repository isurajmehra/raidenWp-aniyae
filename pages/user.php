<?php

/**
 * Template Name: User
 *
 * @package Kiranime
 */
$url = Kiranime_Utility::page_url('pages/profile.php');
wp_redirect($url ? $url : '/');
