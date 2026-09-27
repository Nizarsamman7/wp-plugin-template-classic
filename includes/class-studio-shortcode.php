<?php
/**
 * Front-end service list.
 *
 * @package StudioServices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [studio_services] shortcode.
 */
class Studio_Service_Shortcode {

	/**
	 * Bootstrap hooks.
	 */
	public static function init() {
		add_shortcode( 'studio_services', array( __CLASS__, 'render' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	/**
	 * Load CSS only when the shortcode is present.
	 */
	public static function assets() {
		if ( ! is_singular() ) {
			return;
		}
		$post = get_post();
		if ( ! $post || ! has_shortcode( $post->post_content, 'studio_services' ) ) {
			return;
		}
		wp_enqueue_style(
			'studio-services',
			STUDIO_SERVICES_URL . 'assets/css/studio-services.css',
			array(),
			STUDIO_SERVICES_VERSION
		);
	}

	/**
	 * @param array|string $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'count' => 12,
			),
			$atts,
			'studio_services'
		);

		$query = new WP_Query(
			array(
				'post_type'      => Studio_Service_CPT::POST_TYPE,
				'posts_per_page' => max( 1, (int) $atts['count'] ),
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'no_found_rows'  => true,
			)
		);

		$settings = Studio_Service_Settings::get();
		ob_start();
		?>
		<section class="studio-services">
			<header class="studio-services__intro">
				<p class="studio-services__eyebrow"><?php echo esc_html( $settings['business_name'] ); ?></p>
				<h2><?php echo esc_html__( 'Services', 'studio-services' ); ?></h2>
			</header>
			<?php if ( ! $query->have_posts() ) : ?>
				<p><?php echo esc_html__( 'No services published yet.', 'studio-services' ); ?></p>
			<?php else : ?>
				<ul class="studio-services__list">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$price = get_post_meta( get_the_ID(), 'studio_service_price', true );
						?>
						<li class="studio-services__item">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="studio-services__media"><?php the_post_thumbnail( 'medium' ); ?></div>
							<?php endif; ?>
							<div>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if ( $price ) : ?>
									<p class="studio-services__price"><?php echo esc_html( $price ); ?></p>
								<?php endif; ?>
								<div class="studio-services__excerpt"><?php the_excerpt(); ?></div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			<?php if ( $settings['phone'] || $settings['email'] ) : ?>
				<p class="studio-services__contact">
					<?php if ( $settings['phone'] ) : ?>
						<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $settings['phone'] ) ); ?>"><?php echo esc_html( $settings['phone'] ); ?></a>
					<?php endif; ?>
					<?php if ( $settings['email'] ) : ?>
						<a href="<?php echo esc_url( 'mailto:' . $settings['email'] ); ?>"><?php echo esc_html( $settings['email'] ); ?></a>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</section>
		<?php
		wp_reset_postdata();
		return (string) ob_get_clean();
	}
}
