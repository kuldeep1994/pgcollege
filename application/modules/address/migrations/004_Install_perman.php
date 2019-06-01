<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_perman extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'perman';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
        'registration_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        )
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