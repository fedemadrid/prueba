<?php

class Plantilla extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'plantilla';

  /**
  * atributos
  */
  protected
	$id,
	$descripcion,
	$categoria_id,
	$borrado;

  /**
   * devuelve TODAS las plantillas de la tabla.
   */
  public static function selectAll()
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
  * devuelve las plantillas de la tabla no borradas.
  */
  public static function select()
  {
    $sql = sprintf('SELECT * FROM %s WHERE borrado=0', self::TABLE_NAME);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
      $objects[] = parent::populateObject(__CLASS__, $row);
    }

    return $objects;
  }
	
  /**
  * busca una plantilla en la tabla por su ID.
  */
  public static function selectOneByID($idplantilla)
  {
    if (is_null($idplantilla))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE id=%s', self::TABLE_NAME, $idplantilla);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }
	
  public static function selectLastPlantilla()
  {
  	$sql = sprintf('SELECT * FROM %s ORDER BY id DESC', self::TABLE_NAME);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
  
  	return parent::populateObject(__CLASS__, $first);
  }
  
  /**
  * busca una plantilla en la tabla por su descripcion.
  */
  public static function selectOneByDescripcion($descripcion)
  {
    if (is_null($descripcion))
    {

      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE descripcion="%s"', self::TABLE_NAME, $descripcion);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }
  
  public static function agregarItemPlantilla($idPlantilla, $idItem, $orden)
  {
  	if (is_null($idPlantilla) || is_null($idItem) || is_null($orden))
  	{
  		return null;
  	}
  	
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('INSERT INTO plantilla_item (id_plantilla, id_item, orden) values (?, ?, ?)');
  	$stmt = $con->prepare($sql, array('integer', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  	 
  	return $stmt->execute(array($idPlantilla, $idItem, $orden));
  	 
  }
  
  /**
   * Inserta un elemento en la tabla
   */
  public function create()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('INSERT INTO %s (descripcion) values (?)', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getDescripcion()));
  }
  
  /**
   * realiza una actualización
   */
  public function update()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('UPDATE %s set descripcion = ?, categoria_id = ?, borrado = ? WHERE id = ?', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text', 'integer', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getDescripcion(), $this->getCategoriaId(), $this->getBorrado(), $this->getId()));
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

  public function getDescripcion()
  {
    return $this->descripcion;
  }

  public function setDescripcion($v)
  {
    $this->descripcion = $v;
  }

  public function getCategoriaId()
  {
    return $this->categoria_id;
  }

  public function setCategoriaId($v)
  {
    $this->categoria_id = $v;
  }
  
  public function getBorrado()
  {
  	return $this->borrado;
  }
  
  public function setBorrado($v)
  {
  	$this->borrado = $v;
  }
  
}