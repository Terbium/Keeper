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

use Illuminate\Console\Command;


class KeeperPrintRulesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'keeper:print';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Prints Keeper access rules.';

	/**
	 * The ProviderCreator instance
	 *
	 * @var ProviderCreator
	 */
	protected $keeper;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Keeper $keeper)
	{
		parent::__construct();

		$this->keeper = $keeper;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// TODO
	}


}