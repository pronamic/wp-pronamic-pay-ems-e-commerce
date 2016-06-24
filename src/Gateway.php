<?php

/**
 * Title: EMS e-Commerce
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Gateway extends Pronamic_WP_Pay_Gateway {
	/**
	 * The EMS e-Commerce client object
	 *
	 * @var Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client
	 */
	private $client;

	/////////////////////////////////////////////////

	/**
	 * Constructs and initializes an EMS e-Commerce gateway
	 *
	 * @param Pronamic_WP_Pay_Gateways_EMS_ECommerce_Config $config
	 */
	public function __construct( Pronamic_WP_Pay_Gateways_EMS_ECommerce_Config $config ) {
		parent::__construct( $config );

		$this->set_method( Pronamic_WP_Pay_Gateway::METHOD_HTML_FORM );
		$this->set_has_feedback( true ); // @todo EMS
		$this->set_amount_minimum( 0.01 ); // @todo EMS

		// Client
		$this->client = new Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client();

		$action_url = Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client::ACTION_URL_PRODUCTION;

		if ( Pronamic_IDeal_IDeal::MODE_TEST === $config->mode ) {
			$action_url = Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client::ACTION_URL_TEST;
		}

		$this->client->set_action_url( $action_url );
		$this->client->set_storename( $config->storename );
		$this->client->set_secret( $config->secret );
	}

	/////////////////////////////////////////////////

	/**
	 * Get supported payment methods.
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
	 */
	public function get_supported_payment_methods() {
		return array(
			Pronamic_WP_Pay_PaymentMethods::IDEAL        => Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::IDEAL,
//			Pronamic_WP_Pay_PaymentMethods::CREDIT_CARD  => Pronamic_WP_Pay_Gateways_OmniKassa_PaymentMethods::VISA,
//			Pronamic_WP_Pay_PaymentMethods::DIRECT_DEBIT => Pronamic_WP_Pay_Gateways_OmniKassa_PaymentMethods::INCASSO,
//			Pronamic_WP_Pay_PaymentMethods::BANCONTACT   => Pronamic_WP_Pay_Gateways_OmniKassa_PaymentMethods::BCMC,
		);
	}

	/////////////////////////////////////////////////

	/**
	 * Start
	 *
	 * @see Pronamic_WP_Pay_Gateway::start()
	 * @param Pronamic_Pay_PaymentDataInterface $data
	 */
	public function start( Pronamic_Pay_Payment $payment ) {
		$transaction_reference = $payment->get_meta( 'ems_ecommerce_transaction_reference' );

		if ( empty( $transaction_reference ) ) {
			$transaction_reference = md5( uniqid( '', true ) );

			$payment->set_meta( 'ems_ecommerce_transaction_reference', $transaction_reference );
		}

		$payment->set_action_url( $this->client->get_action_url() );

		$this->client->set_customer_language( Pronamic_WP_Pay_Gateways_EMS_ECommerce_LocaleHelper::transform( $payment->get_language() ) );
		$this->client->set_currency_numeric_code( $payment->get_currency_numeric_code() );
		$this->client->set_order_id( Pronamic_WP_Pay_Gateways_EMS_ECommerce_Util::get_order_id( $this->config->order_id, $payment ) );
		$this->client->set_return_url( home_url( '/' ) );
		$this->client->set_amount( $payment->get_amount() );
		$this->client->set_transaction_reference( $transaction_reference );
		$this->client->set_issuer_id( $payment->get_issuer() );

		// @todo Implement payment methods other than iDEAL
		switch ( $payment->get_method() ) {
			case Pronamic_WP_Pay_PaymentMethods::CREDIT_CARD :
				$this->client->set_payment_method( Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::MAESTRO );
				$this->client->set_payment_method( Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::MASTERCARD );
				$this->client->set_payment_method( Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::VISA );

				break;
//			case Pronamic_WP_Pay_PaymentMethods::DIRECT_DEBIT :
//				$this->client->$this->set_payment_method( Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::INCASSO );
//
//				break;
			case Pronamic_WP_Pay_PaymentMethods::IDEAL :
				$this->client->set_payment_method( Pronamic_WP_Pay_Gateways_EMS_ECommerce_PaymentMethods::IDEAL );

				break;
		}
	}

	/////////////////////////////////////////////////

	/**
	 * Get the output HTML
	 *
	 * @since 1.1.2
	 * @see Pronamic_WP_Pay_Gateway::get_output_html()
	 */
	public function get_output_fields() {
		return $this->client->get_fields();
	}

	/////////////////////////////////////////////////

	/**
	 * Update status of the specified payment
	 *
	 * @param Pronamic_Pay_Payment $payment
	 */
	public function update_status( Pronamic_Pay_Payment $payment ) {
		$input_data = filter_input( INPUT_POST, 'Data', FILTER_SANITIZE_STRING );
		$input_seal = filter_input( INPUT_POST, 'Seal', FILTER_SANITIZE_STRING );

//		$data = Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client::parse_piped_string( $input_data );

		$seal = Pronamic_WP_Pay_Gateways_EMS_ECommerce_Client::compute_hash( $input_data, $this->config->secret );

		// Check if the posted seal is equal to our seal
		if ( 0 === strcasecmp( $input_seal, $seal ) ) {
			$response_code = $data['responseCode'];

			$status = Pronamic_WP_Pay_Gateways_EMS_ECommerce_ResponseCodes::transform( $response_code );

			// Set the status of the payment
			$payment->set_status( $status );

			$labels = array(
				'amount'               => __( 'Amount', 'pronamic_ideal' ),
				'captureDay'           => _x( 'Capture Day', 'creditcard', 'pronamic_ideal' ),
				'captureMode'          => _x( 'Capture Mode', 'creditcard', 'pronamic_ideal' ),
				'currencyCode'         => __( 'Currency Code', 'pronamic_ideal' ),
				'merchantId'           => __( 'Merchant ID', 'pronamic_ideal' ),
				'orderId'              => __( 'Order ID', 'pronamic_ideal' ),
				'transactionDateTime'  => __( 'Transaction Date Time', 'pronamic_ideal' ),
				'transactionReference' => __( 'Transaction Reference', 'pronamic_ideal' ),
				'keyVersion'           => __( 'Key Version', 'pronamic_ideal' ),
				'authorisationId'      => __( 'Authorisation ID', 'pronamic_ideal' ),
				'paymentMeanBrand'     => __( 'Payment Mean Brand', 'pronamic_ideal' ),
				'paymentMeanType'      => __( 'Payment Mean Type', 'pronamic_ideal' ),
				'responseCode'         => __( 'Response Code', 'pronamic_ideal' ),
			);

			$note = '';

			$note .= '<p>';
			$note .= __( 'EMS e-Commerce transaction data in response message:', 'pronamic_ideal' );
			$note .= '</p>';

			$note .= '<dl>';

			foreach ( $labels as $key => $label ) {
				if ( isset( $data[ $key ] ) ) {
					$note .= sprintf( '<dt>%s</dt>', esc_html( $label ) );
					$note .= sprintf( '<dd>%s</dd>', esc_html( $data[ $key ] ) );
				}
			}

			$note .= '</dl>';

			$payment->add_note( $note );
		}
	}
}
