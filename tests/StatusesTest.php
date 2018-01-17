<?php

/**
 * Title: EMS e-Commerce Gateway statuses constants tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_StatusesTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test transform.
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $ems_status, $expected ) {
		$status = Pronamic_WP_Pay_Gateways_EMS_Statuses::transform( $ems_status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return array(
			array( Pronamic_WP_Pay_Gateways_EMS_Statuses::OPEN, Pronamic_WP_Pay_Statuses::OPEN ),
			array( 'not existing status', null ),
		);
	}
}
