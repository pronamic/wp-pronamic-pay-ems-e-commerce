<?php

/**
 * Title: EMS e-Commerce utility class
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Util {
	/**
	 * Get order ID.
	 *
	 * @param string                            $order_id
	 * @param Pronamic_Pay_PaymentDataInterface $data
	 * @param Pronamic_Pay_Payment              $payment
	 */
	public static function get_order_id( $order_id, Pronamic_Pay_Payment $payment ) {
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
