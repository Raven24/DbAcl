<h1>Listing Roles</h1>

<?php foreach( $roles as $role ) { ?>

<dl class="listitem role" data-id="<?= $role['rid'] ?>">
    <dt>
        <div class="controls">
            [<a href="<?= url_for('roles', $role['rid'], 'people', 'new') ?>" class="add_person">Person hinzufügen</a>]
            [<a href="<?= url_for('roles', $role['rid'], 'edit') ?>" class="edit_role">edit</a>]
            [<a href="<?= url_for('roles', $role['rid']) ?>" data-method="delete">delete</a>]
        </div>
        <strong><?= $role['name'] ?></strong> <small><?= $role['desc'] ?></small>
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
        <li><a href="<?= url_for('roles','new') ?>" id="createRole">Neue Rolle</a></li>
    </ul>
</div>
<?php end_content_for(); ?>

<?php content_for('scripts'); ?>
<script type="text/javascript">

$('#createRole, .edit_role, .add_person').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = "roles";

</script>
<?php end_content_for(); ?>