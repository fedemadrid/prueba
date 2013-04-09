<?php

class Ubicacion extends BaseObject
{
	/**
	 * nombre de la tabla
	 */
	const TABLE_NAME = 'ubicacion';

	/**
	 * atributos
	 */
	protected

	$idusuario,
	$latitud,
	$longitud;


	/**
	 * devuelve la unica tupla de la tabla.
	 */
	public static function select()
	{
		$sql = sprintf('SELECT * FROM %s', self::TABLE_NAME);

		$result = ConnectionManager::getInstance()->getConnection()->query($sql);

		$first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);

		return parent::populateObject(__CLASS__, $first);
	}
	
	public static function selectOneByID($idusuario)
	{
		if (is_null($idusuario))
		{
				
			return null;
		}
	
		$sql = sprintf('SELECT * FROM %s WHERE idusuario=%s', self::TABLE_NAME, $idusuario);
	
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
	
		$sql = sprintf('INSERT INTO %s (idusuario, latitud, longitud) values (?, ?, ?)', self::TABLE_NAME);
		$stmt = $con->prepare($sql, array('integer', 'float', 'float'), MDB2_PREPARE_MANIP);
	
		return $stmt->execute(array($this->getIdUsuario(), $this->getLatitud(), $this->getLongitud()));
	}
	
	
	/**
	  * realiza una actualización
	  */
	  public function update()
	  {
	    $con = ConnectionManager::getInstance()->getConnection();
		
	    $sql = sprintf('UPDATE %s set latitud = ?, longitud = ? WHERE idusuario = ?', self::TABLE_NAME);
	    $stmt = $con->prepare($sql, array('float', 'float', 'integer'), MDB2_PREPARE_MANIP);
		
	    return $stmt->execute(array($this->getLatitud(), $this->getLongitud(), $this->getIdUsuario()));
	  }

	/**
	 * GETTERS Y SETTERS
	 */

	public function getIdUsuario()
	{
		return $this->idusuario;
	}

	public function setIdUsuario($v)
	{
		$this->idusuario = $v;
	}

	public function getLatitud()
	{
		return $this->latitud;
	}
	
	public function setLatitud($v)
	{
		$this->latitud = $v;
	}
	
	public function getLongitud()
	{
		return $this->longitud;
	}
	
	public function setLongitud($v)
	{
		$this->longitud = $v;
	}
}

