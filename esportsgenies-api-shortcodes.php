<?php

defined('ABSPATH') || exit;

/*
Plugin Name: esportsgenies api shortcodes 
Description: 
Author: Evgeniy Rezanov
Plugin URI: https://github.com/evgrezanov/esportsgenies-api-shortcodes
Version: 1.0.0
*/

//https://docs.google.com/document/d/1YSJbdzgZkqUeakxwKoujnoinwDf5pw3dN5AZXfywywA/edit

class esports_api_shortcode {

    public static function init() {
        //UPCOMING MATCHES by game
        //http://api.esport-api.com/?token=ESPORTSGENIES24072020&status=upcoming&game=lol
        require_once('shortcode/upcoming-matches.php');
    }
}