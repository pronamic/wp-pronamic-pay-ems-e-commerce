<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Plugin;

/**
 * Title: EMS e-Commerce listener
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class Listener {
	public static function listen() {
		if ( ! filter_has_var( INPUT_POST, 'ems_notify_payment_id' ) ) {
			return;
		}

		$payment_id = filter_input( INPUT_POST, 'ems_notify_payment_id' );

		$payment = get_pronamic_payment( $payment_id );

		if ( null === $payment ) {
			return;
		}

		// Add note.
		$note = sprintf(
			/* translators: %s: EMS */
			__( 'Webhook requested by %s.', 'pronamic_ideal' ),
			__( 'EMS', 'pronamic_ideal' )
		);

		$payment->add_note( $note );

		// Log webhook request.
		do_action( 'pronamic_pay_webhook_log_payment', $payment );

		// Update payment.
		Plugin::update_payment( $payment );
	}
}
