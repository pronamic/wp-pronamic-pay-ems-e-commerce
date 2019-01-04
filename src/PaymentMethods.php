<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\PaymentMethods as Core_PaymentMethods;

/**
 * Title: EMS e-Commerce payment methods
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 2.0.0
 * @since 1.0.0
 */
class PaymentMethods {
	/**
	 * Constant for the Bancontact payment method.
	 *
	 * @var string
	 */
	const BANCONTACT = 'BCMC';

	/**
	 * Constant for the MasterCard payment method.
	 *
	 * @var string
	 */
	const MASTERCARD = 'M';

	/**
	 * Constant for the VISA (Credit/Debit/Electron/Delta) payment method.
	 *
	 * @var string
	 */
	const VISA = 'V';

	/**
	 * Constant for the Maestro payment method.
	 *
	 * @var string
	 */
	const MAESTRO = 'MA';

	/**
	 * Constant for the Maestro UK payment method.
	 *
	 * @var string
	 */
	const MAESTROUK = 'maestroUK';

	/**
	 * Constant for the iDEAL payment method.
	 *
	 * @var string
	 */
	const IDEAL = 'ideal';

	/**
	 * Constant for the PayPal payment method.
	 *
	 * @var string
	 */
	const PAYPAL = 'paypal';

	/**
	 * Constant for the SOFORT Banking payment method.
	 *
	 * @var string
	 */
	const SOFORT = 'sofort';

	/**
	 * Transform WordPress payment method to EMS payment method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $payment_method Payment method.
	 *
	 * @return string
	 */
	public static function transform( $payment_method ) {
		switch ( $payment_method ) {
			case Core_PaymentMethods::BANCONTACT:
				return self::BANCONTACT;

			case Core_PaymentMethods::IDEAL:
				return self::IDEAL;

			case Core_PaymentMethods::PAYPAL:
				return self::PAYPAL;

			case Core_PaymentMethods::SOFORT:
				return self::SOFORT;

			default:
				return null;
		}
	}
}
