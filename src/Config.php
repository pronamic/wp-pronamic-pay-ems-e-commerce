<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: EMS e-Commerce config
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Config extends GatewayConfig {
	/**
	 * Action URL.
	 *
	 * @var string
	 */
	private $action_url;

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

	/**
	 * Construct config.
	 */
	public function __construct() {
		$this->action_url = Client::ACTION_URL_PRODUCTION;
	}

	/**
	 * Get action URL.
	 *
	 * @return string
	 */
	public function get_action_url() {
		return $this->action_url;
	}

	/**
	 * Set action URL.
	 *
	 * @param string $action_url Action URL.
	 * @return void
	 */
	public function set_action_url( $action_url ) {
		$this->action_url = $action_url;
	}
}
