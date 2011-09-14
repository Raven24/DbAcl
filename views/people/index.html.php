<h1><?= _('Listing people') ?></h1>

<?php foreach($people as $pid=>$person) { ?>

  <dl class="listitem person" data-id="<?= $pid ?>">
    <dt>
        <div class="controls">
            <a href="<?= url_for('clients', 'new', array('person_id' => $pid, 'nested'=>'person')) ?>" class="add_client"><img src="img/add.png" alt="<?= _('New client') ?>" title="<?= _('New client') ?>"></a>
            <a href="<?= url_for('people', $pid, 'edit') ?>" class="edit_person"><img src="img/edit.png" alt="<?= _('Edit person') ?>" title="<?= _('Edit person') ?>"></a>
            <a href="<?= url_for('people', $pid) ?>" data-method="delete"><img src="img/delete.png" alt="<?= _('Delete person') ?>" title="<?= _('Delete person') ?>"></a>
        </div>
    
        <strong><?= $person['nachname'] ?></strong> <?= $person['vorname'] ?> <small>(<?= sprintf(ngettext('%d client', '%d clients', count($person['clients'])), count($person['clients'])) ?>)</small>
    </dt>
<?php foreach($person['clients'] as $client) { 

    echo partial('clients/show.person.html.php', array('client'=>$client));
   
} ?>

  </dl>
<?php } ?>


<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('people','new') ?>" id="createPerson"><img src="img/create_person.png" alt="<?= _('Create person') ?>" title="<?= _('Create person') ?>"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>


<?php content_for('scripts'); ?> 

<?= HTML::script("
$('#createPerson, .add_client, .edit_person').click( function() {
    $.getScript(this.href);
    return false;
});
$('.edit_client').live('click', function(event){
    $.getScript(this.href);
    return false;
});
var currentNav = 'people';
") ?>

<?php end_content_for(); ?>
