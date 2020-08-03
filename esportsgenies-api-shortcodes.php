<?php

defined('ABSPATH') || exit;

/*
Plugin Name: eSportsgenies API shortcodes 
Description: API integration for api.esport-api.com for eSportsgenies.com
Author: Evgeniy Rezanov
Plugin URI: https://github.com/evgrezanov/esportsgenies-api-shortcodes
Version: 1.1.0
*/

//https://docs.google.com/document/d/1YSJbdzgZkqUeakxwKoujnoinwDf5pw3dN5AZXfywywA/edit

class esportsApiShortcodes {

    public static function init() {
        add_action('wp_enqueue_scripts', [__CLASS__, 'print_styles']);
        //UPCOMING MATCHES by game
        require_once('shortcodes/upcoming-matches.php');
    }

    public static function print_styles(){
        $style = plugins_url('esportsgenies-api-shortcodes/asset/style.css');
        wp_enqueue_style( 'esports-style', $style );
    }
}

esportsApiShortcodes::init();