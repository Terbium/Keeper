<?php
/**
 * @package Laraon/Keeper
 * @author Volodimyr Terion Kornilov <mail@terion.name>
 * @copyright Copyright (c) 2013 by Laraon
 * @license MIT
 * @version 1.0
 * @access public
 */

namespace Laraon\Keeper;


class Rule implements \Serializable {

	/**
	 * The name of rule
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Readable label for this rule
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * Comparing rule
	 *
	 * @var callable
	 */
	protected $rule;

	/**
	 * Rule mode (Keeper::ACCESS_ONLY | Keeper::ACCESS_EXCEPT)
	 *
	 * @var int
	 */
	protected $mode;

	public function __construct($name = null, $rule = null, $label = null, $mode = null)
	{
		if (is_string($name)) {
			$this->setName($name);
		}

		if (is_callable($rule)) {
			$this->setRule($rule);
		}

		if (is_string($label)) {
			$this->setLabel($label);
		}

		if (is_int($mode)) {
			$this->setMode($mode);
		}
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * String representation of object
	 * @link http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or null
	 */
	public function serialize()
	{
		$data = array(
			'name' => $this->name,
			'rule' => $this->rule,
			'label' => $this->label,
			'mode' => $this->mode
		);
		return serialize($data);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Constructs the object
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 * @param string $serialized <p>
	 * The string representation of the object.
	 * </p>
	 * @return void
	 */
	public function unserialize($serialized)
	{
		$data = unserialize($serialized);
		$this->name = $data['name'];
		$this->rule = $data['rule'];
		$this->label = $data['label'];
		$this->mode = $data['mode'];
	}


	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param callable $rule
	 */
	public function setRule($rule)
	{
		$this->rule = $rule;
	}

	/**
	 * @return callable
	 */
	public function getRule()
	{
		return $this->rule;
	}

	/**
	 * @param int $mode
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
	}

	/**
	 * @return int
	 */
	public function getMode()
	{
		return $this->mode;
	}




}