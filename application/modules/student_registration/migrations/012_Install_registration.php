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
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
		'v_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 150,
            'null'       => false,
		),
		'registration_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
		'registration_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ),
        'student_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
		),
		'father_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
		),
		'mother_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
		),
		'standard' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
		),
		'last_standard' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => false,
		),
        'gender' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'dob' => array(
            'type'       => 'DATE',
            'null'       => false,
            'default'    => '0000-00-00',
        ),
        'nationality' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'relegion' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'caste' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'cast_category' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
		),
		'sub_category' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
		),
		'annual_income' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'aadhar_number' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'mobile_number' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
		),
		'alternate_number' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
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
		'registration_fee' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
		),
        'deleted' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => '0',
        ),
        'deleted_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
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
		$this->down();
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