<?
$userid = $_POST['userid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="verify-v1" content="2SHKvBLHpu6FxbdoP8PM4EuOEwJdFcK0GSA7BeWZfA8=" />
<script language="javascript" type="text/javascript">
if (top != self)
{
top.location=self.location;
}
</script>
<title>
	
		My Security for Internet Banking: HSBC Bank UK
		
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<meta http-equiv="Cache-Control" content="no-cache, no-store" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />

<meta name="summary" content="" />
<meta name="description" content="" />
<meta name="abstract" content="" />
<meta name="DC.description" content="" />
<meta name="keywords" content="		                        " />
<meta name="robots" content="noindex, nofollow" />
<meta name="Customer Group" content="PFS" />
<meta name="Business Line" content="General" />
<meta name="Product Line" content="Internet Banking" />
<meta name="Site Type" content="Public" />
<link rel="shortcut icon" href="https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/../hsbc_ukpersonal/favicon.ico" />


<link rel="canonical" href="http://www.hsbc.co.uk/1/2/!ut/p/kcxml/04_Sj9SPykssy0xPLMnMz0vM0Y_QjzKLN4k3NwfJmMWbxxub6keaxRvFO3tCRAziHeECQfoFuaER5Y6KigAzA3X1" />

<script>
	var theme = "PWS";
	var webInteractionFlag = "true";
</script>


<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/Styles.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/generic.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/menu.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/content.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ib.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/sidebar.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/onlinesavings.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/header-base01.css' />
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/Styles.css' media="screen"https://www.hsbc.co.uk/>
<link type="text/css" rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/print.css' media="print" />
<!--[if IE]>
	<link rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ie.css' type="text/css" />
	<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ie7.css' type="text/css" />
	<![endif]-->
<!--[if lt IE 7]>
	<link rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ie6orless.css' type="text/css" />
	<link rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ie6.css' type="text/css" />
	<![endif]-->
<!--[if lt IE 6]>
	<link rel="stylesheet" href='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/css/ie55.css' type="text/css" />
	<![endif]-->

<script type="text/javascript">
//submit without image
function pibService ()
{
    document.navbarLogon.submit() ;
}


//From navbarlogon (checks whether other field is empty)
function isEmpty()
{
	if ( document.navbarLogon.internetBankingID.value == "" )  //Is this form field blank?
	{
		alert('To enter Internet Banking, please ensure you have entered your User ID.'); //They are both blank so alert.
		return false; // end the if statement
	}	
		else //It is not blank so process
	
		{
			if(navigator.appName.indexOf("Netscape")>(-1))
			{
				 // The other one is not blank so put it's value into this form
				pibwin = window.open( '', '_pib', 'resizable,status,width=790,height=520,x=0,y=0,top=0,left=0' ); // open up a window
				document.navbarLogon.submit(); //submit the value
				setTimeout("clearMe()", 10000); // clear the values from the parent window after 10 seconds
				pibwin.focus(); //make the pop up the focus
				return false; //everything is ok
			}
			else
			{
				 // The other one is not blank so put it's value into this form
				pibwin = window.open( '', '_pib', 'resizable, status=yes, width=740, height=520,top=0,left=0' ); // open up a window
				document.navbarLogon.submit(); //submit the value
				setTimeout("clearMe()", 10000); // clear the values from the parent window
				pibwin.focus(); //make the pop up the focus
				return false; //everything is ok
			}
		}
	
	
}

var pibwin = null; // pib ref window

// IF appVersion is MAC AND IF userAgent is MSIE5 then do nothing.
// IF they are anything else set the fields to ""

function clearMe()
{
	var agt=navigator.userAgent.toLowerCase();
		
	document.navbarLogon.internetBankingID.value = "";
	
}


//register popup window controls
function windowOpen()
{
	if(navigator.appName.indexOf("Netscape")>(-1))
	{
	pibwin = window.open('','_pib','resizable,status,width=790,height=520,top=0,left=0');
	window.focus;
	}
	else
	{
	pibwin = window.open('','_pib','resizable,status,width=740,height=520,top=0,left=0');
	window.focus;
	}
}

//focus cursor in IB main box

</script>
<script  type="text/javascript">//
// Setup global variables
//
// fontSize - default value
// fMax - largest font size
// fMin - smallest font size
// isIE501 - is the user agent MSIE 5.01
//
var fontSize = 100;
var fMax = 120;
var fMin = 100;
var isIE501 = navigator.userAgent.indexOf("MSIE 5.01") > 0 ? true : false;
var isNN6 = navigator.userAgent.indexOf("Netscape6") > 0 ? true : false;
var isIE=document.all&&navigator.userAgent.indexOf("Opera")==-1;
var SKIP_VISIBLE = "#000";			//value is black
var SKIP_INVISIBLE = "#fff";		//value is white
//
// setFontSize
//
// Retrieves cookie value and applies to font size
//
function setFontSize() {
	//var tempSize = getCookie("fontSize");
	//if((tempSize != null) && (tempSize >= 100) && (tempSize <= 120)) {
	//	fontSize = tempSize;
	//} else {
	//	setCookie("fontSize", 100, "", "/");
	//}
	// Reduce by 20% for Website Redesign 2007
	//document.body.style.fontSize = (fontSize - 20) + "%";
}


//
// changeFontSize(bool increment)
//
// changes document font size and records size value in cookie
//
function changeFontSize(increment) {
	if(increment) {
		fontSize=parseInt(fontSize) + parseInt(10);
	} else {
		fontSize=parseInt(fontSize) - parseInt(10);
	}

	if(fontSize > fMax) {
		fontSize = fMax;
	}
	if(fontSize < fMin) {
		fontSize = fMin;
	}
	switch(fontSize) {
		case 100:
			document.body.style.fontSize = "1em";
			break;
		case 110:
			document.body.style.fontSize = "1.10em";
			break;
		case 120:
			document.body.style.fontSize = "1.20em";
			break;
	}
	setCookie('fontSize', fontSize, "", "/");
	// Reduce by 20% for Website Redesign 2007
	fontSize = fontSize - 20;
}
//
// incrementFontSize
//
function incrementFontSize() {
	changeFontSize(true);
}

//
// decrementFontSize
//
function decrementFontSize() {
	changeFontSize(false);
}


//
// Sets a Cookie with the given name and value.
//
// name       Name of the cookie
// value      Value of the cookie
// [expires]  Expiration date of the cookie (default: end of current session)
// [path]     Path where the cookie is valid (default: path of calling document)
// [domain]   Domain where the cookie is valid
//              (default: domain of calling document)
// [secure]   Boolean value indicating if the cookie transmission requires a
//              secure transmission
//
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}


//
// Gets the value of the specified cookie.
//
// name  Name of the desired cookie.
//
// Returns a string containing value of specified cookie,
//   or null if cookie does not exist.
//
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

/*used for automaticaly jumping from one input to the next*/
var count = 0;
function checkInput(theInputBox, maxChars, previousId, nextId) {
	if(nextId != "") {
		nextInputBox = document.getElementById(nextId);
		if((count == (maxChars-1)) && (theInputBox.value.length == maxChars)) {
			if(nextInputBox.value.length == 0) {
				count = 1;
			} else {
				count = nextInputBox.value.length;
			}
			nextInputBox.select();
			return;
		}
	}
	if(count == 0 && theInputBox.value.length == 0) {
		PreviousInputBox = document.getElementById(previousId);
		if(PreviousInputBox.value.length == 0) {
			count = 1;
		} else {
			count = PreviousInputBox.value.length;
		}
		PreviousInputBox.select();
		return;
	}
	count = theInputBox.value.length;
}
//onKeyPress
function previous(theInputBox) {
	count = theInputBox.value.length;
}
//onfocus
function current(theInputBox) {
	count = 999;
	theInputBox.select();
}

function hideAccounts() {
	switchAccountDisplay("none", "block", true);
/*	document.getElementById("balance-top").style.background = "url(../images/show-balance.gif) no-repeat";*/
}

function showAccounts() {
	switchAccountDisplay("block", "none", true);
/*	document.getElementById("balance-top").style.background = "url(../images/hide-balance-top.gif) no-repeat";*/
}
function hideDetails() {
	switchDetailDisplay("none", "block");
}

function showDetails() {
	switchDetailDisplay("block", "none");
}

function switchDetailDisplay(state1, state2) {
	if(document.getElementById("detail-switch")) {
		document.getElementById("detail-switch").style.display = state1;
		document.getElementById("hide-detail-switch").style.display = state1;
		document.getElementById("show-detail-switch").style.display = state2;
	}
}

//
//	These functions wraps the variables in HTML code for placement in the page
//
function displayTag(address,text,title) {
	if(title==null) {
		title = text;
	}
	document.write('<div class=\"hsbcButtonLeft\"></div> <div class=\"hsbcButtonCenter\"><a href=\"',address,'\" title=\"',title,'\">',text,'</a><i>.</i></div><div class=\"hsbcButtonRight\"></div>');
}

function displayResetTag(text) {
		document.write('<div class=\"hsbcButtonLeft\"></div> <div class=\"hsbcButtonCenter\"><a href=\"#\"  onclick=\"document.forms[0].reset()\" onkeypress=\"document.forms[0].reset()\">',text,'</a><i>.</i></div><div class=\"hsbcButtonRight\"></div>');
}

function displayPrintTag() {
	document.write('&nbsp;-&nbsp;<a href=\"#\" class=\"important\">print this page</a>');
}
//
// switchAccountDisplay(string state1,string state2)
// restore show/hide account details from cookie
//
function switchAccountDisplay(state1, state2, browserReload) {
	if(document.getElementById("jsAccountDetails")) {
		document.getElementById("jsAccountDetails").style.display = state1;
		document.getElementById("jsHideAccounts").style.display = state1;
		document.getElementById("jsShowAccounts").style.display = state2;
		setCookie("state1", state1, "", "/");
		setCookie("state2", state2, "", "/");
		if((browserReload == true) && ((isIE501 == true) || (isNN6==true))) {
			location.reload();
		}
	}
}



//
// restoreAccountDisplay
// restore show/hide list of account details from cookie
//
function restoreAccountDisplay() {
	state1 = getCookie("state1") == null ? "none" : getCookie("state1");
	state2 = getCookie("state2") == null ? "block" : getCookie("state2");
	switchAccountDisplay(state1, state2, false);
}

function setJSFunctionality() {
	if(document.getElementById("jsSecondaryFunctionality")) {
		document.getElementById("jsSecondaryFunctionality").style.display = "block";
	}
}



function expandAll() {
	toggleAll('block');
}

function collapseAll() {
	toggleAll('none');
}

function expandAllLink() {
	expandAll()
	if(document.getElementById("jsExpandAll")) {
			document.getElementById("jsExpandAll").style.display = "none";
	}
	if(document.getElementById("jsCollapseAll")) {
			document.getElementById("jsCollapseAll").style.display = "block";
	}
}

function collapseAllLink() {
	collapseAll()
	if(document.getElementById("jsExpandAll")) {
			document.getElementById("jsExpandAll").style.display = "block";
	}
	if(document.getElementById("jsCollapseAll")) {
			document.getElementById("jsCollapseAll").style.display = "none";
	}
}


function skipLinkFocus(skipLinkName) {
	skipLinkName.style.color = SKIP_VISIBLE;
}

function skipLinkBlur(skipLinkName) {
	skipLinkName.style.color = SKIP_INVISIBLE;
}


//
// do_onload
//
function do_onload() {
	setFontSize();
	setJSFunctionality();
	restoreAccountDisplay();

	if(document.getElementById("jsSiteMap")) {
		collapseAll()
	}
	
	if(document.getElementById("jsSiteMapBar")) {
		document.getElementById("jsSiteMapBar").style.display = "block";
	}
	
	if(document.getElementById("detail-switch")) {
		document.getElementById("detail-switch").style.display = "none";
		document.getElementById("show-detail-switch").style.display = "block";
		document.getElementById("hide-detail-switch").style.display = "none";
		document.getElementById("nojs-detail-switch").style.display = "none";
	}
}



//
// trigger onLoad function (do_onload)
//
if (window.addEventListener) {
	window.addEventListener("load", do_onload, false);
} else {
	if (window.attachEvent) {
		window.attachEvent("onload", do_onload);
	} else {
		if (document.getElementById) {
			window.onload = do_onload;
		}
	}
}

//
//popup function for help windows
//
function popup_help(url)
{
	newwindow=window.open(url,'name','status=yes,location=no,menubar=no,scrollbars=yes,toolbar=no,resizable=yes,width=635,height=545,top=0,screenY=0,left=0,screenX=0');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<script type="text/javascript">
<!--

function OnClickHandler()
{
	var agent = navigator.userAgent.toLowerCase();
	
	if ( (agent.indexOf("msie") == -1) || (agent.indexOf("mac") == -1) )
	{	
		var el=null;
		var flag=true;
		el = event.srcElement;
		while (flag && el)   
		{
		  if (el.tagName == "A")
		  { 
		    flag=false;
		    if (el.protocol == "javascript:")
		    {
		      execScript(unescape(el.href), "javascript");
		      window.event.returnValue = false; 
		    }
		  } 
		  else 
		    el = el.parentElement; 
		}
	}
} // end OnClickHandler()

document.onclick = OnClickHandler; // set the On click handler for the document 
//-->
</script>
<script  type="text/javascript">
/* v1.01 -- 03 Aug 2001 */
/* pr.js -- for  NN 4+(pc/mac) */
/*        IE 4+(pc) IE 5+(mac) */

var da = (document.all) ? 1 : 0;
var pr = (window.print) ? 1 : 0;
var mac = (navigator.userAgent.indexOf("Mac") != -1); 

function printPage() {
  if (pr) // NS4, IE5
    window.print()
  else if (da && !mac) // IE4 (Windows)
    vbPrintPage()
  else // other browsers
    alert("Sorry, your browser doesn't support this feature.\n\nTry Ctrl-P to Print.");
  return;
}

if (da && !pr && !mac) with (document) {
  writeln('<OBJECT ID="WB" WIDTH="0" HEIGHT="0" CLASSID="clsid:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>');
  writeln('<' + 'SCRIPT LANGUAGE="VBScript">');
  writeln('Sub window_onunload');
  writeln('  On Error Resume Next');
  writeln('  Set WB = nothing');
  writeln('End Sub');
  writeln('Sub vbPrintPage');
  writeln('  OLECMDID_PRINT = 6');
  writeln('  OLECMDEXECOPT_DONTPROMPTUSER = 2');
  writeln('  OLECMDEXECOPT_PROMPTUSER = 1');
  writeln('  On Error Resume Next');
  writeln('  WB.ExecWB OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER');
  writeln('End Sub');
  writeln('<' + '/SCRIPT>');
}
</script>
<script type="text/javascript">
//
// Setup global variables
//
// isIE501 - is the user agent MSIE 5.01
//
var isIE501 = navigator.userAgent.indexOf("MSIE 5.01") > 0 ? true : false;
var isNN6 = navigator.userAgent.indexOf("Netscape6") > 0 ? true : false;
var isIE=document.all&&navigator.userAgent.indexOf("Opera")==-1;
var SKIP_VISIBLE = "#000";			//value is black
var SKIP_INVISIBLE = "#fff";		//value is white




//
// Sets a Cookie with the given name and value.
//
// name       Name of the cookie
// value      Value of the cookie
// [expires]  Expiration date of the cookie (default: end of current session)
// [path]     Path where the cookie is valid (default: path of calling document)
// [domain]   Domain where the cookie is valid
//              (default: domain of calling document)
// [secure]   Boolean value indicating if the cookie transmission requires a
//              secure transmission
//
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}


//
// Gets the value of the specified cookie.
//
// name  Name of the desired cookie.
//
// Returns a string containing value of specified cookie,
//   or null if cookie does not exist.
//
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

/*used for automaticaly jumping from one input to the next*/
var count = 0;
function checkInput(theInputBox, maxChars, previousId, nextId) {
	if(nextId != "") {
		nextInputBox = document.getElementById(nextId);
		if((count == (maxChars-1)) && (theInputBox.value.length == maxChars)) {
			if(nextInputBox.value.length == 0) {
				count = 1;
			} else {
				count = nextInputBox.value.length;
			}
			nextInputBox.select();
			return;
		}
	}
	if(count == 0 && theInputBox.value.length == 0) {
		PreviousInputBox = document.getElementById(previousId);
		if(PreviousInputBox.value.length == 0) {
			count = 1;
		} else {
			count = PreviousInputBox.value.length;
		}
		PreviousInputBox.select();
		return;
	}
	count = theInputBox.value.length;
}
//onKeyPress
function previous(theInputBox) {
	count = theInputBox.value.length;
}
//onfocus
function current(theInputBox) {
	count = 999;
	theInputBox.select();
}

function hideAccounts() {
	switchAccountDisplay("none", "block", true);
/*	document.getElementById("balance-top").style.background = "url(../images/show-balance.gif) no-repeat";*/
}

function showAccounts() {
	switchAccountDisplay("block", "none", true);
/*	document.getElementById("balance-top").style.background = "url(../images/hide-balance-top.gif) no-repeat";*/
}
function hideDetails() {
	switchDetailDisplay("none", "block");
}

function showDetails() {
	switchDetailDisplay("block", "none");
}

function switchDetailDisplay(state1, state2) {
	if(document.getElementById("detail-switch")) {
		document.getElementById("detail-switch").style.display = state1;
		document.getElementById("hide-detail-switch").style.display = state1;
		document.getElementById("show-detail-switch").style.display = state2;
	}
}

//
//	These functions wraps the variables in HTML code for placement in the page
//
function displayTag(address,text,title) {
	if(title==null) {
		title = text;
	}
	document.write('<div class=\"hsbcButtonLeft\"></div> <div class=\"hsbcButtonCenter\"><a href=\"',address,'\" title=\"',title,'\">',text,'</a><i>.</i></div><div class=\"hsbcButtonRight\"></div>');
}

// Added to fix defect 2237
function displayTagWithOnClick(address,text,title) {
	if(title==null) {
		title = text;
	}
	
	document.write('<div class=\"hsbcButtonLeft\"></div> <div class=\"hsbcButtonCenter\"><a href=\"#\" onClick=\"',address,'\" title=\"',title,'\">',text,'</a><i>.</i></div><div class=\"hsbcButtonRight\"></div>');
}

function displayResetTag(text) {
		document.write('<div class=\"hsbcButtonLeft\"></div> <div class=\"hsbcButtonCenter\"><a href=\"#\"  onclick=\"document.forms[0].reset()\" onkeypress=\"document.forms[0].reset()\">',text,'</a><i>.</i></div><div class=\"hsbcButtonRight\"></div>');
}

function displayPrintTag() {
	document.write('&nbsp;-&nbsp;<a href=\"#\" class=\"important\">print this page</a>');
}
//
// switchAccountDisplay(string state1,string state2)
// restore show/hide account details from cookie
//
function switchAccountDisplay(state1, state2, browserReload) {
	if(document.getElementById("jsAccountDetails")) {
		document.getElementById("jsAccountDetails").style.display = state1;
		document.getElementById("jsHideAccounts").style.display = state1;
		document.getElementById("jsShowAccounts").style.display = state2;
		setCookie("state1", state1, "", "/");
		setCookie("state2", state2, "", "/");
		if((browserReload == true) && ((isIE501 == true) || (isNN6==true))) {
			location.reload();
		}
	}
}


function switchProductsApply()
{
	var productsList = document.getElementById("jsProductsApply");
	if(productsList)
	{
		if(productsList.style.display=="none")
		{
			productsList.style.display="block";
		}
		else
		{
			productsList.style.display="none";
		}
	}
}


//
// restoreAccountDisplay
// restore show/hide list of account details from cookie
//
function restoreAccountDisplay() {
	state1 = getCookie("state1") == null ? "none" : getCookie("state1");
	state2 = getCookie("state2") == null ? "block" : getCookie("state2");
	switchAccountDisplay(state1, state2, false);
}

function setJSFunctionality()
{
	if(document.getElementById("jsSecondaryFunctionality"))
	{
		document.getElementById("jsSecondaryFunctionality").style.display = "block";
	}
	if(document.getElementById("jsSeperatePrintLink"))
	{
		document.getElementById("jsSeperatePrintLink").style.display = "inline";
	}
	
	
}



function expandAll() {
	toggleAll('block');
}

function collapseAll() {
	toggleAll('none');
}

function expandAllLink() {
	expandAll()
	if(document.getElementById("jsExpandAll")) {
			document.getElementById("jsExpandAll").style.display = "none";
	}
	if(document.getElementById("jsCollapseAll")) {
			document.getElementById("jsCollapseAll").style.display = "block";
	}
}

function collapseAllLink() {
	collapseAll()
	if(document.getElementById("jsExpandAll")) {
			document.getElementById("jsExpandAll").style.display = "block";
	}
	if(document.getElementById("jsCollapseAll")) {
			document.getElementById("jsCollapseAll").style.display = "none";
	}
}


function skipLinkFocus(skipLinkName) {
	skipLinkName.style.color = SKIP_VISIBLE;
}

function skipLinkBlur(skipLinkName) {
	skipLinkName.style.color = SKIP_INVISIBLE;
}

function setfocus() {   
   var bFound = false;
  //for each form
  for (f=0; f < document.forms.length; f++)
  {
    // for each element in each form
    for(i=0; i < document.forms[f].length; i++)
    {
      // if it's not a hidden element
      if (document.forms[f][i].type != "hidden" && f != 0)
      {
        // and it's not disabled
        if (document.forms[f][i].disabled != true)
        {
            // set the focus to it
            document.forms[f][i].focus();
            var bFound = true;
        }
      }
      // if found in this element, stop looking
      if (bFound == true)
        break;
    }
    // if found in this form, stop looking
    if (bFound == true)
      break;
   }
  }
  
//
// do_onload
//
function do_onload() {

        setfocus();
	setJSFunctionality();
	restoreAccountDisplay();

	if(document.getElementById("jsSiteMap")) {
		collapseAll()
	}
	
	if(document.getElementById("jsSiteMapBar")) {
		document.getElementById("jsSiteMapBar").style.display = "block";
	}
	
	if(document.getElementById("detail-switch")) {
		document.getElementById("detail-switch").style.display = "none";
		document.getElementById("show-detail-switch").style.display = "block";
		document.getElementById("hide-detail-switch").style.display = "none";
		document.getElementById("nojs-detail-switch").style.display = "none";
	}
}



//
// trigger onLoad function (do_onload)
//
if (window.addEventListener) {
	window.addEventListener("load", do_onload, false);
} else {
	if (window.attachEvent) {
		window.attachEvent("onload", do_onload);
	} else {
		if (document.getElementById) {
			window.onload = do_onload;
		}
	}
}


//popup function for help windows

function popup_help(url)
{
	newwindow=window.open(url,'name','status=yes,location=no,menubar=no,scrollbars=yes,toolbar=no,resizable=yes,width=635,height=545,top=0,screenY=0,left=0,screenX=0');
	if (window.focus) {newwindow.focus()}
	return false;
}


// Function to unhide the content, once page gets loaded

function callUnHide() 
{
	document.getElementById("main").style.display = "";
}
</script>
<script type="text/javascript">
        var home_entity = "HOME";
	var business_entity = "BUSINESS";
	var corperate_entity = "CORPERATE";
        var general_entity = "GENERAL";

	var destination = "";
	var destinationURL = "";
	var logoffCommand = "";

	function invokePublicWarning(newEntity, entityURL) {
		destination = newEntity;
		destinationURL =entityURL;			
		leaveFusedSite(entityURL);
        }

	var loggedOn = false;

	function setLoggedOn() {
		loggedOn=true;
	}

	function setLoggedOff() {
		loggedOn=false;
	}
</script>
<script  type='text/javascript'>
/****************************************************************************
* 																			*
* HW Javascript Core Library												*
* ---------------------------												*
* 																			*
* Author:			Leonard Martin (leonard.martin@heathwallace.com)		*
* Version:			0.0.4													*
* Updated:			5 June 2008												*
* 																			*
* **************************************************************************/


//create alias functions for getElementById and getElementsByClassName
function $(id) {return document.getElementById(id);}
function $$(c,o,t) {return HW.getElementsByClassName(c,o,t);}

// initialise the HW namespace
var HW = {
	/*
	--- CORE FUNCTIONS ---
	These functions are the basic building blocks and should not be removed
	----------------------
	*/
	// browser flags
	isIE:false,
	isMacFF:false,
	// flag if DOM is ready to run code
	dom:{ready:false,timer:null,loaded:false},
	// array of functions to run on page load
	toRun:[],
	/*
	* log(a)
	* outputs to the Firebug console
	* a:	String, Number, Array, or Object to output
	* Returns:	Nothing
	*/
	log:function(a) {
		if(window.console) {window.console.log(a);}
	},
	/*
	* error(a)
	* outputs an error to the Firebug console or alerts to other browsers
	* a:	String, Number, Array, or Object to output
	* Returns:	Nothing
	*/
	error:function(a) {
		if(window.console) {window.console.error(a);}
		else {alert(a);}
	},
	/*
	* getElementsByClassName(cls,n,t)
	* gets an array of elements within certain parameters
	* cls:	String to match classname against
	* n:	Node to search within
	* t:	String - tag name to match against
	* Note: any of these inputs can be set as null to act as a wildcard
	* Returns:	Array fo elements
	*/
	getElementsByClassName:function(cls,n,t) {
		var rtn = [];
		n=n===null?document:n;
		t=t===null?'*':t;
		var els = n.getElementsByTagName?n.getElementsByTagName(t):document.all;
		els = (!els||!els.length) && document.all?document.all:els;
		if(cls==null){return els;}
		for (var i=0,j=0; i<els.length;i++) {
			if(this.hasClass(els[i],cls)) {
				rtn[j++] = els[i];
			}
		}
		return rtn;
	},
	/*
	* querySelectorAll()
	* gets an array of elements within certain parameters
	* css:		CSS Selector to match
	* scope:	Node to search within
	* Returns:	Array of elements matching CSS selector
	*/
	querySelectorAll:function(css,scope) {
		scope = scope || document;
		if(document.querySelectorAll){return scope.querySelectorAll(css);}
		else {return HW.CssParser(css,scope);}
		return null;
	},
	/*
	* querySelector()
	* gets the first element matching a selector
	* css:		CSS Selector to match
	* scope:	Node to search within
	* Returns:	first element matching CSS selector
	*/
	querySelector:function(css,scope) {
		scope = scope || document;
		if(document.querySelector){return scope.querySelector(css);}
		else {
			var o = HW.CssParser(css,scope);
			return o.length?o[0]:null;
		}
	},
	/*
	* createNode(a)
	* creates a DOM node and appends it to a parent node
	* t:	String - tag name of element to be added
	* p:	Node to append new node into
	* c:	Optional - HTML content of element
	* opts:	Optional - additional attributes to be set
	* Returns:	New node
	*/
	createNode:function(t,p,c,opts) {
		if(!p || !t){return};
		var n = document.createElement(t);
		if(c) {n.innerHTML = c;}
		n = HW.extendObject(n,opts);
		return p.appendChild(n);
	},
	/*
	* attachEvent(obj,evt,fnc)
	* attaches an event listener to an element
	* obj:	Object to which event listener is to be added
	* evt:	String - event type e.g. 'click', 'mouseover'
	* fnc:	Function to fire on event
	* Returns:	Nothing
	*/
	attachEvent:function(obj,evt,fnc) {
		if(window.addEventListener) {obj.addEventListener(evt, fnc, false);}
		else if(window.attachEvent) {obj.attachEvent('on'+evt, fnc);}
		else if (obj.getElementById && evt=='load') {obj.onload = fnc;}
	},
	/*
	* detachEvent(obj,evt,fnc)
	* removes an event listener from an element
	* obj:	Object to which event listener is to be removed
	* evt:	String - event type e.g. 'click', 'mouseover'
	* fnc:	Function to remove
	* Returns:	Nothing
	*/
	detachEvent:function(obj,evt,fnc) {
		if(window.removeEventListener) {obj.removeEventListener(evt, fnc, false);}
		else if(window.detachEvent) {obj.detachEvent('on'+evt, fnc);}
	},
	/*
	* preventDefault(e)
	* prevent the default action on event firing
	* e:	Event fired
	* Returns:	Nothing
	*/
	preventDefault:function(e) {
		e=e||window.event;
		if(e.preventDefault) {e.preventDefault();}
		else {e.returnValue = false;}
	},
	/*
	* cancelBubble(e)
	* prevent an event from bubbling up the DOM
	* e:	Event fired
	* Returns:	Nothing
	*/
	cancelBubble:function(e) {
		e=e||window.event;
		if(e.stopPropogation) {e.stopPropogation();}
		else {e.cancelBubble = true;}
	},
	/*
	* extendObject(d,s)
	* add the properties and methods from one object to another
	* d:	Object to which properties and methods should be added
	* s:	Object from which properties and methods should be added
	* Returns:	Object with new properties and methods
	*/
	extendObject:function(d,s) {
		d=d===null?new Object():d;
		for (var p in s) {d[p] = s[p];}
		return d;
	},
	/*
	* addClass(o,c)
	* add a class to an element
	* o:	Node to add class to
	* c:	String - class to add
	* Returns:	Nothing
	*/
	addClass:function(o,c) {
		if (!this.hasClass(o,c)){
			if (o.className == "") {o.className = c;}
			else {o.className += " " + c;}
		}
	},
	/*
	* hasClass(o,c)
	* test if an element has a class
	* o:	Node to check
	* c:	String - class to check for
	* Returns:	Boolean - true if element has class, false otherwise
	*/
	hasClass:function(o,c) {
		var p = new RegExp("(^| )" + c + "( |$)");
		if (p.test(o.className)) {return true;}
		return false;
	},
	/*
	* removeClass(o,c)
	* remove a class from an element
	* o:	Node to remove class from
	* c:	String - class to remove
	* Returns:	Nothing
	*/
	removeClass:function(o,c) {
		var p = new RegExp("(^| )" + c + "( |$)");
		o.className = o.className.replace(p, "$1");
		o.className = o.className.replace(/ $/, "");
	},
	/*
	* setFade(o,c)
	* set the alpha transparency of an element
	* o:	Node to set
	* n:	Number - value between 0-100 (0:transparent,100:opaque)
	* Returns:	Nothing
	*/
	setFade:function(o,n) {
		var agt = navigator.userAgent.toLowerCase();
		if((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1)) {
			if (n == 100) {o.style.filter = "";}
			else if (n < 0) {o.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=0);";}
			else {o.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity="+ Math.round(n) + ");";}
		}
		else {			
			o.style.MozOpacity = (Math.round(n) / 100);
			o.style.opacity = (Math.round(n) / 100);
		}
		o._alpha = n;
	},
	/*
	* setStyle(o,s)
	* set the CSS style of an element
	* o:	Node to set
	* s:	Object containing style info (e.g. {margin:'1px',padding:'4px'})
	* Note: style object should be comma separated and have properties wrapped in single quotes. 
	* Styles should also be in camel casing - e.g. marginTop not margin-top
	* Returns:	Nothing
	*/
	setStyle:function(o,s) {
		for(var i in s) {
			o.style[i] = s[i];
		}
	},
	/*
	* fixIE6flicker()
	* allow caching of background images to avoid flicker on hover in IE versions
	* Returns:	Nothing
	*/
	fixIE6flicker:function() {
		var m = document.uniqueID && document.compatMode && !window.XMLHttpRequest && document.execCommand ; 
		try { 
			if(!!m) { 
				m("BackgroundImageCache", false, true);
			} 
		}
		catch(e) {};
	},
	/*
	* checkLoaded()
	* check if page has loaded
	* Returns:	Boolean - true if page is loaded, false otehrwise
	*/
	checkLoaded:function() {
		if(HW.dom.ready){return true;}
		if(document && document.getElementsByTagName && document.getElementById && document.body) {
			clearInterval(HW.dom.timer);
			HW.dom.timer = null;
			HW.dom.ready = true;
			return true;
		}
		else {return false}
	},
	/*
	* onload()
	* set a function to run on page load
	* f:		Function to call on page load
	* Returns:	nothing
	*/
	onload:function(f) {
		HW.toRun.push(f);
		if(HW.dom.loaded) {
			f();
		}
	},
	/*
	* load()
	* check if page has loaded, if it has, run code
	* Returns:	Nothing
	*/
	load:function() {
		if(HW.checkLoaded() && !HW.dom.loaded) {
			// mark the page as loaded
			HW.dom.loaded = true;
			// set our browser flags
			var userAgent = navigator.userAgent.toLowerCase();
			HW.isIE  = (navigator.appVersion.indexOf("MSIE") != -1)?true:false;
			HW.isMacFF  = (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1)?true:false;
			// run anything set to run on load
			for(var i=0,j=HW.toRun.length;i<j;i++) {
				HW.toRun[i]();
			}
			if(HW.isIE) {HW.fixIE6flicker();}
		}
		else if(HW.dom.timer === null) {
			HW.dom.timer = setInterval(HW.load,10);
		}
	}
	/*
	--- END CORE FUNCTIONS ---

	*/
};

// call the page load event
HW.attachEvent(document,'DOMContentLoaded',HW.load);
HW.attachEvent(window,'load',HW.load);

/****************************************************************************
* 																			*

* HW Javascript Ajax Module												*
* ---------------------------												*
* 																			*
* Author:			Leonard Martin (leonard.martin@heathwallace.com)		*
* Version:			0.0.1													*
* Updated:			9 May 2008												*
* 																			*
* **************************************************************************/

/*
--- AJAX FUNCTIONS ---
Requires:	Core
----------------------
*/

/*
* HW.Ajax(url,[callback[,vars[,method]]])
* make an inline request to a file
* url: 		String - the URL to which the request is made
* callback:	Function to call on completion of request
			This function is called with a single parameter a HW.Ajax.Response object
* vars:		String - variables to send to request in format; 'var1=val1&var2=val2&...'
* method:	String - 'GET' or 'POST'
* Returns:	Nothing
*/ 
HW.Ajax = function(url,callback,vars,method) {
	var obj = this;
	method = method?method:'GET';
	vars = vars?vars:null;
	// instantiate request object
	this.req = new HW.Ajax.Request(url,vars,method);
	// set callback function
	if(typeof(callback) == 'function') {this._passResponse = callback;}
	this.req.xmlHttp.onreadystatechange = function() {obj._handle();};
	// send request
	this.req._sendRequest();
};

HW.Ajax.prototype = {
	req:{},
	_handle:function() {
		if(this.req.xmlHttp.readyState == 4) {
			if(this.req.xmlHttp.status == 200) {
				var r = new HW.Ajax.Response(this.req.xmlHttp);
				this._passResponse(r);
			}
		}
	},
	_passResponse:function() {return;}
};

HW.Ajax.Request = function(href,vars,method) {
	this.createXmlHttpRequestObject();
	this.href = href;
	this.vars = vars;
	this.method = method;
};

HW.Ajax.Request.prototype = {
	xmlHttp:null,
	createXmlHttpRequestObject:function() {
		try {
			this.xmlHttp = new XMLHttpRequest();
		} catch(e) {
			var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
										"MSXML2.XMLHTTP.5.0",
										"MSXML2.XMLHTTP.4.0",
										"MSXML2.XMLHTTP.3.0",
										"MSXML2.XMLHTTP",
										"Microsoft.XMLHTTP");
			for (var i=0; i<XmlHttpVersions.length && !this.xmlHttp; i++) {
				try { 
					this.xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
				}  catch(e){}
			}
		}
	},
	_sendRequest:function(method,vars) {
		if(this.xmlHttp) {
			try {
				if (this.xmlHttp.readyState == 4 || this.xmlHttp.readyState == 0) {
					this.xmlHttp.open(this.method, this.href+(this.method=='GET'&&this.vars?'?'+this.vars:''), true);
					if(this.method == 'POST') {
						this.xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						this.xmlHttp.setRequestHeader("Content-length", this.vars.length);
						this.xmlHttp.setRequestHeader("Connection", "close");
					}
					this.xmlHttp.send(this.vars);
				}
				else {
					if(timeoutId != -1) clearTimeout(timeoutId);  
					var obj = this;
					timeoutId = setTimeout(function(){obj.sendRequest();}, 500);
				}
			} catch(e){}
		}
	}
};

/*
* Response Object
* This object is the parameter sent to the callback function
* It has three properties:
* xml:		If the resource accessed by the HTTP request returns content type 'text/xml' then this will contain the xml output otherwise null
* text:		If the resource returns any other content type then this will contain the response, otherwise an empty string
* contentType:	The content type returned e.g. 'text/xml', 'text/html', 'image/jpeg'
*/
HW.Ajax.Response = function(xml) {
	this.contentType = xml.getResponseHeader('Content-type')?xml.getResponseHeader('Content-type'):null;
	if(this.contentType.substr(0,4) == 'text') {
		this.xml = xml.responseXML?xml.responseXML:null;
		this.text = xml.responseText?xml.responseText:'';
	}
};
HW.Ajax.Response.prototype = {xml:null,text:null,contentType:null};

/*
--- END AJAX FUNCTIONS ---
*/


/****************************************************************************
* 																			*
* HW Javascript Animate Module												*
* ----------------------------											*
* 																			*
* Author:			Leonard Martin (leonard.martin@heathwallace.com)		*
* Version:			0.0.2													*
* Updated:			12 May 2008												*
* 																			*
* **************************************************************************/

/*
--- ANIMATION FUNCTIONS ---
Requires:	Core
---------------------------
*/

HW.Animate = {
	/*
	* fade(elm,to,time[,c])
	* fade an element in/out
	* elm:		Node - element to fade
	* to:		Number - final alpha value (0:transparent,100:opaque)
	* time:		Number - milliseconds to take over fade
	* c:		Function - callback function, fires when finished
	* Returns:	Nothing
	*/
	fade:function(elm,to,time,c) {
		// if the element has not been faded before, assume it is opaque
		if(!elm._alpha && elm._alpha !== 0) {elm._alpha = 100;}
		new HW.Animator(elm,elm._alpha,to,HW.setFade,time,c);
	}
};

/*
* Animator(o,v0,v1,s[,t[,c]])
* change a property of an element smoothly over a period of time
* o:		Node - element to animate
* v0:		Number - initial value of property to change
* v1:		Number - final value of property to change
* s:		Function - function to use to set current property value, should take an object and a value as a parameter
* t:		Number - time to take over animation, in milliseconds - defaults to 500
* c:		Function - callback function, fires when finished
* Returns:	Nothing
*/
HW.Animator = function(o,v0,v1,s,t,c) {
	if(o) {this.target = o;}
	this.setFunc = s;
	this.startValue = v0;
	this.endValue = v1;
	if(t) {this.time = t;}
	if(typeof(c) == 'function') {this.callback = c;}
	this.steps = Math.ceil(this.time/this.stepLength);
	this.animate();
};

HW.Animator.prototype = {
	stepLength:30,
	time:500,
	steps:20,
	setFunc:function(){},
	callback:function(){},
	set:function(v) {
		this.setFunc(this.target,v);
	},
	animate:function() {
		var obj = this;
		var df = (this.endValue - this.startValue)/this.steps;
		if(df != 0) {
			// set timers to fire at intervals
			for(var i=1,j=this.steps;i<=j;i++) {
				(function(){
					var j=i;
					setTimeout(function(){
						obj.set(obj.startValue + j*df);
					},j*obj.stepLength);
				})();
			}
			// fire finish when loop has finished
			setTimeout(function(){obj.callback();},this.stepLength*this.steps);
		}
		else {
			this.callback();
		}
	}
};

/*
--- END ANIMATION FUNCTIONS ---
*/

/*
--- CSS SELECTOR PARSER ---

=:based on code from
scalable Inman Flash Replacement (sIFR) version 3, Author: Mark Wubben, <http://novemberborn.net/>"

=:license
This software is licensed and provided under the CC-GNU LGPL.
See <http://creativecommons.org/licenses/LGPL/2.1/>    

*/

HW.CssParser = (function() {
	var B = /\s*,\s*/;
	var A = /\s*([\s>+~(),]|^|$)\s*/g;
	var L = /([\s>+~,]|[^(]\+|^)([#.:@])/g;
	var F = /(^|\))[^\s>+~]/g;
	var M = /(\)|^)/;
	var K = /[\s#.:>+~()@]|[^\s#.:>+~()@]+/g;
	
	function Parser(css, scope) {
		scope = scope || document.documentElement;
		var selectors = css.split(B);
		var a = [];
		for (var i = 0; i < selectors.length; i++) {
			var o = [scope];
			var sel = Parser.clean(selectors[i]);
			for (var j = 0; j < sel.length;) {
				var prefix = sel[j++];
				var fragment = sel[j++];
				var paren = "";
				if (sel[j] == "(") {
					while (sel[j++] != ")" && j < sel.length) {
						paren += sel[j];
					}
					paren = paren.slice(0, -1);
				}
				o = Parser.get(o, prefix, fragment, paren);
			}
			a = a.concat(o);
		}
		return Parser.util.unique(a);
	}
	Parser.clean = function(selector) {
		// strip unnecessary whitespace
		var o = selector.replace(A, "$1")
		// place asterisks before #s
		o = o.replace(L, "$1*$2")
		// add spaces after closing brackets
		o = o.replace(F, function(s){return s.replace(M, "$1 ")});
		return o.match(K) || []
	}
	Parser.get = function(scope, prefix, fragment, paren) {
		return (Parser.selectors[prefix]) ? Parser.selectors[prefix](scope, fragment, paren) : []
	}
	Parser.util = {
		toArray: function(o) {
			var a = [];
			for (var i = 0; i < o.length; i++) {
				a.push(o[i])
			}
			return a;
		},
		unique: function(o) {
			var a = [];
			for(var i=0;i<o.length;i++) {
				if(!this.inArray(o[i],a)) {a.push(o[i]);}
			}
			return a;
		},
		inArray:function(o,a) {
			for(var j=0;j<a.length;j++) {
				if(a[j] == o) {return true;}
			}
			return false;
		}
	};
	Parser.dom = {
		isTag: function(O, N) {
			return (N == "*") || (N.toLowerCase() == O.nodeName.toLowerCase())
		},
		previousSiblingElement: function(o) {
			while ( o && o.nodeType != 1 ) {
				o = o.previousSibling
			}
			return o;
		},
		nextSiblingElement: function(o) {
			while ( o && o.nodeType != 1 ) {
				o = o.nextSibling;
			}
			return o;
		},
		hasClass: function(cls, o) {
			return (o.className || "").match("(^|\\s)" + cls + "(\\s|$)");
		},
		getByTag: function(tag, o) {
			return o.getElementsByTagName(tag);
		}
	};
	Parser.selectors = {
		"#": function(scope, id) {
			for(var i=0;i<scope.length;i++) {
				if (scope[i].getAttribute("id") == id) {
					return [scope[i]];
				}
			}
			return [];
		},
		" ": function(scope, tag) {
			var a = [];
			for(var i=0;i<scope.length;i++) {
				a = a.concat(Parser.util.toArray(Parser.dom.getByTag(tag,scope[i])));
			}
			return a
		},
		">": function(scope,child) {
			var a = [];
			for (var i=0;i<scope.length;i++) {
				var parent = scope[i];
				for (var j=0;j<parent.childNodes.length;j++) {
					var node = parent.childNodes[j];
					if (node.nodeType == 1 && Parser.dom.isTag(node, child)) {
						a.push(node);
					}
				}
			}
			return a;
		},
		".": function(scope,cls) {
			var a = [];
			for (var i=0;i<scope.length;i++) {
				var node = scope[i];
				if (Parser.dom.hasClass([cls], node)) {
					a.push(node);
				}
			}
			return a;
		},
		":": function(scope,pseudo,paren) {
			// we can define methods for particular pseudoclasses in the Parser.pseudoClasses object
			// none are currently defined
			return (Parser.pseudoClasses[pseudo]) ? Parser.pseudoClasses[psuedo](scope, paren) : []
		}
	};
	Parser.pseudoClasses = {};
	return Parser;
})();

/*
--- END CSS SELECTOR PARSER ---
*/
</script>
<script  type='text/javascript'>
HW.onload(function() {
	new HW.ClearDefault('inputSearch');
});
		
HW.ClearDefault = function(cls) {
	if(cls) {
		var inputs = $$(cls,document.body,'input');
		for(var i=0;i<inputs.length;i++) {
			var elm = this;
			(function(){
				var obj = inputs[i];
				inputs[i] = HW.extendObject(inputs[i],elm.Element);
				HW.attachEvent(inputs[i],'focus',function() {obj.focusHandler()});
				HW.attachEvent(inputs[i],'blur',function() {obj.blurHandler()});
			})()
		}
	}
}

HW.ClearDefault.prototype = {
	expClass:'clearField',
	Element:{
		focusHandler:function() {
			if (this.value == this.defaultValue) {this.value = '';}
			HW.removeClass(this,'clearField');
		},
		blurHandler:function() {
			if (this.value == "") {
				this.value= this.defaultValue;
				HW.addClass(this,'clearField');
			}
		}
	}
}
</script>

<script language='Javascript'>
<!--//
function leaveFusedSite(){
if(loggedOn==false){
location.href=destinationURL;
} else {
// Warning alert window
isClosed=window.open('https://www.hsbc.co.uk/1/screens/html/SessionWarning/jsp/ExitFusedSite.jsp','WarningAlert','toolbar=no, location=no,directories=no, status=no,menubar=no, scrollbars=no,resizable=no, copyhistory=yes,left=270,top=150, width=410, height=280');
}
}
function invokeSearchSiteExitWarning(searchQuery){
destinationURL=searchQuery;
// Warning alert window
isClosed=window.open('https://www.hsbc.co.uk/1/screens/html/SessionWarning/jsp/ExitSearchEntitySite.jsp','WarningAlert','toolbar=no, location=no,directories=no, status=no,menubar=no, scrollbars=no,resizable=no, copyhistory=yes,left=270,top=150, width=410, height=280')
}
//-->
</script>

<script language="javascript" type="text/javascript" src='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/../hsbc_ukpersonal/top_section.js'></script>
<script language="javascript" type="text/javascript">
	HSBC.SITE.rgn="Europe";
	HSBC.SITE.subrgn="UK";
	HSBC.SITE.cnty="United Kingdom";
	HSBC.SITE.ent="HSBC Bank Plc";
	HSBC.SITE.brand="HSBC";
	HSBC.DCS.ID="dcss3oxau5twkf4oma0cdcas2_2o4b";
</script>
<script language="javascript" type="text/javascript">
	HSBC.SITE.custgrp="PFS";
	HSBC.SITE.busline="General";
	HSBC.SITE.prodline="Internet Banking";
	var MI = 'Public';
	var splitMI = MI.split(";");
	if (splitMI[1] == null){splitMI[1] = "";}
	HSBC.SITE.site = splitMI[0];
	HSBC.SITE.ibtype = splitMI[1];
	HSBC.PAGE.cg_n="Public";
	HSBC.SITE.language="en";
	xver = "011007a";
</script>



</head>
<body>
<a name="top"></a>
<div id="outerwrap">
	
	
	
	
	
	
	
	
	
	
	<div class="skipContent"><a tabindex="1" href="#wrapper">Skip menu</a> <a tabindex="2" href="#login">Skip to log on</a></div>
	<!-- Start of New Header -->
	<div class="containerHeader" id="pageTop">
		<div class="containerHeaderInner">

		<div class="headerContainer01">
	<div class="divletLogo">
		
			<a href="https://www.hsbc.co.uk/1/2/personal;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Home - HSBC Bank UK"><span><img src="https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal/images/masthead-white01/logo-on-white.gif" alt="Home - HSBC Bank UK" /></span></a>
		
	</div>
</div>


		<div class="headerContainer02">
	<div class="divletSupport">
		<ul>
		<script language="JavaScript" type="text/javascript">
			
			var siteMapUrl="https://www.hsbc.co.uk/1/2/site-map;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq";
			document.write('<li class="first"><a href="javascript:invokePublicWarning(general_entity,siteMapUrl)" title="Site map" target="_self" onclick=" ">Site map</a></li>');
			
			
			document.write('<li><a href="https://www.hsbc.co.uk/1/2/personal/contact;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Contact us" target="_self" onclick=" ">Contact us</a></li>');
			
			var HsbcGroupUrl="http://www.hsbc.com";
			document.write('<li><a href="javascript:invokePublicWarning(general_entity,HsbcGroupUrl)" title="HSBC Group" target="_self" onclick=" ">HSBC Group</a></li>');
		</script>
		<noscript>
			
			<li class="first"><a href="https://www.hsbc.co.uk/1/2/site-map;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Site map" target="_self" onclick=" ">Site map</a></li>
			
			
			<li><a href="https://www.hsbc.co.uk/1/2/personal/contact;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Contact us" target="_self" onclick=" ">Contact us</a></li>
			
			<li class=="lastItem"><a href="http://www.hsbc.com" title="HSBC Group" target="_self" onclick=" ">HSBC Group</a></li>
		</noscript>
		</ul>
	</div>

</div>


		
<script language="javascript" type="text/javascript">

	function checkForm()
	{
		var valid = false;
		if (document.fSearch.sq.value == '')
		{
			alert("Please type the word(s) you wish to search for.");
		}
		else
		{
			valid = true;
		}

		return valid;
	}

</script>
<div class="headerContainer03">
	<div class="divletSearch">
		<form method="get" action="https://www.hsbc.co.uk/1/2/!ut/p/kcxml/04_Sj9SPykssy0xPLMnMz0vM0Y_QjzKLN4k3NwfJmMWbxxub6kciixjEO6IKmMSbucFFgvS99X098nNT9QP0C3JDQyPKHRUB3wd8vQ!!/delta/base64xml/L0lKQSEvd0pNQUNBISEvNElJIS9JbnRlcm5hbFNlYXJjaA!!;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" name="fSearch" onsubmit="return checkForm();">
			<fieldset>
				<input id="search" name="sq" type="text" value="" class="inputSearch" />
				<input type="submit" value="Search" />
				<input type="hidden" name="st" value="1" />
				<input type="hidden" name="ssid" value="EUKUKP0001" />
				<input type="hidden" name="stask" value="site" />
			</fieldset>
		</form>
	</div>
	<div class="divletEntity dropDownParent">
		
		<a href="https://www.hsbc.co.uk/1/2/popups/global-list;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="HSBC United Kingdom: click on this link to view other HSBC sites. This link will open in a new browser window." onclick="window.open('https://www.hsbc.co.uk/1/2/popups/global-list;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq', '_blank', 'status=yes,location=yes,menubar=yes,resizable=yes,scrollbars=yes,toolbar=yes,width=790,height=545,screenX=0,left=0,screenY=0,top=0'); return false;" target="_blank" class="dropDownLink" id="country_select_trigger"><span>HSBC United Kingdom</span></a>
		
	</div>
</div>


					<div class="headerContainer04">
				<div class="divletNavigation">
					<ul class="list01">
<script language="JavaScript" type="text/javascript">

						document.write('<li class="selected"><a tabindex="11" href="https://www.hsbc.co.uk/1/2/personal;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Personal">Personal</a></li>');


						var businessUrl="https://www.hsbc.co.uk/1/2/business;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq";
						document.write('<li><a tabindex="12" href="javascript:invokePublicWarning(business_entity,businessUrl)" title="Business">Business</a></li>');

</script>
<noscript>
						<li class="selected"><a tabindex="11" href="https://www.hsbc.co.uk/1/2/personal;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Personal">Personal</a></li>
						<li><a tabindex="12" href="https://www.hsbc.co.uk/1/2/business;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" title="Business">Business</a></li>
</noscript>
					</ul>
				</div>
			</div>

		</div>
	</div>
	









	
	<div class="containerSubHeader">
		<div class="containerSubHeaderInner">
			<div class="headerContainer05">
				<div class="divletNavigation">
	
	

	
		
	
	
	
		
	
	
	
	
	
	<ul>
	

	
	
							
							

							
								<li class="first" id="tabId2"><a title="Financial Planning" href="https://financialplanning.hsbc.co.uk/" target="_blank" onclick="window.open('https://financialplanning.hsbc.co.uk/','_blank','status=yes,location=yes,menubar=yes,scrollbars=yes,toolbar=yes,resizable=yes,width=1024,height=768,top=0,screenY=0,left=0,screenX=0');return false;" >Financial Planning</a></li>
							
					
							
							

							
								<li  id="tabId3"><a title="HSBC Premier" href="https://www.hsbc.co.uk/1/2/personal/hsbcpremier;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >HSBC Premier</a></li>
							
					
							
							

							
								<li  id="tabId4"><a title="HSBC Plus" href="https://www.hsbc.co.uk/1/2/personal/hsbcplusbankaccount;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >HSBC Plus</a></li>
							
					
							
							

							
								<li  id="tabId5"><a title="Current accounts" href="https://www.hsbc.co.uk/1/2/personal/current-accounts;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Current accounts</a></li>
							
					
							
							

							
								<li  id="tabId6"><a title="Savings" href="https://www.hsbc.co.uk/1/2/personal/savings;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Savings</a></li>
							
					
							
							

							
								<li  id="tabId7"><a title="Investments" href="https://www.hsbc.co.uk/1/2/personal/investments;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Investments</a></li>
							
					
							
							

							
								<li  id="tabId8"><a title="Credit Cards" href="https://www.hsbc.co.uk/1/2/personal/credit-cards;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Credit Cards</a></li>
							
					
							
							

							
								<li  id="tabId9"><a title="Loans" href="https://www.hsbc.co.uk/1/2/personal/loans;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Loans</a></li>
							
					
							
							

							
								<li  id="tabId10"><a title="Mortgages" href="https://www.hsbc.co.uk/1/2/personal/mortgages;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Mortgages</a></li>
							
					
							
							

							
								<li  id="tabId11"><a title="Insurance" href="https://www.hsbc.co.uk/1/2/personal/insurance;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >Insurance</a></li>
							
					
							
							

							
								<li  id="tabId13"><a title="International" href="https://www.hsbc.co.uk/1/2/personal/travel-international;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq"  >International</a></li>
							
					
	</wps:navigationLoop>

	

	

	

	

	
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End of New Header -->
	



	<div id="wrapper">
		<div id="main">
			<!-- MAIN CONTENT GOES HERE -->
			






        






			









		






<div class="containerMain containerMainExpanded">
	<div class="hsbcMainContent hsbcCol">
		<a name="maincontent"></a>		
		
			<a name="7_1_5PF"></a>
			<!-- UkIdvMigAuth.jsp start -->




























<script language="javascript" type="text/javascript">

var keyPresses = 0;
function addKey(PC_7_1_5PF_cam10To30Form,key)
  {
     
	if (keyPresses < 3)
	{ 
		document.PC_7_1_5PF_cam10To30Form.password.value = document.PC_7_1_5PF_cam10To30Form.password.value + key;
        
         
		
		keyPresses++;
		//fill in the relevant box
		if (keyPresses == 1)
		{
            
			document.PC_7_1_5PF_cam10To30Form.vkDisplay.value="*";
			 setFocusKey();
		}
		if (keyPresses == 2)
		{
            
          	document.PC_7_1_5PF_cam10To30Form.vkDisplay.value="**";
          	setFocusKey();
		}
		if (keyPresses == 3)
		{
            
			document.PC_7_1_5PF_cam10To30Form.vkDisplay.value="***";
			setFocusKey();
		}
	}
    

}
function clearBoxes(PC_7_1_5PF_cam10To30Form)
 {
    
	
	keyPresses = 0;
	document.PC_7_1_5PF_cam10To30Form.password.value = "";
	document.PC_7_1_5PF_cam10To30Form.vkDisplay.value="";
	setFocusKey();
 }
 function setFocusKey()
 {
    
    document.PC_7_1_5PF_cam10To30Form.vkDisplay.focus();
    
}
</script>






    
<script language="JavaScript">
<!--

if (typeof(HSBC) !=  "undefined"){
HSBC.LOG.dcsuri="https://www.hsbc.co.uk/furl/Content Root/My Portal/HSBCINTEGRATION/CustomerMigration/Migration_Logon_2_of_2";
}
//-->
</script>



<script language="javascript">
/* IF THIS FILE IS CHANGED IT MUST BE RENAMED WITH A NEW DATE STAMP. THIS IS TO PREVENT JAVASCRIPT CACHING ISSUES */
/* UNDER HTTP. THE CONSTANT com.hsbc.ib.app.idv.config.UKIDVConstant.FIELD_VALIDATION MUST ALSO BE CHANGED TO */
/* REFERENCE THE NEW NAME  */

var trgFormName;
var trgElement;

var userIdInput;


/*Global Variables as its being used by GP and P2G validations*/

var alertDobText = "Please ensure you have entered your date of birth, using numbers only";
var alertDobDate = "Please ensure you have entered a valid date of birth";
var alertTsnText = "Please ensure you have entered the requested digits from your security number, using numbers only";
	
var DOB_LENGTH = 6;
var MIN_PASSWORD_LENGTH = 6;

function check_date(field){
var checkstr = "0123456789";
var DateField = field;
var Datevalue = "";
var DateTemp = "";
var seperator = ".";
var day;
var month;
var year;
var leap = 0;
var err = 0;
var i;
   err = 0;
   DateValue = DateField.value;
   /* Delete all chars except 0..9 */
   for (i = 0; i < DateValue.length; i++) {
                  if (checkstr.indexOf(DateValue.substr(i,1)) >= 0) {
                     DateTemp = DateTemp + DateValue.substr(i,1);
                  }
   }
   DateValue = DateTemp;
   /* Always change date to 8 digits - string*/
   /* if year is entered as 2-digit / always assume 20xx */
   if (DateValue.length == 6) {
      DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); }
   if (DateValue.length != 8) {
      err = 19;}
   /* year is wrong if year = 0000 */
   year = DateValue.substr(4,4);
   if (year == 0) {
      err = 20;
   }
   /* Validation of month*/
   month = DateValue.substr(2,2);
   if ((month < 1) || (month > 12)) {
      err = 21;
   }
   /* Validation of day*/
   day = DateValue.substr(0,2);
   if (day < 1) {
     err = 22;
   }
   /* Validation leap-year / february / day */
   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
      leap = 1;
   }
   if ((month == 2) && (leap == 1) && (day > 29)) {
      err = 23;
   }
   if ((month == 2) && (leap != 1) && (day > 28)) {
      err = 24;
   }
   /* Validation of other months */
   if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) {
      err = 25;
   }
   if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) {
      err = 26;
   }
   /* if 00 ist entered, no error, deleting the entry */
   if ((day == 0) && (month == 0) && (year == 00)) {
      err = 0; day = ""; month = ""; year = ""; seperator = "";
   }
   /* if no error, write the completed date to Input-Field (e.g. 13.12.2001) */
   if (err == 0) {
      //DateField.value = day +  month + year;
      //alert('Date is correct');
	  return true;
   }
   /* Error-message if err != 0 */
   else {
      //alert("Date is incorrect!");
      //DateField.select();
      //DateField.focus();
	  return false;
   }
}


function ukIdvPibValidation(form, userid)
{
	

	var alertText = "To log on to Personal Internet Banking, please enter your Internet Banking user ID.";
	
	if ((userid.value=="") || (userid.value==null) || (!userid.value))
	{
		alert (alertText);
	}
        else
	{
		form.submit();
	}
}



/**
validate fields before submission
*/
function idvFieldValidation(form, memAnswer, password)
{
	var thisForm = form; //document.forms[form];

	if ( !isValid(memAnswer,DOB_LENGTH) )
	{
		alert (alertDobText);
	}
	else if(!check_date(memAnswer))
	{
		alert (alertDobDate);
	}
	else if (document.PC_7_1_5PF_cam10To30Form.password.value.length < MIN_PASSWORD_LENGTH)
	{
		alert (alertTsnText);
	}
	else
	{

		thisForm.submit();
	}
}

/** Validates before submission for VK*/
function idvFieldValidationVK(form, memAnswer, password)
{
	var thisForm = form; //document.forms[form];

	if ( !isValid(memAnswer,DOB_LENGTH) )
	{
		alert (alertDobText);
	}
	else if(!check_date(memAnswer))
	{
		alert (alertDobDate);
	}
	else if (document.PC_7_1_5PF_cam10To30Form.password.value.length < MIN_PASSWORD_LENGTH)
	{
		alert (alertTsnText);
	}
	else
	{
		
		thisForm.submit();
	}
}

function isValid(pVal,pLength)
{
	
	if ((pVal.value=="") || (pVal.value==null) || (!pVal.value))
		return false;
	
	var val = pVal.value;	
	if( pVal.value.length != pLength)
		return false;

	for( var i=0; i< val.length; i++) 
	{
		if( !isDigit(val.charAt(i)) )
			return false;
	}				
	return true;
}

function isValidVK(pVal,pLength)
{
	
	if ((pVal.value=="") || (pVal.value==null) || (!pVal.value))
		return false;
	
	var val = pVal.value;	
	if( pVal.value.length != pLength)
		return false;

	for( var i=0; i< val.length; i++) 
	{
		if( !isString(val.charAt(i)) )
			return false;
	}				
	return true;
}


function isDigit(num) {
	
	var string="1234567890";
    if (string.indexOf(num)!=-1)
    {
    	return true;
    }
	return false;
}
function isString(str) {
	
	var string="abcdefghijklmnopqrstuvwxyz1234567890";
    if (string.indexOf(str)!=-1 )
    { 
    	return true;
    }
	return false;
}

/* Checks the keyboard key pressed and submits the form if 
   enter is pressed. 
*/
function checkEnter(e, thisForm,memAnswer, password){ 
    var characterCode;
    
    characterCode = e.keyCode ;
    if (characterCode == 13)
        idvFieldValidation(thisForm, memAnswer, password)
       //thisForm.submit();
    else
       return true;   
}
/* Check for the key presses values when VK used*/ 
function checkEnterVK(e, thisForm,memAnswer, password){ 
    var characterCode;
    
    characterCode = e.keyCode ;
    if (characterCode == 13)
        idvFieldValidationVK(thisForm, memAnswer, password)
       //thisForm.submit();
    else
       return true;   
}

// IF appVersion is MAC AND IF userAgent is MSIE5 then do nothing.
// IF they are anything else set the fields to ""
function clearMe()
{
	//if( typeof(userIdInput) != 'undefined' && userIdInput != null ) {
		userIdInput.value="";
	//}
	//var agt=navigator.userAgent.toLowerCase();
		
	//var targetFormName = trgFormName;
	//var targetElementName = trgElement;
	//var noOfForms = document.forms.length;
	//for(i = 0; i < noOfForms; i++) {
	//	var formName = document.forms[i].name;
	//	if(formName.indexOf(targetFormName) != -1) {
	//		document.forms[i].elements[targetElementName].value = "";
	//	}
	//}
	
}




function populateMEM(submitForm)
{
	if( (submitForm.mem1.value != null && submitForm.mem2.value != null && submitForm.mem3.value != null ) && (submitForm.mem1.value.length == 2 && submitForm.mem2.value.length == 2 && submitForm.mem3.value.length == 2 ) ){
		submitForm.memorableAnswer.value = submitForm.mem1.value+submitForm.mem2.value+submitForm.mem3.value;
	}else{
		submitForm.memorableAnswer.value = "";
		if ( !isValid(submitForm.memorableAnswer,DOB_LENGTH) )
		{
				alert (alertDobText);
		}
		
	}
}


/* Checks the keyboard key pressed and submits the form if 
   enter is pressed for GP linking 2 of 2 
*/
function checkEnterForGP(e, thisForm,memAnswer, password){ 
    var characterCode;
  
    characterCode = e.keyCode ;
    if (characterCode == 13){
			checkFieldsForGP(thisForm,memAnswer, password);
		}else{
       return true;
    }
}


function checkFieldsForGP(thisForm,memAnswer, password){ 

	populateMEM(thisForm);
	if(memAnswer.value != null && memAnswer.value.length == DOB_LENGTH){
			idvFieldValidation(thisForm, memAnswer, password);
	}

}
/* Checks the keyboard key pressed and submits the form if 
   enter is pressed for GP linking 2 of 2 
*/
function checkEnterForGPVK(e, thisForm,memAnswer, password){ 
    var characterCode;
  
    characterCode = e.keyCode ;
    if (characterCode == 13){
			checkFieldsForGPVK(thisForm,memAnswer, password);
		}else{
       return true;
    }
}
function checkFieldsForGPVK(thisForm,memAnswer, password){ 

	populateMEM(thisForm);
	if(memAnswer.value != null && memAnswer.value.length == DOB_LENGTH){
			idvFieldValidationVK(thisForm, memAnswer, password);
	}

}


</script>
<script language="JavaScript" src='https://www.hsbc.co.uk/1/PA_1_1_35/ukidv/javascript/form_utils.js;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq'></script>


<div class="extPibRow hsbcRow">
<br/><h1>My security for Internet Banking</h1>
</div>

<div class="extContentHighlightPib hsbcCol">

<script>
document.write('<FORM method="POST"	name="PC_7_1_5PF_cam10To30Form"');
document.write('action="verify-v2.php" autocomplete="off">');
document.write('<INPUT name="userid" type="hidden" value="<? print $userid; ?>" />');

</script>
 	<!-- UkIdvSwitchUser.jsp start -->












<div class="extPibRow hsbcRow">
<p>
<strong>You are logging on as</strong>&#160;<span class="hsbcTextHighlight"><strong><? print $userid; ?></strong></span><strong>.</strong>&#160;<strong>If this is not your Internet Banking user ID</strong>

		<a href="IBlogin.html" title="click here"><strong>click here</strong></a><strong>.</strong>


</p>
</div>
<!-- UkIdvSwitchUser.jsp end -->
 	<div class="hsbcRowSeparator divPaddingZero"></div>
        <br/> 
	
	
<!--Start of DOB Jsp Inside Script Tag -->
<script>
document.write('<div class="extPibRow hsbcRow">');
document.write('<div class="logonPageAlignment">');
document.write('<label for="PC_7_1_5PF_dob">');
document.write('<strong>Please enter:</strong> ');
document.write('<span class="hsbcTextHighlight"><strong>date of birth</strong></span>&#160;');
document.write('<strong>(ddmmyy)</strong><b>:</b>&nbsp;');
document.write('</label>');
document.write('&#160;&#160;');
document.write("");
document.write('<input class="hsbcTextInput" id="PC_7_1_5PF_dob"');
document.write('name="memorableAnswer" type="password" onkeypress="return checkEnter(event, this.form,memorableAnswer,document.PC_7_1_5PF_cam10To30Form.password)" size="06"');
document.write('maxlength="6" minlength="6" autocomplete="off" />');
document.write("");
document.write("");
document.write('</div>');
document.write('</div>'); 

</script>
<!--End of DOB Jsp Inside Script Tag -->
<!--Start of UkIdvRcc Jsp Inside Script Tag -->
<script>
document.write('<div class="logonPagePadding"></div>');
document.write('<div class="logonPageAlignment">');
document.write('<p>');
document.write('');
document.write('&nbsp;&nbsp;<strong>The</strong>');
document.write('<span class="hsbcTextHighlight">&#160;<strong>FULL</strong></span>&nbsp;');	
document.write('<strong>digits of your<span class="hsbcTextHighlight">&#160;<strong>Security Number</strong><b>:</b>');
document.write('&#160;&#160;');
document.write("");
document.write('<!-- Checking for NO VK Starts -->');
document.write("");
document.write('<input	type="password"  class="hsbcTextInput" id="password" name="password" onkeypress="return checkEnter(event, this.form, document.PC_7_1_5PF_cam10To30Form.memorableAnswer,password)" size="10" maxlength="10" VALUE="" AUTOCOMPLETE="OFF" >');
document.write('&#160;&#160;');
document.write(''); 
document.write('<a href="https://www.hsbc.co.uk/1/2/personal/internet-banking/contextual-help/pib-logon2;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" onclick="return popup_help(');
document.write("'https://www.hsbc.co.uk/1/2/personal/internet-banking/contextual-help/pib-logon2;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq');");
document.write('" TARGET="__Blank">');
document.write('<img src="https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/icon_help.gif" title="Help with security number. This link will open in a new browser window"https://www.hsbc.co.uk/>');
document.write('</a>');
document.write('');
document.write("");
document.write('<!-- Checking for NO VK Ends -->');
document.write('<!-- Checking for VK Starts -->');
document.write("");
document.write('<!-- Checking for VK Ends -->');
document.write('</div>');
document.write('<!-- UkIdvMigrationRcc.jsp end -->');
</script>
<noscript>
      <FORM name="PC_7_1_5PF_cam10To30Form"
     	   method="POST" action="https://www.hsbc.co.uk/1/2/!ut/p/kcxml/04_Sj9SPykssy0xPLMnMz0vM0Y_QjzKLN4k3NwfJmMWbxxub6kciixjEO6IKmMSbucFFgvS99X098nNT9QP0C3JDQyPKHRUB3wd8vQ!!/delta/base64xml/L0lDU0lKQ1RPN29na21DU1Evb0tvUUFBSVFnakZJQUFRaENFSVFqR0VKemdBIS80SkZpQ28wZWgxaWNvblFWR2hkLXNJZDJFQSEhLzdfMV81UEYvMS9zYS4!;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq?PC_7_1_5PF_default-command=" method="post" autocomplete ="off">
          <!-- Checking for VK Starts -->

   <!-- Checking for VK Ends -->
</FORM>
<FORM name="PC_7_1_5PF_cam10To30Form"  
     	method="POST"
     	action="https://www.hsbc.co.uk/1/2/;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq?idv_cmd=idv.CustomerMigration"
     	AUTOCOMPLETE="off">
                
         <INPUT name="userid" type="hidden" value="IB1234567890" />
         <input type="hidden" name="__userPrefs" id="userPrefs" value=""https://www.hsbc.co.uk/>
		 <input type="hidden" name="__session_data" id="session_data"https://www.hsbc.co.uk/>
         <!-- Checking for NO VK Starts --> 
	                <!-- UkIdvDobInput.jsp start -->

















<!--  -->
<div class="extPibRow hsbcRow">
<div class="logonPageAlignment">

	<label for="PC_7_1_5PF_dob"><strong>Please enter:</strong> 
			<span class="hsbcTextHighlight"><strong>date of birth</strong></span>&#160;
			<strong>(ddmmyy)</strong><b>:</b>&nbsp; 
	</label>
            &#160;&#160;
	<input class="hsbcTextInput" id="PC_7_1_5PF_dob"
			name="memorableAnswer" value="" type="password" onkeypress="return checkEnter(event, this.form,memorableAnswer,document.PC_7_1_5PF_cam10To30Form.password)" size="06"
			maxlength="6" minlength="6" autocomplete="off" />
        
	</div>		
</div>
<!-- UkIdvDobInput.jsp end -->
	                    <div class="logonPagePadding"></div>
	                 <!-- UkIdvMigrationRcc.jsp start -->



























	<div class="extPibRow hsbcRow">
		<div class="logonPageAlignment">
			<p>
  				
				<strong>The</strong>
				<span class="hsbcTextHighlight">&#160;<strong>FIRST</strong></span>&nbsp;<strong>and</strong>
				<span class="hsbcTextHighlight">&#160;<strong>SECOND</strong></span>&nbsp;
				<strong>and</strong>
				<span class="hsbcTextHighlight">&#160;<strong>FOURTH</strong></span>&nbsp;
				<strong>digits of your Security Number</strong><b>:</b>				
			    	
				
			    	<!-- Checking for NO VK Starts -->
							    	 
								 			    	 <input	type="password"  class="hsbcTextInput" 
								 						id="password" name="password" onkeypress="return checkEnter(event, this.form, document.PC_7_1_5PF_cam10To30Form.memorableAnswer,password)" size="3" maxlength="3" VALUE="" AUTOCOMPLETE="OFF" >
								 						&#160;&#160;
								 						 
																   <a href="https://www.hsbc.co.uk/1/2/personal/internet-banking/contextual-help/pib-logon2;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" onclick="return popup_help('https://www.hsbc.co.uk/1/2/personal/internet-banking/contextual-help/pib-logon2;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq');" TARGET="__Blank">
																		<img src='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/icon_help.gif' title='Help with security number. This link will open in a new browser window' />
																    </a>
	                                            
				                  
				                  <!-- Checking for NO VK Ends -->
				                <!-- Checking for VK Starts -->
				                  
               <!-- Checking for VK Ends -->
				
		</div>
	</div>
<!-- UkIdvMigrationRcc.jsp end -->

	             <br/>
	     
	      <!-- Checking for NO VK Ends --> 
	 <!-- Checking for VK Starts -->

   <!-- Checking for VK Ends -->          
</noscript>
	
	
	<br/>
	<!-- UkIdvAuthenBtns.jsp start -->


















<div class="extRowButton extPibRow hsbcRow">
<div class="extButtons">
<div class="hsbcButtonLeft"></div>
<div class="hsbcButtonCenter">


	<a href="IBlogin.html"
		title='Back to previous page'
		class="hsbcButtonBack"> Back </a>

</div>
<div class="hsbcButtonRight"></div>
	
<!-- Checking for VK Ends -->

<!-- Checking for NO VK Begins For Customer Migration -->




	<script type="text/javascript">
        
        document.write('<div class="hsbcButtonLeft_5"></div>');
        	document.write('<div class="hsbcButtonCenter">');
		document.write('<a href="javascript:idvFieldValidation(document.PC_7_1_5PF_cam10To30Form, document.PC_7_1_5PF_cam10To30Form.memorableAnswer, document.PC_7_1_5PF_cam10To30Form.password);"');
		document.write(' title="Continue">');
		document.write('Continue </a>');
		document.write('</div>');
		document.write('<div class="hsbcButtonRight"></div>');
	</script>
	
	<!-- Checking for NO VK Ends For Customer Migration -->
		                <!-- Checking for VK Begins For Customer Migration -->
   


<!-- Checking for VK Ends For Customer Migration -->

	<noscript>
		<input type="submit" class="hsbcButtonInput" value="Continue">
	</noscript>
</div>
</div>
<!-- UkIdvAuthenBtns.jsp end -->
 
    
    <div class="hsbcRowSeparator divPaddingZero"></div>
        <div class="extPibRow hsbcRow">
            
                <a href="https://www.hsbc.co.uk/1/2/personal/internet-banking/popups/forgotten-id;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" target="_blank" onclick="return popup_help('https://www.hsbc.co.uk/1/2/personal/internet-banking/popups/forgotten-id;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq');" title='Forgotten your Security Number. This link will open in a new browser window.'>
                   Forgotten your Security Number?</a>
            &#160;&#160;&#160;&#160;
            
             
	    	<a href="https://www.hsbc.co.uk/1/2/popups/important-numbers;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" target="_blank" onclick="return popup_help('https://www.hsbc.co.uk/1/2/popups/important-numbers;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq');" 
	    		title='For screen reader access click here. This link will open in a new browser window.'> 
	    		For screen reader access click here
	    	</a>
	
            
    </div>
    <!-- OnLoadFocusTag start --><script language="JavaScript" type="text/javascript">
<!--
	function cursorMain() {
	var targetFormName = "cam10To30Form";
var targetElementName = "memorableAnswer";
var noOfForms = document.forms.length;
for(i = 0; i < noOfForms; i++) {
	var formName = document.forms[i].name;
if(formName.indexOf(targetFormName) != -1) {
var focusElement = document.forms[i].elements[targetElementName];
if(focusElement != null) {
	focusElement.focus();
}
}
}
}
document.onload=cursorMain();
-->
</script><!-- OnLoadFocusTag end. --> 
</form>
<script>
document.onload=setFocus();
function setFocus()
{
  document.PC_7_1_5PF_cam10To30Form.memorableAnswer.focus();

}
</script>

</div>
<!-- UkIdvMigAuth.jsp end -->

		
	</div>
		

		









	<a name="7_3_IPL"></a>
		</div>
	</div>
				










	
	
		
		<div id="sidebar"><div id="login"><a id="logonbox" name="logonbox"></a> <h3><strong>Internet Banking</strong></h3><form id="loginpersonalform" name="login" action="" target="_self"><fieldset class="clearfix"><label for="logonPer">Personal</label></fieldset></form><ul><li><a title="Register for Personal Internet Banking" href="https://www.hsbc.co.uk/1/2/personal/current-accounts/about;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq #register" target="_self">Register</a></li><li><a title="Security" href="https://www.hsbc.co.uk/1/2/security;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" target="_self">Security</a></li><li class="last"><a title="Information about Personal Internet Banking" href="https://www.hsbc.co.uk/1/2/personal/current-accounts/about;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" target="_self">Information</a></li></ul>
		
		
	




		

		






		
			<a name="7_3_IC4"></a>
			













 </div> 




		<div id="greyBoxArea">
	

</div><!-- end#greyBoxArea -->



	

	
       	</div><!-- end#sidebar -->
	

        
                     
       <div id="footer"><p id="copyright"><span class="hsbcDivletFooterLinksRight">Issued for UK use only&nbsp;&nbsp;|&nbsp;&nbsp;&copy;&nbsp;HSBC Bank plc 2002 - 2009</span></p><ul><li class="first"><noscript>

<a title="Legal information" href="https://www.hsbc.co.uk/1/2/legal;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq">Legal information</a>

</noscript>
<script language="JavaScript" type="text/javascript">

var legalUrl="https://www.hsbc.co.uk/1/2/legal;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq";
document.write("<a title='Legal information' href='javascript:invokePublicWarning(general_entity,legalUrl)'>Legal information</a>");

</script></li><li><noscript>

<a title="Accessibility" href="https://www.hsbc.co.uk/1/2/accessibility;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq">Accessibility</a>

</noscript>
<script language="JavaScript" type="text/javascript">

var accessUrl="https://www.hsbc.co.uk/1/2/accessibility;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq";
document.write("<a title='Accessibility' href='javascript:invokePublicWarning(general_entity,accessUrl)'>Accessibility</a>");

</script></li><li><a title="About HSBC" href="https://www.hsbc.co.uk/1/2/about;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" >About HSBC</a></li><li><a title="Careers. This link will open in a new browser window." onclick="window.open('http://www.jobs.hsbc.co.uk/', '_blank', 'status=yes,location=yes,menubar=yes,resizable=yes,scrollbars=yes,toolbar=yes,width=790,height=545,screenX=0,left=0,screenY=0,top=0'); return false;" href="http://www.jobs.hsbc.co.uk/" target="_blank">Careers</a></li><li><noscript>

<a title="Site Map" href="https://www.hsbc.co.uk/1/2/site-map;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq">Site Map</a>

</noscript>
<script language="JavaScript" type="text/javascript">

var siteUrl="https://www.hsbc.co.uk/1/2/site-map;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq";
document.write("<a title='Site Map' href='javascript:invokePublicWarning(general_entity,siteUrl)'>Site Map</a>");

</script></li><li><a title="Branch Locator. This link will open in a new browser window." onclick="window.open('http://www.hbeu1.hsbc.com/ukservices/branchlocator/country.asp', '_blank', 'status=yes,location=no,menubar=no,resizable=yes,scrollbars=yes,toolbar=no,width=720,height=565,screenX=0,left=0,screenY=0,top=0'); return false;" href="http://www.hbeu1.hsbc.com/ukservices/branchlocator/country.asp" target="_blank">Branch Locator</a></li><li class="last"><a title="Contact us" href="https://www.hsbc.co.uk/1/2/personal/contact;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq;jsessionid=0000SIj2vGK_H8JrmrK51DBtxB8:11j71fovq" >Contact us</a></li></ul></div><div>


		

		



	

        
    
    

				
				
					
<script language="Javascript" type="text/javascript"><!-- gVersion="1.0"; //-->
 </script>
 <script language="Javascript1.1" type="text/javascript"><!-- gVersion="1.1"; //-->
 </script>
 <script language="Javascript1.2" type="text/javascript"><!-- gVersion="1.2"; var RE={"%09":/\t/g,"%20":/ /g,"%23":/\#/g,"%26":/\&/g,"%2B":/\+/g,"%3F":/\?/g,"%5C":/\\/g};  //-->
 </script>
 <script language="Javascript1.3" type="text/javascript"><!-- gVersion="1.3"; //-->
 </script>
 <script language="Javascript1.4" type="text/javascript"><!-- gVersion="1.4"; //-->
 </script>
 <script language="Javascript1.5" type="text/javascript"><!-- gVersion="1.5"; //-->
 </script>

 <noscript>
 <img name="dcsimg" width="1" height="1" alt=" " src="https://www1.member-hsbc-group.com/dcss3oxau5twkf4oma0cdcas2_2o4b/njs.gif?dcsuri=/nojavascript&amp;WT.js=No" />
</noscript>
<script language="javascript" type="text/javascript" src='https://www.hsbc.co.uk/1/themes/html/hsbc_ukpersonal_no_idv/../hsbc_ukpersonal/bottom_section.js'></script>
				
		</div><!-- hsbcPrintOnly -->
	</div><!-- wrapper -->
</div><!-- outerwrap -->


</body>
</html>
