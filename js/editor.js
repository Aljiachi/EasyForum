var myeditor, ifm;
var body_id, textboxelement;
var content;
var isIE = /msie|MSIE/.test(navigator.userAgent);
var isChrome = /Chrome/.test(navigator.userAgent);
var isSafari = /Safari/.test(navigator.userAgent) && !isChrome;
var browser = isIE || window.opera;
var textRange;
var enter = 0;
var editorVisible = false;
var enableWysiwyg = false;

function rep(re, str) {
	content = content.replace(re, str);
}

function getToolbar(){

var GetToolbar = document.write('<div class="richeditor"><div class="editbar"><button title="bold" onclick="doClick(\'bold\');" type="button" style="background-image:url(images/editor/bold.png);"></button><button title="italic" onclick="doClick(\'italic\');" type="button" style="background-image:url(images/editor/italic.png);"></button><button title="underline" onclick="doClick(\'underline\');" type="button" style="background-image:url(images/editor/underline.png);"></button><button title="justifyleft" onclick="doClick(\'justifyleft\');" type="button" style="background-image:url(images/editor/text_align_left.png);"></button><button title="justifycenter" onclick="doClick(\'justifycenter\');" type="button" style="background-image:url(images/editor/text_align_center.png);"></button><button title="justifyright" onclick="doClick(\'justifyright\');" type="button" style="background-image:url(images/editor/text_align_right.png);"></button><button title="justifyright" onclick="doViewFontBox()" type="button" style="background-image:url(images/editor/font-family.png);"></button><div class="pop" id="setFontnameBox" style="margin-left:175px; display:none;"><div onclick="setFontname(\'Arial\')" style=" font-family:Arial; font-size:14px;">Arial</div><div onclick="setFontname(\'Tahoma\')" style=" font-family:Tahoma; font-size:14px;">Tahoma</div><div onclick="setFontname(\'Courier New\')" style=" font-family:\'Courier New\'; font-size:14px;">Courier New</div><div onclick="setFontname(\'Comic Sans MS\')" style=" font-family:\'Comic Sans MS\'; font-size:14px;">Comic Sans MS</div><div onclick="setFontname(\'sans-serif\')" style=" font-family:sans-serif; font-size:14px;">sans-serif</div><div onclick="setFontname(\'Georgia\')" style=" font-family:Georgia; font-size:14px;">Georgia</div><div onclick="setFontname(\'Verdana\')" style=" font-family:Verdana; font-size:14px;">Verdana</div></div><button title="justifyright" onclick="doViewSizeBox()" type="button" style="background-image:url(images/editor/size.png);"></button><div class="pop" id="setFontsizeBox" style="margin-left:200px; display:none;"><div onclick="setFontsize(2)" style=" font-size:10pt;">2</div><div onclick="setFontsize(3)" style=" font-size:12pt;">3</div><div onclick="setFontsize(4)" style=" font-size:14pt;">4</div><div onclick="setFontsize(5)" style=" font-size:18pt;">5</div><div onclick="setFontsize(6)" style=" font-size:24pt;">6</div><div onclick="setFontsize(7)" style=" font-size:36pt;">7</div></div><button title="hyperlink" onclick="doLink();" type="button" style="background-image:url(images/editor/link.png);"></button><button title="hyperlink" onclick="doRemoveLink();" type="button" style="background-image:url(images/editor/link_break.png);"></button><button title="image" onclick="doImage();" type="button" style="background-image:url(images/editor/img.gif);"></button><button title="list" onclick="doClick(\'InsertUnorderedList\');" type="button" style="background-image:url(images/editor/icon_list.gif);"></button><button title="color" onclick="showColorGrid2(\'none\')" type="button" style="background-image:url(images/editor/colors.gif);"></button><span id="colorpicker201" class="colorpicker201"></span><button title="quote" onclick="doQuote();" type="button" style="background-image:url(images/editor/icon_quote.png);"></button><button title="code" onclick="doPhpCode();" type="button" style="background-image:url(images/editor/page_white_php.png);"></button><button title="code" onclick="doHtmlCode();" type="button" style="background-image:url(images/editor/script_code.png);"></button><button title="youtube" onclick="InsertYoutube();" type="button" style="background-image:url(images/editor/icon_youtube.gif);"></button><button title="switch to source" type="button" onclick="javascript:SwitchEditor()" style="background-image:url(images/editor/icon_html.gif);"></button></div></div>');	
}

function initEditor(textarea_id, wysiwyg , form_id) {
	if(wysiwyg!=undefined)
		enableWysiwyg = wysiwyg;
	else
	enableWysiwyg = true;
    
	var foid = document.getElementById(form_id).setAttribute('onsubmit' , "doCheck()");
	body_id = textarea_id;
    textboxelement = document.getElementById(body_id);
    textboxelement.setAttribute('class', 'editorBBCODE');
    textboxelement.className = "editorBBCODE";
	
    if (enableWysiwyg) {

        ifm = document.createElement("iframe");
        ifm.setAttribute("id", "rte");
		ifm.setAttribute('class' , 'editorIframeEf');
        ifm.setAttribute("frameborder", "0");
        ifm.style.width = textboxelement.style.width;
        ifm.style.height = textboxelement.style.height;
        textboxelement.parentNode.insertBefore(ifm, textboxelement);
        textboxelement.style.display = 'none';
        if (ifm) {
            ShowEditor();
        } else
            setTimeout('ShowEditor()', 100);
    }
}

function getStyle(el,styleProp)
{
	var x = document.getElementById(el);
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
	else if (window.getComputedStyle)
		var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
	return y;
}

function ShowEditor() {
    
	if (!enableWysiwyg) return;
	
		editorVisible = true;
		content = document.getElementById(body_id).value;
		myeditor = ifm.contentWindow.document;
		bbcode2html();
		myeditor.designMode = "on";
		myeditor.open();
		myeditor.write('<html><head></head>');
		myeditor.write('<body style="margin:0px 0px 0px 0px" class="editorWYSIWYG">');
		myeditor.write(content);
		myeditor.write('</body></html>');
		myeditor.close();
		
		if (myeditor.attachEvent) {
			if(parent.ProcessKeyPress)
				myeditor.attachEvent("onkeydown", parent.ProcessKeyPress);
			myeditor.attachEvent("onkeypress", kp);
		}
		else if (myeditor.addEventListener) {
			if (parent.ProcessKeyPress)
				myeditor.addEventListener("keydown", parent.ProcessKeyPress, true);
			myeditor.addEventListener("keypress",kp,true);
		}
	
}

function SwitchEditor() {
		

    if (editorVisible) {
        doCheck();
        ifm.style.display = 'none';
        textboxelement.style.display = '';
		editorVisible = false;
    }
    else {
        if (enableWysiwyg && ifm) {
            ifm.style.display = '';
            textboxelement.style.display = 'none';
            ShowEditor();
            editorVisible = true;
        }
    }
}

function html2bbcode() {
	rep(/<img\s[^<>]*?src="?([^<>]*?)"?(\s[^<>]*)?\/?>/gi,"[img]$1[/img]");
	rep(/<\/(strong|b)>/gi, "[/b]");
	rep(/<(strong|b)(\s[^<>]*)?>/gi,"[b]");
	rep(/<\/(em|i)>/gi,"[/i]");
	rep(/<(em|i)(\s[^<>]*)?>/gi,"[i]");
	rep(/<\/u>/gi, "[/u]");
	rep(/\n/gi, " ");
	rep(/\r/gi, " ");
	rep(/<u(\s[^<>]*)?>/gi, "[u]");
	rep(/<div><br(\s[^<>]*)?>/gi, "<div>");//chrome-safari fix to prevent double linefeeds
	rep(/<br(\s[^<>]*)?>/gi,"\n");
	rep(/<p(\s[^<>]*)?>/gi,"");
	rep(/<\/p>/gi, "\n");
	rep(/<ul>/gi, "[ul]");
	rep(/<\/ul>/gi, "[/ul]");
	rep(/<ol>/gi, "[ol]");
	rep(/<\/ol>/gi, "[/ol]");
	rep(/<li>/gi, "[li]");
	rep(/<\/li>/gi, "[/li]");
	rep(/<\/div>\s*<div([^<>]*)>/gi, "</span>\n<span$1>");//chrome-safari fix to prevent double linefeeds
	rep(/<div([^<>]*)>/gi,"\n<span$1>");
	rep(/<\/div>/gi,"</span>\n");
	rep(/&nbsp;/gi," ");
	rep(/&quot;/gi,""");
	rep(/&amp;/gi,"&");
	var sc, sc2;
	do {
		sc = content;
		rep(/<font\s[^<>]*?size="?([^<>]*?)"?(\s[^<>]*)?>([^<>]*?)<\/font>/gi,"[size=$1]$3[/size]");
		rep(/<font\s[^<>]*?color="?([^<>]*?)"?(\s[^<>]*)?>([^<>]*?)<\/font>/gi,"[color=$1]$3[/color]");
		if(sc==content)
			rep(/<font[^<>]*>([^<>]*?)<\/font>/gi,"$1");
		rep(/<a\s[^<>]*?href="?([^<>]*?)"?(\s[^<>]*)?>([^<>]*?)<\/a>/gi,"[url=$1]$3[/url]");
		sc2 = content;
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?font-weight: ?bold;?"?\s*([^<]*?)<\/\1>/gi,"[b]<$1 style=$2</$1>[/b]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?font-weight: ?normal;?"?\s*([^<]*?)<\/\1>/gi,"<$1 style=$2</$1>");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?font-style: ?italic;?"?\s*([^<]*?)<\/\1>/gi,"[i]<$1 style=$2</$1>[/i]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?font-style: ?normal;?"?\s*([^<]*?)<\/\1>/gi,"<$1 style=$2</$1>");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?text-decoration: ?underline;?"?\s*([^<]*?)<\/\1>/gi,"[u]<$1 style=$2</$1>[/u]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?text-align: ?right;?"?\s*([^<]*?)<\/\1>/gi,"[right]<$1 style=$2</$1>[/right]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?text-align: ?left;?"?\s*([^<]*?)<\/\1>/gi,"[left]<$1 style=$2</$1>[/left]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?text-align: ?center;?"?\s*([^<]*?)<\/\1>/gi,"[center]<$1 style=$2</$1>[/center]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?text-decoration: ?none;?"?\s*([^<]*?)<\/\1>/gi,"<$1 style=$2</$1>");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?color: ?([^<>]*?);"?\s*([^<]*?)<\/\1>/gi, "[color=$2]<$1 style=$3</$1>[/color]");
		rep(/<(span|blockquote|pre)\s[^<>]*?style="?font-family: ?([^<>]*?);"?\s*([^<]*?)<\/\1>/gi, "[font=$2]<$1 style=$3</$1>[/font]");
		rep(/<(blockquote|pre)\s[^<>]*?style="?"? (class=|id=)([^<>]*)>([^<>]*?)<\/\1>/gi, "<$1 $2$3>$4</$1>");
		rep(/<span\s[^<>]*?style="?"?>([^<>]*?)<\/span>/gi, "$1");
		if(sc2==content) {
			rep(/<span[^<>]*>([^<>]*?)<\/span>/gi, "$1");
			sc2 = content;
		}
	}while(sc!=content)
	rep(/<[^<>]*>/gi,"");
	rep(/&lt;/gi,"<");
	rep(/&gt;/gi,">");
	
	do {
		sc = content;
		rep(/\[(b|i|u)\]\[quote([^\]]*)\]([\s\S]*?)\[\/quote\]\[\/\1\]/gi, "[quote$2][$1]$3[/$1][/quote]");
		rep(/\[color=([^\]]*)\]\[quote([^\]]*)\]([\s\S]*?)\[\/quote\]\[\/color\]/gi, "[quote$2][color=$1]$3[/color][/quote]");
		rep(/\[(b|i|u)\]\[code\]([\s\S]*?)\[\/code\]\[\/\1\]/gi, "[code][$1]$2[/$1][/code]");
		rep(/\[color=([^\]]*)\]\[code\]([\s\S]*?)\[\/code\]\[\/color\]/gi, "[code][color=$1]$2[/color][/code]");
	}while(sc!=content)

	//clean up empty tags
	do {
		sc = content;
		rep(/\[b\]\[\/b\]/gi, "");
		rep(/\[i\]\[\/i\]/gi, "");
		rep(/\[u\]\[\/u\]/gi, "");
		rep(/\[quote[^\]]*\]\[\/quote\]/gi, "");
		rep(/\[code\]\[\/code\]/gi, "");
		rep(/\[url=([^\]]+)\]\[\/url\]/gi, "");
		rep(/\[img\]\[\/img\]/gi, "");
		rep(/\[color=([^\]]*)\]\[\/color\]/gi, "");
	}while(sc!=content)
}

function bbcode2html() {
	// example: [b] to <strong>
	rep(/\</gi,"&lt;"); //removing html tags
	rep(/\>/gi,"&gt;");
	
	rep(/\n/gi, "<br />");
	rep(/\[ul\]/gi, "<ul>");
	rep(/\[\/ul\]/gi, "</ul>");
	rep(/\[ol\]/gi, "<ol>");
	rep(/\[\/ol\]/gi, "</ol>");
	rep(/\[li\]/gi, "<li>");
	rep(/\[\/li\]/gi, "</li>");
	if(browser) {
		rep(/\[b\]/gi,"<strong>");
		rep(/\[\/b\]/gi,"</strong>");
		rep(/\[i\]/gi,"<em>");
		rep(/\[\/i\]/gi,"</em>");
		rep(/\[u\]/gi,"<u>");
		rep(/\[\/u\]/gi,"</u>");
	}else {
		rep(/\[b\]/gi,"<span style="font-weight: bold;">");
		rep(/\[i\]/gi,"<span style="font-style: italic;">");
		rep(/\[u\]/gi,"<span style="text-decoration: underline;">");
		rep(/\[\/(b|i|u)\]/gi,"</span>");
	}
	rep(/\[img\]([^"]*?)\[\/img\]/gi,"<img src="$1" />");
	var sc;
	do {
		sc = content;
		rep(/\[url=([^\]]+)\]([\s\S]*?)\[\/url\]/gi,"<a href="$1">$2</a>");
		rep(/\[url\]([\s\S]*?)\[\/url\]/gi,"<a href="$1">$1</a>");
		if(browser) {
		    rep(/\[size=([^\]]*?)\]([\s\S]*?)\[\/size\]/gi, "<font size="$1">$2</font>");
		    rep(/\[color=([^\]]*?)\]([\s\S]*?)\[\/color\]/gi, "<font color="$1">$2</font>");
		    rep(/\[font=([^\]]*?)\]([\s\S]*?)\[\/font\]/gi, "<font face="$1">$2</font>");
		} else {
		    rep(/\[size=([^\]]*?)\]([\s\S]*?)\[\/size\]/gi, "<font size="$1">$2</font>");
		    rep(/\[color=([^\]]*?)\]([\s\S]*?)\[\/color\]/gi, "<span style="color: $1;">$2</span>");
		    rep(/\[font=([^\]]*?)\]([\s\S]*?)\[\/font\]/gi, "<span style="font-family: $1;">$2</span>");
		}
		rep(/\[center\]([\s\S]*?)\[\/center\]/gi,"<div style='text-align:center;'>$1</div>&nbsp;");
		rep(/\[right\]([\s\S]*?)\[\/right\]/gi,"<div style='text-align:right;'>$1</div>&nbsp;");
		rep(/\[left\]([\s\S]*?)\[\/left\]/gi,"<div style='text-align:left;'>$1</div>&nbsp;");


	}while(sc!=content);
}

function doCheck() {
	
	if (!editorVisible) {
        ShowEditor();
    }
	
	content = myeditor.body.innerHTML;
	
	html2bbcode();
	
	document.getElementById(body_id).value = content;
}

function stopEvent(evt){
	evt || window.event;
	if (evt.stopPropagation){
		evt.stopPropagation();
		evt.preventDefault();
	}else if(typeof evt.cancelBubble != "undefined"){
		evt.cancelBubble = true;
		evt.returnValue = false;
	}
	return false;
}

function doQuote() {
    if (editorVisible) {
        ifm.contentWindow.focus();
        if (isIE) {
            textRange = ifm.contentWindow.document.selection.createRange();
            var newTxt = "[quote]" + textRange.text + "[/quote]";
            textRange.text = newTxt;
        }
        else {
            var edittext = ifm.contentWindow.getSelection().getRangeAt(0);
            var original = edittext.toString();
            edittext.deleteContents();
            edittext.insertNode(document.createTextNode("[quote]" + original + "[/quote]"));
        }
    }
    else {
        AddTag('[quote]', '[/quote]');
    }
}

function doPhpCode() {
    if (editorVisible) {
        ifm.contentWindow.focus();
        if (isIE) {
            textRange = ifm.contentWindow.document.selection.createRange();
            var newTxt = "[php]" + textRange.text + "[/php]";
            textRange.text = newTxt;
        }
        else {
            var edittext = ifm.contentWindow.getSelection().getRangeAt(0);
            var original = edittext.toString();
            edittext.deleteContents();
            edittext.insertNode(document.createTextNode("[php]" + original + "[/php]"));
        }
    }
    else {
        AddTag('[php]', '[/php]');
    }
}

function doHtmlCode() {
    if (editorVisible) {
        ifm.contentWindow.focus();
        if (isIE) {
            textRange = ifm.contentWindow.document.selection.createRange();
            var newTxt = "[code]" + textRange.text + "[/code]";
            textRange.text = newTxt;
        }
        else {
            var edittext = ifm.contentWindow.getSelection().getRangeAt(0);
            var original = edittext.toString();
            edittext.deleteContents();
            edittext.insertNode(document.createTextNode("[code]" + original + "[/code]"));
        }
    }
    else {
        AddTag('[code]', '[/code]');
    }
}

function kp(e){
	if(isIE)
		var k = e.keyCode;
	else
		var k = e.which;
	if(k==13) {
		if(isIE) {
		    var r = myeditor.selection.createRange();
		    if (r.parentElement().tagName.toLowerCase() != "li") {
		        r.pasteHTML('<br/>');
		        if (r.move('character'))
		            r.move('character', -1);
		        r.select();
		        stopEvent(e);
		        return false;
		    }
		}
	}else
		enter = 0;
}
function checkEmpty(string){

	string = string.replace(/ /gi , "");
	
	if(string == ""){ return true }
	
}
function InsertSmile(txt) {
    InsertText(txt);
}
function InsertYoutube() {

	var Url = window.prompt('http://www.youtube.com/watch?v=' , '');
	
	if(!checkEmpty(Url)){
		
		InsertText("[youtube]" + Url + "[/youtube]");

	}
}


function InsertText(txt) {
    if (editorVisible)
        insertHtml(txt);
    else
        textboxelement.value += txt;
}
function setFontname(font){
	
if (editorVisible) {

	  ifm.contentWindow.focus();
  if (isIE) {
      textRange = ifm.contentWindow.document.selection.createRange();
      textRange.select();
  }
  myeditor.execCommand('fontname', false, font);
  
}else{

	AddTag('[font=' + font + ']' , '[/font]');	
	
}

  var hideBox = document.getElementById('setFontnameBox').style.display = "none";
}
function doRemoveLink(){
	  ifm.contentWindow.focus();
  if (isIE) {
      textRange = ifm.contentWindow.document.selection.createRange();
      textRange.select();
  }
  myeditor.execCommand('unlink', false, false);	
}
function setFontsize(size){
	
if (editorVisible) {

  ifm.contentWindow.focus();
  
  if (isIE) {
      textRange = ifm.contentWindow.document.selection.createRange();
      textRange.select();
  }
  
  myeditor.execCommand('fontsize', false, size);	

}else{

	AddTag('[size=' + size + ']' , '[/size]');	
}

  var hideBox = document.getElementById('setFontsizeBox').style.display = "none";

}
function doViewSizeBox(){
	
if(document.getElementById('setFontsizeBox').style.display == "none"){

		$("#setFontsizeBox").slideDown(300);

	
}else{
	
		$("#setFontsizeBox").slideUp(300);

}

	document.getElementById('setFontnameBox').style.display = 'none';	

}

function doViewFontBox(){
	
	document.getElementById('setFontsizeBox').style.display = 'none';	
	
	if(document.getElementById('setFontnameBox').style.display == "none"){
		
		$("#setFontnameBox").slideDown(300);

	}else{

		$("#setFontnameBox").slideUp(300);
		
	}
}

function doClick(command) {
    
	if (editorVisible) {
       
	    ifm.contentWindow.focus();
        myeditor.execCommand(command, false, null);
    
	}else {
    
	    switch (command) {
            case 'bold':
                AddTag('[b]', '[/b]'); break;
            case 'justifyleft':
                AddTag('[left]', '[/left]'); break;
            case 'justifyright':
                AddTag('[right]', '[/right]'); break;
            case 'justifycenter':
                AddTag('[center]', '[/center]'); break;
            case 'italic':
                AddTag('[i]', '[/i]'); break;
            case 'underline':
                AddTag('[u]', '[/u]'); break;
            case 'InsertUnorderedList':
                AddTag('[ul][li]', '[/li][/ul]'); break;
        }
    }
}

function doColor(color) {
  ifm.contentWindow.focus();
  if (isIE) {
      textRange = ifm.contentWindow.document.selection.createRange();
      textRange.select();
  }
  myeditor.execCommand('forecolor', false, color);
}

function doLink() {
    if (editorVisible) {
        ifm.contentWindow.focus();
        var mylink = prompt("Enter a URL:", "http://");
        if ((mylink != null) && (mylink != "")) {
            if (isIE) { //IE
                var range = ifm.contentWindow.document.selection.createRange();
                if (range.text == '') {
                    range.pasteHTML("<a href='" + mylink + "'>" + mylink + "</a>");
                }
                else
                    myeditor.execCommand("CreateLink", false, mylink);
            }
            else if (window.getSelection) { //FF
                var userSelection = ifm.contentWindow.getSelection().getRangeAt(0);
                if(userSelection.toString().length==0)
                    myeditor.execCommand('inserthtml', false, "<a href='" + mylink + "'>" + mylink + "</a>");
                else
                    myeditor.execCommand("CreateLink", false, mylink);
            }
            else
                myeditor.execCommand("CreateLink", false, mylink);
        }
    }
    else {
        AddTag('[url=',']click here[/url]');
    }
}
function doImage() {
    if (editorVisible) {
        ifm.contentWindow.focus();
        myimg = prompt('Enter Image URL:', 'http://');
        if ((myimg != null) && (myimg != "")) {
            myeditor.execCommand('InsertImage', false, myimg);
        }
    }
    else {
      
        myimg = prompt('Enter Image URL:', 'http://');
		
		if ((myimg != null) && (myimg != "")) {
			 
			AddTag('[img='+myimg+']', '');
			
		}else{

			AddTag('[img]', '[/img]');
			
		}
    }
}

function insertHtml(html) {
    ifm.contentWindow.focus();
    if (isIE)
        ifm.contentWindow.document.selection.createRange().pasteHTML(html);
    else
        myeditor.execCommand('inserthtml', false, html);
}

//textarea-mode functions
function MozillaInsertText(element, text, pos) {
    element.value = element.value.slice(0, pos) + text + element.value.slice(pos);
}

function AddTag(t1, t2) {
    var element = textboxelement;
    if (isIE) {
        if (document.selection) {
            element.focus();

            var txt = element.value;
            var str = document.selection.createRange();

            if (str.text == "") {
                str.text = t1 + t2;
            }
            else if (txt.indexOf(str.text) >= 0) {
                str.text = t1 + str.text + t2;
            }
            else {
                element.value = txt + t1 + t2;
            }
            str.select();
        }
    }
    else if (typeof(element.selectionStart) != 'undefined') {
        var sel_start = element.selectionStart;
        var sel_end = element.selectionEnd;
        MozillaInsertText(element, t1, sel_start);
        MozillaInsertText(element, t2, sel_end + t1.length);
        element.selectionStart = sel_start;
        element.selectionEnd = sel_end + t1.length + t2.length;
        element.focus();
    }
    else {
        element.value = element.value + t1 + t2;
    }
}

//=======color picker
function getScrollY() { var scrOfX = 0, scrOfY = 0; if (typeof (window.pageYOffset) == 'number') { scrOfY = window.pageYOffset; scrOfX = window.pageXOffset; } else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) { scrOfY = document.body.scrollTop; scrOfX = document.body.scrollLeft; } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) { scrOfY = document.documentElement.scrollTop; scrOfX = document.documentElement.scrollLeft; } return scrOfY; }

document.write("<style type='text/css'>.colorpicker201{visibility:hidden;display:none;position:absolute;background:#FFF;z-index:999;filter:progid:DXImageTransform.Microsoft.Shadow(color=#D0D0D0,direction=135);}.o5582brd{padding:0;width:12px;height:14px;border-bottom:solid 1px #DFDFDF;border-right:solid 1px #DFDFDF;}a.o5582n66,.o5582n66,.o5582n66a{font-family:arial,tahoma,sans-serif;text-decoration:underline;font-size:9px;color:#666;border:none;}.o5582n66,.o5582n66a{text-align:center;text-decoration:none;}a:hover.o5582n66{text-decoration:none;color:#FFA500;cursor:pointer;}.a01p3{padding:1px 4px 1px 2px;background:whitesmoke;border:solid 1px #DFDFDF;}</style>");

function getTop2() { csBrHt = 0; if (typeof (window.innerWidth) == 'number') { csBrHt = window.innerHeight; } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) { csBrHt = document.documentElement.clientHeight; } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) { csBrHt = document.body.clientHeight; } ctop = ((csBrHt / 2) - 115) + getScrollY(); return ctop; }
var nocol1 = "&#78;&#79;&#32;&#67;&#79;&#76;&#79;&#82;",
clos1 = "X";

function getLeft2() { var csBrWt = 0; if (typeof (window.innerWidth) == 'number') { csBrWt = window.innerWidth; } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) { csBrWt = document.documentElement.clientWidth; } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) { csBrWt = document.body.clientWidth; } cleft = (csBrWt / 2) - 125; return cleft; }

//function setCCbldID2(val, textBoxID) { document.getElementById(textBoxID).value = val; }
function setCCbldID2(val) { if (editorVisible) doColor(val); else AddTag('[color=#' + val + ']', '[/color]'); }

function setCCbldSty2(objID, prop, val) {
    switch (prop) {
        case "bc": if (objID != 'none') { document.getElementById(objID).style.backgroundColor = val; }; break;
        case "vs": document.getElementById(objID).style.visibility = val; break;
        case "ds": document.getElementById(objID).style.display = val; break;
        case "tp": document.getElementById(objID).style.top = val; break;
        case "lf": document.getElementById(objID).style.left = val; break;
    }
}

function putOBJxColor2(Samp, pigMent, textBoxId) { if (pigMent != 'x') { setCCbldID2(pigMent, textBoxId); setCCbldSty2(Samp, 'bc', pigMent); } setCCbldSty2('colorpicker201', 'vs', 'hidden'); setCCbldSty2('colorpicker201', 'ds', 'none'); }

function showColorGrid2(Sam, textBoxId) {
    var objX = new Array('00', '33', '66', '99', 'CC', 'FF');
    var c = 0;
    var xl = '"' + Sam + '","x", "' + textBoxId + '"'; var mid = '';
    mid += '<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="border:solid 0px #F0F0F0;padding:2px;"><tr>';
    mid += "<td colspan='9' align='left' style='margin:0;padding:2px;height:12px;' ><input class='o5582n66' type='text' size='12' id='o5582n66' value='#FFFFFF'><input class='o5582n66a' type='text' size='2' style='width:14px;' id='o5582n66a' onclick='javascript:alert("click on selected swatch below...");' value='' style='border:solid 1px #666;'></td><td colspan='9' align='right'><a class='o5582n66' href='javascript:onclick=putOBJxColor2(" + xl + ")'><span class='a01p3'>" + clos1 + "</span></a></td></tr><tr>";
    var br = 1;
    for (o = 0; o < 6; o++) {
        mid += '</tr><tr>';
        for (y = 0; y < 6; y++) {
            if (y == 3) { mid += '</tr><tr>'; }
            for (x = 0; x < 6; x++) {
                var grid = '';
                grid = objX[o] + objX[y] + objX[x];
                var b = "'" + Sam + "','" + grid + "', '" + textBoxId + "'";
                mid += '<td class="o5582brd" style="background-color:#' + grid + '"><a class="o5582n66"  href="javascript:onclick=putOBJxColor2(' + b + ');" onmouseover=javascript:document.getElementById("o5582n66").value="#' + grid + '";javascript:document.getElementById("o5582n66a").style.backgroundColor="#' + grid + '";  title="#' + grid + '"><div style="width:12px;height:14px;"></div></a></td>';
                c++;
            }
        }
    }
    mid += "</tr></table>";
    //var ttop=getTop2();
    //setCCbldSty2('colorpicker201','tp',ttop);
    //document.getElementById('colorpicker201').style.left=getLeft2();
    document.getElementById('colorpicker201').innerHTML = mid;
    setCCbldSty2('colorpicker201', 'vs', 'visible');
    setCCbldSty2('colorpicker201', 'ds', 'inline');
}