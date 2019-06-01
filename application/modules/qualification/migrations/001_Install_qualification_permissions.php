<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_qualification_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Qualification.Content.View',
			'description' => 'View Qualification Content',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Content.Create',
			'description' => 'Create Qualification Content',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Content.Edit',
			'description' => 'Edit Qualification Content',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Content.Delete',
			'description' => 'Delete Qualification Content',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Master.View',
			'description' => 'View Qualification Master',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Master.Create',
			'description' => 'Create Qualification Master',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Master.Edit',
			'description' => 'Edit Qualification Master',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Master.Delete',
			'description' => 'Delete Qualification Master',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Reports.View',
			'description' => 'View Qualification Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Reports.Create',
			'description' => 'Create Qualification Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Reports.Edit',
			'description' => 'Edit Qualification Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Reports.Delete',
			'description' => 'Delete Qualification Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Settings.View',
			'description' => 'View Qualification Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Settings.Create',
			'description' => 'Create Qualification Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Settings.Edit',
			'description' => 'Edit Qualification Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Settings.Delete',
			'description' => 'Delete Qualification Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Developer.View',
			'description' => 'View Qualification Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Developer.Create',
			'description' => 'Create Qualification Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Developer.Edit',
			'description' => 'Edit Qualification Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Qualification.Developer.Delete',
			'description' => 'Delete Qualification Developer',
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