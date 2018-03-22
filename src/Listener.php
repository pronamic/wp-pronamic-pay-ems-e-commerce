<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Plugin;

/**
 * Title: EMS e-Commerce listener
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Listener {
	public static function listen() {
		if ( ! filter_has_var( INPUT_POST, 'ems_notify_payment_id' ) ) {
			return;
		}

		$payment_id = filter_input( INPUT_POST, 'ems_notify_payment_id' );

		$payment = get_pronamic_payment( $payment_id );

		Plugin::update_payment( $payment );
	}
}
