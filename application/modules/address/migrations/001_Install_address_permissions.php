<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_address_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Address.Content.View',
			'description' => 'View Address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Content.Create',
			'description' => 'Create Address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Content.Edit',
			'description' => 'Edit Address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Content.Delete',
			'description' => 'Delete Address Content',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Reports.View',
			'description' => 'View Address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Reports.Create',
			'description' => 'Create Address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Reports.Edit',
			'description' => 'Edit Address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Reports.Delete',
			'description' => 'Delete Address Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Settings.View',
			'description' => 'View Address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Settings.Create',
			'description' => 'Create Address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Settings.Edit',
			'description' => 'Edit Address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Settings.Delete',
			'description' => 'Delete Address Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Developer.View',
			'description' => 'View Address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Developer.Create',
			'description' => 'Create Address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Developer.Edit',
			'description' => 'Edit Address Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Address.Developer.Delete',
			'description' => 'Delete Address Developer',
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