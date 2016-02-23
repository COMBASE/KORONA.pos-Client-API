<?php

/**
 * 
 * @author Till Freier
 *
 */
class PayQwick {
	private static $serviceUrl = "https://sandbox.payqwick.com/api/Payments";
	
	private static function restCall($method, $url, $data = false) {
		$curl = curl_init ();
		
		switch ($method) {
			case "POST" :
				curl_setopt ( $curl, CURLOPT_POST, 1 );
				
				if ($data)
				{
					$headers = array(
							"Content-type: application/json;charset=\"utf-8\"",
							"Content-length: ".strlen($data)
						);

					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data ); 
					}
				break;
			case "PUT" :
				curl_setopt ( $curl, CURLOPT_PUT, 1 );
				break;
			default :
				if ($data)
					$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
		}
		
		// Optional Authentication:
		// curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		// curl_setopt($curl, CURLOPT_USERPWD, "username:password");
		
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		
		$result = curl_exec ( $curl );
		
		curl_close ( $curl );
		
		return $result;
	}
	public static function payment($merchantName, $merchantAccessKey, $accountNo, $pin, $cvc, $requestId, $amount, $debug=false) {
		$data = array (
				'@odata.type' => '#Payqwick.Models.ChargeRequest',
				'AccountNumber' => $accountNo,
				'Amount' => intval($amount),
				'BillingAddress1' => NULL,
				'BillingAddress2' => NULL,
				'BillingEmail' => NULL,
				'BillingPhone' => NULL,
				'BillingState' => NULL,
				'BillingZIP' => NULL,
				'CardSwiped' => NULL,
				'FirstName' => NULL,
				'LastName' => NULL,
				'MerchantAccessKey' => $merchantAccessKey,
				'MerchantName' => $merchantName,
				'MI' => NULL,
				'Orders@odata.type' => '#Collection(Payqwick.Models.PurchaseOrder)',
				'Orders' => array (
						0 => array (
								'@odata.type' => '#Payqwick.Models.PurchaseOrder',
								'CustomData' => '<RewardProgram name="PayQwickRetailer"><RetailerName></RetailerName><SellerName></SellerName><SellerCardNumber>0000000000000000</SellerCardNumber></RewardProgram>',
								'Details@odata.type' => '#Collection(Payqwick.Models.OrderDetail)',
								'Details' => array (
										0 => array (
												'@odata.type' => '#Payqwick.Models.OrderDetail',
												'CustomData' => '<PayQwickCard><CardNumber>0000000000000000</CardNumber><CVC>000</CVC><PIN>0000</PIN></PayQwickCard>',
												'Id' => NULL,
												'Notes' => NULL,
												'Quantity' => NULL,
												'SalesTaxRate' => NULL,
												'SKU' => NULL,
												'Title' => NULL,
												'TotalWeight' => NULL,
												'UnitPrice' => NULL,
												'UnitWeight' => NULL,
												'UPC' => NULL 
										) 
								),
								'Email' => NULL,
								'FirstName' => NULL,
								'Id' => NULL,
								'IPAddress' => NULL,
								'LastName' => NULL,
								'MI' => NULL,
								'Phone' => NULL,
								'Prefix' => NULL,
								'ShippingAddress1' => NULL,
								'ShippingAddress2' => NULL,
								'ShippingCity' => NULL,
								'ShippingState' => NULL,
								'ShippingZIP' => NULL,
								'Suffix' => NULL 
						) 
				),
				'PayerIPAddress' => NULL,
				'PIN' => $pin,
				'Prefix' => NULL,
				'RequestId' => $requestId,
				'SecurityCode' => $cvc,
				'SenderData' => NULL,
				'Suffix' => NULL 
		);
		
		$jsonData = json_encode ( $data, JSON_UNESCAPED_SLASHES );
		
		if ($debug)
			echo "\nrequest:\n $jsonData \n";
		
		$response = self::restCall ( "POST", self::$serviceUrl, $jsonData );
		
		return json_decode($response);
	}
}

?>