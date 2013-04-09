<?php

class Tipo_Item extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'tipo_item';

  /**
  * atributos
  */
  protected
	$id,
        $descripcion,
        $activo;

  /**
  * devuelve TODOS los tipos de items de la tabla.
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
  * busca un item en la tabla por su ID.
  */
  public static function selectOneByID($idtipoitem)
  {
    if (is_null($idtipoitem))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE id=%s', self::TABLE_NAME, $idtipoitem);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }	
  
  public static function selectOneByIdTipoItem($idTipoItem)
  {
  	if (is_null($idTipoItem))
  	{
  			
  		return null;
  	}
  	
  	$sql = sprintf('SELECT * FROM %s WHERE id = %s', self::TABLE_NAME, $idTipoItem);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
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

  public function getActivo()
  {
    return $this->activo;
  }

  public function setActivo($v)
  {
    $this->activo = $v;
  }
  
}