/*calendar height setting*/
$(function(){
    var h =$(".calendar-date").height();
    var dateD = $(".calendar-month");
    dateD.height(h);
    dateD.css("line-height",h+"px");
})