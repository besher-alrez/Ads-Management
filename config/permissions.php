<?php

$permissions = [
	'change password' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.access.change_password.description',
		'display_name' => 'permissions.access.change_password.display_name',
	],

	'create roles' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.create.roles.description',
		'display_name' => 'permissions.create.roles.display_name',
	],

	'create users' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.create.users.description',
		'display_name' => 'permissions.create.users.display_name',
	],

	'delete roles' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.delete.roles.description',
		'display_name' => 'permissions.delete.roles.display_name',
	],

	'delete users' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.delete.users.description',
		'display_name' => 'permissions.delete.users.display_name',
	],

	'edit roles' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.edit.roles.description',
		'display_name' => 'permissions.edit.roles.display_name',
	],

	'edit users' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.edit.users.description',
		'display_name' => 'permissions.edit.users.display_name',
	],

	'impersonate users' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.impersonate.description',
		'display_name' => 'permissions.impersonate.display_name',
	],

	'view roles' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.view.roles.description',
		'display_name' => 'permissions.view.roles.display_name',
	],

	'view users' =>	[
		'category' => 'permissions.categories.access',
		'description' => 'permissions.view.users.description',
		'display_name' => 'permissions.view.users.display_name',
	],

];

$path = config_path('modules_permissions');

foreach (glob("{$path}/*.php") as $filename)
{
    $permission = include $filename;
    $permissions = array_merge($permissions, $permission);
}

return $permissions;
