<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$BkFile = "Backup.2fas";
$decoded = json_decode(file_get_contents('$BkFile'),true);
$arr = $decoded['services'];
$qr = new QR();
for ($i = 0;$i < count($arr);$i++){
    $name = $arr[$i]['name'];
    $secret = $arr[$i]['secret'];
    $account = $arr[$i]['otp']['account'];
    echo "name:".$name."<br>";
    echo "account:".$account."<br>";
    echo "secret:".$secret."<br>";
    echo "digits:".$arr[$i]['otp']['digits']."<br>";
    echo "period:".$arr[$i]['otp']['period']."<br>";
    echo "tokenType:".$arr[$i]['otp']['tokenType']."<br>";
    echo "counter:".$arr[$i]['otp']['counter']."<br>";
    echo "algorithm:".$arr[$i]['otp']['algorithm']."<br>";
    $otpauth = "otpauth://totp/$account?secret=$secret&issuer=$name";
    echo "<p><img src=".$qr->getQrCode($otpauth,300,300)." title=\"Link to AUTH of $name\" /></p>";
    echo "****************************************************************************************<br>";

}


class QR
{
	const CHT="qr";
	const APIURL="https://chart.apis.google.com/chart";

	public function getQrCode($data, $width, $height, $output_encoding=false, $error_correction_level=false){
        $data=urlencode($data); 
        $url=QR::APIURL."?cht=".QR::CHT."&chl=".$data."&chs=".$width."x".$height; 
        if ($output_encoding) { 
            $url.="&choe=".$output_encoding; 
        } 
        if ($error_correction_level) {
            $url.="&chld=".$error_correction_level; 
        } 
        return $url; 
    }
}
?>
