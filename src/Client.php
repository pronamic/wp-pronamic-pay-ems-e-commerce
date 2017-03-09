<?php

/**
 * Title: EMS e-Commerce client
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.3
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client {
	/**
	 * Action URL to start a payment request in the test environment,
	 * the POST data is sent to.
	 *
	 * @see page 14 - http://pronamic.nl/wp-content/uploads/2013/10/integratiehandleiding_rabo_omnikassa_en_versie_5_0_juni_2013_10_29451215.pdf
	 * @var string
	 */
	const ACTION_URL_TEST = 'https://test.ipg-online.com/connect/gateway/processing';

	/**
	 * Action URL For a payment request in the production environment,
	 * the POST data is sent to
	 *
	 * @see page 14 - http://pronamic.nl/wp-content/uploads/2013/10/integratiehandleiding_rabo_omnikassa_en_versie_5_0_juni_2013_10_29451215.pdf
	 * @var string
	 */
	const ACTION_URL_PRODUCTION = 'https://www.ipg-online.com/connect/gateway/processing';

	//////////////////////////////////////////////////

	/**
	 * Hash algorithm SHA256 indicator
	 *
	 * @var string
	 */
	const HASH_ALGORITHM_SHA256 = 'sha256';

	//////////////////////////////////////////////////

	/**
	 * The action URL
	 *
	 * @var string
	 */
	private $action_url;

	//////////////////////////////////////////////////

	/**
	 * Currency code in ISO 4217-Numeric codification
	 *
	 * @doc http://en.wikipedia.org/wiki/ISO_4217
	 * @doc http://www.iso.org/iso/support/faqs/faqs_widely_used_standards/widely_used_standards_other/currency_codes/currency_codes_list-1.htm
	 *
	 * @var string N3
	 */
	private $currency_numeric_code;

	/**
	 * Storename
	 *
	 * @var string N15 @todo DOC - Storename format requirement
	 */
	private $storename;

	/**
	 * Normal return URL
	 *
	 * @var string ANS512 url
	 */
	private $return_url;

	/**
	 * Amount
	 *
	 * @var string N12
	 */
	private $amount;

	//////////////////////////////////////////////////

	/**
	 * Notification URL
	 *
	 * @var string ANS512 url
	 */
	private $notification_url;

	/**
	 * Language in ISO 639‐1 Alpha2
	 *
	 * @doc http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
	 * @var string A2
	 */
	private $language;

	/**
	 * Payment method
	 *
	 * @var array
	 */
	private $payment_method;

	/**
	 * Order ID
	 *
	 * @var string AN32
	 */
	private $order_id;

	/**
	 * Payment ID
	 *
	 * @var string AN32
	 */
	private $payment_id;

	//////////////////////////////////////////////////

	/**
	 * Shared secret
	 *
	 * @var string
	 */
	private $secret;

	//////////////////////////////////////////////////

	/**
	 * Issuer ID.
	 *
	 * @var string
	 */
	private $issuer_id;

	//////////////////////////////////////////////////

	/**
	 * Transaction datetime.
	 */
	private $transation_datetime;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initalize an EMS e-Commerce object
	 */
	public function __construct() {
	}

	//////////////////////////////////////////////////

	/**
	 * Get the action URL
	 *
	 * @return the action URL
	 */
	public function get_action_url() {
		return $this->action_url;
	}

	/**
	 * Set the action URL
	 *
	 * @param string $url an URL
	 */
	public function set_action_url( $url ) {
		$this->action_url = $url;
	}

	//////////////////////////////////////////////////

	/**
	 * Get the currency numeric code
	 *
	 * @return string currency numeric code
	 */
	public function get_currency_numeric_code() {
		return $this->currency_numeric_code;
	}

	/**
	 * Set the currency code
	 *
	 * @param string $code
	 */
	public function set_currency_numeric_code( $code ) {
		$this->currency_numeric_code = $code;
	}

	//////////////////////////////////////////////////

	/**
	 * Get storename
	 *
	 * @return string
	 */
	public function get_storename() {
		return $this->storename;
	}

	/**
	 * Set the storename
	 *
	 * @param string $storename
	 */
	public function set_storename( $storename ) {
		$this->storename = $storename;
	}

	//////////////////////////////////////////////////

	/**
	 * Get normal return URL
	 *
	 * @return string
	 */
	public function get_return_url() {
		return $this->return_url;
	}

	/**
	 * Set the normal return URL
	 *
	 * LET OP! De URL mag geen parameters bevatten.
	 *
	 * @param string $return_url
	 */
	public function set_return_url( $return_url ) {
		$this->return_url = $return_url;
	}

	//////////////////////////////////////////////////

	/**
	 * Get amount
	 *
	 * @return float
	 */
	public function get_amount() {
		return $this->amount;
	}

	/**
	 * Get formmated amount
	 *
	 * @return int
	 */
	public function get_formatted_amount() {
		return Pronamic_WP_Pay_Util::amount_to_cents( $this->amount );
	}

	/**
	 * Set amount
	 *
	 * @param float $amount
	 */
	public function set_amount( $amount ) {
		$this->amount = $amount;
	}

	//////////////////////////////////////////////////

	/**
	 * Get notification URL
	 *
	 * @return string
	 */
	public function get_notification_url() {
		return $this->notification_url;
	}

	/**
	 * Set notification URL
	 *
	 * @param string $notification_url
	 */
	public function set_notification_url( $notification_url ) {
		$this->notification_url = $notification_url;
	}

	//////////////////////////////////////////////////

	/**
	 * Get language.
	 *
	 * @return string
	 */
	public function get_language() {
		return $this->language;
	}

	/**
	 * Set language.
	 *
	 * @param string $language
	 */
	public function set_language( $language ) {
		$this->language = $language;
	}

	//////////////////////////////////////////////////

	/**
	 * Set the payment method.
	 *
	 * @param string $payment_method
	 */
	public function set_payment_method( $payment_method ) {
		$this->payment_method = $payment_method;
	}

	/**
	 * Get the payment method.
	 *
	 * @return string ANS128 listString comma separated list
	 */
	public function get_payment_method() {
		return $this->payment_method;
	}

	//////////////////////////////////////////////////

	/**
	 * Get order ID
	 *
	 * @return string
	 */
	public function get_order_id() {
		return $this->order_id;
	}

	/**
	 * Set order ID
	 *
	 * @param string $order_id
	 */
	public function set_order_id( $order_id ) {
		$this->order_id = $order_id;
	}

	//////////////////////////////////////////////////

	/**
	 * Get payment ID
	 *
	 * @return int
	 */
	public function get_payment_id() {
		return $this->payment_id;
	}

	/**
	 * Set payment ID
	 *
	 * @param int $payment_id
	 */
	public function set_payment_id( $payment_id ) {
		$this->payment_id = $payment_id;
	}

	//////////////////////////////////////////////////

	/**
	 * Get the transaaction datetime.
	 *
	 * @param boolean $createNew indicator for creating a new expire date
	 * @return
	 */
	public function get_transation_datetime( $create_new = false ) {
		if ( null === $this->transation_datetime || $create_new ) {
			$this->transation_datetime = new DateTime( null, new DateTimeZone( 'UTC' ) );
		}

		return $this->transation_datetime;
	}

	public function set_transaction_datetime( DateTime $datetime ) {
		$this->transation_datetime = $datetime;
	}

	//////////////////////////////////////////////////

	/**
	 * Get data
	 *
	 * @return string
	 */
	public function get_data() {
		// Required fields for payment request
		$required_fields = array(
			'txntype'        => 'sale',
			// According the EMS documentation the timezone should be in `Area/Location` notation, but it seems like `UTC` is also working.
			'timezone'       => 'UTC',
			// In WordPress, PHP's `time()` will always return `UTC` and is the same as calling `current_time( 'timestamp', true )`.
			'txndatetime'    => $this->get_transation_datetime()->format( 'Y:m:d-H:i:s' ),
			'hash_algorithm' => 'SHA256',
			'storename'      => $this->get_storename(),
			'mode'           => 'payonly',
			'chargetotal'    => number_format( ( $this->get_formatted_amount() / 100 ), 2, '.', '' ),
			'currency'       => $this->get_currency_numeric_code(),
		);

		// Optional fields for payment request
		$optional_fields = array(
			'oid'                        => $this->get_order_id(),
			'language'                   => $this->get_language(),
			'paymentMethod'              => $this->get_payment_method(),
			'responseFailURL'            => $this->get_return_url(),
			'responseSuccessURL'         => $this->get_return_url(),
			'transactionNotificationURL' => $this->get_notification_url(),
			'idealIssuerID'              => $this->get_issuer_id(),
			'ems_notify_payment_id'      => $this->get_payment_id(),
		);

		// @see http://briancray.com/2009/04/25/remove-null-values-php-arrays/
		$optional_fields = array_filter( $optional_fields );

		// Data
		$data = $required_fields + $optional_fields;

		return $data;
	}

	//////////////////////////////////////////////////

	/**
	 * Get shared secret
	 *
	 * @return string
	 */
	public function get_secret() {
		return $this->secret;
	}

	/**
	 * Set shared secret
	 *
	 * @return string
	 */
	public function set_secret( $secret ) {
		$this->secret = $secret;
	}

	//////////////////////////////////////////////////

	/**
	 * Get hash
	 *
	 * @return string
	 */
	public function get_hash() {
		$data   = $this->get_data();
		$secret = $this->get_secret();

		$values = array(
			$data['storename'],
			$data['txndatetime'],
			$data['chargetotal'],
			$data['currency'],
			$secret,
		);

		return self::compute_hash( $values );
	}

	/**
	 * Compute hash
	 *
	 * @param array $values
	 *
	 * @return string
	 */
	public static function compute_hash( $values ) {
		$value = implode( '', $values );

		$value = bin2hex( $value );

		return hash( self::HASH_ALGORITHM_SHA256, $value );
	}

	//////////////////////////////////////////////////

	/**
	 * Get fields
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_fields() {
		$fields = $this->get_data();

		$fields['hash'] = $this->get_hash();

		return $fields;
	}

	//////////////////////////////////////////////////

	public function set_issuer_id( $issuer_id ) {
		$this->issuer_id = $issuer_id;
	}

	public function get_issuer_id() {
		return $this->issuer_id;
	}
}
