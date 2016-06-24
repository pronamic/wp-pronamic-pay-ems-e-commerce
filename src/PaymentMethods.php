<?php

/**
 * Title: EMS e-Commerce payment methods
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods {
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
}
