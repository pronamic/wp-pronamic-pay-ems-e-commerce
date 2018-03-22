<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: EMS e-Commerce utility class
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Util {
	/**
	 * Get order ID.
	 *
	 * @param string $order_id
	 * @param Payment $payment
	 *
	 * @return string
	 */
	public static function get_order_id( $order_id, Payment $payment ) {
		// Replacements definition
		$replacements = array(
			'{order_id}'   => $payment->get_order_id(),
			'{payment_id}' => $payment->get_id(),
		);

		// Find and replace
		$order_id = str_replace(
			array_keys( $replacements ),
			array_values( $replacements ),
			$order_id,
			$count
		);

		// Make sure there is an dynamic part in the order ID
		if ( 0 === $count ) {
			$order_id .= $payment->get_order_id();
		}

		return $order_id;
	}
}
