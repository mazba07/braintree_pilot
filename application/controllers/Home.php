<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('lib/Braintree');
    }

    public function pay() {

        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('mjbdtwcmfw2dgfk6');
        Braintree_Configuration::publicKey('6wqdqpbgqp3sng6s');
        Braintree_Configuration::privateKey('dcbdab7bf07c30aa454d16e56ac16075');

        $data['clientToken'] = Braintree_ClientToken::generate();
        // $data['clientToken'] = Braintree_ClientToken::generate([
        //     "customerId" => 'abirroy8813'
        // ]);
        $this->load->view("pay",$data);

        // FOR REAL LIFE SITUATION
        // $nonceFromTheClient = $_POST["payment_method_nonce"];
        //  $result = Braintree_Transaction::sale([
        //    'amount' => '3.00',
        //    'creditCard' => array(
        //        'number' => '4111 1111 1111 1111',
        //        'expirationDate' => '08/19'
        //    ),
        //    'options' => [
        //        'submitForSettlement' => True
        //    ]
        //  ]);
        $result = Braintree_Transaction::sale([
          'amount' => '80.00',
          'creditCard' => array(
                 'number' => '',
                 'expirationDate' => '6011111111111117',
                 'cvv' => ''
             ),
          'paymentMethodNonce' => 'fake-valid-nonce',
          'options' => [
            'submitForSettlement' => True
          ]
        ]);

       if ($result) {
           echo "<pre>";
           print_r("Success!");
           echo "</pre>";
       }
    }

}
