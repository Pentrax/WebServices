<?php
/**
 * Project: webservices
 * File:    s_002.php
 * Date:    2020 - 03 - 30
 * Time:    11:27
 *
 * @author           Jorge Leonardo Ramirez Montoya <lramirez@sugit.com.ar>
 * @version          2020
 *
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once '../../vendor/nusoap/lib/nusoap.php';

/**
 * Estructura del WS
 * 1. se crea la instancia
 * 2. se declaran todos los tipos complejos
 * 3. se registran los metodos que van a estar expuestos
 * 4. se codifica la logica del metodo una vez consumido
 * 5. servir el servicio
 */

/*
* Configuracion del servicio web
*/
$page = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

if (isset($_SERVER['HTTPS'])) {
    $ns="https://".$page;
} else {
    $ns="http://".$page;
}

/*
 * 1. declaro la instancia del servidor del ws
 */
$server = new soap_server();
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;
$server->configureWSDL('suvtv',$ns);
$server->wsdl->schemaTargetNamespace = $ns;

/*
* 2. Registro de los objetos complejos que voy a recibir
*/
$server->wsdl->addComplexType(
    "certificadoDigital",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "certificadoURL" 			=>      array("name" => "certificadoURL",      		"type" => "xsd:string", "nillable" => "true"),
        "certificadoBase64" 		=>      array("name" => "certificadoBase64",      	"type" => "xsd:string"),
    )
);

$server->wsdl->addComplexType(
    "respuestaInformarVerificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "respuestaID" 				=>      array("name" => "respuestaID",      		"type" => "xsd:int"),
        "respuestaMensaje" 			=> 		array("name" => "respuestaMensaje",			"type" => "xsd:string"),
        "turnoID" 					=>      array("name" => "turnoID",      			"type" => "xsd:unsignedLong"),
        "dominio" 					=>      array("name" => "dominio",      			"type" => "xsd:string", "nillable" => "true"),
        "mtm"						=> 		array("name" => "mtm", 						"type" => "xsd:string", "nillable" => "true"),
        "verificacionID" 			=> 		array("name" => "verificacionID",			"type" => "xsd:unsignedLong", "nillable" => "true"),
        "certificadoDigital"        =>      array("name" => "certificadoDigital",       "type" => "tns:certificadoDigital"),
    )
);

$server->wsdl->addSimpleType(
    "estadosFormularios",
    'xsd:string',
    'simpleType',
    'scalar',
    array("V", "C") // V: Vigente, C:Cancelado
);

$server->wsdl->addComplexType(
    "formulariosListado",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "formulario" 			=>      array("name" => "formulario",      			"type" => "xsd:unsignedLong"),
        "estado"				=> 		array("name" => "estado", 					"type" => "tns:estadosFormularios")
    )
);

$server->wsdl->addComplexType(
    'formularios',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 			      'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:formulariosListado[]')
    ),
    'tns:formulariosListado'
);

$server->wsdl->addComplexType(
    "datosPresentante",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "datosPersonales" 		=>      array("name" => "datosPersonales",      		"type" => "tns:datosPersonales"),
        "domicilio"				=> 		array("name" => "domicilio", 					"type" => "tns:domicilio"),
        "datosContacto"			=> 		array("name" => "datosContacto", 				"type" => "tns:datosContactoPresentante")
    )
);

/** Agregado por Pablo */

$server->wsdl->addComplexType(
    "domicilio",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "calle" 			    =>      array("name" => "calle",      			        "type" => "xsd:string"),
        "numero"				=> 		array("name" => "numero", 					    "type" => "xsd:int")
    )
);


$server->wsdl->addComplexType(
    "datosContactoPresentante",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "genero" 				=>      array("name" => "genero",      					"type" => "tns:genero"),
        "tipoDocumento" 		=> 		array("name" => "tipoDocumento",				"type" => "xsd:int", 			"nillable" => "true"),
        "numeroDocumento" 		=> 		array("name" => "numeroDocumento", 		  		"type" => "xsd:unsignedLong", 	"nillable" => "true"),
        "numeroCuit" 			=> 		array("name" => "numeroCuit", 		  			"type" => "xsd:unsignedLong", 	"nillable" => "true"),
        "nombre"				=> 		array("name" => "nombre", 						"type" => "xsd:string", 		"nillable" => "true"),
        "apellido"				=> 		array("name" => "apellido", 					"type" => "xsd:string", 		"nillable" => "true"),
        "razonSocial"			=> 		array("name" => "razonSocial", 					"type" => "xsd:string", 		"nillable" => "true")
    )
);
/** *********************** */
$server->wsdl->addSimpleType(
    "verificacionResultado",
    'xsd:string',
    'simpleType',
    'scalar',
    array("A", "R", "C") /* A: Arpobado, R: Rechazado, C: Condicional  */
);

$server->wsdl->addComplexType(
    "resultadoVerificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "resultado" 			=>      array("name" => "resultado",      				"type" => "tns:verificacionResultado"),
        "observaciones"			=> 		array("name" => "observaciones", 				"type" => "xsd:string", "nillable" => "true")
    )
);

$server->wsdl->addComplexType(
    "medicionesVerificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "frenosEficaciaServicio" 			=>      array("name" => "frenosEficaciaServicio",      				"type" => "xsd:float", "nillable" => "true"),
        "frenosEficaciaMano"			    => 		array("name" => "frenosEficaciaMano", 				        "type" => "xsd:float", "nillable" => "true"),
        "frenosDesequilibrio1Eje"			=> 		array("name" => "frenosDesequilibrio1Eje", 				    "type" => "xsd:float", "nillable" => "true"),
        "frenosDesequilibrio2Eje"			=> 		array("name" => "frenosDesequilibrio2Eje", 				    "type" => "xsd:float", "nillable" => "true"),
        "amortiguadores1EjeIzq"			    => 		array("name" => "amortiguadores1EjeIzq", 				    "type" => "xsd:float", "nillable" => "true"),
        "amortiguadores2EjeIzq"			    => 		array("name" => "amortiguadores2EjeIzq", 				    "type" => "xsd:float", "nillable" => "true"),
        "amortiguadores1EjeDer"			    => 		array("name" => "amortiguadores1EjeDer", 				    "type" => "xsd:float", "nillable" => "true"),
        "amortiguadores2EjeDer"			    => 		array("name" => "amortiguadores2EjeDer", 				    "type" => "xsd:float", "nillable" => "true"),
        "alineacionDeriva"			        => 		array("name" => "alineacionDeriva", 				        "type" => "xsd:float", "nillable" => "true"),
        "contaminacionCOBaja"			    => 		array("name" => "contaminacionCOBaja", 			    	    "type" => "xsd:float", "nillable" => "true"),
        "contaminacionPpmHcBaja"			=> 		array("name" => "contaminacionPpmHcBaja", 				    "type" => "xsd:float", "nillable" => "true"),
        "contaminacionCOAlta"			    => 		array("name" => "contaminacionCOAlta", 			    	    "type" => "xsd:float", "nillable" => "true"),
        "contaminacionPpmHcAlta"			=> 		array("name" => "contaminacionPpmHcAlta", 				    "type" => "xsd:float", "nillable" => "true"),
        "contaminacionDieselK"			    => 		array("name" => "contaminacionDieselK", 				    "type" => "xsd:float", "nillable" => "true"),
    )
);

$server->wsdl->addComplexType(
    "detallesVerificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "motorVerificacion" 		=>      array("name" => "motorVerificacion",      		"type" => "tns:resultadoVerificacion"),
        "lucesVerificacion" 		=> 		array("name" => "lucesVerificacion",			"type" => "tns:resultadoVerificacion"),
        "direccionVerificacion" 	=> 		array("name" => "direccionVerificacion", 		"type" => "tns:resultadoVerificacion"),
        "frenosVerificacion"		=> 		array("name" => "frenosVerificacion", 			"type" => "tns:resultadoVerificacion"),
        "suspensionVerificacion"	=> 		array("name" => "suspensionVerificacion", 		"type" => "tns:resultadoVerificacion"),
        "chasisVerificacion"		=> 		array("name" => "chasisVerificacion", 			"type" => "tns:resultadoVerificacion"),
        "llantasVerificacion"		=> 		array("name" => "llantasVerificacion", 			"type" => "tns:resultadoVerificacion"),
        "neumaticosVerificacion"	=> 		array("name" => "neumaticosVerificacion", 		"type" => "tns:resultadoVerificacion"),
        "generalVerificacion"		=> 		array("name" => "generalVerificacion", 			"type" => "tns:resultadoVerificacion"),
        "contaminacionVerificacion"	=> 		array("name" => "contaminacionVerificacion", 	"type" => "tns:resultadoVerificacion"),
        "seguridadVerificacion"		=> 		array("name" => "seguridadVerificacion", 		"type" => "tns:resultadoVerificacion"),
        "medicionesVerificacion"    =>      array("name" => "medicionesVerificacion",       "type" => "tns:medicionesVerificacion", "nillable" => "true")
    )
);

$server->wsdl->addComplexType(
    "datosVerificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "resultado" 			=>      array("name" => "resultado",      				"type" => "tns:verificacionResultado"),
        "fechaVencimiento" 		=> 		array("name" => "fechaVencimiento",				"type" => "xsd:date"),
        "fechaVigencia" 		=> 		array("name" => "fechaVigencia", 		  		"type" => "xsd:date"),
        "fechaEntrada"			=> 		array("name" => "fechaEntrada", 				"type" => "xsd:dateTime"),
        "fechaSalida"			=> 		array("name" => "fechaSalida", 					"type" => "xsd:dateTime"),
        "linea"					=> 		array("name" => "linea", 						"type" => "xsd:int"),
        "detallesVerificacion"	=> 		array("name" => "detallesVerificacion", 		"type" => "tns:detallesVerificacion"),
        "observaciones"			=> 		array("name" => "observaciones", 				"type" => "xsd:string", "nillable" => "true")
    )
);

$server->wsdl->addSimpleType(
    "genero",
    'xsd:string',
    'simpleType',
    'scalar',
    array("M", "F","PJ") /* M: Masculino, F: Femenino, PJ: Persona juridica */
);

$server->wsdl->addComplexType(
    "datosPersonales",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "genero" 				=>      array("name" => "genero",      					"type" => "tns:genero"),
        "tipoDocumento" 		=> 		array("name" => "tipoDocumento",				"type" => "xsd:int", 			"nillable" => "true"),
        "numeroDocumento" 		=> 		array("name" => "numeroDocumento", 		  		"type" => "xsd:unsignedLong", 	"nillable" => "true"),
        "numeroCuit" 			=> 		array("name" => "numeroCuit", 		  			"type" => "xsd:unsignedLong", 	"nillable" => "true"),
        "nombre"				=> 		array("name" => "nombre", 						"type" => "xsd:string", 		"nillable" => "true"),
        "apellido"				=> 		array("name" => "apellido", 					"type" => "xsd:string", 		"nillable" => "true"),
        "razonSocial"			=> 		array("name" => "razonSocial", 					"type" => "xsd:string", 		"nillable" => "true")
    )
);

$server->wsdl->addComplexType(
    "datosVehiculoInformar",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "dominio" 				=>      array("name" => "dominio",      				"type" => "xsd:string"),
        "numeroChasis"			=> 		array("name" => "numeroChasis", 				"type" => "xsd:string"),
        "anio"					=> 		array("name" => "anio", 						"type" => "xsd:int"),
        "jurisdiccionID"		=> 		array("name" => "jurisdiccionID", 				"type" => "xsd:int")
    )
);

$server->wsdl->addComplexType(
    "tiempos",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "horaIngreso" 			=>      array("name" => "horaIngreso",      		"type" => "xsd:string"),
        "horaEgreso"			=> 		array("name" => "horaEgreso", 				"type" => "xsd:string"),
        "tiempoTotalLinea"		=> 		array("name" => "tiempoTotalLinea", 		"type" => "xsd:string"),
        "tiempoTotalEgreso"		=> 		array("name" => "tiempoTotalEgreso", 		"type" => "xsd:string")
    )
);

$server->wsdl->addComplexType(
    "titular",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "nombreApellido" 		=>      array("name" => "nombreApellido",      	"type" => "xsd:string"),
        "tipoDocumento"			=> 		array("name" => "tipoDocumento", 		"type" => "xsd:string"),
        "numeroDocumento"		=> 		array("name" => "numeroDocumento", 		"type" => "xsd:string")
    )
);

$server->wsdl->addComplexType(
    "vehiculo",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "dominio" 		=>      array("name" => "dominio",      	"type" => "xsd:string"),
        "anio"			=> 		array("name" => "anio", 		    "type" => "xsd:string"),
        "marca"		    => 		array("name" => "marca", 		    "type" => "xsd:string"),
        "modelo" 		=>      array("name" => "modelo",      	    "type" => "xsd:string"),
        "clasificacion"	=> 		array("name" => "clasificacion",    "type" => "xsd:string"),
        "chasis"		=> 		array("name" => "chasis", 		    "type" => "xsd:string")
    )
);

$server->wsdl->addComplexType(
    "verificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "resultado" 		        =>      array("name" => "resultado",      	    "type" => "xsd:string"),
        "fechaInspeccion"			=> 		array("name" => "fechaInspeccion",      "type" => "xsd:string"),
        "detalleVerificacion"		=> 		array("name" => "detalleVerificacion",  "type" => "tns:detalleVerificacion")
    )
);

$server->wsdl->addComplexType(
    "detalleVerificacionListado",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "codigo" 			=>      array("name" => "formulario",      			"type" => "xsd:string"),
        "descripcion"		=> 		array("name" => "estado", 					"type" => "tns:string"),
        "tipoDefecto"		=> 		array("name" => "estado", 					"type" => "tns:string")
    )
);

$server->wsdl->addComplexType(
    'detalleVerificacion',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 			      'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:detalleVerificacionListado[]')
    ),
    'tns:detalleVerificacionListado'
);

$server->wsdl->addComplexType(
    "verificacion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "resultado" 		        =>      array("name" => "resultado",      	    "type" => "xsd:string"),
        "fechaInspeccion"			=> 		array("name" => "fechaInspeccion",      "type" => "xsd:string"),
        "detalleVerificacion"		=> 		array("name" => "detalleVerificacion",  "type" => "tns:detalleVerificacion")
    )
);

$server->wsdl->addComplexType(
    "datosImpresion",
    "complexType",
    "struct",
    "all",
    "",
    array (
        "informeInspeccionNumero" 		=>      array("name" => "informeInspeccionNumero",      "type" => "xsd:string"),
        "obleaNumero"		            => 		array("name" => "obleaNumero",                  "type" => "xsd:string"),
        "fechaVencimiento"		        => 		array("name" => "fechaVencimiento",             "type" => "xsd:string"),
        "codigo" 		                =>      array("name" => "codigo",      	                "type" => "xsd:string"),
        "observaciones"			        => 		array("name" => "observaciones",                "type" => "xsd:string"),
        "tiempos"		                => 		array("name" => "tiempos",                      "type" => "tns:tiempos"),
        "titular" 		                =>      array("name" => "titular",      	            "type" => "tns:titular"),
        "vehiculo"			            => 		array("name" => "vehiculo",                     "type" => "tns:vehiculo"),
        "verificacion"		            => 		array("name" => "verificacion",                 "type" => "tns:verificacion")
    )
);

/*
* 3. Registro de los metodos que estaran disponibles para el webservice
*/
$server->register(
    "informarVerificacion", //nombre del metodo del ws
    // declaracion de la estrucutra del request
    array(
        "usuarioID" 			=> "xsd:unsignedLong",
        "ingresoID"				=> "xsd:unsignedLong",
        "plantaID" 				=> "xsd:unsignedLong",
        "turnoID" 				=> "xsd:unsignedLong",
        "formularios" 			=> "tns:formularios",
        "tramiteNumero"			=> "xsd:unsignedLong",
        "obleaID"				=> "xsd:unsignedLong",
        "datosPresentante" 		=> "tns:datosPresentante",
        "datosVerificacion"		=> "tns:datosVerificacion",
        "datosTitular"			=> "tns:datosPersonales",
        "datosVehiculo"			=> "tns:datosVehiculoInformar",
        "datosImpresion"        => "tns:datosImpresion"
    ),
    array(
        "return" => "tns:respuestaInformarVerificacion" //objeto complejo de respuesta
    ),
    $ns, //namespace
    $ns."#informarVerificacion", //accion soap
    "rpc",
    "encoded",
    'la documentacion de la operacion informarVerificacion'
);

/*
* 4. metodo al que llama el webservice cuando es consumido
*/
function informarRecaudos($informarVerificacionRequest){

    $retorno = array();
    $retorno['respuestaInformarVerificacion'] = array(
        "respuestaID" 				=> '1',
        "respuestaMensaje" 			=> 'test',
        "turnoID" 					=> '1',
        "dominio" 					=> 'ABC123',
        "mtm"						=> 'string',
        "verificacionID" 			=> '2',
        "certificadoDigital"        => array (
            "certificadoURL" 			=> 'http://url.certificado.com',
            "certificadoBase64" 		=>  'base64string',
        )

    );
    return $retorno;
}

/*
 * 5. sirvo el servicio
 */
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
