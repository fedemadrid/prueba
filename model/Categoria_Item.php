<?php

class Categoria_Item extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'categoria_item';

  /**
  * atributos
  */
  protected
	$id,
        $descripcion,
        $categoria_padre_id,
  		$borrado;
          
  /**
  * devuelve TODOS las categorias items de la tabla.
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
   * devuelve TODOS las categorias items de la tabla no borradas.
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
  * busca un dato_item en la tabla por su ID.
  */
  public static function selectOneByID($idcategoriaitem)
  {
    if (is_null($idcategoriaitem))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE id=%s', self::TABLE_NAME, $idcategoriaitem);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }		
  

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
  
  public static function selectDescripcionByID($idcategoriaitem)
  {
  	if (is_null($idcategoriaitem))
  	{
  			
  		return null;
  	}
  
  	$sql = sprintf('SELECT * FROM %s WHERE id=%s', self::TABLE_NAME, $idcategoriaitem);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
  
  	return parent::populateObject(__CLASS__, $first);
  }
  
  /**
   * Inserta un elemento en la tabla
   */
  public function create()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  	 
  	$sql = sprintf('INSERT INTO %s (descripcion, categoria_padre_id, borrado) values (?, ?, ?)', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getDescripcion(), $this->getCategoriaPadreId(), $this->getBorrado()));
  }

  /**
   * realiza una actualización
   */
  public function update()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('UPDATE %s set descripcion = ?, categoria_padre_id = ?, borrado = ? WHERE id = ?', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getDescripcion(), $this->getCategoriaPadreId(), $this->getBorrado(), $this->getId()));
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
    public function getCategoriaPadreId()
  {
    return $this->categoria_padre_id;
  }

  public function setCategoriaPadreId($v)
  {
    $this->categoria_padre_id = $v;
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