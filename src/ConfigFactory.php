<?php

/**
 * Title: EMS e-Commerce config factory
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_ConfigFactory extends Pronamic_WP_Pay_GatewayConfigFactory {
	public function get_config( $post_id ) {
		$config = new Pronamic_WP_Pay_Gateways_EMS_ECommerce_Config();

		$config->storename  = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_storename', true );
		$config->secret     = get_post_meta( $post_id, '_pronamic_gateway_ems_ecommerce_secret', true );
		$config->mode       = get_post_meta( $post_id, '_pronamic_gateway_mode', true );

		return $config;
	}
}
