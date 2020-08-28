<?php

defined('ABSPATH') || exit;

class Streamers {
     
    public static function init (){
        add_shortcode( 'esports-streamers', [__CLASS__, 'render_shortcode'] );
    }

    public static function get_streamer_name($url){
        if ( !empty($url) ):
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            return $query['channel'];
        endif;
    }

    public static function render_shortcode(){
        if ( is_tax('esport') ):
            //https://api.esport-api.com/?token={{TOKEN}}&date={{future}}&game={{ESPORT}}
            $game = get_queried_object()->slug;
            $esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' );
            $url = $esportsgenies_options_options['api_url_0'];
            $token = $esportsgenies_options_options['token_1'];
            if (!empty($token)) {         
                $url .= '?token=' . $token;
            }

            $url .= '&date=future';
           
            $url .= '&game='.$game;
            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) :
                return false; // Bail early
            endif;

            $body = wp_remote_retrieve_body( $request );

            $matches = json_decode( $body );

            if( !empty($matches) ) :
                $streamers = array();
                foreach( $matches as $match ) { 
                    if ( !empty($match->streamLink1) && !in_array($match->streamLink1, $streamers) ) : $streamers[] = $match->streamLink1; endif;
                    if ( !empty($match->streamLink2) && !in_array($match->streamLink2, $streamers) ) : $streamers[] = $match->streamLink2; endif;                         
                }
                if ( !empty($streamers) ):
                    ob_start(); ?>
<div class="streamers-by-game">

    <?php if ( !empty($streamers) ): ?>
    <h3 class="streamers-list-title">Streamers</h3>
    <ul class="streamers-list">
        <?php 
        foreach ($streamers as $streamer): 
            $name = self::get_streamer_name($streamer);
            if (!empty($name)):
        ?>
        <li class="streamer-title">
            <a href="<?=$streamer?>" targer="_blank" rel="nofollow"><?=self::get_streamer_name($streamer)?></a>
        </li>
        <?php 
        endif;
        endforeach;
    ?>
    </ul>
    <?php endif; ?>
</div>
<?php  
                    return ob_get_clean();
                endif;     
            endif; 
        endif;
    }


}

Streamers::init();

?>