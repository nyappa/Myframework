$(document).ready(function(){

var nowdate = new Date();
var year = nowdate.getFullYear(); // 年
var mon  = nowdate.getMonth() + 1; // 月
var date = nowdate.getDate(); // 日

if(mon < 10){
  mon  = "0" + mon;
}
if(date < 10){
  date  = "0" + date;
}


var now_date = "" + year + mon + date;

    $("#log_menu").load("/index.php/IrcLog/ajax_log_list");
    $("#log_menu").fadeIn("slow");
    $("#log_new").load("/index.php/IrcLog/ajax_log_main?logs=" + now_date);
    $("#log_new").fadeIn("slow");
	var Hash = $('#new_foot');
	var HashOffset = $(Hash).offset().top;
	$(".min").animate({
		scrollTop: HashOffset
	}, 100);
   
    var interval = 5000;
    setInterval(function(){
        $("#log_new").load("/index.php/IrcLog/ajax_log_main?logs=" + now_date);
	var Hash = $('#new_foot');
	var HashOffset = $(Hash).offset().top;
	$(".min").animate({
		scrollTop: HashOffset
	}, 1000);
    }, interval);

});

var Timer;

function load_log(logs){
         $("#log_main").hide();
	 $("#log_main").load("/index.php/IrcLog/ajax_log_main?logs=" + logs);
	 $("#log_main").fadeIn("slow");
}
