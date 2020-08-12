<?php

defined('ABSPATH') || exit;

class NextMatch {
    // api support this games
    public static $all_games = 'csgo|lol|dota|sc2|ow|hs|pubg|hots';

    // we need display this games
    public static $games = array('csgo','dota','lol');

    public static function init (){
        add_shortcode( 'next-match', [__CLASS__, 'next_match'] );
    }

    public static function get_next_matches_data(){
        $next_matches = array();
        //https://api.esport-api.com/?token={{TOKEN}}&status=live
        $esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' );
        $url = $esportsgenies_options_options['api_url_0'];
        $token = $esportsgenies_options_options['token_1'];

        if (!empty($token)) {         
            $url .= '?token=' . $token;
        }

        $url .= '&status=live';

        foreach (self::$games as $game):

            $newurl = $url.'&games='.$game;

            $request = wp_remote_get($newurl);

            if( is_wp_error( $request ) ) :
                return false;
            endif;

            $body = wp_remote_retrieve_body( $request );

            $matches = json_decode( $body );
            if( !empty($matches) ):
                $next_matches[]=$matches[0];
            endif;

        endforeach;
        return $next_matches;
    }

    public static function next_match(){
        if ( is_singular('bookmakers') ):
            global $post;
            $matches = self::get_next_matches_data();
            if( !empty($matches) ) :
                ob_start();?>
<div class="next-matches row">
    <?php
                foreach ($matches as $next_match):
                
                    if ($esport = get_term_by('slug', $next_match->game, 'esport')):
                        $esport_logo = get_term_meta( $esport->term_id, 'logo', true );
                        $logo_attributes = wp_get_attachment_image_src( $esport_logo, array(25,25) );
                        if (empty($esport->description)):
                            $esport_title = $esport->name;
                        else:
                            $esport_title = $esport->description;
                        endif;
                         ?>
    <div class="card next-game col" style="width: 18rem;">
        <div class="card-body next-match">
            <img src="<?=$logo_attributes[0]?>" width="<?=$logo_attributes[1]?>" height="<?=$logo_attributes[2]?>">
            <h5 class="card-title">NEXT MATCH <a href="<?=get_post_meta($post->ID,'url',true)?>"> BET NOW </a></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?=$esport_title?></h6>
            <div class="card-text">
                <span class="team1"><?=$next_match->nameOpponent1?></span>
                <span class="matsh-with">VS</span>
                <span class="team2"><?=$next_match->nameOpponent2?></span>
            </div>
        </div>
    </div>
    <?php  
                    endif;
                endforeach;
                ?>
</div>
<?php      
            endif;
            return ob_get_clean();
        endif;
    }


}

NextMatch::init();

?>