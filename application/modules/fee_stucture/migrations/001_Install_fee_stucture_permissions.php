<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_fee_stucture_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Fee_stucture.Content.View',
			'description' => 'View Fee_stucture Content',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Content.Create',
			'description' => 'Create Fee_stucture Content',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Content.Edit',
			'description' => 'Edit Fee_stucture Content',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Content.Delete',
			'description' => 'Delete Fee_stucture Content',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Master.View',
			'description' => 'View Fee_stucture Master',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Master.Create',
			'description' => 'Create Fee_stucture Master',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Master.Edit',
			'description' => 'Edit Fee_stucture Master',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Master.Delete',
			'description' => 'Delete Fee_stucture Master',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Reports.View',
			'description' => 'View Fee_stucture Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Reports.Create',
			'description' => 'Create Fee_stucture Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Reports.Edit',
			'description' => 'Edit Fee_stucture Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Reports.Delete',
			'description' => 'Delete Fee_stucture Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Settings.View',
			'description' => 'View Fee_stucture Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Settings.Create',
			'description' => 'Create Fee_stucture Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Settings.Edit',
			'description' => 'Edit Fee_stucture Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Settings.Delete',
			'description' => 'Delete Fee_stucture Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Developer.View',
			'description' => 'View Fee_stucture Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Developer.Create',
			'description' => 'Create Fee_stucture Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Developer.Edit',
			'description' => 'Edit Fee_stucture Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Fee_stucture.Developer.Delete',
			'description' => 'Delete Fee_stucture Developer',
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