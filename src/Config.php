<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS_ECommerce;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: EMS e-Commerce config
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Config extends GatewayConfig {
	public $storename;

	public $secret;

	public $order_id;

	public function get_gateway_class() {
		return __NAMESPACE__ . '\Gateway';
	}
}
