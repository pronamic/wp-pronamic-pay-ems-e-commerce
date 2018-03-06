<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS_ECommerce;

use Pronamic\WordPress\Pay\Core\Statuses as Core_Statuses;

/**
 * Title: EMS e-Commerce Gateway statuses constants
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Statuses {
	/**
	 * Open
	 *
	 * @var string
	 */
	const OPEN = 'open';

	/**
	 * Transform an EMS e-Commerce state to an more global status
	 *
	 * @param string $status
	 *
	 * @return null|string
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::OPEN :
				return Core_Statuses::OPEN;

			default:
				return null;
		}
	}
}
