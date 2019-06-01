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
        'course' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'year_semester' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'sr_no_for_old_student' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'sr_no_for_new_student' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'category_2' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'bank_name_branch_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 155,
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