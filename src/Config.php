<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: EMS e-Commerce config
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Config extends GatewayConfig {
	/**
	 * Store name.
	 *
	 * @var string|null
	 */
	public $storename;

	/**
	 * Secret.
	 *
	 * @var string|null
	 */
	public $secret;

	/**
	 * Order ID.
	 *
	 * @var string|null
	 */
	public $order_id;
}
