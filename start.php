<?php

elgg_register_event_handler('init', 'system', 'entity_admins_init');

function entity_admins_init() {
	elgg_register_event_handler('create', 'all', 'entity_admins_manage_admins');
	elgg_register_event_handler('update', 'all', 'entity_admins_manage_admins');
	
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'entity_admins_permission_check');
}

function entity_admins_manage_admins($event, $object_type, $object) {
	if (get_input('entity-admins-support') && $object) {
		remove_entity_relationships($object->guid, 'entity_admin_for', TRUE);
		// currently the userpicker name is hardcoded to "members"
		$members = get_input('members');
		if ($members) {
			foreach($members as $guid) {
				add_entity_relationship($guid,'entity_admin_for',$object->guid);
			}
		}
	}
}

function entity_admins_permission_check($hook, $entity_type, $returnvalue, $params) {
	if ($returnvalue) {
		return $returnvalue;
	}
	$e = $params['entity'];
	if ($e) {
		$user_guid = elgg_get_logged_in_user_guid();
		$guid = $e->guid;
		if ($user_guid && $guid && check_entity_relationship($user_guid,'entity_admin_for',$guid)) {
			return TRUE;
		}
	}
}
