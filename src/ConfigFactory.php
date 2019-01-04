<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\GatewayConfigFactory;

/**
 * Title: EMS e-Commerce config factory
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.1
 * @since 1.0.0
 */
class ConfigFactory extends GatewayConfigFactory {
	public function get_config( $post_id ) {
		$config = new Config();

		$config->storename = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_storename', true );
		$config->secret    = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_secret', true );
		$config->mode      = get_post_meta( $post_id, '_pronamic_gateway_mode', true );
		$config->order_id  = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_order_id', true );

		return $config;
	}
}
