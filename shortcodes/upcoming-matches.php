<?php

defined('ABSPATH') || exit;

class UpcomingMatches {
    public static $status = 'upcoming';
     
    public static function init (){
        add_shortcode( 'upcoming-matches', [__CLASS__, 'render_shortcode'] );
    }

    public static function render_shortcode(){
        if ( is_tax('esport') ):
            //http://api.esport-api.com/?token={{TOKEN}}&status={{STATUS}}&game={{ESPORT}}
            $game = get_queried_object()->slug;
            //echo '<h3 class="api-error-msg">'.$game.'</h3>';
            //$token = get_option('api-token');
            //echo '<h3 class="api-error-msg">'.$token.'</h3>';
            //if ($game && $token):
                $url = 'http://api.esport-api.com/?token=ESPORTSGENIES24072020&status='.self::$status.'&game='.$game;
                $request = wp_remote_get($url);

                if( is_wp_error( $request ) ) :
                    return false; // Bail early
                endif;

                $body = wp_remote_retrieve_body( $request );

                $matches = json_decode( $body );

                if( ! empty( $matches ) ) :
                    ob_start();
                    ?>
<div class="upcoming-matches-by-game">
    <?php 
                                                                                                    foreach( $matches as $match ) { 
                                                                                                    ?>
    <div id="<?=$match->matchid?>" class="match-item row">
        <!--match-item-start-->
        <div class="esport-league-watch-live col-sm-6">

            <div class="esport-league">
                <h2 class="tournament-title"><?=$match->tournament?></h2>
                <small><?=date('Y-m-d H:i', $match->timestamp)?></small>
            </div>
            <!--esport-league-end-->

            <div class="esport-watch-live">
                <?php if (!empty($match->streamLink1)): ?>
                <a class="live-stream-link" style="color:red;" href="<?=$match->streamLink1 ?>">WATCH LIVE (link1)</a>
                <br>
                <?php endif; ?>
                <?php if (!empty($match->streamLink2)): ?>
                <a class="live-stream-link" style="color:red;" href="<?=$match->streamLink2 ?>">WATCH LIVE (link1)</a>
                <?php endif; ?>
            </div>
            <!--esport-watch-live-end-->

        </div>

        <div class="teams-match-info col-sm-6">
            <div class="row">
                <div class="esport-match-opponent-1 col-sm-5">
                    <h3 class="team-title">
                        <?=$match->nameOpponent1?>
                        <?php 
                            if ( !empty($match->opponentFlag1) ): 
                                $country_code = mb_strtolower($match->opponentFlag1);
                                $path = plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.$country_code.'.png');
                        ?>
                        <img class="team-country-flag" src="<?=$path?>">
                        <?php endif; ?>
                    </h3>

                    <?php if ( !empty($match->scoreOpponent1) ): ?>
                    <span class="team-prop">[<?=$match->scoreOpponent1?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->betOpponent1) ): ?>
                    <span class="team-prop">[<?=$match->betOpponent1?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->winProbabilityOpponent1) ): ?>
                    <span class="team-prop">[<?=$match->winProbabilityOpponent1?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->opponent1Logo) ): ?>
                    <span class="team-prop">[<?=$match->opponent1Logo?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->nameOpponent1Player1) && !empty($match->nameOpponent1Player5) ): ?>
                    <ul class="opponent-1-team">
                        <?php   
                                                                                                                                                for ( $i = 0; $i <= 5; $i++ ) {
                                                                                                                                                    self::display_player(1, $i, $match);
                                                                                                                                                }
                                                                                                                                            ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <!--esport-match-opponent-1 col-sm-5 end-->

                <div class="esport-match-icon col-sm-2">
                    <div class="elementor-icon">
                        <i aria-hidden="true" class="fas fa-trophy"></i>
                    </div>
                </div>

                <div class="esport-match-opponent-2 col-sm-5">
                    <h3 class="team-title">
                        <?=$match->nameOpponent2?>
                        <?php if ( !empty($match->opponentFlag2) ): 
                                                                                                                                                $country_code = mb_strtolower($match->opponentFlag2);
                                                                                                                                                $path = plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.$country_code.'.png');
                                                                                                                                            ?>
                        <img class="team-country-flag" src="<?=$path?>">
                        <?php endif; ?>
                    </h3>

                    <?php if ( !empty($match->scoreOpponent2) ): ?>
                    <span class="team-prop">[<?=$match->scoreOpponent2?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->betOpponent2) ): ?>
                    <span class="team-prop">[<?=$match->betOpponent2?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->winProbabilityOpponent2) ): ?>
                    <span class="team-prop">[<?=$match->winProbabilityOpponent2?>]</span>
                    <?php endif; ?>

                    <?php if ( !empty($match->opponent2Logo) ): ?>
                    <span class="team-prop">[<?=$match->opponent2Logo?>]</span>
                    <?php endif; ?>
                    <?php if ( !empty($match->nameOpponent2Player1) && !empty($match->nameOpponent2Player5) ): ?>
                    <ul class="opponent-2-team">
                        <?php   
                                                                                                                                            for ( $i = 0; $i <= 5; $i++ ) {
                                                                                                                                                self::display_player(2, $i, $match);
                                                                                                                                            } 
                                                                                                                                        ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <!--esport-match-opponent-2 col-sm-5 end-->

            </div>
        </div>
    </div>
    <!--match-item-end-->
    <hr>
    <?php } ?> </div> <?php
                                                
                else:
                    ?> <h3 class="api-error-msg">No have upcoming matches</h3> <?php
                endif;

            //else: 
            ?>
<!--<h3 class="api-error-msg">Check API parametrs, something wrong!</h3>-->
<?php
            //endif;
                
            return ob_get_clean();
        else: ?>
<h3 class="api-error-msg">Use this shortcode at esport archive page, esport page slug should = game in API.</h3>
<?php     
        endif;
    }

    public static function display_player($team_number, $player_number, $match){
        if ( !empty($team) && !empty($number) ):
            $team_name = 'nameOpponent'.$team_number;
            $player = $teamname.'Player'.$player_number;
            echo '<li>'.$match->$player.'</li>';
        endif;
    }
}

UpcomingMatches::init();

?>