<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Title: EMS e-Commerce integration
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.1.1
 * @since 1.0.0
 */
class Integration extends AbstractGatewayIntegration {
	/**
	 * Action URL.
	 * 
	 * @var string
	 */
	private $action_url;

	/**
	 * Construct EMS e-Commerce integration.
	 *
	 * @param array<string, mixed> $args Arguments.
	 */
	public function __construct( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'id'            => 'ems-ecommerce',
				'name'          => 'EMS e-Commerce',
				'action_url'    => Client::ACTION_URL_PRODUCTION,
				'provider'      => 'ems',
				'product_url'   => null,
				'dashboard_url' => 'https://www.ipg-online.com/vt/login',
				'supports'      => array(
					'webhook',
					'webhook_log',
					'webhook_no_config',
				),
				'manual_url'    => \__( 'https://www.pronamic.eu/support/how-to-connect-ems-with-wordpress-via-pronamic-pay/', 'pronamic_ideal' ),
			)
		);

		parent::__construct( $args );

		$this->action_url = $args['action_url'];

		// Actions
		$function = array( __NAMESPACE__ . '\Listener', 'listen' );

		if ( ! has_action( 'wp_loaded', $function ) ) {
			add_action( 'wp_loaded', $function );
		}
	}

	/**
	 * Get settings fields.
	 *
	 * @return array<int, array<string, callable|int|string|bool|array<int|string,int|string>>>
	 */
	public function get_settings_fields() {
		$fields = array();

		// Storename.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_UNSAFE_RAW,
			'meta_key' => '_pronamic_gateway_ems_ecommerce_storename',
			'title'    => _x( 'Storename', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
		);

		// Shared secret.
		$fields[] = array(
			'section'  => 'general',
			'filter'   => FILTER_UNSAFE_RAW,
			'meta_key' => '_pronamic_gateway_ems_ecommerce_secret',
			'title'    => _x( 'Shared Secret', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'large-text', 'code' ),
		);

		// Purchase ID.
		$fields[] = array(
			'section'     => 'advanced',
			'filter'      => array(
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FLAG_NO_ENCODE_QUOTES,
			),
			'meta_key'    => '_pronamic_gateway_ems_ecommerce_order_id',
			'title'       => __( 'Order ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'regular-text', 'code' ),
			'tooltip'     => sprintf(
				/* translators: %s: <code>{orderId}</code> */
				__( 'The EMS e-Commerce %s parameter.', 'pronamic_ideal' ),
				sprintf( '<code>%s</code>', 'orderId' )
			),
			'description' => sprintf(
				'%s %s<br />%s',
				__( 'Available tags:', 'pronamic_ideal' ),
				sprintf(
					'<code>%s</code> <code>%s</code>',
					'{order_id}',
					'{payment_id}'
				),
				sprintf(
					/* translators: %s: default code */
					__( 'Default: <code>%s</code>', 'pronamic_ideal' ),
					'{payment_id}'
				)
			),
		);

		// Notification URL.
		$fields[] = array(
			'section'  => 'feedback',
			/* translators: Translate 'notification' the same as in the EMS e-Commerce dashboard. */
			'title'    => _x( 'Notification URL', 'EMS e-Commerce', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'large-text', 'code' ),
			'value'    => home_url( '/' ),
			'readonly' => true,
			/* translators: Translate 'notification' the same as in the EMS e-Commerce dashboard. */
			'tooltip'  => _x(
				'The Notification URL as sent with each transaction to receive automatic payment status updates on.',
				'EMS e-Commerce',
				'pronamic_ideal'
			),
		);

		return $fields;
	}

	/**
	 * Get configuration by post ID.
	 *
	 * @param int $post_id Post ID.
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->set_action_url( $this->action_url );

		$config->storename = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_storename', true );
		$config->secret    = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_secret', true );
		$config->order_id  = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_order_id', true );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		return new Gateway( $this->get_config( $post_id ) );
	}
}
