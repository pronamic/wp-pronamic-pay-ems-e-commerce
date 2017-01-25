<?php

/**
 * Title: EMS e-Commerce config
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Config extends Pronamic_WP_Pay_GatewayConfig {
	public $storename;

	public $secret;

	public $order_id;

	public function get_gateway_class() {
		return 'Pronamic_WP_Pay_Gateways_EMS_ECommerce_Gateway';
	}
}
