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
  yearsRange:[2010,2013]
});

document.getElementById("currentdate").innerHTML = g_globalObject.currentDay 
  + "/" + g_globalObject.currentMonth
  + "/" + g_globalObject.currentYear;

document.getElementById("takes").innerHTML="<img src='img/cargando.png'>";

ajax(fill(g_globalObject.currentYear,
     g_globalObject.currentMonth,
     g_globalObject.currentDay));

g_globalObject.setOnSelectedDelegate(function(){
  var obj = g_globalObject.getSelectedDay();
  document.getElementById("currentdate").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
  document.getElementById("takes").innerHTML="<img src='img/cargando.png'>";
  ajax(fill(obj.year, obj.month, obj.day));
  });
};

