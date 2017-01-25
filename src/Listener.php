<?php

/**
 * Title: EMS e-Commerce listener
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Listener implements Pronamic_Pay_Gateways_ListenerInterface {
	public static function listen() {
		if ( filter_has_var( INPUT_POST, 'ems_notify_payment_id' ) ) {
			$payment_id = filter_input( INPUT_POST, 'ems_notify_payment_id' );

			$payment = get_pronamic_payment( $payment_id );

			Pronamic_WP_Pay_Plugin::update_payment( $payment );
		}
	}
}
