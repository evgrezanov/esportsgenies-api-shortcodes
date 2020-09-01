<?php

defined('ABSPATH') || exit;

class UpcomingMatches {
    public static $leagues = [];

    public static $streamers = [];
     
    public static function init (){
        add_shortcode( 'upcoming-matches', [__CLASS__, 'render_shortcode'] );
    }

    public static function render_shortcode(){
        //if ( is_tax('esport') ):
            //http://api.esport-api.com/?token={{TOKEN}}&status={{STATUS}}&game={{ESPORT}}
            $game = get_queried_object()->slug;
            $game = 'lol';
            $esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' );
            $url = $esportsgenies_options_options['api_url_0'];
            $token = $esportsgenies_options_options['token_1'];
            if (!empty($token)) {         
                $url .= '?token=' . $token;
            }
            $status = $esportsgenies_options_options['default_match_status_2'];
            if (!empty($status)) {
                $url .= '&status='.$status;
            }
            $match_date = $esportsgenies_options_options['default_match_date_3'];
            if (!empty($match_date) && $match_date != 'noDate'){
                $url .= '&date='.$match_date;
            }
            $url .= '&game='.$game;
            $request = wp_remote_get($url);

            if( is_wp_error( $request ) ) :
                return false; // Bail early
            endif;

            $body = wp_remote_retrieve_body( $request );

            $matches = json_decode( $body );

            if( ! empty($matches) ) :
                $logo = get_term_meta( get_queried_object()->term_id, 'logo', true );
                $logo_game = wp_get_attachment_image_url( $logo, 'full' );
                $nologo = plugins_url('esportsgenies-api-shortcodes/inc/teamnoavatar.png');
                ob_start(); ?>
<div class="upcoming-matches-by-game">
    <?php foreach( $matches as $match ) { ?>
    <?php 
                        if ( !empty($betOpponent1 = $match->betOpponent1) && !empty($betOpponent2 = $match->betOpponent2) ): 
                            $betOpponent1Class = '';
                            $betOpponent2Class = '';
                            if ($betOpponent1 > $betOpponent2): $betOpponent2Class = 'green'; endif;
                            if ($betOpponent1 < $betOpponent2): $betOpponent1Class = 'green'; endif;
                        ?>
    <div id="matchid-<?=$match->matchid?>" class="match-item row">
        <nav style="display:none;" id="betting-menu"></nav>
        <!--match league info-->
        <div class="esport-league-watch-live col-sm-4">
            <div class="esport-league row">
                <div class="col-sm-3 float-sm-left">
                    <img width="50" height="50" src="<?=$logo_game?>" class="attachment-full size-full">
                </div>
                <div class="col-sm-9 float-sm-left">
                    <span class="tournament-title"><?=$match->tournament?></span>
                    <br>
                    <small class="match-date-time"><?=date('Y-m-d H:i', $match->timestamp)?></small>
                    <?php if (!empty($match->streamLink1)) : ?>
                    <a class="wath-live-link" href="<?=$match->streamLink1?>">WATCH LIVE</a>
                    <?php endif; ?>
                    <?php if (!empty($match->streamLink2)) : ?>
                    <a class="wath-live-link" href="<?=$match->streamLink1?>">WATCH LIVE 2</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--match team info-->
        <div class="teams-match-info col-sm-6">
            <div class="row">
                <!--team1 info-->
                <div class="esport-match-opponent-1 col-sm-5">
                    <div class="row float-sm-right">
                        <!--name-->
                        <div class="col-sm-6">
                            <div class="team1 team-name">
                                <?=$match->nameOpponent1?>
                                <?php if ( !empty($match->opponentFlag1) ): ?>
                                <img class="team-country-flag"
                                    src="<?=plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.mb_strtolower($match->opponentFlag1).'.png')?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--odds-->
                        <div class="col-sm-6">
                            <div class="team1 team-odds" title="<?=$match->winProbabilityOpponent1?>"
                                class="team-prop esport-kf-bet <?=$betOpponent1Class?>">
                                <?=$match->betOpponent1?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--delimeter-->
                <div class="esport-match-icon col-sm-2">
                    <div class="elementor-icon">
                        <i class="fas fa-crosshairs"></i>
                    </div>
                </div>
                <!--team2 info-->
                <div class="esport-match-opponent-2 col-sm-5">
                    <div class="row float-sm-left">
                        <!--odds-->
                        <div class="col-sm-6">
                            <div class="team2 team-odds" title="<?=$match->winProbabilityOpponent2?>"
                                class="team-prop esport-kf-bet <?=$betOpponent2Class?>">
                                <?=$match->betOpponent2?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="team2 team-name">
                                <?=$match->nameOpponent2?>
                                <?php if ( !empty($match->opponentFlag2) ): ?>
                                <img class="team-country-flag"
                                    src="<?= plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.mb_strtolower($match->opponentFlag2).'.png')?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--all offers-->
        <div class="all-offers-link col-sm-2">
            <div class="all-offers-link">
                <a id="matchid-<?=$match->matchid?> class=" js-slideout-toggle" href="#">All offers</a>
            </div>
        </div>
    </div>
    <?php 
                        endif; ?>
    <?php } ?>
</div>

<?php                                
            else:
                ?> <h3 class="api-error-msg">No have upcoming matches</h3> <?php
            endif;
        //else: ?>
<!--<h3 class="api-error-msg">Use this shortcode at esport archive page, esport page slug should = game in API.</h3>-->
<?php     
        //endif;            
        return ob_get_clean();

    }

    public static function display_player($match, $team){
        if ( get_queried_object()->slug == 'csgo' && !empty($match) ):
            for ( $i=1; $i<=5; $i++){
                ?>
<ul>
    <?php
                $team_name = 'nameOpponent'.$team;
                $player = $team_name.'Player'.$i;
                if ( !empty($match->$player) ):
                    echo '<li>'.$match->$player.'</li>';
                else:
                    echo '<li>'.$player.'</li>';
                endif;
                ?>
</ul>
<?php
    }
endif;
}

}

UpcomingMatches::init();

?>