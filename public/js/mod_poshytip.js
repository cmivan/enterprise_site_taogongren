//绑定提示tip标签
//var classname = 'darkgray';
//var classname = 'green';
//var classname = 'skyblue';
//var classname = 'twitter';
//var classname = 'violet';
//var classname = 'yellow';
//var classname = 'yellowsimple';
var classname = 'twitter';
$(function(){ $("#poshytip").attr("href",js_url+"poshytip/"+classname+"/"+classname+".css"); bindtip(); });
function bindtip(){
 $('.tip').poshytip({
	className: classname,
	showTimeout: 1,
	alignTo: 'target',
	alignX: 'center',
	offsetY: 8,
	allowTipHover: false
	});
}