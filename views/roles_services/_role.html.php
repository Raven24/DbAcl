<?php
$arrNames = array();
$arrIds = array();
foreach( $role['services'] as $service ) {
    array_push($arrNames, '<span class="service" data-id="'.$service['sid'].'" data-role_id="'.$role['rid'].'"><strong>'.$service['daemon_name'].'</strong><br>'.$service['fqdn'].'</span>');
    array_push($arrIds, $service['sid']);
}
?>
<div data-id="<?= $role['rid'] ?>" data-containing="[<?= implode(',', $arrIds) ?>]" class="role">
    <strong><?= $role['role_name'] ?></strong> <small>(<?= sprintf(ngettext('%d service', '%d services', count($role['services'])), count($role['services'])) ?>)</small><br>
    <div class="services">
        <?= implode('', $arrNames) ?>
    </div>
</div>