function fill(year, month, day){
  var d = year + "-";
  d += (month<10) ? "0" + month : month;
  d += (day<10) ? "-0" + day : "-" + day;

  return d;
}

function updateLightBox()
{
  $('.take a').lightBox();
}

window.onload = function(){		
  g_globalObject = new JsDatePick({
  useMode:1,
  isStripped:true,
  target:"calendar",
  yearsRange:[2010,2013],
  limitToToday:true
});

document.getElementById("currentdate").innerHTML = g_globalObject.currentDay 
  + "/" + g_globalObject.currentMonth
  + "/" + g_globalObject.currentYear;

document.getElementById("takes").innerHTML="<img src='img/cargando.png' style='margin-bottom:30px;'>";

ajax(fill(g_globalObject.currentYear,
     g_globalObject.currentMonth,
     g_globalObject.currentDay));

g_globalObject.setOnSelectedDelegate(function(){
  var obj = g_globalObject.getSelectedDay();
  document.getElementById("currentdate").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
  document.getElementById("takes").innerHTML="<img src='img/cargando.png' style='margin-bottom:30px;'>";
  ajax(fill(obj.year, obj.month, obj.day));
  });
};

function selectDay()
{
  var i = document.getElementById("list").selectedIndex;
  if(i>0){
    var t = document.getElementById("list").options[i].text;
    var v = document.getElementById("list").options[i].value;
    document.getElementById("currentdate").innerHTML = t; 
    document.getElementById("takes").innerHTML="<img src='img/cargando.png' style='margin-bottom:30px;'>";
    ajax(v);
  }
}

