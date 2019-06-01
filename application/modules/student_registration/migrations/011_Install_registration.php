<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_registration extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'qualification';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'last_name' => array(
			'type'       => 'VARCHAR',
			'constraint' => 30,
			'null'       => true,
		),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->down();
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}