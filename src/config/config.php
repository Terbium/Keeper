<?php


return array(

	/*
	 * Default mode for defined rules
	 * Laraon\Keeper\Keeper::ACCESS_ONLY or Laraon\Keeper\Keeper::ACCESS_EXCEPT
	 * ACCESS_ONLY means that only listed groups/users will have access to given obj
	 * ACCESS_EXCEPT means that all groups/users except of listed will have access
	 */
	'default_mode' => Laraon\Keeper\Keeper::ACCESS_ONLY,

	/*
	 * Action for undefined rules
	 * E.g. if access rules for object being checked
	 * are not described
	 */
	'undefined_action' => Laraon\Keeper\Keeper::ACCESS_ALL

);