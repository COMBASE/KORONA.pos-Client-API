<!DOCTYPE html>
<html>
<head>
<title>KORONA.pos PayQwick Config</title>

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



<head>
<body>
	<form class="form" name="form1" action=""
		style="margin:50px">
		
		<h1>PayQwick Setup</h1>
		<div class="row">
			<div class="col-xs-4">
				<div class="form-group">
					<label class="sr" for="paymentMethodNumber">KORONA Payment Method Number*</label>
					<input class="form-control" type="text" name="paymentMethodNumber" value="<?=$_REQUEST["paymentMethodNumber"]?>" id="accountNumber"
						required="required" placeholder="KORONA payment method number*"></input>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<div class="form-group">
					<label class="sr" for="name">Merchant Name*</label>
					<input class="form-control" type="text" name="name" value="<?=$_REQUEST["name"]?>"
						required="required" placeholder="Name*"></input>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<div class="form-group">
					<label class="sr" for="siteId">Access Key*</label>
					<input class="form-control" type="text" name="accessKey" value="<?=$_REQUEST["accessKey"]?>" 
						required="required" placeholder="Access Key*"></input>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">setup</button>
					
				</div>
			</div>
		</div>
	</form>

	<form style="margin:50px;">
	<?php
		$fields = array($_REQUEST['name'], $_REQUEST['accessKey'], $_REQUEST['paymentMethodNumber']);
		$plain = implode('|', $fields);
		$data = urlencode(base64_encode($plain));
		
		$types = array(
			"activate" => "Activate Card",
			"add" => "Load Card",
			"check" => "Check Balance"
		);
		if (strlen($plain) > 10)
		{
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url = str_replace("config.php", "", $url);
				$url = explode('?', $url);
				$url = $url[0];
				$url .= $data;
				$url .= "/payQwick.php";
		?>
		<div class="row">
			<div class="col-xs-4">
				<div class="form-group">
					<label class="" for="url">Display URL</label>
					<input class="form-control" type="text" name="url" id="url" value="<?=$url?>" 
						required="required" placeholder="" onblur="this.focus();" onclick="this.select();"></input>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				1) Log in to your <a href="https://www.koronacloud.com/">KORONA.pos Cloud Account</a> and create a new External System Call under Settings. <br />
				2) Assign a name (ex. PayQwick) <br />
				3) Use the above URL as Display-URL <br />
				4) Leave other fields blank and save the external system call <br />
				5) Create a button for the external system call <br />
				 
			</div>
		</div>
		<script type="text/javascript">
    		document.getElementById("url").focus();
    		document.getElementById("url").select();
    		
		</script>
	
	<?php			
		}
		
	?>
	</form>

</body>
</html>
