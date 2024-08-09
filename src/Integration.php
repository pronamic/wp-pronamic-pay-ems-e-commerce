<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\AbstractGatewayIntegration;

/**
 * Title: EMS e-Commerce integration
 * Description:
 * Copyright: 2005-2024 Pronamic
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
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'id'            => 'ems-ecommerce',
				'name'          => 'EMS e-Commerce',
				'action_url'    => Client::ACTION_URL_PRODUCTION,
				'provider'      => 'ems',
				'product_url'   => null,
				'dashboard_url' => 'https://www.ipg-online.com/vt/login',
				'supports'      => [
					'webhook',
					'webhook_log',
					'webhook_no_config',
				],
				'manual_url'    => \__( 'https://www.pronamicpay.com/en/manuals/how-to-connect-ems-to-wordpress-with-pronamic-pay/', 'pronamic_ideal' ),
			]
		);

		parent::__construct( $args );

		$this->action_url = $args['action_url'];

		// Actions
		$function = [ __NAMESPACE__ . '\Listener', 'listen' ];

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
		$fields = [];

		// Storename.
		$fields[] = [
			'section'  => 'general',
			'meta_key' => '_pronamic_gateway_ems_ecommerce_storename',
			'title'    => _x( 'Storename', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => [ 'code' ],
			'required' => true,
		];

		// Shared secret.
		$fields[] = [
			'section'  => 'general',
			'meta_key' => '_pronamic_gateway_ems_ecommerce_secret',
			'title'    => _x( 'Shared Secret', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => [ 'large-text', 'code' ],
			'required' => true,
		];

		// Purchase ID.
		$fields[] = [
			'section'     => 'advanced',
			'meta_key'    => '_pronamic_gateway_ems_ecommerce_order_id',
			'title'       => __( 'Order ID', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => [ 'regular-text', 'code' ],
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
		];

		// Notification URL.
		$fields[] = [
			'section'  => 'feedback',
			/* translators: Translate 'notification' the same as in the EMS e-Commerce dashboard. */
			'title'    => _x( 'Notification URL', 'EMS e-Commerce', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => [ 'large-text', 'code' ],
			'value'    => home_url( '/' ),
			'readonly' => true,
			/* translators: Translate 'notification' the same as in the EMS e-Commerce dashboard. */
			'tooltip'  => _x(
				'The Notification URL as sent with each transaction to receive automatic payment status updates on.',
				'EMS e-Commerce',
				'pronamic_ideal'
			),
		];

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
