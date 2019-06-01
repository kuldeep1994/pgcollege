<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_local_address extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'local_address';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'registration_d' => array(
			'type'       => 'INT',
			'constraint' => 11,
		),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_column($this->table_name,$this->fields);
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