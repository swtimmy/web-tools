function convertTime12hTo24h(time) {
    if(time.length<6||time.length>8){
        return time;
    }
    var hours = Number(time.match(/^(\d\d?)/)[1]);
    var minutes = Number(time.match(/:(\d\d?)/)[1]);
    var AMPM = time.match(/\s(AM|PM)$/i)[1];
    if((AMPM == 'PM' || AMPM == 'pm') && hours < 12) {
        hours = hours + 12;
    }
    else if((AMPM == 'AM' || AMPM == "am") && hours == 12) {
        hours = hours - 12;
    }
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if(hours < 10) {
        sHours = "0" + sHours;
    }
    if(minutes < 10) {
        sMinutes = "0" + sMinutes;
    }
    return sHours + ":" + sMinutes;
}
function getTimezoneOffset(){
    var date = new Date();
    return date.getTimezoneOffset();
}
function getTimezone(){
    var date = new Date();
    var timezoneOffset = date.getTimezoneOffset();
    var hours = ('00' + Math.floor(Math.abs(timezoneOffset/60))).slice(-2);
    var minutes = ('00' + Math.abs(timezoneOffset%60)).slice(-2);
    return (timezoneOffset >= 0 ? '-' : '+') + hours + ':' + minutes;
}
function getFullTimeFormatWithYYYYMMDDhhmm($string){
    return $string.substring(0, 16)+":00"+getTimezone();
}
function getYYYYMMDDWithDate($date){
    var YYYY = $date.getFullYear();
    var MM = ($date.getMonth()+1).pad(2);
    var DD = $date.getDate().pad(2);
    return YYYY+"-"+MM+"-"+DD;
}
function getHHmmWithDate($date){
    var HH = $date.getHours().pad(2);
    var mm = $date.getMinutes().pad(2);
    return HH+":"+mm;
}
function getYYYYMMDDTHHmmWithDate($date){
    var YYYY = $date.getFullYear();
    var MM = ($date.getMonth()+1).pad(2);
    var DD = $date.getDate().pad(2);
    var HH = $date.getHours().pad(2);
    var mm = $date.getMinutes().pad(2);
    return YYYY+"-"+MM+"-"+DD+"T"+HH+":"+mm;
}
function getYYYYMMDDHHmmWithDate($date){
    var YYYY = $date.getFullYear();
    var MM = ($date.getMonth()+1).pad(2);
    var DD = $date.getDate().pad(2);
    var HH = $date.getHours().pad(2);
    var mm = $date.getMinutes().pad(2);
    return YYYY+"-"+MM+"-"+DD+" "+HH+":"+mm;
}
function getYYYYMMDDHHmmssWithDate($date){
    var YYYY = $date.getFullYear();
    var MM = ($date.getMonth()+1).pad(2);
    var DD = $date.getDate().pad(2);
    var HH = $date.getHours().pad(2);
    var mm = $date.getMinutes().pad(2);
    var ss = $date.getSeconds().pad(2);
    return YYYY+"-"+MM+"-"+DD+" "+HH+":"+mm+":"+ss;
}
function getDayWithDate($date){
    var d = $date.getDay();
    var day_str = "Sun";
    if(d==1){
        day_str = "Mon";
    }else if(d==2){
        day_str = "Tue";
    }else if(d==3){
        day_str = "Wed";
    }else if(d==4){
        day_str = "Thu";
    }else if(d==5){
        day_str = "Fri";
    }else if(d==6){
        day_str = "Sat";
    }
    return day_str;
}
function getTimestampWithDate($date){
    if($date.length==16||$date.length==19){
        $date = $date.replace(' ', 'T')
    }
    return new Date($date)/1000;
}
function timestampToDate($timestamp){
    return new Date(parseInt($timestamp)*1000);
}
function getTimestampWithHHmm($date){
    return new Date("2020-01-01 "+$date)/1000;
}
function getHowLongDayWithStartEndDate($start,$end){
    var per_day = 1000*60*60*24;
    var start = $start/per_day;
    var end = $end/per_day;
    return Math.round((end-start)*10)/10;
}