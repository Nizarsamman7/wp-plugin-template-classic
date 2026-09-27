<?php
/**
 * Business details used by the shortcode.
 *
 * @package StudioServices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings → Studio Services.
 */
class Studio_Service_Settings {

	const OPTION = 'studio_services_settings';

	/**
	 * Bootstrap hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	/**
	 * @return array{business_name:string,phone:string,email:string}
	 */
	public static function get() {
		$stored = get_option( self::OPTION, array() );
		$defaults = array(
			'business_name' => get_bloginfo( 'name' ),
			'phone'         => '',
			'email'         => get_bloginfo( 'admin_email' ),
		);
		return wp_parse_args( is_array( $stored ) ? $stored : array(), $defaults );
	}

	/**
	 * Settings page under Settings.
	 */
	public static function menu() {
		add_options_page(
			__( 'Studio Services', 'studio-services' ),
			__( 'Studio Services', 'studio-services' ),
			'manage_options',
			'studio-services',
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Register the option.
	 */
	public static function register() {
		register_setting(
			'studio_services',
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * @param mixed $input Raw settings.
	 * @return array{business_name:string,phone:string,email:string}
	 */
	public static function sanitize( $input ) {
		$input = is_array( $input ) ? $input : array();
		return array(
			'business_name' => sanitize_text_field( $input['business_name'] ?? '' ),
			'phone'         => sanitize_text_field( $input['phone'] ?? '' ),
			'email'         => sanitize_email( $input['email'] ?? '' ),
		);
	}

	/**
	 * Settings form.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$settings = self::get();
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Studio Services', 'studio-services' ); ?></h1>
			<form action="options.php" method="post">
				<?php settings_fields( 'studio_services' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="studio_business_name"><?php echo esc_html__( 'Business name', 'studio-services' ); ?></label></th>
						<td><input name="<?php echo esc_attr( self::OPTION ); ?>[business_name]" id="studio_business_name" type="text" class="regular-text" value="<?php echo esc_attr( $settings['business_name'] ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="studio_phone"><?php echo esc_html__( 'Phone', 'studio-services' ); ?></label></th>
						<td><input name="<?php echo esc_attr( self::OPTION ); ?>[phone]" id="studio_phone" type="text" class="regular-text" value="<?php echo esc_attr( $settings['phone'] ); ?>" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="studio_email"><?php echo esc_html__( 'Email', 'studio-services' ); ?></label></th>
						<td><input name="<?php echo esc_attr( self::OPTION ); ?>[email]" id="studio_email" type="email" class="regular-text" value="<?php echo esc_attr( $settings['email'] ); ?>" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
