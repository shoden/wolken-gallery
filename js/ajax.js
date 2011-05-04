top.ajax = ajax;

function ajax(fecha)
{	
  var ajax=nuevoAjax();

	parent.document.getElementById("takelist").style.display ="none";
  
  ajax.open("POST", "inc/datos.php", true);
  ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  ajax.send("f="+fecha+"&list=1");  
  
  ajax.onreadystatechange=function()
	{
	  if (ajax.readyState==4){	
      parent.document.getElementById("takelist").innerHTML=ajax.responseText;
      parent.updateLightBox();
		}
  }

  var ajax2=nuevoAjax();
  
  ajax2.open("POST", "inc/datos.php", true);
  ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  ajax2.send("f="+fecha);  
  
  ajax2.onreadystatechange=function()
	{
	  if (ajax2.readyState==4){	
      parent.document.getElementById("takes").innerHTML=ajax2.responseText;
      parent.updateLightBox();

      if(ajax2.responseText=="")
        parent.document.getElementById("takes").innerHTML="<div class='error'>Este d&iacute;a no tiene capturas.</div>";
      else
        parent.document.getElementById("takelist").style.display ="inline";
		}
  }
}

function nuevoAjax()
{ 
	// Objeto AJAX
	var xmlhttp=false; 
	try{ 
		// Para navegadores distintos de IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e){
		try{ 
			// Para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if(!xmlhttp && typeof XMLHttpRequest!="undefined")
    xmlhttp=new XMLHttpRequest();

	return xmlhttp; 
}

function deleteday()
{
  var today = document.getElementById('currentdate').innerHTML;
  var answer = confirm('Se van a eliminar todas las capturas del día ' + today + '. ¿Continuar?');

  if(!answer)
    return false;

  var del=nuevoAjax();
  
  del.open("POST", "backend/deleteday.php", true);
  del.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  del.send("f="+today);  
  
  del.onreadystatechange=function()
	{
	  if (del.readyState==4){	
      if(del.responseText == "ok"){
        alert('¡Capturas eliminadas!');
        window.location.reload(true);
      }
      else
        alert(del.responseText);
        //alert('Se ha producido un error y no se han podido eliminar las capturas.');
		}
  }
}

function zipday()
{
  var today = document.getElementById('currentdate').innerHTML;
  dir = "inc/zipday.php?d=" + today;
  op = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";

  window.open(dir, "", op);
}
