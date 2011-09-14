<h1><?= _("Listing roles")?></h1>

<?php foreach( $roles as $role ) { ?>

<dl class="listitem role" data-id="<?= $role['rolle_id'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('roles', $role['rolle_id'], 'service', 'new') ?>" class="add_service"><img src="img/add.png" alt="<?= _("Add service") ?>" title="<?= _("Add service") ?>"></a>
        </div>
        <strong><?= $role['rolle_name'] ?></strong> <?= $role['rolle_desc'] ?> <small>(<?= sprintf(ngettext('%d service', '%d services', count($role['services'])), count($role['services'])) ?>)</small>
    </dt>
<?php
foreach($role['services'] as $service) {
    $role['id'] = $role['rolle_id'];
?>
    <dd data-id="<?= $service['dienst_id'] ?>">
        <?= render('access/show.html.php', null, array('service'=>$service,'role'=>$role)) ?>
    </dd>
<?php } ?>
</dl>

<?php } ?>

<?php content_for('scripts'); ?> 

<?= HTML::script("
$('.add_service').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = 'access';
") ?>

<?php end_content_for(); ?>