<?php
                $data = $_REQUEST['data'];
                                
                $plain = base64_decode($data);
                $fields = explode('|', $plain);
                list($name, $accessKey, $paymentMethodNumber) = explode('|', $plain);
                

                if (empty($name) || empty($accessKey) || empty($paymentMethodNumber))
                {
                	include dirname(_FILE_)."/payQwickConfig.php";
                	exit(0);
                }

?>

<!DOCTYPE html>
<html>
<head>
<title>PayQwick</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Syntax highlighter-->
<link rel="stylesheet"
	href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css"></link>
<script type="text/javascript"
	src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>

<script src="http://codemirror.net/lib/codemirror.js"></script>
<link rel="stylesheet" href="http://codemirror.net/lib/codemirror.css">
<script src="http://codemirror.net/mode/javascript/javascript.js"></script>
<script src="http://codemirror.net/addon/fold/foldcode.js"></script>
<link rel="stylesheet"
	href="http://codemirror.net/addon/fold/foldgutter.css"></link>
<script src="http://codemirror.net/addon/fold/foldgutter.js"></script>
<script src="http://codemirror.net/addon/fold/brace-fold.js"></script>

<!-- jQuery -->
<script src="jquery.min.js"></script>

<!-- Bootstrap -->
<link rel="stylesheet" href="bootstrap.min.css"></link>
<link rel="stylesheet" href="bootstrap-theme.min.css"></link>
<script src="bootstrap.min.js"></script>

<!-- KORONA.pos-Client API module -->
<script type="text/javascript" src="korona-plugin-api.js"></script>
<link rel="stylesheet" href="koronaposclient.css"></link>

<style>
code, kbd, pre, samp {
        font-family: monospace;
}

body {
        font-family: "Roboto", "Helvetica", "Arial", sans-serif;
}

.CodeMirror {
        height: auto;
}
</style>

<script type="text/javascript">

        korona_plugin_api.response.identifyAs("PayQwick Plugin", "1");

        var amount=0;
        var receipt="000";
        window.onload = function myOnLoadFunc() {
        korona_plugin_api.ready(function myReadyFunc() {

                if ((amount == 0 || amount === null) && korona_plugin_api.request.inputLine == "")
                {
                        korona_plugin_api.response.displayMessage({
                                text: "Please enter the amount first.",
                                title: "Input Required",
                                level: "INFO"
                        });

                        korona_plugin_api.backToKorona();
                }
                else if (korona_plugin_api.request.inputLine > 0)
                        amount=korona_plugin_api.request.inputLine;

                var receipt=korona_plugin_api.request.receipt.number;

                document.getElementById('amount').innerHTML = amount;
        });
                document.getElementById('amount').innerHTML = amount;
        };

        function paymentRequest(f)
        {
                f.accountNumber.disabled=true;
                params = "input="+encodeURI(f.accountNumber.value);
                params += "&pin="+encodeURI(f.pin.value);
                params += "&cvc="+encodeURI(f.cvc.value);
                params += "&name=<?=urlencode($name)?>";
                params += "&accessKey=<?=urlencode($accessKey)?>";
                params += "&paymentMethodNumber=<?=urlencode($paymentMethodNumber)?>";
                params += "&amount="+encodeURI(amount);
                params += "&receipt="+encodeURI(receipt);

                $.ajax({
                        url: "payQwickRequest.php?"+params,
                        type: "GET",
                        dataType: "text"
                }).done(function(data){
                        eval(data);
                });

                return false;
        }
</script>
<head>
<body>
        <form class="form" name="form1" action=""
                onsubmit="paymentRequest(document.form1); return false;" style="margin:50px">

                <h1>Charge PayQwick Card - $<span id="amount">???</span></h1>

                <h3>Swipe, Scan or Key Card</h3>
                <div class="row">
                        <div class="col-xs-4">
                                <div class="form-group">
                                        <label class="sr-only" for="accountNumber">Account number*</label>
                                        <input class="form-control" type="text" name="accountNumber" id="accountNumber" rows="1"
                                                required="required" placeholder="Account number*"></input>
                                </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-4">
                                <div class="form-group">
                                        <label class="sr-only" for="pin">PIN*</label>
                                        <input class="form-control" type="text" name="pin" id="pin" rows="1"
                                                required="required" placeholder="PIN*"></input>
                                </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-4">
                                <div class="form-group">
                                        <label class="sr-only" for="cvc">CVC*</label>
                                        <input class="form-control" type="text" name="cvc" id="cvc" rows="1"
                                                required="required" placeholder="CVC*"></input>
                                </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-xs-12">
                                <div class="form-group">
                                        <button class="btn btn-primary" type="submit">submit</button>

                                        <button class="btn btn-secundary" onclick="korona_plugin_api.showOsk();return false;">show keyboard</button>
                                </div>
                        </div>
                </div>
        </form>


<script type="text/javascript">
        document.getElementById("accountNumber").focus();
</script>
</body>
</html>
