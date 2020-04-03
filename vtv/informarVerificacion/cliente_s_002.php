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
//echo "<h2>Array TEST</h2><pre>";
//echo print_r($arr,true);
//echo "</pre>";die;
//header("content-type: application/pdf");


$wsdl = "http://localhost/webservices/vtv/informarVerificacion/s_002.php?wsdl";
$sClient = new nusoap_client($wsdl,'wsdl');
$sClient->soap_defencoding = 'UTF-8';
$sClient->decode_utf8 = false;
$sClient->encode_utf8 = true;
//echo "<h2>Fault</h2><pre>";
//echo print_r($sClient);
//echo "</pre>";die;



$response = $sClient->call('informarVerificacion', $arr);


$error = $sClient->getError();
if ($error) {

    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
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





echo '<h2>Request</h2><pre>' . htmlspecialchars($sClient->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($sClient->response, ENT_QUOTES) . '</pre>';
echo '<h1>Debug</h1><pre>' . htmlspecialchars($sClient->getDebug(), ENT_QUOTES) . '</pre>';

