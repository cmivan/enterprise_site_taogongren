//定义指定时间的差 函数
Date.prototype.dateDiff = function(interval,objDate){
// Download by http://www.codefans.net
    //若參數不足或 objDate 不是日期物件則回傳 undefined
    if(arguments.length<2||objDate.constructor!=Date) return undefined;
    switch (interval) {
      //計算秒差
      case "s":return parseInt((objDate-this)/1000);
      //計算分差
      case "n":return parseInt((objDate-this)/60000);
      //計算時差
      case "h":return parseInt((objDate-this)/3600000);
      //計算日差
      case "d":return parseInt((objDate-this)/86400000);
      //計算週差
      case "w":return parseInt((objDate-this)/(86400000*7));
      //計算月差
      case "m":return (objDate.getMonth()+1)+((objDate.getFullYear()-this.getFullYear())*12)-(this.getMonth()+1);
      //計算年差
      case "y":return objDate.getFullYear()-this.getFullYear();
      //輸入有誤
      default:return undefined;
    }
  }


$(function(){
jQuery.fn.countDown = function(settings) {
		var cd=new Date();
		var td=new Date(settings.startDate);	
		var displayText="";
		//开始构造显示用的字串
		var secondDiff=cd.dateDiff("s",td);
		
		var dayDiff=parseInt(secondDiff/(60*60*24));
		    if(dayDiff>0){displayText+=(dayDiff>=0?dayDiff:"0")+"天";}
		var hourDiff=parseInt(secondDiff/(60*60));
		    if(hourDiff>0){displayText+=(hourDiff>=0?hourDiff%24:"0")+"时";}
		var minuterDiff=parseInt(secondDiff/(60));
		    if(minuterDiff>0){displayText+=(minuterDiff>=0?minuterDiff%60:"0")+"分";}
		displayText+='<span>'+(secondDiff>=0?secondDiff%60:"0")+'</span>秒后可重新获取';
	
	$(this).html(displayText).animate({"none":"none"},settings.duration,'',function() {
		if(secondDiff>=0) {
			$(this).countDown(settings);
		}else{
			settings.callBack(this);
		}
	});		
	return this;
};
//计时&&重新计时
jQuery.fn.CRcountDown = function(settings) {
	settings = jQuery.extend({
		startDate: new Date(),
		duration: 1000,
		callBack: function() { }
	}, settings);
	this.data("CR_targetDate",settings.startDate),
	this.data("CR_duration",settings.duration);
	this.data("CR_callBack",settings.callBack);
	return this.stop().countDown(settings);
};

})