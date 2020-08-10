<?php

defined('ABSPATH') || exit;

class NextMatch {
     
    public static function init (){
        add_shortcode( 'next-match', [__CLASS__, 'next_match'] );
    }


    public static function next_match(){
        if ( is_single('bookmakers') ):
            global $post;
            //https://api.esport-api.com/?token={{TOKEN}}&status=live
            $game = get_queried_object()->slug;
            $esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' );
            $url = $esportsgenies_options_options['api_url_0'];
            $token = $esportsgenies_options_options['token_1'];
            if (!empty($token)) {         
                $url .= '?token=' . $token;
            }

            $url .= '&status=live';

            if( is_wp_error( $request ) ) :
                return false; // Bail early
            endif;

            $body = wp_remote_retrieve_body( $request );

            $matches = json_decode( $body );

            if( !empty($matches) ) :
                $next_match = $matches[0];
                    ob_start(); ?>
<div class="card next-game" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">NEXT MATCH <a href="<?=get_post_meta($post->ID,'url',true)?>" BET NOW</a></h5>
        <h6 class="card-subtitle mb-2 text-muted"><?=$next_match->game?></h6>
        <p class="card-text">
            <?=$next_match->nameOpponent1?>VS<?=$next_match->nameOpponent2?>
        </p>
    </div>
</div>
<?php  
                    return ob_get_clean();
                     
            endif; 
        endif;
    }


}

NextMatch::init();

?>