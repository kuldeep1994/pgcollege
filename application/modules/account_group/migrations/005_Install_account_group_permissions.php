<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_account_group_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Account_group.Reports.View',
			'description' => 'View Account_group Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Reports.Create',
			'description' => 'Create Account_group Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Reports.Edit',
			'description' => 'Edit Account_group Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Reports.Delete',
			'description' => 'Delete Account_group Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Settings.View',
			'description' => 'View Account_group Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Settings.Create',
			'description' => 'Create Account_group Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Settings.Edit',
			'description' => 'Edit Account_group Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Settings.Delete',
			'description' => 'Delete Account_group Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Developer.View',
			'description' => 'View Account_group Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Developer.Create',
			'description' => 'Create Account_group Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Developer.Edit',
			'description' => 'Edit Account_group Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_group.Developer.Delete',
			'description' => 'Delete Account_group Developer',
			'status' => 'active',
		),
    );

    /**
     * @var string The name of the permission key in the role_permissions table
     */
    private $permissionKey = 'permission_id';

    /**
     * @var string The name of the permission name field in the permissions table
     */
    private $permissionNameField = 'name';

	/**
	 * @var string The name of the role/permissions ref table
	 */
	private $rolePermissionsTable = 'role_permissions';

    /**
     * @var numeric The role id to which the permissions will be applied
     */
    private $roleId = '1';

    /**
     * @var string The name of the role key in the role_permissions table
     */
    private $roleKey = 'role_id';

	/**
	 * @var string The name of the permissions table
	 */
	private $tableName = 'permissions';

	//--------------------------------------------------------------------

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
        $this->down();
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
        $permissionNames = array();
		foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                          ->where_in($this->permissionNameField, $permissionNames)
                          ->get($this->tableName);

        if ( ! $query->num_rows()) {
            return;
        }

        $permissionIds = array();
        foreach ($query->result() as $row) {
            $permissionIds[] = $row->{$this->permissionKey};
        }

        $this->db->where_in($this->permissionKey, $permissionIds)
                 ->delete($this->rolePermissionsTable);

        $this->db->where_in($this->permissionNameField, $permissionNames)
                 ->delete($this->tableName);
	}
}