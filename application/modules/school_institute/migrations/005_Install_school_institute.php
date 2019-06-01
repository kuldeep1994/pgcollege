<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_school_institute extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'school_institute';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'institute_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'registration_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'address' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
        'city' => array(
            'type'       => 'VARCHAR',
            'constraint' => 50,
            'null'       => false,
        ),
        'state' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'zip_code' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'country' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'deleted' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => '0',
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'modified_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
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