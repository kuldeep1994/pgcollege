<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_local_address_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Local_address.Master.View',
			'description' => 'View Local_address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Master.Create',
			'description' => 'Create Local_address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Master.Edit',
			'description' => 'Edit Local_address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Master.Delete',
			'description' => 'Delete Local_address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Reports.View',
			'description' => 'View Local_address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Reports.Create',
			'description' => 'Create Local_address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Reports.Edit',
			'description' => 'Edit Local_address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Reports.Delete',
			'description' => 'Delete Local_address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Settings.View',
			'description' => 'View Local_address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Settings.Create',
			'description' => 'Create Local_address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Settings.Edit',
			'description' => 'Edit Local_address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Settings.Delete',
			'description' => 'Delete Local_address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Developer.View',
			'description' => 'View Local_address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Developer.Create',
			'description' => 'Create Local_address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Developer.Edit',
			'description' => 'Edit Local_address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Local_address.Developer.Delete',
			'description' => 'Delete Local_address Developer',
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