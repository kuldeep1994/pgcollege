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
        'first_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'last_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
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
        'registration_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ),
        'nationality' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'annual_income' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
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
        'aadhar_number' => array(
            'type'       => 'BIGINT',
            'null'       => false,
        ),
        'mobile_number' => array(
            'type'       => 'BIGINT',
            'null'       => true,
        ),
        'email_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 75,
            'null'       => true,
        ),
        'birth_of_place' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ),
        'martial_status' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'disability' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
        'mark_of_identification' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
        ),
        'last_school_rool_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 100,
            'null'       => true,
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
        'account_no' => array(
            'type'       => 'VARCHAR',
            'constraint' => 150,
            'null'       => false,
        ),
        'ifsc_code' => array(
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