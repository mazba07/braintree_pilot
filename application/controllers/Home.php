<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('lib/Braintree');
    }

    public function pay() {
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('h3cjzwqgvr6fc6zh');
        Braintree_Configuration::publicKey('j9qkckxf7nzg92jy');
        Braintree_Configuration::privateKey('e8a5dfa2b30d63bce76f077dc1efe2f3');

        echo($clientToken = Braintree_ClientToken::generate());



//        $result = Braintree_Transaction::sale([
//                    'amount' => '3.00',
//                    'creditCard' => array(
//                        'number' => $this->input->post('number'),
//                        'expirationDate' => '08/19'
//                    ),
//                    'options' => [
//                        'submitForSettlement' => True
//                    ]
//        ]);
//
//        if ($result) {
//            echo "<pre>";
//            print_r($result);
//            echo "</pre>";
//        }
    }

}
