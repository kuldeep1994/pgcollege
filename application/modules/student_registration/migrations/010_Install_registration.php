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
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
		'registration_no' => array(
			'type'       => 'VARCHAR',
			'constraint' => 100,
			'null'       => true,
		),
		'class' => array(
			'type'       => 'VARCHAR',
			'constraint' => 30,
			'null'       => false,
		),
		'stream' => array(
			'type'       => 'VARCHAR',
			'constraint' => 30,
			'null'       => false,
		),
		'organization' => array(
			'type'       => 'VARCHAR',
			'constraint' => 100,
			'null'       => false,
		),
		'board' => array(
			'type'       => 'VARCHAR',
			'constraint' => 100,
			'null'       => true,
		),
		'roll_no' => array(
			'type'       => 'VARCHAR',
			'constraint' => 50,
			'null'       => false,
		),
		'total_marks' => array(
			'type'       => 'VARCHAR',
			'constraint' => 50,
			'null'       => true,
		),
		'percentage' => array(
			'type'       => 'VARCHAR',
			'constraint' => 50,
			'null'       => true,
		),
		'pass_year' => array(
			'type'       => 'VARCHAR',
			'constraint' => 50,
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
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
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