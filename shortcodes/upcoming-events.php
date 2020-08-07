<?php

defined('ABSPATH') || exit;

class UpcomingEvents {
     
    public static function init (){
        add_shortcode( 'upcoming-events', [__CLASS__, 'render_shortcode'] );
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

            if( ! empty($matches) ) :
                ob_start(); ?>
<div class="upcoming-events-by-game">
    <div class="events-item row">
        <div class="col future events">
            <ul class="events-list">
                <?php 
                $all_events = array();
                $streamers = array();
                foreach( $matches as $match ) { 
                    if ( !empty($betOpponent1 = $match->betOpponent1) && !empty($betOpponent2 = $match->betOpponent2) ):
                        $tournament = $match->tournament;
                        if ( !in_array($tournament, $all_events) || empty($all_events) ):
                            $all_events[]= $tournament;
                        endif;
                        if ( !empty($match->streamLink1) && !in_array($match->streamLink1, $streamers) ) : $streamers[] = $match->streamLink1; endif;
                        if ( !empty($match->streamLink2) && !in_array($match->streamLink2, $streamers) ) : $streamers[] = $match->streamLink2; endif;
                ?>
                <li class="tournament-title"><?=$tournament?></li>
                <?php 
                         
                    endif; 
                } ?>
            </ul>
        </div>
        <?php if ( !empty($streamers) ): ?>
        <div class="col streamers">
            <ul class="streamers-list">
                <?php foreach ($streamers as $streamer): ?>
                <li class="streamer-title">
                    <a href="<?=$streamer?>" targer="_blank" rel="nofollow"><?=self::get_streamer_name($streamer)?></a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif; ?>?
    </div>
</div>

<?php                                
            else:
                ?> <h3 class="api-error-msg">No have upcoming events</h3> <?php
            endif;
        else: ?>
<h3 class="api-error-msg">
    Use this shortcode at esport archive page, esport page slug should = game in API.
</h3>
<?php     
        endif;            
        return ob_get_clean();
    }


}

UpcomingEvents::init();

?>