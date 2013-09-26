<?php
/**
 * @package Terbium/Keeper
 * @author Volodimyr Terion Kornilov <mail@terion.name>
 * @copyright Copyright (c) 2013 by Terbium
 * @license MIT
 * @version 1.0
 * @access public
 */

namespace Terbium\Keeper;


use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

class Keeper {

	const DENY_ALL = 0;
	const ACCESS_ALL = 1;
	const ACCESS_ONLY = 2;
	const ACCESS_EXCEPT = 3;

	/**
	 * Set of Rule objects
	 *
	 * @var \SplObjectStorage
	 */
	protected $rules;

	/**
	 * Application instance
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Config instance
	 *
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Default rule mode
	 *
	 * @var int
	 */
	protected $defaultMode;

	/**
	 * Scope stack for grouping feature
	 *
	 * @var \SplStack
	 */
	private $ruleScopeStack;

	/**
	 * @param \Illuminate\Foundation\Application $app
	 */
	public function __construct(Application $app, Repository $config)
	{
		$this->app = $app;
		$this->rules = new \SplObjectStorage();
		$this->defaultMode = $this->config->get('keeper::default_mode');
		$this->ruleScopeStack = new \SplStack();
	}


	/**
	 * Register an access rule
	 *
	 * @param string $name
	 * @param callable $rule
	 * @param string $label
	 * @param int $mode
	 * @throws \InvalidArgumentException
	 */
	public function register($name, \Closure $rule = null, $label = '', $mode = null) {
		// Check input
		if (!is_int($mode)) {
			$mode = $this->defaultMode;
		}
		if ( $mode !== self::ACCESS_ONLY && $mode !== self::ACCESS_EXCEPT ) {
			throw new \InvalidArgumentException('Rule mode is incorrect');
		}
		// Create new rule
		// TODO: учесть текущий scope
		$rule = new Rule($name, $rule, $label, $mode);
		// Attach it in the storage
		$this->rules->attach($rule);
	}

	/**
	 * Group rules
	 *
	 * @param $name
	 * @param callable $nestedRules
	 * @param callable $rule
	 * @param string $label
	 * @param null $mode
	 * @throws \InvalidArgumentException
	 */
	public function group($name, \Closure $nestedRules, \Closure $rule = null, $label = '', $mode = null) {
		// Check input
		if (!is_int($mode)) {
			$mode = $this->defaultMode;
		}
		if ( $mode !== self::ACCESS_ONLY && $mode !== self::ACCESS_EXCEPT ) {
			throw new \InvalidArgumentException('Rule mode is incorrect');
		}


	}

	private function getScope() {
		if ( $this->ruleScopeStack->isEmpty() ) {
			return null;
		}

		$this->ruleScopeStack->rewind();

		// Set current scope
		$current = $this->ruleScopeStack->current();
		$scope = array(
			'name' => $current['name'],
			'rule' => $current['rule'],
			'label' => $current['label'],
			'mode' => $current['mode']
		);

		// Chain the rule name (e.g. blog.blogname.edit)
		//TODO: функции проверки тоже чейнить нужно
		$this->ruleScopeStack->next();
		while( $this->ruleScopeStack->valid() )
		{
			$scope['name'] = str_finish($this->ruleScopeStack->current()['name'], '.') . $scope['name'];
			$this->ruleScopeStack->next();
		}

		return $scope;
	}

	/**
	 * @param string|Rule $rule
	 * @param mixed $obj
	 * @param \User $user
	 */
	public function check($rule, $obj = null, $user = null) {
		// TODO
	}

	public function listRules() {
		// TODO
	}

	/**
	 * @param int $defaultMode
	 */
	public function setDefaultMode($defaultMode)
	{
		$this->defaultMode = $defaultMode;
	}

	/**
	 * @return int
	 */
	public function getDefaultMode()
	{
		return $this->defaultMode;
	}



}