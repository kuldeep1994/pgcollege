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
            'v_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 150,
            'null'       => false,
		),
		'standard' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
		),
		'fee_category' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
		),
		'date' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
		),
		'test_date' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
		),
		'subjects' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
		),
		'last_standard' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
		),
		'registration_fee' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
		),
		'alternate_number' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
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