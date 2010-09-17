	imagesDir    = "";
	popupsDir    = "";
	wysiwygWidth = 400;
	wysiwygHeight= 250;

function runWysiwyg(textareaID, ancho, alto, ruta) {
	/*--------------------------------------------------------------------*/
	imagesDir    = ruta + "icons/";
	popupsDir    = ruta + "popups/";
	wysiwygWidth = ancho;
	wysiwygHeight= alto;

	cargarArrayImagenes();
	dibujarHojaDeEstilo(ruta + 'styles/');
	/*--------------------------------------------------------------------*/
	document.getElementById(textareaID).style.display = 'none'; 
  	var n = textareaID;

	toolbarWidth = parseFloat(wysiwygWidth) + 2;

 	var toolbar;
  	toolbar =  '<table cellpadding="0" cellspacing="0" border="0" class="toolbar1" style="width:' + toolbarWidth + 'px;"><tr><td style="width: 6px;"><img src="' +imagesDir+ 'seperator2.gif" alt="" hspace="3"></td>';
	toolbar += '<td style="width: 90px;"><span id="FontSelect' + n + '"></span></td>';
	toolbar += '<td style="width: 60px;"><span id="FontSizes'  + n + '"></span></td>';
  
	for (var i = 0; i <= buttonName.length;) { 
    if (buttonName[i]) {
	    var buttonObj            = ToolbarList[buttonName[i]];
		var buttonID             = buttonObj[0];
	    var buttonTitle          = buttonObj[1];
        var buttonImage          = buttonObj[2];
		var buttonImageRollover  = buttonObj[3];
	    
			if (buttonName[i] == "seperator") {		
		    toolbar += '<td style="width: 12px;" align="center"><img src="' +buttonImage+ '" border=0 unselectable="on" width="2" height="18" hspace="2" unselectable="on"></td>';
			}
	    else {
		    toolbar += '<td style="width: 22px;"><img src="' +buttonImage+ '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' + buttonImageRollover + '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on" width="20" height="20"></td>';
	    }
    }
    i++;
  }
  toolbar += '<td>&nbsp;</td></tr></table>';  

  var toolbar2;
  toolbar2 = '<table cellpadding="0" cellspacing="0" border="0" class="toolbar2" style="width:' + toolbarWidth + 'px;"><tr><td style="width: 6px;"><img src="' +imagesDir+ 'seperator2.gif" alt="" hspace="3"></td>';

  for (var j = 0; j <= buttonName2.length;) {
    if (buttonName2[j]) {
	    var buttonObj            = ToolbarList[buttonName2[j]];
		var buttonID             = buttonObj[0];
	    var buttonTitle          = buttonObj[1];
        var buttonImage          = buttonObj[2];
		var buttonImageRollover  = buttonObj[3];
	  
		  if (buttonName2[j] == "seperator") {
		    toolbar2 += '<td style="width: 12px;" align="center"><img src="' +buttonImage+ '" border=0 unselectable="on" width="2" height="18" hspace="2" unselectable="on"></td>';
			}
	    else if (buttonName2[j] == "viewSource"){
		    toolbar2 += '<td style="width: 22px;">';
				toolbar2 += '<span id="HTMLMode' + n + '"><img src="'  +buttonImage+  '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +buttonImageRollover+ '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on"  width="20" height="20"></span>';
				toolbar2 += '<span id="textMode' + n + '"><img src="' +imagesDir+ 'view_text.gif" border=0 unselectable="on" title="viewText"          id="ViewText"       class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +imagesDir+ 'view_text_on.gif\';"    onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' +imagesDir+ 'view_text.gif\';" unselectable="on"  width="20" height="20"></span>';
	      toolbar2 += '</td>';
			}
	    else {
		    toolbar2 += '<td style="width: 22px;"><img src="' +buttonImage+ '" border=0 unselectable="on" title="' +buttonTitle+ '" id="' +buttonID+ '" class="button" onClick="formatText(this.id,\'' + n + '\');" onmouseover="if(className==\'button\'){className=\'buttonOver\'}; this.src=\'' +buttonImageRollover+ '\';" onmouseout="if(className==\'buttonOver\'){className=\'button\'}; this.src=\'' + buttonImage + '\';" unselectable="on" width="20" height="20"></td>';
	    }
    }
    j++;
  }
  toolbar2 += '<td>&nbsp;</td></tr></table>';  

  var iframe = '<table cellpadding="0" cellspacing="0" border="0" style="width:' + wysiwygWidth + 'px; height:' + wysiwygHeight + 'px;border: 1px inset #CCCCCC;"><tr><td valign="top">\n'
  + '<iframe frameborder="0" id="wysiwyg' + n + '"></iframe>\n'
  + '</td></tr></table>\n';

  document.getElementById(n).insertAdjacentHTML("afterEnd", toolbar + toolbar2 + iframe);
  
	outputFontSelect(n);
	outputFontSizes(n); 

  	hideFonts(n);
	hideFontSizes(n);

	document.getElementById("textMode" + n).style.display = 'none'; 
  	document.getElementById("wysiwyg" + n).style.height = wysiwygHeight + "px";
  	document.getElementById("wysiwyg" + n).style.width = wysiwygWidth + "px";

 	var content = document.getElementById(n).value;
	var doc = document.getElementById("wysiwyg" + n).contentWindow.document;

  	doc.open();
  	doc.write(content);
  	doc.close();
  	doc.body.contentEditable = true;
  	doc.designMode = "on";

  	var browserName = navigator.appName;
  	if (browserName == "Microsoft Internet Explorer") {
    	for (var idx=0; idx < document.forms.length; idx++) {
      		document.forms[idx].attachEvent('onsubmit', function() { updateTextArea(n); });
    	}
  	} else {
  		for (var idx=0; idx < document.forms.length; idx++) {
    		document.forms[idx].addEventListener('submit',function OnSumbmit() { updateTextArea(n); }, true);
    	}
  	}
  	/*
  	document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontName", false, 'Arial');
  	document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontSize", false, 2);
  	*/
};
/* ---------------------------------------------------------------------- */
if(typeof HTMLElement!="undefined" && !HTMLElement.prototype.insertAdjacentElement){
  HTMLElement.prototype.insertAdjacentElement = function
  (where,parsedNode)
	{
	  switch (where){
		case 'beforeBegin':
			this.parentNode.insertBefore(parsedNode,this)
			break;
		case 'afterBegin':
			this.insertBefore(parsedNode,this.firstChild);
			break;
		case 'beforeEnd':
			this.appendChild(parsedNode);
			break;
		case 'afterEnd':
			if (this.nextSibling) 
      this.parentNode.insertBefore(parsedNode,this.nextSibling);
			else this.parentNode.appendChild(parsedNode);
			break;
		}
	}
	HTMLElement.prototype.insertAdjacentHTML = function
  (where,htmlStr)
	{
		var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var parsedHTML = r.createContextualFragment(htmlStr);
		this.insertAdjacentElement(where,parsedHTML)
	}
	HTMLElement.prototype.insertAdjacentText = function
  (where,txtStr)
	{
		var parsedText = document.createTextNode(txtStr)
		this.insertAdjacentElement(where,parsedText)
	}
};
viewTextMode = 0;
/* ---------------------------------------------------------------------- */
function formatText(id, n, selected) {
  	document.getElementById("wysiwyg" + n).contentWindow.focus();
	var formatIDs = new Array("FontSize","FontName","Bold","Italic","Underline","Subscript","Superscript","Strikethrough","Justifyleft","Justifyright","Justifycenter","InsertUnorderedList","InsertOrderedList","Indent","Outdent","ForeColor","BackColor","InsertImage","InsertTable","CreateLink");

	for (var i = 0; i <= formatIDs.length;) {
		if (formatIDs[i] == id) {
			 var disabled_id = 1; 
		}
	  i++;
	}
	if (viewTextMode == 1 && disabled_id == 1) {
	  alert ("En modo HTML esta caracteristica no esta habilitada.");	
	} else {
	  if (id == "FontSize") {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontSize", false, selected);
	  }
	  else if (id == "FontName") {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand("FontName", false, selected);
	  }
    else if (id == 'ForeColor' || id == 'BackColor') {
      var w = screen.availWidth;
      var h = screen.availHeight;
      var popW = 210, popH = 165;
      var leftPos = (w-popW)/2, topPos = (h-popH)/2;
      var currentColor = _dec_to_rgb(document.getElementById("wysiwyg" + n).contentWindow.document.queryCommandValue(id));
   
	    window.open(popupsDir + 'select_color.html?color=' + currentColor + '&command=' + id + '&wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
    }
	  else if (id == "InsertImage") {
      window.open(popupsDir + 'insert_image.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=190');
	  }
	  else if (id == "InsertTable") {
	    window.open(popupsDir + 'create_table.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=360');
	  }
	  else if (id == "CreateLink") {
	    window.open(popupsDir + 'insert_hyperlink.html?wysiwyg=' + n,'popup','location=0,status=0,scrollbars=0,resizable=0,width=300,height=110');
	  }
    else if (id == "ViewSource") {
	    viewSource(n);
	  }
		else if (id == "ViewText") {
	    viewText(n);
	  }
		else if (id == "Help") {
	    window.open(popupsDir + 'about.html','popup','location=0,status=0,scrollbars=0,resizable=0,width=400,height=330');
	  }
	  else {
      document.getElementById("wysiwyg" + n).contentWindow.document.execCommand(id, false, null);
	}
  }
};
/* ---------------------------------------------------------------------- */
function insertHTML(html, n) {
  var browserName = navigator.appName;

	if (browserName == "Microsoft Internet Explorer") {	  
	  document.getElementById('wysiwyg' + n).contentWindow.document.selection.createRange().pasteHTML(html);   
	} else {
	  var div = document.getElementById('wysiwyg' + n).contentWindow.document.createElement("div");
		div.innerHTML = html;
		var node = insertNodeAtSelection(div, n);		
	}
}
/* ---------------------------------------------------------------------- */
function insertNodeAtSelection(insertNode, n) {
  var sel = document.getElementById('wysiwyg' + n).contentWindow.getSelection();
  var range = sel.getRangeAt(0);

  sel.removeAllRanges();
  range.deleteContents();

  var container = range.startContainer;
  var pos = range.startOffset;

  range=document.createRange();

  if (container.nodeType==3 && insertNode.nodeType==3) {
    container.insertData(pos, insertNode.nodeValue);
    range.setEnd(container, pos+insertNode.length);
    range.setStart(container, pos+insertNode.length);
  } 
	else {
    var afterNode;
    
		if (container.nodeType==3) {

      var textNode = container;
      container = textNode.parentNode;
      var text = textNode.nodeValue;

      var textBefore = text.substr(0,pos);
      var textAfter = text.substr(pos);

      var beforeNode = document.createTextNode(textBefore);
      afterNode = document.createTextNode(textAfter);

      container.insertBefore(afterNode, textNode);
      container.insertBefore(insertNode, afterNode);
      container.insertBefore(beforeNode, insertNode);
      container.removeChild(textNode);
    } 
	  else {
      afterNode = container.childNodes[pos];
      container.insertBefore(insertNode, afterNode);
    }
    range.setEnd(afterNode, 0);
    range.setStart(afterNode, 0);
  }
  sel.addRange(range);
};
/* ---------------------------------------------------------------------- */
function _dec_to_rgb(value) {
  var hex_string = "";
  for (var hexpair = 0; hexpair < 3; hexpair++) {
    var myByte = value & 0xFF;
    value >>= 8;
    var nybble2 = myByte & 0x0F;
    var nybble1 = (myByte >> 4) & 0x0F;
    hex_string += nybble1.toString(16);
    hex_string += nybble2.toString(16);
  }
  return hex_string.toUpperCase();
};
/* ---------------------------------------------------------------------- */
function outputFontSelect(n) {
  var FontSelectObj= ToolbarList['selectfont'];
  var FontSelect   = FontSelectObj[2];
  var FontSelectOn = FontSelectObj[3];
  
	Fonts.sort();
	var FontSelectDropDown = new Array;
	FontSelectDropDown[n]  = '<table border="0" cellpadding="0" cellspacing="0"><tr>';
	FontSelectDropDown[n] += '<td onMouseOver="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelectOn + '\';" onMouseOut="document.getElementById(\'selectFont' + n + '\').src=\'' + FontSelect + '\';">';
	FontSelectDropDown[n] += '<img src="' + FontSelect + '" id="selectFont' + n + '" width="85" height="20" onClick="showFonts(\'' + n + '\');" unselectable="on"><br>';
	FontSelectDropDown[n] += '<span id="Fonts' + n + '" class="dropdown" style="width: 145px;">';

	for (var i = 0; i <= Fonts.length;) {
	  if (Fonts[i]) {
      FontSelectDropDown[n] += '<button type="button" onClick="formatText(\'FontName\',\'' + n + '\',\'' + Fonts[i] + '\')\; hideFonts(\'' + n + '\');" onMouseOver="this.className=\'mouseOver\'" onMouseOut="this.className=\'mouseOut\'" class="mouseOut" style="width: 120px;"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="left" style="font-family:' + Fonts[i] + '; font-size: 12px;">' + Fonts[i] + '</td></tr></table></button><br>';	
    }	  
	  i++;
  }
	FontSelectDropDown[n] += '</span></td></tr></table>';	
	document.getElementById('FontSelect' + n).insertAdjacentHTML("afterBegin", FontSelectDropDown[n]);
};
/* ---------------------------------------------------------------------- */
function outputFontSizes(n) {
  var FontSizeObj= ToolbarList['selectsize'];
  var FontSize   = FontSizeObj[2];
  var FontSizeOn = FontSizeObj[3];

	FontSizes.sort();
	var FontSizesDropDown = new Array;
	FontSizesDropDown[n] = '<table border="0" cellpadding="0" cellspacing="0"><tr><td onMouseOver="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSizeOn + '\';" onMouseOut="document.getElementById(\'selectSize' + n + '\').src=\'' + FontSize + '\';"><img src="' + FontSize + '" id="selectSize' + n + '" width="49" height="20" onClick="showFontSizes(\'' + n + '\');" unselectable="on"><br>';
  FontSizesDropDown[n] += '<span id="Sizes' + n + '" class="dropdown" style="width: 170px;">';

	for (var i = 0; i <= FontSizes.length;) {
	  if (FontSizes[i]) {
      FontSizesDropDown[n] += '<button type="button" onClick="formatText(\'FontSize\',\'' + n + '\',\'' + FontSizes[i] + '\')\;hideFontSizes(\'' + n + '\');" onMouseOver="this.className=\'mouseOver\'" onMouseOut="this.className=\'mouseOut\'" class="mouseOut" style="width: 145px;"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="left" style="font-family: arial, verdana, helvetica;"><font size="' + FontSizes[i] + '">size ' + FontSizes[i] + '</font></td></tr></table></button><br>';	
    }	  
	  i++;
  }
	FontSizesDropDown[n] += '</span></td></tr></table>';
	document.getElementById('FontSizes' + n).insertAdjacentHTML("afterBegin", FontSizesDropDown[n]);
};
/* ---------------------------------------------------------------------- */
function hideFonts(n) {document.getElementById('Fonts' + n).style.display = 'none';};
/* ---------------------------------------------------------------------- */
function hideFontSizes(n) {document.getElementById('Sizes' + n).style.display = 'none';};
/* ---------------------------------------------------------------------- */
function showFonts(n) { 
  if (document.getElementById('Fonts' + n).style.display == 'block') {
    document.getElementById('Fonts' + n).style.display = 'none';
	}
  else {
    document.getElementById('Fonts' + n).style.display = 'block'; 
    document.getElementById('Fonts' + n).style.position = 'absolute';		
  }
};
/* ---------------------------------------------------------------------- */
function showFontSizes(n) { 
  if (document.getElementById('Sizes' + n).style.display == 'block') {
    document.getElementById('Sizes' + n).style.display = 'none';
	}
  else {
    document.getElementById('Sizes' + n).style.display = 'block'; 
    document.getElementById('Sizes' + n).style.position = 'absolute';		
  }
};
/* ---------------------------------------------------------------------- */
function viewSource(n) {
  var getDocument = document.getElementById("wysiwyg" + n).contentWindow.document;
  var browserName = navigator.appName;

  if (browserName == "Microsoft Internet Explorer") {
    var iHTML = getDocument.body.innerHTML;
    getDocument.body.innerText = iHTML;
	}
  else {
    var html = document.createTextNode(getDocument.body.innerHTML);
    getDocument.body.innerHTML = "";
    getDocument.body.appendChild(html);
	}
  document.getElementById('HTMLMode' + n).style.display = 'none'; 
	document.getElementById('textMode' + n).style.display = 'block';
	getDocument.body.style.fontSize = "12px";
	getDocument.body.style.fontFamily = "Courier New"; 
	
  viewTextMode = 1;
};
/* ---------------------------------------------------------------------- */
function viewText(n) { 
  var getDocument = document.getElementById("wysiwyg" + n).contentWindow.document;
  var browserName = navigator.appName;

  if (browserName == "Microsoft Internet Explorer") {
    var iText = getDocument.body.innerText;
    getDocument.body.innerHTML = iText;
	}
  else {
    var html = getDocument.body.ownerDocument.createRange();
    html.selectNodeContents(getDocument.body);
    getDocument.body.innerHTML = html.toString();
	}
  	document.getElementById('textMode' + n).style.display = 'none'; 
	document.getElementById('HTMLMode' + n).style.display = 'block';
	
  	getDocument.body.style.fontSize = "";
	getDocument.body.style.fontFamily = ""; 
	viewTextMode = 0;
};
/* ---------------------------------------------------------------------- */
function updateTextArea(n) {
  document.getElementById(n).value = document.getElementById("wysiwyg" + n).contentWindow.document.body.innerHTML;
};
/* ---------------------------------------------------------------------- */
var Fonts = new Array();
  	Fonts[0] = "Arial";
  	Fonts[1] = "Sans Serif";
  	Fonts[2] = "Tahoma";
	Fonts[3] = "Verdana";
	Fonts[4] = "Courier New";
	Fonts[5] = "Georgia";
	Fonts[6] = "Times New Roman";
	Fonts[7] = "Impact";
  	Fonts[8] = "Comic Sans MS";
var BlockFormats = new Array();
  	BlockFormats[0]  = "Address";
  	BlockFormats[1]  = "Bulleted List";
  	BlockFormats[2]  = "Definition";
	BlockFormats[3]  = "Definition Term";
	BlockFormats[4]  = "Directory List";
	BlockFormats[5]  = "Formatted";
	BlockFormats[6]  = "Heading 1";
	BlockFormats[7]  = "Heading 2";
	BlockFormats[8]  = "Heading 3";
	BlockFormats[9]  = "Heading 4";
	BlockFormats[10] = "Heading 5";
	BlockFormats[11] = "Heading 6";
	BlockFormats[12] = "Menu List";
	BlockFormats[13] = "Normal";
	BlockFormats[14] = "Numbered List";
// List of available font sizes
var FontSizes = new Array();
  	FontSizes[0]  = "1";
  	FontSizes[1]  = "2";
  	FontSizes[2]  = "3";
	FontSizes[3]  = "4";
	FontSizes[4]  = "5";
	FontSizes[5]  = "6";
	FontSizes[6]  = "7";
var buttonName = new Array();
  	buttonName[0]  = "bold";
  	buttonName[1]  = "italic";
  	buttonName[2]  = "underline";
	//buttonName[3]  = "strikethrough";
  	buttonName[4]  = "seperator";
	/*buttonName[5]  = "subscript";*/
	/*buttonName[6]  = "superscript";*/
	buttonName[7]  = "seperator";
	buttonName[8]  = "justifyleft";
	buttonName[9]  = "justifycenter";
	buttonName[10] = "justifyright";
	buttonName[11] = "seperator";
	buttonName[12] = "unorderedlist";
	buttonName[13] = "orderedlist";
	/*buttonName[14] = "outdent";*/
	/*buttonName[15] = "indent";*/
var buttonName2 = new Array();
  	buttonName2[0]  = "forecolor";
	buttonName2[1]  = "backcolor";
	buttonName2[2]  = "seperator";
	buttonName2[3]  = "cut";
	buttonName2[4]  = "copy";
	buttonName2[5]  = "paste";
	buttonName2[6]  = "seperator";
  	buttonName2[7]  = "undo";
	buttonName2[8]  = "redo";
  	buttonName2[9]  = "seperator";
	buttonName2[10] = "inserttable";
  	buttonName2[11] = "insertimage";
  	buttonName2[12] = "createlink";
	buttonName2[13] = "seperator";
	buttonName2[14] = "viewSource";
	buttonName2[15] = "seperator";
  	/*buttonName2[16] = "help";*/

var ToolbarList = new Array();
function cargarArrayImagenes() {
	ToolbarList = {
		//Name            buttonID                 buttonTitle           buttonImage                           buttonImageRollover
	  	"bold":           ['Bold',                 'Bold',               imagesDir + 'bold.gif',               imagesDir + 'bold_on.gif'],
	  	"italic":         ['Italic',               'Italic',             imagesDir + 'italics.gif',            imagesDir + 'italics_on.gif'],
	  	"underline":      ['Underline',            'Underline',          imagesDir + 'underline.gif',          imagesDir + 'underline_on.gif'],
		"strikethrough":  ['Strikethrough',        'Strikethrough',      imagesDir + 'strikethrough.gif',      imagesDir + 'strikethrough_on.gif'],
		"seperator":      ['',                     '',                   imagesDir + 'seperator.gif',          imagesDir + 'seperator.gif'],
		"subscript":      ['Subscript',            'Subscript',          imagesDir + 'subscript.gif',          imagesDir + 'subscript_on.gif'],
		"superscript":    ['Superscript',          'Superscript',        imagesDir + 'superscript.gif',        imagesDir + 'superscript_on.gif'],
		"justifyleft":    ['Justifyleft',          'Justifyleft',        imagesDir + 'justify_left.gif',       imagesDir + 'justify_left_on.gif'],
		"justifycenter":  ['Justifycenter',        'Justifycenter',      imagesDir + 'justify_center.gif',     imagesDir + 'justify_center_on.gif'],
		"justifyright":   ['Justifyright',         'Justifyright',       imagesDir + 'justify_right.gif',      imagesDir + 'justify_right_on.gif'],
		"unorderedlist":  ['InsertUnorderedList',  'InsertUnorderedList',imagesDir + 'list_unordered.gif',     imagesDir + 'list_unordered_on.gif'],
		"orderedlist":    ['InsertOrderedList',    'InsertOrderedList',  imagesDir + 'list_ordered.gif',       imagesDir + 'list_ordered_on.gif'],
		"outdent":        ['Outdent',              'Outdent',            imagesDir + 'indent_left.gif',        imagesDir + 'indent_left_on.gif'],
		"indent":         ['Indent',               'Indent',             imagesDir + 'indent_right.gif',       imagesDir + 'indent_right_on.gif'],
		"cut":            ['Cut',                  'Cut',                imagesDir + 'cut.gif',                imagesDir + 'cut_on.gif'],
		"copy":           ['Copy',                 'Copy',               imagesDir + 'copy.gif',               imagesDir + 'copy_on.gif'],
	  	"paste":          ['Paste',                'Paste',              imagesDir + 'paste.gif',              imagesDir + 'paste_on.gif'],
		"forecolor":      ['ForeColor',            'ForeColor',          imagesDir + 'forecolor.gif',          imagesDir + 'forecolor_on.gif'],
		"backcolor":      ['BackColor',            'BackColor',          imagesDir + 'backcolor.gif',          imagesDir + 'backcolor_on.gif'],
		"undo":           ['Undo',                 'Undo',               imagesDir + 'undo.gif',               imagesDir + 'undo_on.gif'],
		"redo":           ['Redo',                 'Redo',               imagesDir + 'redo.gif',               imagesDir + 'redo_on.gif'],
		"inserttable":    ['InsertTable',          'InsertTable',        imagesDir + 'insert_table.gif',       imagesDir + 'insert_table_on.gif'],
		"insertimage":    ['InsertImage',          'InsertImage',        imagesDir + 'insert_picture.gif',     imagesDir + 'insert_picture_on.gif'],
		"createlink":     ['CreateLink',           'CreateLink',         imagesDir + 'insert_hyperlink.gif',   imagesDir + 'insert_hyperlink_on.gif'],
		"viewSource":     ['ViewSource',           'ViewSource',         imagesDir + 'view_source.gif',        imagesDir + 'view_source_on.gif'],
		"viewText":       ['ViewText',             'ViewText',           imagesDir + 'view_text.gif',          imagesDir + 'view_text_on.gif'],
		"help":           ['Help',                 'Help',               imagesDir + 'help.gif',               imagesDir + 'help_on.gif'],
		"selectfont":     ['SelectFont',           'SelectFont',         imagesDir + 'select_font.gif',        imagesDir + 'select_font_on.gif'],
		"selectsize":     ['SelectSize',           'SelectSize',         imagesDir + 'select_size.gif',        imagesDir + 'select_size_on.gif']
	};
}
function dibujarHojaDeEstilo(ruta){document.write('<link rel="stylesheet" type="text/css" href="' +ruta+ 'et_editor.css">');}