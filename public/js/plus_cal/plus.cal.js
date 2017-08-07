/**
	the script only works on "input [type=text]"

**/

// don't declare anything out here in the global namespace

(function($) { // create private scope (inside you can use $ instead of jQuery)

    // functions and vars declared here are effectively 'singletons'.  there will be only a single
    // instance of them.  so this is a good place to declare any immutable items or stateless
    // functions.  for example:

	var today = new Date(); // used in defaults
    var months = '一月,二月,三月,四月,五月,六月,七月,八月,九月,十月,十一月,十二月'.split(',');
	var monthlengths = '31,28,31,30,31,30,31,31,30,31,30,31'.split(',');
  	var dateRegEx = /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/;
	var yearRegEx = /^\d{4,4}$/;

    // next, declare the plugin function
    $.fn.simpleDatepicker = function(options) {

        // functions and vars declared here are created each time your plugn function is invoked

        // you could probably refactor your 'build', 'load_month', etc, functions to be passed
        // the DOM element from below

		var opts = jQuery.extend({}, jQuery.fn.simpleDatepicker.defaults, options);
		
		// replaces a date string with a date object in opts.startdate and opts.enddate, if one exists
		// populates two new properties with a ready-to-use year: opts.startyear and opts.endyear
		
		setupYearRange();
		/** extracts and setup a valid year range from the opts object **/
		function setupYearRange () {
			
			var startyear, endyear;  
			if (opts.startdate.constructor == Date) {
				startyear = opts.startdate.getFullYear();
			} else if (opts.startdate) {
				if (yearRegEx.test(opts.startdate)) {
					startyear = opts.startdate;
				} else if (dateRegEx.test(opts.startdate)) {
					opts.startdate = new Date(opts.startdate);
					startyear = opts.startdate.getFullYear();
				} else {
					startyear = today.getFullYear();
				}
			} else {
				startyear = today.getFullYear();
			}
			opts.startyear = startyear;
			
			if (opts.enddate.constructor == Date) {
				endyear = opts.enddate.getFullYear();
			} else if (opts.enddate) {
				if (yearRegEx.test(opts.enddate)) {
					endyear = opts.enddate;
				} else if (dateRegEx.test(opts.enddate)) {
					opts.enddate = new Date(opts.enddate);
					endyear = opts.enddate.getFullYear();
				} else {
					endyear = today.getFullYear();
				}
			} else {
				endyear = today.getFullYear();
			}
			opts.endyear = endyear;	
		}
		
		/** HTML factory for the actual datepicker table element **/
		// has to read the year range so it can setup the correct years in our HTML <select>
		function newDatepickerHTML () {
			
			var years = [];
			
			// process year range into an array
			for (var i = 0; i <= opts.endyear - opts.startyear; i ++) years[i] = opts.startyear + i;

			// build the table structure
			var table = jQuery('<table class="datepicker" cellpadding="0" cellspacing="0"></table>');
			table.append('<thead></thead>');
			table.append('<tfoot></tfoot>');
			table.append('<tbody></tbody>');
			
			// month select field
			var monthselect = '<select name="month">';
			for (var i in months) monthselect += '<option value="'+i+'">'+months[i]+'</option>';
			monthselect += '</select>';

			// year select field
			var yearselect = '<select name="year">';
			for (var i in years) yearselect += '<option>'+years[i]+'</option>';
			yearselect += '</select>';
			
			jQuery("thead",table).append('<tr><td colspan="7" class="top_arrow"><div class="arrow">&nbsp;</div></td></tr><tr class="controls"><th colspan="7"><span class="prevMonth">&laquo;</span>&nbsp;'+monthselect+yearselect+'&nbsp;<span class="nextMonth">&raquo;</span></th></tr>');
			jQuery("thead",table).append('<tr class="days"><th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th></tr>');
			jQuery("tfoot",table).append('<tr><td colspan="2"><span class="today">今天</span></td><td colspan="3">&nbsp;</td><td colspan="2"><span class="close">关闭</span></td></tr>');
			for (var i = 0; i < 6; i++) jQuery("tbody",table).append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');	
			return table;
		}
		
		/** get the real position of the input (well, anything really) **/
		//http://www.quirksmode.org/js/findpos.html
		function findPosition (obj) {
			var curleft = curtop = 0;
			if (obj.offsetParent) {
				do { 
					curleft += obj.offsetLeft;
					curtop += obj.offsetTop;
				} while (obj = obj.offsetParent);
				return [curleft,curtop];
			} else {
				return false;
			}
		}
		
		
		function remonths(a,b){
			a = parseInt(a);
			b = parseInt(b);
			jQuery("select[name=month] option").attr('disabled',true);
			for (i=a;i<=b;i++){
				jQuery("select[name=month] option").eq(i).attr('disabled',false);
			}
			return true;
			}

		/** load the initial date and handle all date-navigation **/
		// initial calendar load (e is null)
		// prevMonth & nextMonth buttons
		// onchange for the select fields
		function loadMonth (e, el, datepicker, chosendate) {
			
			// reference our years for the nextMonth and prevMonth buttons
			var mo = jQuery("select[name=month]", datepicker).get(0).selectedIndex;
			var yr = jQuery("select[name=year]", datepicker).get(0).selectedIndex;
			var yrs = jQuery("select[name=year] option", datepicker).get().length;
			
			//add by cmivan time:11.12.1
            var startYear = opts.startYear;
			var endYear = opts.endyear;
			var startMonth = parseInt(opts.startdate.getMonth());
			var endMonth = parseInt(opts.enddate.getMonth());
			var monthselect;
			if(startMonth<endMonth){
				//startMonth 2 endMonth
				remonths(startMonth,endMonth);
			}else{
				var thisYear = jQuery("select[name=year]").val();
				if(parseInt(endYear)==parseInt(thisYear)){
					//1 2 startMonth
					remonths(0,endMonth);
				}else{
					//endMonth 2 12
					remonths(startMonth,11);
				}
			}
			//end
			


			// first try to process buttons that may change the month we're on
			if (e && jQuery(e.target).hasClass('prevMonth')) {				
				if (0 == mo && yr) {
					yr -= 1; mo = 11;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = 11;
					jQuery("select[name=year]", datepicker).get(0).selectedIndex = yr;
				} else {
					mo -= 1;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = mo;
				}
			} else if (e && jQuery(e.target).hasClass('nextMonth')) {
				if (11 == mo && yr + 1 < yrs) {
					yr += 1; mo = 0;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = 0;
					jQuery("select[name=year]", datepicker).get(0).selectedIndex = yr;
				} else { 
					mo += 1;
					jQuery("select[name=month]", datepicker).get(0).selectedIndex = mo;
				}
			}
			
			// maybe hide buttons
			if (0 == mo && !yr) jQuery("span.prevMonth", datepicker).fadeOut(200); 
			else jQuery("span.prevMonth", datepicker).fadeIn(200);; 
			if (yr + 1 == yrs && 11 == mo){jQuery("span.nextMonth", datepicker).fadeOut(200);}
			else {jQuery("span.nextMonth", datepicker).fadeIn(200);} 
			
			// clear the old cells
			var cells = jQuery("tbody td", datepicker).unbind().empty().removeClass('date');
			
			// figure out what month and year to load
			var m = jQuery("select[name=month]", datepicker).val();
			var y = jQuery("select[name=year]", datepicker).val();
			var d = new Date(y, m, 1);
			var startindex = d.getDay();
			var numdays = monthlengths[m];
			
			// http://en.wikipedia.org/wiki/Leap_year
			if (1 == m && ((y%4 == 0 && y%100 != 0) || y%400 == 0)) numdays = 29;
			
			// test for end dates (instead of just a year range)
			if (opts.startdate.constructor == Date) {
				var startMonth = opts.startdate.getMonth();
				var startDate = opts.startdate.getDate();
			}
			if (opts.enddate.constructor == Date) {
				var endMonth = opts.enddate.getMonth();
				var endDate = opts.enddate.getDate();
			}
			
			// walk through the index and populate each cell, binding events too
			for (var i = 0; i < numdays; i++) {
				
				var cell = jQuery(cells.get(i+startindex)).removeClass('chosen');
				
				// test that the date falls within a range, if we have a range
				if ( 
					(yr || ((!startDate && !startMonth) || ((i+1 >= startDate && mo == startMonth) || mo > startMonth))) &&
					(yr + 1 < yrs || ((!endDate && !endMonth) || ((i+1 <= endDate && mo == endMonth) || mo < endMonth)))) {
				
					cell
						.text(i+1)
						.addClass('date')
						.hover(
							function () { jQuery(this).addClass('over'); },
							function () { jQuery(this).removeClass('over'); })
						.click(function () {
							var chosenDateObj = new Date(jQuery("select[name=year]", datepicker).val(), jQuery("select[name=month]", datepicker).val(), jQuery(this).text());
							closeIt(el, datepicker, chosenDateObj);
						});
						
					// highlight the previous chosen date
					if (i+1 == chosendate.getDate() && m == chosendate.getMonth() && y == chosendate.getFullYear()) cell.addClass('chosen');
				}
			}
		}
		
		/** closes the datepicker **/
		// sets the currently matched input element's value to the date, if one is available
		// remove the table element from the DOM
		// indicate that there is no datepicker for the currently matched input element
		function closeIt (el, datepicker, dateObj) { 
			if (dateObj && dateObj.constructor == Date){
				el.val(jQuery.fn.simpleDatepicker.formatOutput(dateObj)).blur();
				}
			datepicker.remove();
			datepicker = null;
			jQuery.data(el.get(0), "simpleDatepicker", { hasDatepicker : false });
			return false;
		}

        // iterate the matched nodeset
        return this.each(function() {
			
            // functions and vars declared here are created for each matched element. so if
            // your functions need to manage or access per-node state you can defined them
            // here and use $this to get at the DOM element
			
			if ( jQuery(this).is('input') && 'text' == jQuery(this).attr('type')) {

				var datepicker; 
				jQuery.data(jQuery(this).get(0), "simpleDatepicker", { hasDatepicker : false });

				// open a datepicker on the click event
				jQuery(this).click(function (ev) {
											 
					var $this = jQuery(ev.target);
					
					if (false == jQuery.data($this.get(0), "simpleDatepicker").hasDatepicker) {
						
						// store data telling us there is already a datepicker
						jQuery.data($this.get(0), "simpleDatepicker", { hasDatepicker : true });
						
						// validate the form's initial content for a date
						var initialDate = $this.val();
						
						if (initialDate && dateRegEx.test(initialDate)) {
							var chosendate = new Date(initialDate);
						} else if (opts.chosendate.constructor == Date) {
							var chosendate = opts.chosendate;
						} else if (opts.chosendate) {
							var chosendate = new Date(opts.chosendate);
						} else {
							var chosendate = today;
						}
							
						// insert the datepicker in the DOM
						datepicker = newDatepickerHTML();
						jQuery("body").prepend(datepicker);
						
						// position the datepicker
						var elPos = findPosition($this.get(0));
						var x = (parseInt(opts.x) ? parseInt(opts.x) : 0) + elPos[0];
						var y = (parseInt(opts.y) ? parseInt(opts.y) : 0) + elPos[1];
						jQuery(datepicker).css({ position: 'absolute', left: x, top: y });
					
						// bind events to the table controls
						jQuery("span", datepicker).css("cursor","pointer");
						jQuery("select", datepicker).bind('change', function () { loadMonth (null, $this, datepicker, chosendate); });
						jQuery("span.prevMonth", datepicker).click(function (e) { loadMonth (e, $this, datepicker, chosendate); });
						jQuery("span.nextMonth", datepicker).click(function (e) { loadMonth (e, $this, datepicker, chosendate); });
						jQuery("span.today", datepicker).click(function () { closeIt($this, datepicker, new Date()); });
						jQuery("span.close", datepicker).click(function () { closeIt($this, datepicker); });
	

						// set the initial values for the month and year select fields
						// and load the first month
						jQuery("select[name=month]", datepicker).get(0).selectedIndex = chosendate.getMonth();
						jQuery("select[name=year]", datepicker).get(0).selectedIndex = Math.max(0, chosendate.getFullYear() - opts.startyear);
						loadMonth(null, $this, datepicker, chosendate);
					}
					
					//helper by cmivan 11-8-9 (for: auto close when click out of the datepicker)
					jQuery('div').click(function(){closeIt($this, datepicker);});
					$this.focus();
					return false;
					
				});
			}

        });

    };

    // finally, I like to expose default plugin options as public so they can be manipulated.  one
    // way to do this is to add a property to the already-public plugin fn

	jQuery.fn.simpleDatepicker.formatOutput = function (dateObj) {
		
		var thisDate=dateObj.getDate().toString();
		var thisMonth=(dateObj.getMonth()+1).toString();
		    if(thisDate.length<2){thisDate="0"+thisDate;}
			if(thisMonth.length<2){thisMonth="0"+thisMonth;}
		return dateObj.getFullYear() + "-" + thisMonth + "-" + thisDate;	
	};
	
	jQuery.fn.simpleDatepicker.defaults = {
		// date string matching /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/
		chosendate : today,
		
		// date string matching /^\d{1,2}\/\d{1,2}\/\d{2}|\d{4}$/
		// or four digit year
		startdate : today.getFullYear(), 
		enddate : today.getFullYear() + 1,
		
		// offset from the top left corner of the input element
		x : 18, // must be in px
		y : 18 // must be in px
	};

})(jQuery);


//辅助函数 add by cmivan
function getSdate(){
	var Tdata=new Date();
	var TMonth=parseInt(Tdata.getMonth());
	var TSMonth=TMonth+1;
	if(TSMonth>12){ TSMonth = 12; }
	SData=(TSMonth)+"/"+Tdata.getDate()+"/"+(Tdata.getFullYear());
	return SData;
	}
function getEdate(){
	var Tdata=new Date();
	var TMonth=parseInt(Tdata.getMonth());
	var TEMonth = TMonth + 12;
	var TYear = Tdata.getFullYear();
	if(TEMonth>12){
		TYear = parseInt(TYear)+1;
		TEMonth = parseInt(TEMonth)-12;
	}
	EData = (TEMonth)+"/"+Tdata.getDate()+"/"+(TYear);
	return EData;
	}