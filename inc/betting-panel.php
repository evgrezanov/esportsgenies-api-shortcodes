<?php

defined('ABSPATH') || exit;

class eSportPanel {

    public static function init (){
        add_action('wp_enqueue_scripts', [__CLASS__, 'panel_asset']);
        add_action('wp_footer', [__CLASS__, 'display_panel']);
    }
    
    public static function panel_asset(){
        $slideout_style  = plugins_url('esportsgenies-api-shortcodes/inc/slideout/slideout.css');
        wp_enqueue_style( 'slideout-style', $slideout_style );
        
        $slideout_script_min = plugins_url('esportsgenies-api-shortcodes/inc/slideout/slideout.min.js');
        wp_enqueue_script(
            'slideout-min-script',
            $slideout_script_min,
            [],
            '321',
            false
        );
        /*
        $slideout_script = plugins_url('esportsgenies-api-shortcodes/inc/slideout/slideout-init.js');
        wp_enqueue_script(
            'slideout-init',
            $slideout_script,
            ['slideout-min-script'],
            '123',
            false
        );*/
    }

    public static function display_panel(){
    ?>
<div id="betting-panel" class="betting-panel">
    <div></div>
</div>
<script>
window.onload = function() {
    var slideout = new Slideout({
        panel: document.getElementById("panel"),
        menu: document.getElementById("menu"),
        side: "right",
    });

    document
        .querySelector(".js-slideout-toggle")
        .addEventListener("click", function() {
            slideout.toggle();
        });

    document
        .querySelector(".menu")
        .addEventListener("click", function(eve) {
            if (eve.target.nodeName === "A") {
                slideout.close();
            }
        });
};
</script>
<?php
    }
}
eSportPanel::init();