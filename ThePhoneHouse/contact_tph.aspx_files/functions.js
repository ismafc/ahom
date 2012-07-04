
function OnReadyStateChangeRegisterShopGenericLog() {
}
			
function RegisterSessionLog() {
}
			
function OnReadyStateChangeRegisterShopGenericLog(){
}

function RegisterShopGenericLog(affiliate,shop,customer,type,code,p1,p2,p3){
	var ajax;
	if (window.XMLHttpRequest) 
			ajax = new XMLHttpRequest();
	else
		ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
		
	ajax.onreadystatechange = OnReadyStateChangeRegisterShopGenericLog;	

	var sURL;
	var sQuery;

	sURL="/tools/register_shop_generic_log.aspx";
	sQuery = "affiliate=" + affiliate;
	sQuery+="&shop=" + shop;
	sQuery+="&customer=" + customer;
	sQuery+="&type=" + type;
	sQuery+="&code=" + code;
	sQuery+="&p1=" + p1;
	sQuery+="&p2=" + p2;
	sQuery+="&p3=" + p3;
	var d = new Date();
	var curr_msec = d.getMilliseconds()
	sQuery+="&rnd=" + curr_msec;
	ajax.open("POST", sURL, false);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(sQuery); 

	ajax = null;
}

function ShowPriceShipMethod(oCombo,url)
{
	document.location.href='/product.aspx'+url+'&cship='+oCombo.options[oCombo.selectedIndex].value;
}


function SearchSearchIt() {
	if (document.getElementById('txtSpSearch').value.length > 2) {
		sDummy = new String(document.getElementById('txtSpSearch').value);
		oRegExp = new RegExp(' ', 'g');
		
		document.location.href = 'list.aspx?search=' + sDummy.replace(oRegExp, '+');
	}
}

function EmailCheck(sEmail) {
	var at = "@";
	var dot = ".";
	var lat = sEmail.indexOf(at);
	var lstr = sEmail.length;
	var ldot = sEmail.indexOf(dot);

	if (sEmail.indexOf(at)==-1) { return false; }
	if (sEmail.indexOf(at)==-1 || sEmail.indexOf(at)==0 || sEmail.indexOf(at)==lstr) { return false; }
	if (sEmail.indexOf(dot)==-1 || sEmail.indexOf(dot)==0 || sEmail.indexOf(dot)==lstr) { return false; }
	if (sEmail.indexOf(at,(lat+1))!=-1) { return false; }
	if (sEmail.substring(lat-1,lat)==dot || sEmail.substring(lat+1,lat+2)==dot) { return false; }
	if (sEmail.indexOf(dot,(lat+2))==-1) { return false; }
	if (sEmail.indexOf(" ")!=-1) { return false; }

 	return true;
}


function changelanguage(ai_ilanguage){
	var url=document.forms[0].action;
	var matchStr=/(\&l=.)/;
	var matchStr2=/(\?l=.)/;
	var symbol='&';
	var question='?';

	url = url.replace(matchStr, '');
	url = url.replace(matchStr2, '');
	if ((url.indexOf(question))==-1) symbol='?';

	document.location.href=url+symbol+'l='+ai_ilanguage;
}

function SelectCategory(ai_icategory, ai_ilevel){
	if (ai_ilevel>1)
		document.location.href='/list.aspx?c='+ai_icategory+'&md=2';
	else	
		document.location.href='/category.aspx?c='+ai_icategory;
}


function ReadCookie(cookieName) {
 var theCookie=""+document.cookie;
 var ind=theCookie.indexOf(cookieName);
 if (ind==-1 || cookieName=="") return "";
 var ind1=theCookie.indexOf(';',ind);
 if (ind1==-1) ind1=theCookie.length; 
 return unescape(theCookie.substring(ind+cookieName.length+1,ind1));
}

function SetCookie(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
}

function IsThereCookies(){
testValue=Math.floor(1000*Math.random());
SetCookie('AreCookiesEnabled',testValue);
return (testValue==ReadCookie('AreCookiesEnabled')); 
}


function showVariantContent(type, field, index, at) {
window.open('/show_variant_content.aspx?type='+type+'&field='+field+'&index='+index+'&at='+at, 'suscriber_legal_notice', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=250,left=' + ((screen.width -400) / 2) + ',top=' + ((screen.height -250) / 2));
}

function ValidatorBefore() {
    if (document.all){
    var i;
    for (i = 0; i < Page_Validators.length; i++) {
        ValidatorValidate(Page_Validators[i]);
    }
    ValidatorUpdateIsValid();    
    Page_BlockSubmit = !Page_IsValid;
    return Page_IsValid;
    }
    else return true;
}


function ShowTechDetail() { 
	if (document.getElementById('oTechDetail').style.display == 'none')  {
		document.getElementById('oTechDetail').style.display = '';	}
	else {
		document.getElementById('oTechDetail').style.display = 'none';
	}
}


function DateString(){
	var month=new Array(12);
	month[0]="Enero";
	month[1]="Febrero";
	month[2]="Marzo";
	month[3]="Abril";
	month[4]="Mayo";
	month[5]="Junio";
	month[6]="Julio";
	month[7]="Agosto";
	month[8]="Septiembre";
	month[9]="Octubre";
	month[10]="Noviembre";
	month[11]="Diciembre";
	 
	var odate= new Date();
	
	iday = odate.getDate(); 
	smonth = month[odate.getMonth()];
	iyear = odate.getFullYear();
	 
	return iday+" de "+smonth+" de "+iyear; 
}


	function changeMenuHome(cat) {
			if (document.getElementById("optionMenuHome")) document.getElementById("optionMenuHome").value = cat;
			
			if (document.getElementById("divHome12")) document.getElementById("divHome12").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome25")) document.getElementById("divHome25").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome26")) document.getElementById("divHome26").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome27")) document.getElementById("divHome27").className = 'centerHomeDivOcult';
			
			if (document.getElementById("divHome29")) document.getElementById("divHome29").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome30")) document.getElementById("divHome30").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome31")) document.getElementById("divHome31").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome32")) document.getElementById("divHome32").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome33")) document.getElementById("divHome33").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome34")) document.getElementById("divHome34").className = 'centerHomeDivOcult';
			
			if (document.getElementById("divHome59")) document.getElementById("divHome59").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome60")) document.getElementById("divHome60").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome61")) document.getElementById("divHome61").className = 'centerHomeDivOcult';
			
	
			if (document.getElementById("image12")) document.getElementById("image12").src = "/images/12_off.gif";
			if (document.getElementById("image25")) document.getElementById("image25").src = "/images/25_off.gif";
			if (document.getElementById("image26")) document.getElementById("image26").src = "/images/26_off.gif";
			if (document.getElementById("image27")) document.getElementById("image27").src = "/images/27_off.gif";

			stype=cat;

			document.getElementById("divHome"+ cat).className = 'centerHomeDiv';
			document.getElementById("image"+ cat).src = "/images/"+cat+"_on.gif";	
			
			document.getElementById("imgall").src = "/images/todoson.jpg";	
			document.getElementById("imgvodafone").src = "/images/vodafoneoff.jpg";	
			document.getElementById("imgorange").src = "/images/orangeoff.jpg";	
			document.getElementById("imgyoigo").src = "/images/yoigooff.jpg";
			
		

			
			var sMod;
			
			switch(cat)
					{
						case 12:
							sMod="Contrato";
							break;
					
						case 25:
							sMod="Prepago";
							break;
						
						case 26:
							sMod="Portabilidad";
							break;	
					
						case 27:
							sMod="Libre";
							break;	
					}
			
			document.getElementById("message").innerHTML="Estas son las <b>SUPEROFERTAS<\/b> de la modalidad de <b>"+sMod+"<\/b> en el operador <b>TODOS<\/b>";
			
			if (cat==27)
				{
				
				document.getElementById("imgvodafone").style.display='none';
				document.getElementById("imgorange").style.display='none';
				document.getElementById("imgyoigo").style.display='none';
				}
				
			else
				{
				document.getElementById("imgvodafone").style.display='';
				document.getElementById("imgorange").style.display='';
				document.getElementById("imgyoigo").style.display='';
				}
				
			if (cat==25)
				{
					document.getElementById("imgHappy").style.display='';
					document.getElementById("sepHappy").style.display='';
				}
			else
				{
					if (document.getElementById("imgHappy")) document.getElementById("imgHappy").style.display='none';
					if (document.getElementById("imgHappy")) document.getElementById("sepHappy").style.display='none';
				
				}	
					
				
			
	}
	
	
	function changeSubMenuHome(cat) {
	
			if (document.getElementById("optionSubMenuHome")) document.getElementById("optionSubMenuHome").value = cat;
	
			// en disenyo cambiar 68 a 94
			var sMod;
			var sOper;
			
			if (document.getElementById("divHome12")) document.getElementById("divHome12").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome25")) document.getElementById("divHome25").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome26")) document.getElementById("divHome26").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome27")) document.getElementById("divHome27").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome29")) document.getElementById("divHome29").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome30")) document.getElementById("divHome30").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome31")) document.getElementById("divHome31").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome32")) document.getElementById("divHome32").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome33")) document.getElementById("divHome33").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome34")) document.getElementById("divHome34").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome59")) document.getElementById("divHome59").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome60")) document.getElementById("divHome60").className = 'centerHomeDivOcult';
			if (document.getElementById("divHome61")) document.getElementById("divHome61").className = 'centerHomeDivOcult';
			
			if (document.getElementById("divHome68"))
				document.getElementById("divHome68").className = 'centerHomeDivOcult';
			
			if (document.getElementById("divHome94"))
				document.getElementById("divHome94").className = 'centerHomeDivOcult';
			
			
			document.getElementById("imgall").src = "/images/todosoff.jpg";	
			document.getElementById("imgvodafone").src = "/images/vodafoneoff.jpg";	
			document.getElementById("imgorange").src = "/images/orangeoff.jpg";
			document.getElementById("imgyoigo").src = "/images/yoigooff.jpg";	
			
			document.getElementById("imghappy").src = "/images/happyoff.jpg";	
			
			
			
			switch(stype)
			{

			case 12: 
					sMod="Contrato";
					switch(cat)
					{
						case 0:
							document.getElementById("divHome12").className = 'centerHomeDiv';
							document.getElementById("imgall").src = "/images/todoson.jpg";	
							
							sOper="TODOS";
							
							break;
					
						case 1:
							document.getElementById("divHome29").className = 'centerHomeDiv';
							document.getElementById("imgvodafone").src = "/images/vodafoneon.jpg";	
							
							sOper="Vodafone";
							
							break;
						
						case 2:
							document.getElementById("divHome30").className = 'centerHomeDiv';
							document.getElementById("imgorange").src = "/images/orangeon.jpg";	
							sOper="Orange";
							break;	
					
						case 3:
							document.getElementById("divHome59").className = 'centerHomeDiv';
							document.getElementById("imgyoigo").src = "/images/yoigoon.jpg";	
							sOper="Yoigo";
							break;	
					}
					

			break;

			case 25: 
				sMod="Prepago";
				switch(cat)
					{
						case 0:
							document.getElementById("divHome25").className = 'centerHomeDiv';
							document.getElementById("imgall").src = "/images/todoson.jpg";	
							sOper="TODOS";
							break;
					
						case 1:
							document.getElementById("divHome31").className = 'centerHomeDiv';
							document.getElementById("imgvodafone").src = "/images/vodafoneon.jpg";	
							sOper="Vodafone";
							break;
						
						case 2:
							document.getElementById("divHome32").className = 'centerHomeDiv';
							document.getElementById("imgorange").src = "/images/orangeon.jpg";	
							sOper="Orange";
							break;	
						case 3:
							document.getElementById("divHome61").className = 'centerHomeDiv';
							document.getElementById("imgyoigo").src = "/images/yoigoon.jpg";	
							sOper="Yoigo";
							break;
						case 4:
							
							if (document.getElementById("divHome68"))
								document.getElementById("divHome68").className = 'centerHomeDiv';
							if (document.getElementById("divHome94"))
								document.getElementById("divHome94").className = 'centerHomeDiv';
							
							
							document.getElementById("imghappy").src = "/images/happyon.jpg";	
							sOper="Happy M&oacute;vil";
							break;			
					
					}
					
			
				;

			break;

			case 26: 
				sMod="Portabilidad";	
				switch(cat)
					{
						case 0:
							document.getElementById("divHome26").className = 'centerHomeDiv';
							document.getElementById("imgall").src = "/images/todoson.jpg";	
							sOper="TODOS";
							break;
					
						case 1:
							document.getElementById("divHome33").className = 'centerHomeDiv';
							document.getElementById("imgvodafone").src = "/images/vodafoneon.jpg";	
							sOper="Vodafone";
							break;
						
						case 2:
							document.getElementById("divHome34").className = 'centerHomeDiv';
							document.getElementById("imgorange").src = "/images/orangeon.jpg";	
							sOper="Orange";
							break;	
					
						case 3:
							document.getElementById("divHome60").className = 'centerHomeDiv';
							document.getElementById("imgyoigo").src = "/images/yoigoon.jpg";	
							sOper="Yoigo";
							break;	
					}
				;

			break; 

			case 27:
			
				sMod="Libre"; 
				sOper="TODOS";
				document.getElementById("imgall").src = "/images/todoson.jpg";	
				document.getElementById("divHome27").className = 'centerHomeDiv';
				

			break; 

			};
						
			
			document.getElementById("message").innerHTML="Estas son las <b>SUPEROFERTAS<\/b> de la modalidad de <b>"+sMod+"<\/b> en el operador <b>"+sOper+"<\/b>";
			

		
	}



function ShowPhoneHouseHome() {
	document.getElementById("divHome26").className = 'centerHomeDiv';

	stype=26;

	document.getElementById("message").innerHTML="Estas son las <b>SUPEROFERTAS<\/b> de la modalidad de <b>Portabilidad<\/b> en el operador <b>Todos<\/b>";
			



}


function MM_preloadImages() { //v3.0
var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


function PreLoadImages(){

	var oI;
	
	oI = new Image(72,30)
	oI.src = "/images/todoson.jpg";
	oI = new Image(72,30)
	oI.src = "/images/todosoff.jpg";

	oI = new Image(85,30)
	oI.src = "/images/vodafoneon.jpg";
	oI = new Image(85,30)
	oI.src = "/images/vodafoneoff.jpg";

	oI = new Image(85,29)
	oI.src = "/images/orangeon.jpg";
	oI = new Image(85,29)
	oI.src = "/images/orangeoff.jpg";

	oI = new Image(85,29)
	oI.src = "/images/yoigoon.jpg";
	oI = new Image(85,29)
	oI.src = "/images/yoigooff.jpg";

	oI = new Image(95,33)
	oI.src = "/images/12_on.gif";
	oI = new Image(95,33)
	oI.src = "/images/12_off.gif";

	oI = new Image(95,33)
	oI.src = "/images/25_on.gif";
	oI = new Image(95,33)
	oI.src = "/images/25_off.gif";

	oI = new Image(95,33)
	oI.src = "/images/26_on.gif";
	oI = new Image(95,33)
	oI.src = "/images/26_off.gif";


	oI = new Image(95,33)
	oI.src = "/images/27_on.gif";
	oI = new Image(95,33)
	oI.src = "/images/27_off.gif";

}


function ShowSupportForm() {
	window.open('/support.aspx', 'support', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,width=750,height=590,left=' + ((screen.width -750) / 2) + ',top=' + ((screen.height -590) / 2));
}



// **************************************************************
// **************************************************************
// FICHA DE PRODUCTO V2
// **************************************************************
// **************************************************************

	function ChangePTab(iMode, iTab) {
		var sMode;
		
		if (iMode == 1) 
		{
			sMode = "-on"; 
		}
		else 
		{
			sMode = "-off"; 
		}
		
		if (document.getElementById("img_ptab" + iTab)) 
		{
			if (document.getElementById("ptab" + iTab) && document.getElementById("ptab" + iTab).className == 'productTabOff') 
			{
				//if (document.getElementById("img_ptab" + iTab)) { document.getElementById("img_ptab" + iTab).src = "/images/v2/ptab-" + iTab + sMode + ".gif"; }
				document.getElementById("img_ptab" + iTab).src = "/images/v2/ptab-" + iTab + sMode + ".gif"; 
			}
		}
	}

	//Pinta las pestañas
	function ShowPTab(iTab) {
		for (i = 1; i < 10; i++) {
			if (document.getElementById("ptab" + i)) 
			{
				document.getElementById("ptab" + i).className = "productTabOff";
				document.getElementById("ptab" + i).style.display = "none";
				if (document.getElementById("img_ptab" + i)) 
				{ 
					document.getElementById("img_ptab" + i).src = "/images/v2/ptab-" + i + "-off.gif"; 
				}
			}
		}
		
		if(document.getElementById("img_ptab" + iTab))
		{
			document.getElementById("ptab" + iTab).className = "productTabOn";
			document.getElementById("ptab" + iTab).style.display = "";
			document.getElementById("img_ptab" + iTab).src = "/images/v2/ptab-" + iTab + "-on.gif";
		}
		
		CloseHelper("helperTarifa");
		CloseHelper("helperTipoContrato");
		CloseHelper("helperTarifaValor");
	}
		
	//Guarda el id del producto final seleccionado en un campo oculto
	function SetBPv2(iProd) 
	{
		document.getElementById('hidProductSel').value = iProd;
	}
	
	//Muestra u oculta las capas
	function ShowDivs(ai_iLevel1, ai_iLevel2, ai_iLevel3, ai_iLevel4, oRadio) 
	{
		
		
		var iMaxIteraciones = 10;
		var iMaxIteracionesTarifas = 10;
		
		if(document.getElementById('hiddenNumOperadores'))
		{
			iNumOperadores = document.getElementById('hiddenNumOperadores').value;
		}
		
		document.getElementById('hidProductSel').value = ''; //Resetear el id del producto elegido
	
		//Si se hace click en una opción del nivel 1
		if (ai_iLevel1 > 0 && ai_iLevel2 == 0 ) 
		{
			if (document.getElementById('divOperadoresHNivel2_' + ai_iLevel1).getAttribute("udState") == 0) 
			{
				document.getElementById('divOperadoresHNivel2_' + ai_iLevel1).setAttribute("udState", 1);
				document.getElementById('divOperadoresHNivel2_' + ai_iLevel1).style.display = '';
				document.getElementById('divNivel1Title_' + ai_iLevel1).style.backgroundImage = 'url(/images/v2/bg_tipo_alta_nivel1_on.gif)';
			}
			else 
			{
				document.getElementById('divOperadoresHNivel2_' + ai_iLevel1).setAttribute("udState", 0);
				document.getElementById('divOperadoresHNivel2_' + ai_iLevel1).style.display = 'none';
				document.getElementById('divNivel1Title_' + ai_iLevel1).style.backgroundImage = 'url(/images/v2/bg_tipo_alta_nivel1.gif)';
			}
		}
		
		//Si se hace click en una opción del nivel 2
		if (ai_iLevel1 > 0 && ai_iLevel2 > 0 && ai_iLevel3 == 0 ) 
		{
			if(document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2))
			{
				if (document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).getAttribute("udState") == 0) 
				{
					//Muestra la tabla de tarifas
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).setAttribute("udState", 1);
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).style.display = '';
				}
				else 
				{
					//Oculta la tabla de tarifas
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).setAttribute("udState", 0);
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).style.display = 'none';
				}
			}
			
			//Deschequea todos los radio de tarifas al cambiar de operador
			for(i1=1; i1 < iMaxIteraciones; i1++)
			{
				for(i2=1; i2 < iMaxIteraciones; i2++)
				{
					if (i1!= ai_iLevel2 && document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + "_" + i1 + '_' + i2))
					{
						document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + '_' + i1 + "_" + i2).checked = false;
					}
				}
			}
		}
		
		for (i1 = 1; i1 < iMaxIteraciones; i1++) 
		{
			if (document.getElementById('divOperadoresHNivel2_' + i1)) 
			{
				if (i1 != ai_iLevel1) 
				{ 
					//Oculta las opciones de Contrato y/o Tarjeta y/o Libre en las que no estemos.
					document.getElementById('divOperadoresHNivel2_' + i1).style.display = 'none';
					document.getElementById('divOperadoresHNivel2_' + i1).setAttribute("udState", 0);
				}
				
				//Si se hace click en una opción del nivel 3
				if (document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + i1) && i1 != ai_iLevel2 && ai_iLevel3 > 0) 
				{
					//Oculta todas las capas de los otros operadores que no se el seleccionado
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + i1).setAttribute("udState", 0);
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + i1).style.display = 'none';
				}
				
				for (i2 = 1; i2 < iMaxIteraciones; i2++)
				{
					if (document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2)) 
					{
						
						if (document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2).getAttribute("udState") == 0) 
						{
							//Oculta la tabla de tarifas
							document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2).style.display = 'none';
						}
						
						for (i3 = 1; i3 < iMaxIteracionesTarifas; i3++) 
						{
							//Oculta los tipos de tarifas
							if (document.getElementById('divTarifaHNivel4_' + i1 + '_' + i2 + '_' + i3)) 
							{
								document.getElementById('divTarifaHNivel4_' + i1 + '_' + i2 + '_' + i3).style.display = 'none';
							}
						}
					}
				}
			}
		}
		
		if (document.getElementById('rTipoAltaNivel1_' + ai_iLevel1)) 
		{
			document.getElementById('rTipoAltaNivel1_' + ai_iLevel1).checked = true; 
			
			//LIBRE
			if (ai_iLevel1 == 3) 
			{
				if (document.getElementById('divOperadoresHNivel2OperadorH_3')) { document.getElementById('divOperadoresHNivel2OperadorH_3').style.display = 'none'; }
				if (document.getElementById('rOperadorNivel2_3_3')) { document.getElementById('rOperadorNivel2_3_3').checked = true; }
				if (document.getElementById('divTipoConexionHNivel3_3_3')) { document.getElementById('divTipoConexionHNivel3_3_3').style.display = ''; }
				
				for (i3x = 0; i3x < iMaxIteraciones; i3x++) 
				{
					if (document.getElementById('rTipoConexionNivel3_3_3_' + i3x)) 
					{
						document.getElementById('rTipoConexionNivel3_3_3_' + i3x).checked = true;
					}

					if (document.getElementById('divTarifaHNivel4_3_3_' + i3x)) 
					{
						document.getElementById('divTarifaHNivel4_3_3_' + i3x).style.display = '';
						
						document.getElementById('divTarifaHNivel4_3_3_' + i3x).firstChild.childNodes[1].checked = true;
						document.getElementById('divTarifaHNivel4_3_3_' + i3x).firstChild.childNodes[1].click();
						document.getElementById('divTarifaHNivel4_3_3_' + i3x).firstChild.style.display = 'none';
					}
				}
			}
		}
		
		
		if (document.getElementById('rOperadorNivel2_' + ai_iLevel1 + '_' + ai_iLevel2)) 
		{
			document.getElementById('rOperadorNivel2_' + ai_iLevel1 + '_' + ai_iLevel2).checked = true;
			
			if (document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2)) 
			{ 
				if (document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).getAttribute("udState") == 1)
				{
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).style.display = ''; 
				}
				else
				{
					document.getElementById('divTipoConexionHNivel3_' + ai_iLevel1 + '_' + ai_iLevel2).style.display = 'none'; 
				}
			}
			
			// TARJETA
			if (ai_iLevel1 == 2) 
			{
				for (i3x = 1; i3x < iMaxIteraciones; i3x++) 
				{
					if (document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + i3x)) 
					{
						document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + i3x).checked = true;
					}

					if (document.getElementById('divTarifaHNivel4_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + i3x)) 
					{
						document.getElementById('divTarifaHNivel4_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + i3x).style.display = '';
					}
				}
			}			
		}
		
		
		if (document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + ai_iLevel3)) 
		{
			document.getElementById('rTipoConexionNivel3_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + ai_iLevel3).checked = true;
			if (document.getElementById('divTarifaHNivel4_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + ai_iLevel3)) 
			{ 
				document.getElementById('divTarifaHNivel4_' + ai_iLevel1 + '_' + ai_iLevel2 + '_' + ai_iLevel3).style.display = ''; 
			}
		}

		if (ai_iLevel2 > 0) 
		{ 
			CloseHelper("helperTipoAlta"); 
		}
		else 
		{
			ShowHelper("helperTipoAlta", 0); 
		}
		

		//Cuando se cambia de tipo de alta de Contrato, Tarjeta o Libre
		if (ai_iLevel3 == 0)
		{
			if (document.getElementById('divNivel1Title_' + ai_iLevel1)) 
			{ 
				//Cambiar la imagen de fondo
				for (iImg = 1; iImg <= 3; iImg++) 
				{
					if (iImg != ai_iLevel1) 
					{
						document.getElementById('divNivel1Title_' + iImg).style.backgroundImage = 'url(/images/v2/bg_tipo_alta_nivel1.gif)';
					}
				}
				
				//Ocultar las capas que se hayan mostrado en los tipos de alta (contrato, tarjeta, libre) que no sean el que estamos
				for (i1 = 1; i1 < iMaxIteraciones; i1++) 
				{
					if(ai_iLevel1 != i1)
					{
						for (i2 = 1; i2 < iMaxIteraciones; i2++) 
						{
							if(ai_iLevel2 != i2 && document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2))
							{
								document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2).style.display = 'none';
								document.getElementById('divTipoConexionHNivel3_' + i1 + '_' + i2).setAttribute("udState", 0);
								if(document.getElementById('rOperadorNivel2_' + i1 + '_' + i2))
								{
									document.getElementById('rOperadorNivel2_' + i1 + '_' + i2).checked = false;
								}
							}
						}
					}
				}
			}
		}		
	
		CloseHelper("helperTarifa");
		CloseHelper("helperTipoContrato");
		CloseHelper("helperTarifaValor");
	}

	//Muestra la capa de ayuda
	function ShowHelper(ai_sName, ai_iOperador) {
		if (document.getElementById('helperTarifa')) { document.getElementById('helperTarifa').style.display = 'none'; }
		if (document.getElementById('helperTipoContrato')) { document.getElementById('helperTipoContrato').style.display = 'none'; }
		if (document.getElementById('helperTarifaValor')) { document.getElementById('helperTarifaValor').style.display = 'none'; }

		if (document.getElementById(ai_sName)) { 
			document.getElementById(ai_sName).style.display = '';
			
			if (ai_sName == 'helperTipoContrato' || ai_sName == 'helperTarifaValor') { document.getElementById(ai_sName).style.top = 292 + (33 * ai_iOperador);  }
		}
	}

	//Oculta la capa de ayuda
	function CloseHelper(ai_sName) {
		if (document.getElementById(ai_sName)) { document.getElementById(ai_sName).style.display = 'none'; }
	}
	
	
	function Show3DProduct(URL) {
		var w3d = window.open("/3d.htm?d="+URL,"3D","toolbar=0,status=0,menubar=0,resizable=0,scrollbars=0,left=100,top=100,width=320,height=500");
	}

	//Muestra la capa de informacion de tarifas
	function ShowInfoTarifa(iIndex, ai_iLevel1, ai_iLevel2, ai_iLevel3) { 
		var iMultiplier = 1;
		var iDesplazamiento = 45;//33
		var iDesplazamientoAuxiliar = 15;
		
		if (document.getElementById('helperTipoContrato')) { document.getElementById('helperTipoContrato').style.display = 'none'; }
		if (document.getElementById('helperTarifaValor')) { document.getElementById('helperTarifaValor').style.display = 'none'; }
		
		if (document.getElementById('helperTarifa')) {
			if (ai_iLevel1 == 1) {
				switch (ai_iLevel3) {
					case 1:
						iMultiplier = 1; break;
					case 2:
						iMultiplier = 1; break;
					case 3:
						iMultiplier = 2; break;
					case 4:
						iMultiplier = 2; break;
					case 7:
						iMultiplier = 3; break;
					case 9:
						iMultiplier = 3; break;
				}
				if (ai_iLevel2 == 2)
					iDesplazamientoAuxiliar = 0;
				if (ai_iLevel2 == 4)
					iDesplazamientoAuxiliar = -58;
						
				document.getElementById('helperTarifa').style.top = 230 + (iDesplazamiento * ai_iLevel1) + (iDesplazamiento * ai_iLevel2) + iDesplazamientoAuxiliar + (iDesplazamiento * iMultiplier);
				}
			else {
				document.getElementById('helperTarifa').style.top = 230 + (iDesplazamiento * ai_iLevel1) + (iDesplazamiento * ai_iLevel2) + 15;
			}
			
			if (document.getElementById('helpTarifa_' + iIndex)) {
				document.getElementById('helperTarifaCenter').innerHTML = document.getElementById('helpTarifa_' + iIndex).innerHTML; }
			else {
				document.getElementById('helperTarifaCenter').innerHTML = document.getElementById('helpNoInfo').innerHTML; }
			
			document.getElementById('helperTarifa').style.display = '';
		}
	}		

// **************************************************************



