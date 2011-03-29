
function open_win(id) {
var url = 'bills/view/'+id;
var width = 600;
var height = 600;
var bgc = '#ffffff';
//var left = parseInt((screen.availWidth/2) Ð (width/2));
//var top = parseInt((screen.availHeight/2) Ð (height/2));
var top = 100;
var left = 400;
var windowFeatures = 'background=' + bgc + ',width=' + width + ',height=' + height + ',status, resizable, left=' + left + ',top=' + top + 'screenX=' + left + ',screenY=' + top;
myWindow = window.open(url, 'subWind', windowFeatures);
}
