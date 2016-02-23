<?php

/**
 * 
 * @author Till Freier
 *
 */
require_once(dirname(__FILE__)."/payQwick.php");

function gen_uuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
}

//$data = json_decode('{"@odata.type":"#Payqwick.Models.ChargeRequest","AccountNumber":"2507420010000579","Amount":10,"BillingAddress1":null,"BillingAddress2":null,"BillingEmail":"test@randyrow.com","BillingPhone":null,"BillingState":null,"BillingZIP":null,"CardSwiped":null,"FirstName":null,"LastName":null,"MerchantAccessKey":"4822a42d-8c0a-4c03-b460-a3a0d46d425b","MerchantName":"RandyRoe","MI":null,"Orders@odata.type":"#Collection(Payqwick.Models.PurchaseOrder)","Orders":[{"@odata.type":"#Payqwick.Models.PurchaseOrder","CustomData":"<RewardProgram name=\"PayQwickRetailer\"><RetailerName></RetailerName><SellerName></SellerName><SellerCardNumber>0000000000000000</SellerCardNumber></RewardProgram>","Details@odata.type":"#Collection(Payqwick.Models.OrderDetail)","Details":[{"@odata.type":"#Payqwick.Models.OrderDetail","CustomData":"<PayQwickCard><CardNumber>0000000000000000</CardNumber><CVC>000</CVC><PIN>0000</PIN></PayQwickCard>","Id":null,"Notes":null,"Quantity":null,"SalesTaxRate":null,"SKU":null,"Title":null,"TotalWeight":null,"UnitPrice":null,"UnitWeight":null,"UPC":null}],"Email":null,"FirstName":null,"Id":null,"IPAddress":null,"LastName":null,"MI":null,"Phone":null,"Prefix":null,"ShippingAddress1":null,"ShippingAddress2":null,"ShippingCity":null,"ShippingState":null,"ShippingZIP":null,"Suffix":null}],"PayerIPAddress":null,"PIN":"0420","Prefix":null,"RequestId":"be16d818-cc5f-4849-b713-963fe4cceeaa","SecurityCode":"821","SenderData":null,"Suffix":null}');

//var_export($data);

//exit(0);


$id = gen_uuid();
$response = PayQwick::payment("RandyRoe", "4822a42d-8c0a-4c03-b460-a3a0d46d425b","2507420010000579", "0420", "821", $id, "10");

var_dump($response);

?>