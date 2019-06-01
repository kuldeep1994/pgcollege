<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_fee_stucture extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'fee_stucture';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'fee_head_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => false,
        ),
        'course_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => false,
        ),
        'year_or_semester_id' => array(
            'type'       => 'BIGINT',
            'constraint' => 10,
            'null'       => false,
        ),
        'frequency' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'amount' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'created_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'modified_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'modified_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
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