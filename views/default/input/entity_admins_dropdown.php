<?php
$guids = array();
$entity = $vars['entity'];
if ($entity) {
	$options = array(
		'type' => 'user',
		'relationship' => 'entity_admin_for',
		'relationship_guid' => $entity->guid,
		'inverse_relationship' => TRUE,
	);
	$users = elgg_get_entities_from_relationship($options);
	foreach ($users as $user) {
		$guids[] = $user->guid;
	}
}

echo elgg_view('input/hidden',array('name'=>'entity-admins-support','value'=>1));
echo elgg_view('input/userpicker',array('value'=>$guids));
