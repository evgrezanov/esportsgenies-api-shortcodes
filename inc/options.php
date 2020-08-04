<?php

class ESportsgeniesOptions {
private $esportsgenies_options_options;

public function __construct() {
add_action( 'admin_menu', array( $this, 'esportsgenies_options_add_plugin_page' ) );
add_action( 'admin_init', array( $this, 'esportsgenies_options_page_init' ) );
}

public function esportsgenies_options_add_plugin_page() {
add_menu_page(
'eSportsgenies options', // page_title
'eSportsgenies options', // menu_title
'manage_options', // capability
'esportsgenies-options', // menu_slug
array( $this, 'esportsgenies_options_create_admin_page' ), // function
'dashicons-admin-home', // icon_url
5 // position
);
}

public function esportsgenies_options_create_admin_page() {
$this->esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' ); ?>

<div class="wrap">
    <h2>eSportsgenies options</h2>
    <p>
        <h2>PARAMETER "status"</h2>
        <ul>
            <li>"live" = all matches with status live</li>
            <li>"upcoming" = all matches with status upcoming</li>
            <li>"finished" = all matches with status finished</li>
            <li>"notlive" = all matches with status upcoming or finished</li>
            <li>"notupcoming" = all matches with status live or finished</li>
            <li>"notfinished" = all matches with status live or upcoming</li>
            <li>No status parameter = all matches from any status</li>
        </ul>
        <h2>PARAMETER "date"</h2>
        <ul>
            <li>Digit number in YYYYMMDD format = all matches at a specific date From the 1st of january 2018</li>
            <li>"yesterday" = all matches at date of yesterday</li>
            <li>"tomorrow" = all matches at date of tomorrow</li>
            <li>"allTime" = all matches from 1 month ago to 1 month in the future</li>
            <li>"future" = all matches from today to 1 month in the future</li>
            <li>"past" = all matches from 1 month ago to today</li>
            <li>"fromYesterday" = all matches from yesterday to 1 month in the future</li>
            <li>"toTomorrow" = all matches from 1 month ago to tomorrow</li>
            <li>"No date" parameter = all matches from the current day.</li>
        </ul>
    </p>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
					settings_fields( 'esportsgenies_options_option_group' );
					do_settings_sections( 'esportsgenies-options-admin' );
					submit_button();
				?>
    </form>
</div>
<?php }

	public function esportsgenies_options_page_init() {
		register_setting(
			'esportsgenies_options_option_group', // option_group
			'esportsgenies_options_option_name', // option_name
			array( $this, 'esportsgenies_options_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'esportsgenies_options_setting_section', // id
			'Settings', // title
			array( $this, 'esportsgenies_options_section_info' ), // callback
			'esportsgenies-options-admin' // page
		);

		add_settings_field(
			'api_url_0', // id
			'API URL', // title
			array( $this, 'api_url_0_callback' ), // callback
			'esportsgenies-options-admin', // page
			'esportsgenies_options_setting_section' // section
		);

		add_settings_field(
			'token_1', // id
			'Token', // title
			array( $this, 'token_1_callback' ), // callback
			'esportsgenies-options-admin', // page
			'esportsgenies_options_setting_section' // section
		);

		add_settings_field(
			'default_match_status_2', // id
			'Default match status', // title
			array( $this, 'default_match_status_2_callback' ), // callback
			'esportsgenies-options-admin', // page
			'esportsgenies_options_setting_section' // section
		);

		add_settings_field(
			'default_match_date_3', // id
			'Default match date', // title
			array( $this, 'default_match_date_3_callback' ), // callback
			'esportsgenies-options-admin', // page
			'esportsgenies_options_setting_section' // section
		);
	}

	public function esportsgenies_options_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['api_url_0'] ) ) {
			$sanitary_values['api_url_0'] = sanitize_text_field( $input['api_url_0'] );
		}

		if ( isset( $input['token_1'] ) ) {
			$sanitary_values['token_1'] = sanitize_text_field( $input['token_1'] );
		}

		if ( isset( $input['default_match_status_2'] ) ) {
			$sanitary_values['default_match_status_2'] = $input['default_match_status_2'];
		}

		if ( isset( $input['default_match_date_3'] ) ) {
			$sanitary_values['default_match_date_3'] = $input['default_match_date_3'];
		}

		return $sanitary_values;
	}

	public function esportsgenies_options_section_info() {
		
	}

	public function api_url_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="esportsgenies_options_option_name[api_url_0]" id="api_url_0" value="%s">',
			isset( $this->esportsgenies_options_options['api_url_0'] ) ? esc_attr( $this->esportsgenies_options_options['api_url_0']) : ''
		);
	}

	public function token_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="esportsgenies_options_option_name[token_1]" id="token_1" value="%s">',
			isset( $this->esportsgenies_options_options['token_1'] ) ? esc_attr( $this->esportsgenies_options_options['token_1']) : ''
		);
	}

	public function default_match_status_2_callback() {
		?> <select name="esportsgenies_options_option_name[default_match_status_2]" id="default_match_status_2">
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'all') ? 'selected' : '' ; ?>
    <option value="all" <?php echo $selected; ?>> All matches</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'upcoming') ? 'selected' : '' ; ?>
    <option value="upcoming" <?php echo $selected; ?>> Upcoming</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'live') ? 'selected' : '' ; ?>
    <option value="live" <?php echo $selected; ?>> Live</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'finished') ? 'selected' : '' ; ?>
    <option value="finished" <?php echo $selected; ?>> Finished</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'notlive ') ? 'selected' : '' ; ?>
    <option value="notlive " <?php echo $selected; ?>> Not live</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'notupcoming') ? 'selected' : '' ; ?>
    <option value="notupcoming" <?php echo $selected; ?>> Not upcoming</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_status_2'] ) && $this->esportsgenies_options_options['default_match_status_2'] === 'notfinished') ? 'selected' : '' ; ?>
    <option value="notfinished" <?php echo $selected; ?>> Not finished</option>
</select> <?php
	}

	public function default_match_date_3_callback() {
		?> <select name="esportsgenies_options_option_name[default_match_date_3]" id="default_match_date_3">
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'noDate') ? 'selected' : '' ; ?>
    <option value="noDate" <?php echo $selected; ?>> no Date</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'yesterday') ? 'selected' : '' ; ?>
    <option value="yesterday" <?php echo $selected; ?>> Yesterday</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'tomorrow') ? 'selected' : '' ; ?>
    <option value="tomorrow" <?php echo $selected; ?>> Tomorrow</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'allTime') ? 'selected' : '' ; ?>
    <option value="allTime" <?php echo $selected; ?>> allTime</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'future') ? 'selected' : '' ; ?>
    <option value="future" <?php echo $selected; ?>> future</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'past ') ? 'selected' : '' ; ?>
    <option value="past " <?php echo $selected; ?>> past</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'fromYesterday') ? 'selected' : '' ; ?>
    <option value="fromYesterday" <?php echo $selected; ?>> fromYesterday</option>
    <?php $selected = (isset( $this->esportsgenies_options_options['default_match_date_3'] ) && $this->esportsgenies_options_options['default_match_date_3'] === 'toTomorrow') ? 'selected' : '' ; ?>
    <option value="toTomorrow" <?php echo $selected; ?>> toTomorrow</option>
</select> <?php
	}

}
//if ( is_admin() )
	$esportsgenies_options = new ESportsgeniesOptions();

/* 
 * Retrieve this value with:
 * $esportsgenies_options_options = get_option( 'esportsgenies_options_option_name' ); // Array of All Options
 * $api_url_0 = $esportsgenies_options_options['api_url_0']; // API URL
 * $token_1 = $esportsgenies_options_options['token_1']; // Token
 * $default_match_status_2 = $esportsgenies_options_options['default_match_status_2']; // Default match status
 * $default_match_date_3 = $esportsgenies_options_options['default_match_date_3']; // Default match date
 */