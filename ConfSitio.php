<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

//si inicio sesion y es administrador
if ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() == 1))
{
  if (isset($_POST['submitEditar']))
  {
    $conf->setNombre($_POST['nombre']);
    $conf->setItemsxpag($_POST['itemsxpag']);
    $conf->setEstiloactual($_POST['estiloactual']);
    $mensaje = "La actualizacion se realizo correctamente";
    if (is_uploaded_file($_FILES['uploadedcss']['tmp_name']))
    {
 	  if ($_FILES['uploadedcss']['type'] == "text/css")
 	  {
        if (!file_exists("css/estilos/" . $_FILES["uploadedcss"]["name"]))
        {
    	  copy($_FILES['uploadedcss']['tmp_name'], "css/estilos/{$_FILES['uploadedcss']['name']}");
	      $estilo = new Estilo();
	      $estilo->setNombre($_FILES['uploadedcss']['name']);
	      $estilo->create();
    	}
 	   	else
 	   	{
    	  $mensaje = "Error. Nombre de archivo ya existente";
   		}
      }
      else
      {
        $mensaje = "Error. Tipo de archivo incorrecto";
      }
    }

	$conf->update();
  }
  $view_page = "configurar.twig";
  $estilos = Estilo::select();
  $conf = Configuracion::select();
  //inicializacion twig
  $templateDir = "views/sitio";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('back-end_layout.twig');
  $template->display(array('isset_view_page' => isset($view_page),
  		'titulo' => $conf->getNombre(),
  		'view_page' => $view_page,
  		'username' => $_SESSION['usr']->getUsername(),
  		'conf' => $conf,
  		'estilos' => $estilos,
  		'hayMensaje' => isset($mensaje),
  		'mensaje' => $mensaje,
  		'logueado' => isset($_SESSION['usr'])
  ));
  
}
else
  header('Location: index.php');