
top.ajax = ajax;

var vector=new Array();
var vector2=new Array();

function prueba()
{  
  var cadena = "";
  for (var i=0;i<vector.length-1;i++){
    cadena = cadena + vector[i] + " ";
  }
  alert (cadena);
}

function ajax(fecha)
{	
  var ajax=nuevoAjax();
  
  ajax.open("POST", "datos.php", true);
  ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  ajax.send("f="+fecha);  
  
  ajax.onreadystatechange=function()
	{
	  if (ajax.readyState==4)
		{	
			  //alert(ajax.responseText);
			  //Separo los elementos que he enviado desde el php en un vector
			  //var a = ajax.responseText.split('$');
			  
			  parent.document.getElementById("takes").innerHTML=ajax.responseText;//a[0] + " - " + a[1];
        parent.updateLightBox();
		}

  }
}

//Función para crear un objeto de tipo AJAX
function nuevoAjax()
{ 
	// Crea el objeto AJAX.
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}
