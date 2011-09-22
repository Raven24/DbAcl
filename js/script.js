/* Author: 
  Florian Staudacher
*/

// let all buttons look like jquery-ui buttons
$('.button, button').button();

$('*[data-method=delete]').live("click", function(){
    if(confirm('are you sure?'))
    {            
        $.ajax(this.href, {
            type: 'DELETE',
            //dataType: 'script',
            success: function(data, status, xhr) {
                //console.log(xhr.getAllResponseHeaders());
            }                
            
        });
    }
    return false;
});

// handle forms that want to be sent via ajax
// the response is expected to be javascript and will be interpreted
$('*[data-remote=true]').live("submit", function() {    
    $.post(this.action, $(this).serialize(), null, 'script');
    return false;
});

if( $('.dragitems').length > 0 ) {	
	//	let text 'fade out' if too long
	var dragBg = $('.dragitems > div').css('background-color');
	var dragBgRGB = getRGB(dragBg);
	$('.dragitems > div').css('position', 'relative').append(
			$('<div></div>').css({
				'width' : '1.5em',
				'position' : 'absolute',
				'right' : 0,
				'top' : 0,
				'bottom' : 0,
			}).attr('style', function(i, val) {
				var style = val;
				style += 'background-image: -webkit-gradient(linear, left bottom, right bottom, color-stop(0, rgba('+dragBgRGB[0]+', '+dragBgRGB[1]+', '+dragBgRGB[2]+', 0.0)), color-stop(0.75, '+dragBg+'));\
				background-image: -moz-linear-gradient(left, rgba('+dragBgRGB[0]+', '+dragBgRGB[1]+', '+dragBgRGB[2]+', 0.0) 0%, '+dragBg+' 75%)';
				return style;
			})
	);
}

// highliting for the header imagemap
$('#header_img').maphilight({
    fillColor: '44AAFF',
    fillOpacity: 0.15,
    strokeColor: 'FFFFE0',
    strokeWidth: 2,
    shadow: true,
    shadowX: 1,
    shadowY: 1,
    shadowRadius: 5,
    shadowColor: '333333',
    shadowOpacity: 0.6
});

var currentNav = currentNav || 'people';
var data = $('#'+currentNav+'_nav').data('maphilight') || {};
data.alwaysOn = true;
$('#'+currentNav+'_nav').data('maphilight', data).trigger('alwaysOn.maphilight');

handleAggregates(true);
