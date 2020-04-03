<?php


function getArrayTest(){

    $today = date("Y/m/d");
    $date_time = date("Y/m/d H:i:s");

    return array(
        "usuarioID" 			=> "1",
        "ingresoID"				=> "2",
        "plantaID" 				=> "1",
        "turnoID" 				=> "1",
        "formularios"           => array(
            "formulariosListado" =>
                array(
                    "formulario" => 1236,
                    "estado"        => "V"
                )
        ),
        "tramiteNumero"			=> "1",
        "obleaID"				=> "1",
        "datosPresentante" 		=> array(

            "genero" => "M",
            "tipoDocumento"     => 1,
            "numeroDocumento"   => 29867643,
            "numeroCuit"        => 20298676436,
            "nombre"            => "Pepa",
            "apellido"          => "Pig",
            "razonSocial"       => "ninguna"
        ,
            "domicilio" => array(
                "calle" => " LALALA",
                "numero" => 132
            ),
            "datosContacto" => array(
                "genero" => "M",
                "tipoDocumento"     => 1,
                "numeroDocumento"   => 29867643,
                "numeroCuit"        => 20298676436,
                "nombre"            => "Pepa",
                "apellido"          => "Pig",
                "razonSocial"       => "ninguna"
            )
        ),
        "datosVerificacion"		=> array(
            "resultado"         => "A",
            "fechaVencimiento"  => $today,
            "fechaVigencia"     => $today,
            "fechaEntrada"      => $date_time,
            "fechaSalida"       => $date_time,
            "linea"             => 1,
            "detallesVerificacion" => array(
                                "motorVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "lucesVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "direccionVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "frenosVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "suspensionVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "chasisVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "llantasVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "neumaticosVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "generalVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "contaminacionVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "seguridadVerificacion" => array(
                                    "resultado" => "A",
                                    "observaciones" => "OBS"
                                ),
                                "medicionesVerificacion" => array(
                                    "frenosEficaciaServicio" 			=>  1.0 ,
                                    "frenosEficaciaMano"			    => 	1.0,
                                    "frenosDesequilibrio1Eje"			=> 	1.0,
                                    "frenosDesequilibrio2Eje"			=> 	1.0,
                                    "amortiguadores1EjeIzq"			    => 	1.0,
                                    "amortiguadores2EjeIzq"			    => 	1.0,
                                    "amortiguadores1EjeDer"			    => 	1.0,
                                    "amortiguadores2EjeDer"			    => 	1.0,
                                    "alineacionDeriva"			        => 	1.0,
                                    "contaminacionCOBaja"			    => 	1.0,
                                    "contaminacionPpmHcBaja"			=> 	1.0,
                                    "contaminacionCOAlta"			    => 	1.0,
                                    "contaminacionPpmHcAlta"			=> 	1.0,
                                    "contaminacionDieselK"			    => 	1.0
                                )
                            )
        ),
        "datosTitular"			=> array(
            "genero" => "M",
            "tipoDocumento"     => 1,
            "numeroDocumento"   => 29867643,
            "numeroCuit"        => 20298676436,
            "nombre"            => "Pepa",
            "apellido"          => "Pig",
            "razonSocial"       => "ninguna"
        ),
        "datosVehiculo"			=> array(
            "dominio" 				=> "AB001DC",
            "numeroChasis"			=> 	"7894565587462",
            "anio"					=> 	2020,
            "jurisdiccionID"		=> 	1
        ),
        "datosImpresion"        => array(
            "informeInspeccionNumero" 		=> "1362165161",
            "obleaNumero"		            => 	"898989",
            "fechaVencimiento"		        => 	"2020/03/01",
            "codigo" 		                =>  "01",
            "observaciones"			        => 	"OBS Impresion",
            "tiempos"		                => 		array(
                "horaIngreso" 			=>  "10:00",
                "horaEgreso"			=> 	"10:30",
                "tiempoTotalLinea"		=> 	"30 min",
                "tiempoTotalEgreso"		=> 	"30 min"
            ),
            "titular" 		                =>      array(
                "nombreApellido" 		=> "Pepa Pig",
                "tipoDocumento"			=>  "DNI",
                "numeroDocumento"		=> 	"000007"
            ),
            "vehiculo"			            => 		array(
                "dominio" 		=>     "XD001XD",
                "anio"			=> 		"2020",
                "marca"		    => 		"Audi",
                "modelo" 		=>      "TT",
                "clasificacion"	=> 		"de gatgo",
                "chasis"		=> 		"789465789"
            ),
            "verificacion"		            => 		array(
                "resultado" 		        =>    "Aprobado",
                "fechaInspeccion"			=> 		"2020/04/01",
                "detalleVerificacion"		=> 	array(
                    "detalleVerificacionListado" => array(
                        "codigo" 			=>  "123",
                        "descripcion"		=> 	 "XSXSXS",
                        "tipoDefecto"		=> 		"LALALALAL"
                         ),
                    array(
                        "codigo" 			=>  "999",
                        "descripcion"		=> 	 "XDXDXXD",
                        "tipoDefecto"		=> 		"TRTRTRTR"
                    )
                )

            )
        )
    );
}

/**   array(
"motorVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"lucesVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"direccionVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"frenosVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"suspensionVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"chasisVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"llantasVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"neumaticosVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"generalVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"contaminacionVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"seguridadVerificacion" => array(
"resultado" => "A",
"observaciones" => "OBS"
),
"medicionesVerificacion" => array(
"frenosEficaciaServicio" 			=>  1.0 ,
"frenosEficaciaMano"			    => 	1.0,
"frenosDesequilibrio1Eje"			=> 	1.0,
"frenosDesequilibrio2Eje"			=> 	1.0,
"amortiguadores1EjeIzq"			    => 	1.0,
"amortiguadores2EjeIzq"			    => 	1.0,
"amortiguadores1EjeDer"			    => 	1.0,
"amortiguadores2EjeDer"			    => 	1.0,
"alineacionDeriva"			        => 	1.0,
"contaminacionCOBaja"			    => 	1.0,
"contaminacionPpmHcBaja"			=> 	1.0,
"contaminacionCOAlta"			    => 	1.0,
"contaminacionPpmHcAlta"			=> 	1.0,
"contaminacionDieselK"			    => 	1.0
)

) */