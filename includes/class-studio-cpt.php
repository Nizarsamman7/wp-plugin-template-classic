<?php
/**
 * Service custom post type.
 *
 * @package StudioServices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the studio_service post type and price meta.
 */
class Studio_Service_CPT {

	const POST_TYPE = 'studio_service';

	/**
	 * Bootstrap hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( __CLASS__, 'save_price' ) );
	}

	/**
	 * Flush rewrite rules on activation.
	 */
	public static function activate() {
		self::register();
		flush_rewrite_rules();
	}

	/**
	 * Flush rewrite rules on deactivation.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Register the post type.
	 */
	public static function register() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'       => array(
					'name'          => __( 'Services', 'studio-services' ),
					'singular_name' => __( 'Service', 'studio-services' ),
					'add_new_item'  => __( 'Add service', 'studio-services' ),
					'edit_item'     => __( 'Edit service', 'studio-services' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => 'dashicons-hammer',
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
				'rewrite'      => array( 'slug' => 'services' ),
			)
		);
	}

	/**
	 * Price stored as a plain string so currency formatting stays in the theme.
	 */
	public static function register_meta() {
		register_post_meta(
			self::POST_TYPE,
			'studio_service_price',
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	/**
	 * Price field on the service edit screen.
	 */
	public static function add_meta_box() {
		add_meta_box(
			'studio_service_price',
			__( 'Price label', 'studio-services' ),
			array( __CLASS__, 'render_price_box' ),
			self::POST_TYPE,
			'side'
		);
	}

	/**
	 * @param WP_Post $post Current service.
	 */
	public static function render_price_box( $post ) {
		wp_nonce_field( 'studio_service_price', 'studio_service_price_nonce' );
		$value = get_post_meta( $post->ID, 'studio_service_price', true );
		echo '<label for="studio_service_price" class="screen-reader-text">' . esc_html__( 'Price label', 'studio-services' ) . '</label>';
		echo '<input type="text" id="studio_service_price" name="studio_service_price" class="widefat" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr__( 'From €49', 'studio-services' ) . '" />';
	}

	/**
	 * @param int $post_id Service ID.
	 */
	public static function save_price( $post_id ) {
		if ( ! isset( $_POST['studio_service_price_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['studio_service_price_nonce'] ) ), 'studio_service_price' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$price = isset( $_POST['studio_service_price'] ) ? sanitize_text_field( wp_unslash( $_POST['studio_service_price'] ) ) : '';
		update_post_meta( $post_id, 'studio_service_price', $price );
	}
}
