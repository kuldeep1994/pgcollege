<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_registration extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'registration';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'last_school' => array(
			'type'       => 'VARCHAR',
			'constraint' => 100,
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