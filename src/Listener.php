<?php

/**
 * Title: EMS e-Commerce listener
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Listener implements Pronamic_Pay_Gateways_ListenerInterface {
	public static function listen() {
		// @todo Implement listener
		if (
			filter_has_var( INPUT_POST, 'Data' )
				&&
			filter_has_var( INPUT_POST, 'Seal' )
		) {
			$input_data = filter_input( INPUT_POST, 'Data', FILTER_SANITIZE_STRING );

			$data = Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client::parse_piped_string( $input_data );

			$transaction_reference = $data['transactionReference'];

			$payment = get_pronamic_payment_by_meta( '_pronamic_payment_ems_ecommerce_transaction_reference', $transaction_reference );

			Pronamic_WP_Pay_Plugin::update_payment( $payment );
		}
	}
}
