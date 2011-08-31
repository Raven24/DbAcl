<h1><?= _('Listing roles') ?></h1>

<?php foreach( $roles as $role ) { ?>

<dl class="listitem role" data-id="<?= $role['rid'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('roles', $role['rid'], 'people', 'new') ?>" class="add_person"><img src="img/add.png" alt="<?= _('Add person') ?>" title="<?= _('Add person') ?>"></a>
            <a href="<?= url_for('roles', $role['rid'], 'edit') ?>" class="edit_role"><img src="img/edit.png" alt="<?= _('Edit role') ?>" title="<?= _('Edit role') ?>"></a>
            <a href="<?= url_for('roles', $role['rid']) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _('Delete role') ?>" title="<?= _('Delete role') ?>"></a>
        </div>
        <strong><?= $role['name'] ?></strong> <small>(<?= sprintf(ngettext('%d person', '%d people', count($role['people'])), count($role['people'])) ?>)</small><br>
        <?= $role['desc'] ?>
    </dt>   
<?php
foreach($role['people'] as $person) {
    $role['id'] = $role['rid'];
    $person['id'] = $person['pid'];
?>
    <dd data-id="<?= $person['pid'] ?>">
        <?= render('people/show.html.php', null, array('person'=>$person, 'role'=>$role)) ?>
    </dd>
<?php } ?>
</dl>

<?php } ?>

<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('roles','new') ?>" id="createRole"><img src="img/create_role.png" alt="Neue Rolle" title="Neue Rolle"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

// hide the clients on pageload
$('dd').hide();

// make name clickable and show clients onclick
$('dt')
  .css('cursor','pointer')
  .click(function() {
    var children = $(this).parents('dl').find('dd');
    children.slideToggle('fast', 'swing');
  });

$('#createRole, .edit_role, .add_person').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = "roles";

</script>
<?php end_content_for(); ?>