//定义指定时间的差 函数
Date.prototype.dateDiff = function(interval,objDate){
// Download by http://www.codefans.net
    //若参数不足或 objDate 不是日期物件则回传 undefined
    if(arguments.length<2||objDate.constructor!=Date) return undefined;
    switch (interval) {
      //计算秒差
      case "s":return parseInt((objDate-this)/1000);
      //计算分差
      case "n":return parseInt((objDate-this)/60000);
      //计算时差
      case "h":return parseInt((objDate-this)/3600000);
      //计算日差
      case "d":return parseInt((objDate-this)/86400000);
      //计算周差
      case "w":return parseInt((objDate-this)/(86400000*7));
      //计算月差
      case "m":return (objDate.getMonth()+1)+((objDate.getFullYear()-this.getFullYear())*12)-(this.getMonth()+1);
      //计算年差
      case "y":return objDate.getFullYear()-this.getFullYear();
      //输入有误
      default:return undefined;
    }
  }


$(function(){
jQuery.fn.countDown = function(settings) {
		var cd=new Date();
		var tt=settings.startDate;
			//处理，兼容ie和google浏览器
			tts=tt.split("-");
			tt1=parseInt(tts[0]);
			tt2=parseInt(tts[1])-1;  //月份需要减去1
			tt3=parseInt(tts[2]);
			//var td=new Date(2011,7,01);   -> ok
			//var td=new Date("2011-7-01"); -> 不兼容
		var td=new Date(tt1,tt2,tt3);
		var displayText="";
		//开始构造显示用的字串
		var secondDiff=parseInt(cd.dateDiff("s",td))+3600*24*1;
		if(secondDiff>0){
			var dayDiff=parseInt(secondDiff/(60*60*24));
				if(dayDiff>0){displayText+=(dayDiff>=0?dayDiff:"0")+"天";}
			var hourDiff=parseInt(secondDiff/(60*60));
				if(hourDiff>0){displayText+=(hourDiff>=0?hourDiff%24:"0")+"时";}
			var minuterDiff=parseInt(secondDiff/(60));
				if(minuterDiff>0){displayText+=(minuterDiff>=0?minuterDiff%60:"0")+"分";}
			displayText+=(secondDiff>=0?secondDiff%60:"0")+"秒";
		}else{
		    //add by cmivan
			displayText="投标已到期!";
		}
	$(this).text(displayText).animate({"none":"none"},settings.duration,'',function() {
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
//计时暂停
jQuery.fn.pause = function(settings) { return this.stop(); };

})