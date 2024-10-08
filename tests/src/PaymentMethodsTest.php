<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\PaymentMethods as Core_PaymentMethods;

/**
 * Title: EMS e-Commerce Gateway payment methods tests
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 2.0.0
 * @since 1.0.0
 */
class PaymentMethodsTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test transform.
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $wp_payment_method, $expected ) {
		$ems_payment_method = PaymentMethods::transform( $wp_payment_method );

		$this->assertEquals( $expected, $ems_payment_method );
	}

	public function status_matrix_provider() {
		return [
			[ Core_PaymentMethods::IDEAL, PaymentMethods::IDEAL ],
			[ Core_PaymentMethods::PAYPAL, PaymentMethods::PAYPAL ],
			[ Core_PaymentMethods::SOFORT, PaymentMethods::SOFORT ],
			[ 'not existing payment method', null ],
		];
	}
}
