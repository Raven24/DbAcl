<h1>Listing Roles</h1>

<?php foreach( $roles as $role ) { ?>

<dl class="listitem role" data-id="<?= $role['rolle_id'] ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('roles', $role['rolle_id'], 'service', 'new') ?>" class="add_service"><img src="img/add.png" alt="Dienst hinzufügen" title="Dienst hinzufügen"></a>
        </div>
        <strong><?= $role['rolle_name'] ?></strong> <small><?= $role['rolle_desc'] ?></small>
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
<script type="text/javascript">

$('.add_service').click(function() {
   $.getScript(this.href);
   return false;
});

var currentNav = "access";

</script>
<?php end_content_for(); ?>