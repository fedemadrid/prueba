<?php

class Estilo extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'estilo';

  /**
  * atributos
  */
  protected
	$id,
	$nombre;

  /**
  * devuelve TODOS los estilos de la tabla.
  */
  public static function select()
  {
    $sql = sprintf('SELECT * FROM %s', self::TABLE_NAME);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
      $objects[] = parent::populateObject(__CLASS__, $row);
    }

    return $objects;
  }
 
  /**
   * Inserta un elemento en la tabla
   */
  public function create()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('INSERT INTO %s (nombre) values (?)', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getNombre()));
  }
  
  /**
  * GETTERS Y SETTERS
  */
  public function getId()
  {
    return $this->id;
  }

  public function setId($v)
  {
    $this->id = $v;
  }

  public function getNombre()
  {
    return $this->nombre;
  }

  public function setNombre($v)
  {
    $this->nombre = $v;
  }

}