<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

/**
 * common stuff
 */
require_once(dirname(__FILE__).'/../config/database.php');
require_once(dirname(__FILE__).'/ConnectionManager.php');
require_once(dirname(__FILE__).'/../lib/BaseObject.php');



/**
 * MDB2
 */
require_once('MDB2.php');


/**
 * models
 */

require_once (dirname(__FILE__).'/../model/Configuracion.php');
require_once (dirname(__FILE__).'/../model/Usuario.php');
require_once(dirname(__FILE__).'/../model/Plantilla.php');
require_once(dirname(__FILE__).'/../model/Item.php');
require_once(dirname(__FILE__).'/../model/Dato_Item.php');
require_once(dirname(__FILE__).'/../model/Categoria_Item.php');
require_once(dirname(__FILE__).'/../model/Perfil.php');
require_once(dirname(__FILE__).'/../model/Tipo_Item.php');
require_once(dirname(__FILE__).'/../model/Estilo.php');
require_once(dirname(__FILE__).'/../model/Ubicacion.php');



/**
 * TWIG
 */

require_once("/opt/twig/lib/Twig/Autoloader.php");
Twig_Autoloader::register();


/**
* Obtener configuracion del sitio
*/

$conf = Configuracion::select();

/**
* iniciar sesion
*/
session_start();
