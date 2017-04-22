<?php
	$barcodeUrl = "https://www.pullandbear.com/#qr0968330980040";
	if (isset($_POST["url"])) $barcodeUrl = $_POST["url"];

	// $barcodeUrl = "https://www.pullandbear.com/#qr0968330980040";
	// $barcodeUrl = "https://www.pullandbear.com/#qr0968633142740";
	// $barcodeUrl = "https://www.pullandbear.com/#qr1162521100138";

	// file_get_contents($barcodeUrl);

	$productId = substr($barcodeUrl, strpos($barcodeUrl, "qr")+2, strlen($barcodeUrl) - stripos($barcodeUrl, "qr") - 4);

	$response = file_get_contents("https://www.pullandbear.com/#qr0968330980040");
	$urlStartPos = strpos($response, "itxrest", strpos($response, "itxrest") + strlen("itxrest"));
	$url = substr($response, $urlStartPos, strpos(substr($response, $urlStartPos), "\""));
	$url = "https://www.pullandbear.com/" .$url .$productId;
	echo "url = " .$url ."<br><br>";
	
	$baseUrlStartPos = strpos($response, "imageBaseUrl") + strlen("imageBaseUrl\":\"");
	$imageBaseUrl = substr($response, $baseUrlStartPos, strpos(substr($response, $baseUrlStartPos), "\""));

	$response = file_get_contents($url);
	$json = json_decode($response, true);
	$colors = $json["detail"]["colors"];

	foreach ($colors as $key => $value) {
		if (strpos($value["image"]["url"], substr($productId, 1))) break;
	}

	$item = $colors[$key];
	$imgUrl = $imageBaseUrl .$item["image"]["url"] ."_1_1_1.jpg";
	echo "imgUrl = " .$imgUrl ."<br><br>";

	echo "<img src=\"" .$imgUrl ."\" width=300 height=400>";
	echo "<img src=\"" .substr($imgUrl, 0, strpos($imgUrl, "_")) ."_2_1_1.jpg" ."\" width=300 height=400>";

?>

<!DOCTYPE html>
<html>
<head>
	<title>barcode</title>
</head>
<body>
	<br><br>
	<form method="post">
		<label>Select Barcode-</label>
		<select name="url">
			<option value="https://www.pullandbear.com/#qr0968330980040">https://www.pullandbear.com/#qr0968330980040</option>
			<option value="https://www.pullandbear.com/#qr0968633142740">https://www.pullandbear.com/#qr0968633142740</option>
			<option value="https://www.pullandbear.com/#qr1162521100138">https://www.pullandbear.com/#qr1162521100138</option>
		</select>
		<input type="submit">
	</form>
	
</body>
</html>