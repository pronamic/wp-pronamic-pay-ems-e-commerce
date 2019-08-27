<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Gateways\Common\AbstractIntegration;

/**
 * Title: EMS e-Commerce integration
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Integration extends AbstractIntegration {
	public function __construct() {
		$this->id            = 'ems-ecommerce';
		$this->name          = 'EMS e-Commerce';
		$this->product_url   = '';
		$this->dashboard_url = array(
			__( 'test', 'pronamic_ideal' ) => 'https://test.ipg-online.com/vt/login',
			__( 'live', 'pronamic_ideal' ) => 'https://www.ipg-online.com/vt/login',
		);
		$this->provider      = 'ems';
		$this->supports      = array(
			'webhook',
			'webhook_log',
			'webhook_no_config',
		);

		// Actions
		$function = array( __NAMESPACE__ . '\Listener', 'listen' );

		if ( ! has_action( 'wp_loaded', $function ) ) {
			add_action( 'wp_loaded', $function );
		}
	}

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
					/* translators: %s: {order_id} */
					__( 'Default: <code>%s</code>', 'pronamic_ideal' ),
					'{order_id}'
				)
			),
		);

		// Notification URL.
		$fields[] = array(
			'section'  => 'feedback',
			'title'    => __( 'Notification URL', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'large-text', 'code' ),
			'value'    => home_url( '/' ),
			'readonly' => true,
			'tooltip'  => __(
				'The Notification URL as sent with each transaction to receive automatic payment status updates on.',
				'pronamic_ideal'
			),
		);

		return $fields;
	}

	public function get_config( $post_id ) {
		$config = new Config();

		$config->storename = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_storename', true );
		$config->secret    = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_secret', true );
		$config->mode      = get_post_meta( $post_id, '_pronamic_gateway_mode', true );
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
