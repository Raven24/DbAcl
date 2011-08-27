<?php

# people index
dispatch('/people', 'people_index');
function people_index()
{
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    # query the database
    $arrClients = $db->select(
        "SELECT {$cfg['tblPerson']}.id as pid,
                {$cfg['tblClient']}.id as cid,
                {$cfg['tblPerson']}.*,
                {$cfg['tblClient']}.*

        FROM {$cfg['tblPerson']}
        LEFT JOIN {$cfg['tblClient']}
        ON {$cfg['tblClient']}.person_id = {$cfg['tblPerson']}.id
        ORDER BY {$cfg['tblPerson']}.nachname ASC"
    );

    # create a nested array of people with their clients
    $currPerson = 0;
    $arrPersonen = array();
    foreach($arrClients as $entry)
    {
        if( $currPerson != $entry['pid'] ) {
            $currPerson = $entry['pid'];
            $arrPersonen[$currPerson] = array();
            $arrPersonen[$currPerson]['vorname']  = $entry['vorname'];
            $arrPersonen[$currPerson]['nachname'] = $entry['nachname'];
        }

        array_push($arrPersonen[$currPerson], $entry);
    }

    set('people', $arrPersonen);

    return html('people/index.html.php');
}

# show form for new person
dispatch('/people/new', 'people_new');
function people_new()
{
    if( isAjaxRequest() )
    {
        return html('people/new.js.php', null);
    }
    
    return html('people/new.html.php');
}

# do stuff with newly created person
dispatch_post('/people', 'people_create');
function people_create()
{
    return print_r($_POST, true);
}

# edit form
dispatch('/people/:id/edit', 'people_edit');
function people_edit()
{
    $id = intval(params('id'));
    $cfg = $GLOBALS['cfg'];
    $db  = $GLOBALS['db'];
    
    $arrPerson = $db->select(
        "SELECT *
        FROM {$cfg['tblPerson']}
        WHERE id=$id"
    );
    
    if( $arrPerson )
    {
        set('person', $arrPerson[0]);
        
        if( isAjaxRequest() )
        {
            return html('people/edit.js.php', null);
        }
        
        return html('people/edit.html.php');
    }

    halt(NOT_FOUND);
}

# update existing person
dispatch_put('/people', 'people_update');
function people_update()
{
    return print_r($_POST, true);
}

dispatch_delete('/people/:id', 'people_delete');
function people_delete()
{
    return print_r(params('id'), true);
}

/*
$cfg = $GLOBALS['cfg'];
$db  = $GLOBALS['db'];

$content = '';

$arrClients = $db->select(
    "SELECT {$cfg['tblPerson']}.id as pid,
            {$cfg['tblClient']}.id as cid,
            {$cfg['tblPerson']}.*,
            {$cfg['tblClient']}.*
            
    FROM {$cfg['tblPerson']}
    LEFT JOIN {$cfg['tblClient']}
    ON {$cfg['tblClient']}.person_id = {$cfg['tblPerson']}.id
    ORDER BY {$cfg['tblPerson']}.nachname ASC"
);

//$content = dbg($arrPersonen);

$currPerson = 0;
$arrPersonen = array();
foreach($arrClients as $entry)
{
    if( $currPerson != $entry['pid'] ) {
        $currPerson = $entry['pid'];
        $arrPersonen[$currPerson] = array();
        $arrPersonen[$currPerson]['vorname']  = $entry['vorname'];
        $arrPersonen[$currPerson]['nachname'] = $entry['nachname'];
    }

    array_push($arrPersonen[$currPerson], $entry);
}

//$content = dbg($arrClients);

foreach($arrPersonen as $pid=>$person)
{
    $content .= "<dl class='listitem person'>";
    $content .= "<dt data-id='{$pid}'><strong><span class='nachname'>{$person['nachname']}</span></strong> <span class='vorname'>{$person['vorname']}</span></dt>";
    unset($person['vorname']);
    unset($person['nachname']);

    foreach($person as $client)
    {
        $content .= "<dd data-id='{$client['cid']}'>[<span class='type'>{$client['type']}</span>] <span class='desc'>{$client['desc']}</span>: \n<span class='mac'>{$client['mac']}</span></dd>";
    }
    
    $content .= "</dl>\n";
}

$content .=<<<EOT
<div id="controls">
    <ul>
        <li><a href="#" onclick="createPerson(); return false;">Neue Person</a></li>
        <li><a href="#" onclick="createClient(); return false;">Neuer Client</a></li>
    </ul>
</div>
EOT;



$scripts=<<<EOT
var createPerson = function()
{
    var form = $('<div id="createPerson"><form action="submit.php" method="POST"></form></div>');
    form.hide();
    var innerForm = form.find('form');
    innerForm.append('<label for="vorname">Vorname</label><input type="text" name="vorname" value="">');
    innerForm.append('<label for="nachname">Nachname</label><input type="text" name="nachname" value="">');

    $('body').append(form);
    $('#createPerson').dialog({
        title: "Person anlegen",
        modal: true,
        buttons: [
            {
                text: 'Speichern',
                click: function() {
                    innerForm.submit();
                }
            }
        ]
    });
}

$(document).ready(function()
{

    var editblCfg = {
        'style'      : 'inherit',
        'cssclass'   : 'editable',
        'type'       : 'text',
        'placeholder': '<small>[edit]</small>'
    };

    $('.nachname, .vorname').editable(function(val, settings){
        //console.log($(this).parents('dt').data('id'));
        $.post('submit.php', {
            'mode' : 'update',
            'id'   : $(this).parents('dt').data('id'),
            'tbl'  : '{$cfg['tblPerson']}',
            'field': $(this).attr('class'),
            'value': val
        });
        return val;
    }, editblCfg);
    
    $('.type, .desc, .mac').editable(function(val, settings){
        //console.log($(this).parents('dd').data('id'));
        $.post('submit.php', {
            'mode' : 'update',
            'id'   : $(this).parents('dd').data('id'),
            'tbl'  : '{$cfg['tblClient']}',
            'field': $(this).attr('class'),
            'value': val
        });
        return val;
    }, editblCfg);

    // ### quit while we're ahead
    return;
    // ###
    
    var r = new Raphael("main");

    var y = 30;
    var x1 = 30;
    var x2 = x1+150;
    var initialWidth = 80;
    var personElements = r.set(),
        clientElements = r.set(),
        clientElementsTxt = r.set(),
        connections    = new Array();

    var textx = 10;
    var texty = 10;
    var maxpTextWidth = 0,
        maxpTextHeight = 0,
        maxcTextWidth = 0,
        maxcTextHeight = 0;
        
    $('#main dt').each(function(){

        var el = r.rect(x1, y, initialWidth, 20, 4);
        el.attr({fill: '#222', stroke: '#666'});
        personElements.push(el);
        
        var txt = r.text(x1+textx, y+texty, $(this).contents().filter(function(){ return(this.nodeType == 3); }).text());
        txt.attr({fill: '#FFF', 'text-anchor': 'start', 'font-size': 12});

        var grp = r.set();
        grp.push(el);
        grp.push(txt);

        if( $(txt.node).width() > maxpTextWidth ) 
            maxpTextWidth = $(txt.node).width();
        
        if( $(txt.node).height() > maxpTextHeight ) 
            maxpTextHeight = $(txt.node).height();
        
        
        var clients = $(this).siblings('dd');
        if( clients.length > 0 )
        {
            clients.each(function(){
                var el2 = r.rect( x2, y, initialWidth, 20, 4);
                el2.attr({fill: '#222', stroke: '#666'});
                clientElements.push(el2);

                $(el2.node).dblclick(function() {
                    el2.lines.hide();
                    el2.neighbours.hide();
                    
                });
                
                var txt2 = r.text(x2+textx, y+texty, $(this).contents().filter(function(){ return(this.nodeType == 3); }).text());
                txt2.attr({fill: '#FFF', 'text-anchor': 'start', 'font-size': 12});
                clientElements.push(txt2);
                clientElementsTxt.push(txt2);
                
                if( $(txt2.node).width() > maxcTextWidth ) 
                    maxcTextWidth = $(txt2.node).width();

                if( $(txt2.node).height() > maxcTextHeight )
                    maxcTextHeight = $(txt2.node).height();
                    
                y += maxcTextHeight + x1;

                connections.push( r.connection( grp, el2, '#000', '#BBB' ) );
            })
        } else {
            y += maxcTextHeight + x1;
        }


    });

    personElements.attr('width', maxpTextWidth + textx );
    clientElements.attr({
        'width' : maxcTextWidth + textx,
        'height': maxcTextHeight + texty
    });
    clientElements.translate( maxpTextWidth-initialWidth, -texty);
    clientElementsTxt.translate(0, (maxcTextHeight/2)-(texty/2) )
           
    for (var i = connections.length; i--;) {
        r.connection(connections[i]);
    }

    //console.log(clientElements);
    $('#main svg').height( (clientElementsTxt.length * (maxcTextHeight+x1)) );
    $('#main').css('height', $('#main svg').height()+50);
    $('dl').hide();
});
EOT;
*/
?>