<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_account_head_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Account_head.Master.View',
			'description' => 'View Account_head Content',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Master.Create',
			'description' => 'Create Account_head Content',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Master.Edit',
			'description' => 'Edit Account_head Content',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Master.Delete',
			'description' => 'Delete Account_head Content',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Reports.View',
			'description' => 'View Account_head Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Reports.Create',
			'description' => 'Create Account_head Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Reports.Edit',
			'description' => 'Edit Account_head Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Reports.Delete',
			'description' => 'Delete Account_head Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Settings.View',
			'description' => 'View Account_head Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Settings.Create',
			'description' => 'Create Account_head Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Settings.Edit',
			'description' => 'Edit Account_head Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Settings.Delete',
			'description' => 'Delete Account_head Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Developer.View',
			'description' => 'View Account_head Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Developer.Create',
			'description' => 'Create Account_head Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Developer.Edit',
			'description' => 'Edit Account_head Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Account_head.Developer.Delete',
			'description' => 'Delete Account_head Developer',
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
		$rolePermissionsData = array();
		foreach ($this->permissionValues as $permissionValue) {
			$this->db->insert($this->tableName, $permissionValue);

			$rolePermissionsData[] = array(
                $this->roleKey       => $this->roleId,
                $this->permissionKey => $this->db->insert_id(),
			);
		}

		$this->db->insert_batch($this->rolePermissionsTable, $rolePermissionsData);
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