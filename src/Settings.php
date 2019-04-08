<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\GatewaySettings;

/**
 * Title: EMS e-Commerce gateway settings
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Settings extends GatewaySettings {
	/**
	 * Settings constructor.
	 */
	public function __construct() {
		add_filter( 'pronamic_pay_gateway_sections', array( $this, 'sections' ) );
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );
	}

	/**
	 * Sections.
	 *
	 * @param array $sections Sections.
	 *
	 * @return array
	 */
	public function sections( array $sections ) {
		// EMS e-Commerce.
		$sections['ems_ecommerce'] = array(
			'title'       => __( 'EMS e-Commerce', 'pronamic_ideal' ),
			'methods'     => array( 'ems_ecommerce' ),
			'description' => __( 'Account details are provided by the payment provider after registration. These settings need to match with the payment provider dashboard.', 'pronamic_ideal' ),
		);

		// Advanced.
		$sections['ems_ecommerce_advanced'] = array(
			'title'       => __( 'Advanced', 'pronamic_ideal' ),
			'methods'     => array( 'ems_ecommerce' ),
			'description' => __( 'Optional settings for advanced usage only.', 'pronamic_ideal' ),
		);

		// Transaction feedback.
		$sections['ems_ecommerce_feedback'] = array(
			'title'       => __( 'Transaction feedback', 'pronamic_ideal' ),
			'methods'     => array( 'ems_ecommerce' ),
			'description' => __(
				'Payment status updates will be processed without any additional configuration. The <em>Notification URL</em> is being used to receive the status updates.',
				'pronamic_ideal'
			),
		);

		return $sections;
	}

	/**
	 * Fields.
	 *
	 * @param array $fields Fields.
	 *
	 * @return array
	 */
	public function fields( array $fields ) {
		// Storename.
		$fields[] = array(
			'filter'   => FILTER_UNSAFE_RAW,
			'section'  => 'ems_ecommerce',
			'meta_key' => '_pronamic_gateway_ems_ecommerce_storename',
			'title'    => _x( 'Storename', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'code' ),
		);

		// Shared secret.
		$fields[] = array(
			'filter'   => FILTER_UNSAFE_RAW,
			'section'  => 'ems_ecommerce',
			'meta_key' => '_pronamic_gateway_ems_ecommerce_secret',
			'title'    => _x( 'Shared Secret', 'ems', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'large-text', 'code' ),
		);

		// Transaction feedback.
		$fields[] = array(
			'section' => 'ems_ecommerce',
			'methods' => array( 'ems_ecommerce' ),
			'title'   => __( 'Transaction feedback', 'pronamic_ideal' ),
			'type'    => 'description',
			'html'    => __( 'Payment status updates will be processed without any additional configuration.', 'pronamic_ideal' ),
		);

		// Purchase ID.
		$fields[] = array(
			'filter'      => array(
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FLAG_NO_ENCODE_QUOTES,
			),
			'section'     => 'ems_ecommerce_advanced',
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
			'section'  => 'ems_ecommerce_feedback',
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

		// Webhook status.
		$fields[] = array(
			'section'  => 'ems_ecommerce_feedback',
			'methods'  => array( 'ems_ecommerce' ),
			'title'    => __( 'Status', 'pronamic_ideal' ),
			'type'     => 'description',
			'callback' => array( 'Pronamic\WordPress\Pay\WebhookManager', 'settings_status' ),
		);

		return $fields;
	}
}
