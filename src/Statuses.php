<?php

/**
 * Title: EMS e-Commerce Gateway statuses constants
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_Statuses {
	/**
	 * Open
	 *
	 * @var string
	 */
	const OPEN = 'open';

	/////////////////////////////////////////////////

	/**
	 * Transform an Mollie state to an more global status
	 *
	 * @param string $status
	 */
	public static function transform( $status ) {
		switch ( $status ) {
			case self::OPEN :
				return Pronamic_WP_Pay_Statuses::OPEN;
			default:
				return null;
		}
	}
}
