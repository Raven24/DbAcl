<h1>Listing People</h1>

<?php foreach($people as $pid=>$person) { ?>

  <dl class="listitem person" data-id="<?= $pid ?>">
    <dt>
        <div class="controls">
            <a href="#" onclick="createClient(this, <?= $pid ?>); return false;"><img src="img/add.png" alt="Neuer Client" title="Neuer Client"></a>
            <a href="<?= url_for('people', $pid, 'edit') ?>" class="edit_person"><img src="img/edit.png" alt="edit"></a>
            <a href="<?= url_for('people', $pid) ?>" data-method="delete"><img src="img/delete.png" alt="delete"></a>
        </div>
    
        <strong><?= $person['nachname'] ?></strong> <?= $person['vorname'] ?></span>
    </dt>
    
<?php
  unset($person['vorname']);
  unset($person['nachname']);
?>

<?php foreach($person as $client) { ?>

    <dd data-id="<?= $client['cid'] ?>">
        <?= render('clients/show.html.php', null, array('client'=>$client)) ?>
    </dd>
<?php  } ?>

  </dl>
<?php } ?>


<?php content_for('controls'); ?>
<div id="controls">
    <ul>
        <li><a href="<?= url_for('people','new') ?>" id="createPerson"><img src="img/create_person.png" alt="Neue Person" title="Neue Person"></a></li>
    </ul>
</div>
<?php end_content_for(); ?>


<?php content_for('scripts'); ?>
<script type="text/javascript">

$('.edit_person').live("click", function(){
    var dialog = $('<div id="editPerson"></div>');
    $('body').append(dialog);

    $.get(this.href, {}, function(response) {
        dialog.html(response);
        $('#editPerson').find('input[type=submit]').remove();
    });

    dialog.dialog({
        title: 'Person bearbeiten',
        modal: true,
        buttons: [
            {
                text: 'Speichern',
                click: function() {
                    $('#editPerson').find('form').submit();
                }
            }
        ]
    });

    return false;
});

$('.edit_client').live("click", function(){
    $.getScript(this.href);
    return false;
});

$('#createPerson').click(function() {
    var dialog = $('<div id="create_person"></div>');
    $('body').append(dialog);

    $.get(this.href, {}, function(response){
        dialog.html(response);
        $('#create_person').find('input[type=submit]').remove();
    });

    dialog.dialog({
        title: 'Person erstellen',
        modal: true,
        buttons:[
            {
                text: 'Speichern',
                click: function() {
                    $('#create_person').find('form').submit();
                }
            }
        ]
    });

    return false;
});

var createClient = function(element, id)
{
    $.getScript('<?= str_replace('&amp;', '&', url_for('clients', 'new', array('person_id'=>''))) ?>'+id);
    return false;
};

var currentNav = "people";

</script>
<?php end_content_for(); ?>
