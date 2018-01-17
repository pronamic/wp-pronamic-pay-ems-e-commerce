<?php

/**
 * Title: EMS e-Commerce Gateway payment methods tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethodsTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test transform.
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $wp_payment_method, $expected ) {
		$ems_payment_method = Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::transform( $wp_payment_method );

		$this->assertEquals( $expected, $ems_payment_method );
	}

	public function status_matrix_provider() {
		return array(
			array( Pronamic_WP_Pay_PaymentMethods::IDEAL, Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::IDEAL ),
			array( Pronamic_WP_Pay_PaymentMethods::PAYPAL, Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::PAYPAL ),
			array( Pronamic_WP_Pay_PaymentMethods::SOFORT, Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::SOFORT ),
			array( 'not existing payment method', null ),
		);
	}
}
