<?php

class Configuracion extends BaseObject
{
	/**
	 * nombre de la tabla
	 */
	const TABLE_NAME = 'configuracion';

	/**
	 * atributos
	 */
	protected

	$nombre,
	$itemsxpag,
	$estiloactual;


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

	/**
	 * realiza una actualización
	 */
	public function update()
	{
		$con = ConnectionManager::getInstance()->getConnection();

		$sql = sprintf('UPDATE %s set nombre = ?, itemsxpag = ?, estiloactual = ?', self::TABLE_NAME);
		$stmt = $con->prepare($sql, array('text', 'integer', 'text'), MDB2_PREPARE_MANIP);

		return $stmt->execute(array($this->getNombre(), $this->getItemsxpag(), $this->getEstiloactual()));
	}

	/**
	 * GETTERS Y SETTERS
	 */

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($v)
	{
		$this->nombre = $v;
	}

	public function getItemsxpag()
	{
		return $this->itemsxpag;
	}
	
	public function setItemsxpag($v)
	{
		$this->itemsxpag = $v;
	}
	
	public function getEstiloactual()
	{
		return $this->estiloactual;
	}
	
	public function setEstiloactual($v)
	{
		$this->estiloactual = $v;
	}
}

