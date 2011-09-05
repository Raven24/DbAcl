
// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
    arguments.callee = arguments.callee.caller;
    var newarr = [].slice.call(arguments);
    (typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  }
};

// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());


// place any jQuery/helper plugins in here, instead of separate, slower script files.


// register a function that is triggered on ajax error
$('body').ajaxError(function(){
    alert("Ajax Error - the request could not be completed\n\nEither the server responded with an error code or \nthe response contained a (script) error.");
    hideOverlay();    
});

var overlay = $('<div id="overlay"></div>');

// loading indicator
var loading_grey = $('<img src="img/loading_g.gif" alt="loading">');
var loading = '<div style="margin-top: 3em; text-align:center;" id="loading"><img src="img/loading_w.gif" alt="loading..."></div>';

// show a dark background with loading indicator on top
var showOverlay = function()
{
    $('body').append(overlay);
    $('#overlay').fadeIn('fast', function() {
        $(this).append(loading_grey);
    });
    $('#overlay img').css({
        display: 'block',
        margin: '7em auto'
    });
};

// hide loading overlay
var hideOverlay = function()
{
    $('#overlay').fadeOut('fast', function() {
        $(this).remove();
    });
};

// hide the aggregated items in the lists and show them on click
var handleAggregates = function(hideAll)
{
    if( hideAll && hideAll == true )
    {
        // hide the aggregates on pageload
        $('.listitem dd').hide();
    }

    // make name clickable and show aggregates onclick
    $('.listitem dt small').each(function(i, element) {
        $(element).unbind('click').removeAttr('style');
        var children = $(element).parents('dl').find('dd');

        // calculate the number of elements and replace it
        $(this).text($(this).text().replace(/[0-9]+/g, children.length));
        
        if( children.length > 0 )
        {
            $(element)
            .css({
                'cursor': 'pointer',
                'text-decoration': 'underline'
            })
            .click(function() {
                children.slideToggle('fast', 'swing');
            });
        }
    });
};

// default settings for draggable items
var dragDefaults = {
    revert: 'invalid',
    opacity: 0.7,
    distance: 20,
    helper: "clone"
};
