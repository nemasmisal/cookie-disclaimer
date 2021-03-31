<?php

class CookieDisclaimerSettings
{
	private $cookie_disclaimer_settings_options;

	public function __construct()
	{
		add_action('admin_menu', array($this, 'cookie_disclaimer_settings_add_plugin_page'));
		add_action('admin_init', array($this, 'cookie_disclaimer_settings_page_init'));
	}

	public function cookie_disclaimer_settings_add_plugin_page()
	{
		add_menu_page(
			'Cookie Disclaimer', 
			'Cookie Disclaimer',
			'manage_options', 
			'cookie-disclaimer-settings',
			array($this, 'cookie_disclaimer_settings_create_admin_page'), 
			'dashicons-edit-large',
			80 
		);
	}

	public function cookie_disclaimer_settings_create_admin_page()
	{
		$this->cookie_disclaimer_settings_options = get_option('cookie_disclaimer_settings_option_name'); ?>

		<div class="wrap">
			<h2>Cookie Disclaimer</h2>
			<p>Settings Cookie Disclaimer</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields('cookie_disclaimer_settings_option_group');
				do_settings_sections('cookie-disclaimer-settings-admin');
				submit_button();
				?>
			</form>
		</div>
<?php }

	public function cookie_disclaimer_settings_page_init()
	{
		register_setting(
			'cookie_disclaimer_settings_option_group', 
			'cookie_disclaimer_settings_option_name', 
			array($this, 'cookie_disclaimer_settings_sanitize') 
		);

		add_settings_section(
			'cookie_disclaimer_settings_setting_section', 
			'Settings', 
			array($this, 'cookie_disclaimer_settings_section_info'), 
			'cookie-disclaimer-settings-admin' 
		);

		add_settings_field(
			'cookie_statement',
			'Cookie Statement', 
			array($this, 'cookie_statement_callback'), 
			'cookie-disclaimer-settings-admin',
			'cookie_disclaimer_settings_setting_section'  
		);

		add_settings_field(
			'site_ownership',
			'Site Ownership', 
			array($this, 'site_ownership_callback'), 
			'cookie-disclaimer-settings-admin', 
			'cookie_disclaimer_settings_setting_section'
		);

		add_settings_field(
			'accept_button', 
			'Accept Button', 
			array($this, 'accept_button_callback'), 
			'cookie-disclaimer-settings-admin',
			'cookie_disclaimer_settings_setting_section' 
		);

		add_settings_field(
			'link_to_policy', 
			'Link to policy',
			array($this, 'link_to_policy_callback'), 
			'cookie-disclaimer-settings-admin', 
			'cookie_disclaimer_settings_setting_section' 
		);
	}

	public function cookie_disclaimer_settings_sanitize($input)
	{
		$sanitary_values = array();
		if (isset($input['cookie_statement'])) {
				$sanitary_values['cookie_statement'] = esc_textarea($input['cookie_statement']);
		}

		if ( isset( $input['site_ownership'] ) ) {
		$sanitary_values['site_ownership'] = esc_textarea($input['site_ownership']);
		}

		if (isset($input['accept_button'])) {
			$sanitary_values['accept_button'] = sanitize_text_field($input['accept_button']);
		}

		if (isset($input['link_to_policy'])) {
			$sanitary_values['link_to_policy'] = sanitize_text_field($input['link_to_policy']);
		}

		return $sanitary_values;
	}

	public function cookie_disclaimer_settings_section_info()
	{
	}

	public function cookie_statement_callback()
	{
		printf(
			'<textarea rows="5" name="cookie_disclaimer_settings_option_name[cookie_statement]" id="cookie_statement">%s</textarea>',
			isset($this->cookie_disclaimer_settings_options['cookie_statement']) ? esc_attr($this->cookie_disclaimer_settings_options['cookie_statement']) : ''
		);
	}

	public function site_ownership_callback()
	{
		printf(
			'<textarea rows="5" name="cookie_disclaimer_settings_option_name[site_ownership]" id="site_ownership">%s</textarea>',
			isset($this->cookie_disclaimer_settings_options['site_ownership']) ? esc_attr($this->cookie_disclaimer_settings_options['site_ownership']) : ''
		);
	}

	public function accept_button_callback()
	{
		printf(
			'<input type="text" name="cookie_disclaimer_settings_option_name[accept_button]" id="accept_button" value="%s">',
			isset($this->cookie_disclaimer_settings_options['accept_button']) ? esc_attr($this->cookie_disclaimer_settings_options['accept_button']) : '',
			__( 'Accept and Close')
		);
	}

	public function link_to_policy_callback()
	{
		printf(
			'<input type="text" name="cookie_disclaimer_settings_option_name[link_to_policy]" id="link_to_policy" value="%s">',
			isset($this->cookie_disclaimer_settings_options['link_to_policy']) ? esc_attr($this->cookie_disclaimer_settings_options['link_to_policy']) : ''
		);
	}
}
if (is_admin())
	$cookie_disclaimer_settings = new CookieDisclaimerSettings();

/* 
 * Retrieve this value with:
 * $cookie_disclaimer_settings_options = get_option( 'cookie_disclaimer_settings_option_name' ); // Array of All Options
 * $cookie_statement = $cookie_disclaimer_settings_options['cookie_statement']; // Cookie Statement
 * $site_ownership = $cookie_disclaimer_settings_options['site_ownership']; // Site Ownership
 * $accept_button = $cookie_disclaimer_settings_options['accept_button']; // Accept Button
 * $link_to_policy = $cookie_disclaimer_settings_options['link_to_policy']; // Link to policy
 */
