<?php

defined('ABSPATH') || exit;

class eSportHelpers {
     
    public static function init (){
        add_shortcode( 'eg_display_rating', [__CLASS__, 'display_rating'] );
        add_shortcode( 'eg_display_button', [__CLASS__, 'display_button'] );
    }

    public static function display_rating($atts){
        $bookmaker_id = $atts['bookmaker'];
        $title = '<div class="book-bonus-title-home">'.get_the_title($bookmaker_id).'</div>';
        $rating = '<div class="book-bonus-rating-home">'.get_post_meta($bookmaker_id, 'rating', true).'</div>';
        return $title.$rating;
    }

    public static function display_button($atts){
        $bonus_id = $atts['bonus_id'];
        $ammount = get_post_meta($bonus_id, 'ammount', true);
        $currencies = get_post_meta($bonus_id, 'currencies', true);
        $url = get_post_meta($bonus_id, 'offer-url', true);
        
        $type = wp_get_post_terms( $bonus_id, 'bonus-type', array('fields' => 'names') );
        if ( $type ):
            $button = '<a class="elementor-button elementor-size-xs" role="button" href="'.$url.'">'.$ammount.$currencies.' '.$type[0].'</a>';
            return '<div class="go-to-partner">'.$button.'</div>';
        endif;
    }
}

eSportHelpers::init();