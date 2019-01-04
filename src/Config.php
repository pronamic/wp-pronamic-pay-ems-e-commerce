<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: EMS e-Commerce config
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Config extends GatewayConfig {
	public $storename;

	public $secret;

	public $order_id;
}
