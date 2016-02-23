<?php
/**
 */
ini_set('display_errors',false);
error_reporting(0);

require_once dirname(_FILE_)."/payQwick.php";

$merchantName = $_REQUEST['name'];
$merchantAccessKey = $_REQUEST['accessKey'];
$amount = $_REQUEST['amount'];
$accountNo = $_REQUEST['input'];
$pm = $_REQUEST['paymentMethodNumber'];
$receipt = $_REQUEST['receipt'];
$pin = $_REQUEST['pin'];
$cvc = $_REQUEST['cvc'];


function addPayment($no, $amount) { ?>
korona_plugin_api.response.addPayment({
					paymentMethodNumber: "<?=$no?>",
					inputAmount: "<?=$amount?>"
				});
<?php 
}

function message($title, $text, $level) { ?>
korona_plugin_api.response.displayMessage({
                        text: "<?=$text?>",
                        title: "<?=$title?>",
                        level: "<?=$level?>"
                });
<?php }
function logMsg($text, $level) { ?>
korona_plugin_api.response.logMessage({
		text: emptyToNull("<?=$text?>"),
		level: emptyToNull("<?=$level?>")
		});
<?php }


function handleResult($result, $pm, $showError=true) {

	unset($error);
	if (isset($result->error) && isset($result->error->message))
		$error = preg_replace('/^\s+|\n|\r|\s+$/m', ' ', $result->error->message);
	
	$amount = $result->Amount;
	

	if (isset($amount) && $amount > 0)
		addPayment($pm, $amount);
	
	if (isset($error) && !empty($error))
		message("ERROR", $error, "WARN");

}

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

echo "/*\n";

echo "PayQwick::payment($merchantName, $merchantAccessKey, $accountNo, $pin, $cvc, uuid, $amount)\n";

$result = PayQwick::payment($merchantName, $merchantAccessKey, $accountNo, $pin, $cvc, gen_uuid(), $amount);

echo "\n\nresponse:\n";

var_dump($result);

echo "\n */ \n";

handleResult($result, $pm)

?>
korona_plugin_api.backToKorona();

