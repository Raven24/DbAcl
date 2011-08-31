<?php
$arrNames = array();
$arrIds = array();
foreach( $role['people'] as $person ) {
    array_push($arrNames, '<span class="person" data-id="'.$person['pid'].'" data-role_id="'.$role['rid'].'">'.$person['nachname'].'</span>');
    array_push($arrIds, $person['pid']);
}
?>
<div data-id="<?= $role['rid'] ?>" data-containing="[<?= implode(',', $arrIds) ?>]" class="role">
    <strong><?= $role['name'] ?></strong> <small>(<?= sprintf(ngettext('%d person', '%d people', count($role['people'])), count($role['people'])) ?>)</small><br>
    <?= $role['desc'] ?>
    <div class="people">
        <?= implode(', ', $arrNames) ?>
    </div>
</div>