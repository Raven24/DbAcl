<h1>Listing People</h1>

<?php foreach($people as $pid=>$person) { ?>

  <dl class="listitem person" data-id="<?= $pid ?>">
    <dt>
        <div class="controls">
            [<a href="#" onclick="createClient(this, <?= $pid ?>); return false;">Neuer Client</a>]
            [<a href="<?= url_for('people', $pid, 'edit') ?>" class="edit_person">edit</a>]
            [<a href="<?= url_for('people', $pid) ?>" data-method="delete">delete</a>]
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
        <li><a href="<?= url_for('people','new') ?>" id="createPerson">Neue Person</a></li>
    </ul>
</div>
<?php end_content_for(); ?>


<?php content_for('scripts'); ?>
<script type="text/javascript">

$('.edit_person').click(function(){
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

$('.edit_client').click(function(){
    $.getScript(this.href);
    return false;
});

$('#createPerson').click(function() {
    var dialog = $('<div id="createPerson"></div>');
    $('body').append(dialog);

    $.get(this.href, {}, function(response){
        dialog.html(response);
        $('#createPerson').find('input[type=submit]').remove();
    });

    dialog.dialog({
        title: 'Person erstellen',
        modal: true,
        buttons:[
            {
                text: 'Speichern',
                click: function() {
                    $('#createPerson').find('form').submit();
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

</script>
<?php end_content_for(); ?>
