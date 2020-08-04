<div id="matchid-<?=$match->matchid?>" class="match-item row">
    <!--match info-->
    <div class="esport-league-watch-live col-sm-6">
        <div class="esport-league row">
            <div class="col-sm-2 float-sm-left">
                <img width="50" height="50" src="<?=$logo?>" class="attachment-full size-full">
            </div>
            <div class="col-sm-10 float-sm-left">
                <span class="tournament-title"><?=$match->tournament?></span>
                <br>
                <small><?=date('Y-m-d H:i', $match->timestamp)?></small>
                <?php 
                    if (!empty($match->streamLink1)):
                        self::display_watch_live($match->streamLink1);
                    endif;
                    if (!empty($match->streamLink2)):
                        self::display_watch_live($match->streamLink2);
                    endif;
                    ?>
            </div>
        </div>
    </div>

    <div class="teams-match-info col-sm-6">
        <div class="row">
            <!--team1 info-->
            <div class="esport-match-opponent-1 col-sm-5">
                <div class="row">
                    <!--name-->
                    <div class="col-6">
                        <h3 class="team-title"><?=$match->nameOpponent1?></h3>
                        <?php if ( !empty($match->opponentFlag1) ): ?>
                        <img class="team-country-flag"
                            src="<?=plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.mb_strtolower($match->opponentFlag1).'.png')?>">
                        <?php endif; ?>
                    </div>
                    <!--logo-->
                    <div class="col-3">
                        <?php if ( !empty($match->opponent1Logo) ): ?>
                        <img width=50px; height=50px; class="team-logo" scr="<?=$match->opponent1Logo?>">
                        <?php else: ?>
                        <img width=50px; height=50px; class="team-logo"
                            scr="<?=plugins_url('esportsgenies-api-shortcodes/inc/teaqm-no-logo.png')?>">
                        <?php endif; ?>
                    </div>
                    <!--bet-->
                    <div class="col-3">
                        <span class="team-prop esport-kf-bet"><?=$match->betOpponent1?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span title="<?=$match->winProbabilityOpponent1?>"
                            class="team-prop win"><?=$match->betOpponent1?></span>
                    </div>
                </div>
            </div>
            <!--delimeter-->
            <div class="esport-match-icon col-sm-2">
                <div class="elementor-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
            </div>
            <!--team2 info-->
            <div class="esport-match-opponent-2 col-sm-5">
                <div class="row">
                    <div class="col-3">
                        <span class="team-prop esport-kf-bet"><?=$match->betOpponent2?></span>
                    </div>
                    <div class="col-3">
                        <?php if ( !empty($match->opponent2Logo) ): ?>
                        <img width=50px; height=50px; class="team-logo" scr="<?=$match->opponent2Logo?>">
                        <?php else: ?>
                        <img width=50px; height=50px; class="team-logo"
                            scr="<?=plugins_url('esportsgenies-api-shortcodes/inc/teaqm-no-logo.png')?>">
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <h3 class="team-title"><?=$match->nameOpponent2?></h3>
                        <?php if ( !empty($match->opponentFlag2) ): ?>
                        <img class="team-country-flag"
                            src="<?=plugins_url('esportsgenies-api-shortcodes/inc/famfamfam_flag_icons/png/'.mb_strtolower($match->opponentFlag2).'.png')?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <span class="team-prop"><?=$match->betOpponent2?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>