<?php

/**
 * Title: EMS e-Commerce gateway settings
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.3
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Settings extends Pronamic_WP_Pay_GatewaySettings {
	public function __construct() {
		add_filter( 'pronamic_pay_gateway_sections', array( $this, 'sections' ) );
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );
	}

	public function sections( array $sections ) {
		// iDEAL
		$sections['ems_ecommerce'] = array(
			'title'       => __( 'EMS e-Commerce', 'pronamic_ideal' ),
			'methods'     => array( 'ems_ecommerce' ),
			'description' => __( 'Account details are provided by the payment provider after registration. These settings need to match with the payment provider dashboard.', 'pronamic_ideal' ),
		);

		// Advanced
		$sections['ems_ecommerce_advanced'] = array(
			'title'       => __( 'Advanced', 'pronamic_ideal' ),
			'methods'     => array( 'ems_ecommerce' ),
			'description' => __( 'Optional settings for advanced usage only.', 'pronamic_ideal' ),
		);

		return $sections;
	}

	public function fields( array $fields ) {
		// Storename
		$fields[] = array(
			'filter'      => FILTER_UNSAFE_RAW,
			'section'     => 'ems_ecommerce',
			'meta_key'    => '_pronamic_gateway_ems_ecommerce_storename',
			'title'       => _x( 'Storename', 'ems', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'code' ),
		);

		// Shared secret
		$fields[] = array(
			'filter'      => FILTER_UNSAFE_RAW,
			'section'     => 'ems_ecommerce',
			'meta_key'    => '_pronamic_gateway_ems_ecommerce_secret',
			'title'       => _x( 'Shared Secret', 'ems', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'large-text', 'code' ),
		);

		// Transaction feedback
		$fields[] = array(
			'section'     => 'ems_ecommerce',
			'title'       => __( 'Transaction feedback', 'pronamic_ideal' ),
			'type'        => 'description',
			'html'        => sprintf(
				'<span class="dashicons dashicons-yes"></span> %s',
				__( 'Payment status updates will be processed without any additional configuration.', 'pronamic_ideal' )
			),
		);

		// Purchase ID
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
					__( 'Default: <code>%s</code>', 'pronamic_ideal' ),
					'{order_id}'
				)
			),
		);

		return $fields;
	}
}
