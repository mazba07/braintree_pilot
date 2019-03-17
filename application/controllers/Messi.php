<?php

class Messi extends CI_Controller {
    /*
     * braintree user: mazba09@gmail.com
      braintree pass: braintreemazba9delta
     */

    public function __construct() {
        parent::__construct();
        $this->load->helper('lib/Braintree');
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('byg5ktfx2gqk5mgn');
        Braintree_Configuration::publicKey('ywm3tn44h5hg3hx8');
        Braintree_Configuration::privateKey('e7cba5f7632e3ba00d645c668b2a3929');
    }

    public function x() {
        echo $clientToken = Braintree_ClientToken::generate();
    }

    /*
     * main link:: https://developers.braintreepayments.com/reference/response/transaction/ruby
     * Transaction Lifecycle:: https://articles.braintreepayments.com/get-started/transaction-life-cycle
     *
     *  Authorized
     * -----------
      The first step is to ask the customer’s bank if the payment method is legitimate and has sufficient funds to pay for your product or service. If the customer's bank approves, the transaction is Authorized. This puts a hold on the funds, meaning the customer isn’t able to spend that money, but it doesn’t take any funds out just yet.

      Submitted for settlement
     * ---------------------------
      Eventually, authorizations will expire. In order to collect funds, you need to submit for settlement. This is enabled by default when creating a transaction via the Control Panel, but you have to specify whether you want to submit for settlement when creating a transaction via the API.

      In most cases, you’ll want to submit a transaction for settlement at the same time that you authorize the payment. Some merchants that ship physical goods wait to submit for settlement until after the product has shipped in order to reduce chargebacks. Read more about extended authorizations in Managing Authorizations.

      Settling
     * -----------
      This is a transitory state. While the processors and the banks are working out the details of the exchange of funds, the transaction will be Settling. The amount of time this takes is dependent on the processing bank. Contact us if you have questions.

      Settled
     * --------------------
      This is when the money moves from your customer’s bank through your merchant account. Once the money hits your merchant account, the transaction will display as Settled, and the funds will be routed to your bank account. For more information on funding timelines, continue to the next section.
     */

    public function pay() {
        $result = Braintree_Transaction::sale([
                    'merchantAccountId' => 'abir_kure',
                    'amount' => '7.00',
                    'paymentMethodNonce' => 'fake-valid-nonce',
                    'serviceFeeAmount' => "1.00",
                    'creditCard' => [
                        'cvv' => 123,
                        'expirationMonth' => 12,
                        'expirationYear' => 20,
                        'number' => 6011111111111117
                    ],
                    'options' => [
                        'submitForSettlement' => True
                    ]
        ]);

        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    /*
     * details about a transection, param transection id: rp58y42g
     */

    public function find_status_of_transection() {
        $transaction = Braintree_Transaction::find('f22c2zwk');
        if ($transaction) {
            echo "<pre>";
            print_r($transaction);
            echo "</pre>";
        }
    }

    public function create_marcent() {
        //created by manually in braintree website....
    }

    /*
     * We need submachent for fee khabo ha ha ha
     */

    public function create_sub_marchant() {
        $merchantAccountParams = [
            'individual' => [
                'firstName' => 'Alif',
                'lastName' => 'Escrow',
                'email' => 'alif_escrow@14ladders.com',
                'phone' => '5553334444',
                'dateOfBirth' => '1981-11-19',
                'ssn' => '456-45-4567',
                'address' => [
                    'streetAddress' => '111 Main St',
                    'locality' => 'Chicago',
                    'region' => 'IL',
                    'postalCode' => '60622'
                ]
            ],
            'business' => [
                'legalName' => 'Jane\'s Ladders',
                'dbaName' => 'Jane\'s Ladders',
                'taxId' => '98-7654321',
                'address' => [
                    'streetAddress' => '111 Main St',
                    'locality' => 'Chicago',
                    'region' => 'IL',
                    'postalCode' => '60622'
                ]
            ],
            'funding' => [
                'descriptor' => 'Blue Ladders',
                'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
                'email' => 'funding@blueladders.com',
                'mobilePhone' => '5555555555',
                'accountNumber' => '1123581321',
                'routingNumber' => '071101307'
            ],
            'tosAccepted' => true,
            'masterMerchantAccountId' => "msmusic",
            'id' => "alif_escrow"
        ];
        $result = Braintree_MerchantAccount::create($merchantAccountParams);
        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    /*
     * Transection with escrow
     */

    public function pay_escrow() {
        $result = Braintree_Transaction::sale([
                    'merchantAccountId' => 'alif_escrow',
                    'amount' => '65.00',
                    'paymentMethodNonce' => 'fake-valid-nonce',
                    'serviceFeeAmount' => "1.00",
                    'creditCard' => [
                        'cvv' => 123,
                        'expirationMonth' => 12,
                        'expirationYear' => 20,
                        'number' => 5555555555554444
                    ],
                    'options' => [
                        'submitForSettlement' => True,
                        'holdInEscrow' => TRUE
                    ]
        ]);

        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    public function hold_in_escrow() {
        $result = $result = Braintree_Transaction::holdInEscrow('cdjh7xtm');
        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    public function release_from_escrow() {
        $result = Braintree_Transaction::releaseFromEscrow("rp58y42g");
        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    /*
     * You can void transactions that have a status of authorized or submitted for settlement.
     *  The only required information is the transaction ID. When the transaction is voided, Braintree will perform an authorization reversal, if possible, to remove the pending charge from the customer's card.
     */

    public function void_transection() {
        $result = Braintree_Transaction::void('f22c2zwk');
        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

    /*
     * You can refund transactions that have a status of settled or settling. 
     * If the transaction has not yet begun settlement, use Braintree::Transaction.void() instead. 
     * If you do not specify an amount to refund, the entire transaction amount will be refunded.
     */

    public function refund() {
        $result = Braintree_Transaction::refund('f22c2zwk'); //for full refund
        //$result = Braintree_Transaction::refund('f22c2zwk','20.9'); //for partial  refund
        if ($result) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
    }

}
