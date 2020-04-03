<?php
/**
 * Project: webservices
 * File:    cliente_s_002.php
 * Date:    2020 - 03 - 30
 * Time:    14:10
 *
 * @author           Jorge Leonardo Ramirez Montoya <lramirez@sugit.com.ar>
 * @version          2020
 *
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 'On');
require_once '../../vendor/nusoap/lib/nusoap.php';
require_once  'testData.php';
ini_set ('soap.wsdl_cache_enabled', 0);

$arr = getArrayTest();


$wsdl = "http://localhost/webservices/vtv/informarVerificacion/s_002.php?wsdl";
$sClient = new nusoap_client($wsdl,'wsdl');
$sClient->soap_defencoding = 'UTF-8';
$sClient->decode_utf8 = false;
$sClient->encode_utf8 = true;



$response = $sClient->call('informarVerificacion', $arr);

$contents = $response['certificadoDigital']['certificadoBase64'];



$error = $sClient->getError();
if ($error) {

    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}else{
    /** En caso de no tener errores aber el pdf */
    openPdf($contents);
}

if ($sClient->fault) {
    echo "<h2>Fault</h2><pre>";
    echo print_r($response);
    echo "</pre>";die;
} else {
    $error = $sClient->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    if ($response != "" || NULL){
        echo "<h2>Respond</h2><pre>";
        print_r ($response);
        echo "</pre>";
    }
}



function openPdf($contents){

    $decoded = base64_decode($contents);
    $file = 'example.pdf';
    file_put_contents($file, $decoded);

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
       // exit;
    }
    /** Borro el archivo que se genera ,ya que el usuario lo descarga en su maquina */
    if (file_exists($file)){
        unlink($file);
    }
}

echo '<h2>Request</h2><pre>' . htmlspecialchars($sClient->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($sClient->response, ENT_QUOTES) . '</pre>';
echo '<h1>Debug</h1><pre>' . htmlspecialchars($sClient->getDebug(), ENT_QUOTES) . '</pre>';

