<?php

Braintree_Configuration::environment('sandbox');

Braintree_Configuration::merchantId('whx7z7j746wbqntb');

Braintree_Configuration::publicKey('r44zwq9vtmxdvsx5');
Braintree_Configuration::privateKey('c74308813739fc443715463501b0a668');


$result = Braintree_Transaction::sale(array(
    'amount' => '1.00',
    'creditCard' => array(
        'number' => '5105105105105100',
        'expirationDate' => '05/16'
    )
));
pr($result);die;
if ($result->success) {
  
    print_r("success!: " . $result->transaction->id);
   
} else if ($result->transaction) {
     
    print_r("Error processing transaction:");
    print_r("\n  code: " . $result->transaction->processorResponseCode);
    print_r("\n  text: " . $result->transaction->processorResponseText);
} else {
    
    print_r("Validation errors: \n");
    print_r($result->errors->deepAll());
}

?>