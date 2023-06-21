/*

# Easy Forum 
# Devloper : Ali AL-jiachi
# Contact  : php4u@live.com
# S.Date   : 2011
# R.Date   : 2014
# ---------------
# The program is free and for all
# ---------------

*/

function editstyle(table_name,style_id){
	var tname = table_name;
	var sid   = style_id;
	location  = 'styles.php?action=templates_style&style_id='+sid+'&tname='+tname+'';
}

function deleteact(fid){
	
	var doit = window.confirm(window['confirmMessage']);
	
	var page = \"sections.php?action=delete&fid=\"+fid+\"\";
	
	if(doit == true){
		location = page;
	}	

}

function checkAll(form){
  for (var i = 0; i < form.elements.length; i++){
    eval(\"form.elements[\" + i + \"].checked = form.elements[0].checked\");
  }
}

function empty(mixed_var){
    if(typeof mixed_var === \"array\"){
        if(mixed_var.length === 0){
            return true;
        }
        return false;
    }
    if(typeof mixed_var === \"object\"){
        for(k in mixed_var){
            if(mixed_var.hasOwnProperty(k)){
                return false;
            }
        }
        return true;
    }
    if(typeof mixed_var === \"number\"){
        mixed_var = Math.floor(mixed_var);
        if(mixed_var === 0){
            return true;
        }
        return false;
    }
    if(typeof mixed_var === \"boolean\"){
        if(mixed_var === false){
            return true;
        }
        return false;
    }
    if(mixed_var === null || mixed_var === \"\" || mixed_var.length === 0
        || mixed_var === \"0\" || typeof mixed_var === \"undefined\"){
        return true;
    }
    return false;
}
 
function PopMsg(){
	var text = window['checkRedInputs'];
	$('#msg').hide();
	$('#msg').show();
	$('#msg').html(\"<div class='red'>\"+text+\"</div>\");
}

function Redcss(got){
	$(got).effect(\"shake\", { times:3 }, 300);
	return got.css({
	//\"border\":\"1px solid red\",
	\"-webkit-box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px red\",
	\"-moz-box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px red\",
	\"box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px red\"
	});	
}

function Greencss(got){
	return got.css({
	//\"border\":\"1px solid red\",
	\"-webkit-box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px green\",
	\"-moz-box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px green\",
	\"box-shadow\":\"inset 0 2px 2px #ccc, 0 0 10px green\"
	});	
}

function Vsetting(){
	var title = $(\"#title\").val();	
	var dec = $(\"#dec\").val();	
	var icon = $(\"#icon\").val();	
	var avatar_w = $(\"#avatar_w\").val();	
	var avatar_h = $(\"#avatar_h\").val();
	var icon_w = $(\"#icon_w\").val();	
	var icon_h = $(\"#icon_h\").val();	
	if(empty(title)){
		Redcss($('#title'));
		PopMsg();
		return false;
		}else{
		Greencss($('#title'));	
	}
	if(empty(dec)){
		Redcss($('#dec'));
		PopMsg();
		return false;
		}else{
		Greencss($('#dec'));	
	}if(empty(icon)){
		Redcss($('#icon'));
		PopMsg();
		return false;
		}else{
		Greencss($('#icon'));	
	}if(avatar_w == \"\"){
		Redcss($('#avatar_w'));
		PopMsg();
		return false;
		}else{
		Greencss($('#avatar_w'));	
	}if(avatar_h == \"\"){
		Redcss($('#avatar_h'));
		PopMsg();
		return false;
		}else{
		Greencss($('#avatar_h'));	
	}if(icon_w == \"\"){
		Redcss($('#icon_w'));
		PopMsg();
		return false;
		}else{
		Greencss($('#icon_w'));	
	}if(icon_h == \"\"){
		Redcss($('#icon_h'));
		PopMsg();
		return false;
		}else{
		Greencss($('#icon_h'));	
	}
}

function Vposts(){
	
	if(empty($('#pages').val())){
		Redcss($('#pages'));
		PopMsg();
		return false;
	}else{
		Greencss($('#pages'));	
	}
	
	if(empty($('#ticon').val())){
		Redcss($('#ticon'));
		PopMsg();
		return false;
	}else{
		Greencss($('#ticon'));	
	}
}

function accessempty(){
						
		var one = $('#one');
		
		var t = $('#t');
	
		var z = $('#z');

		if(one.val() == \"\"){
						
			Redcss(one);
			
			PopMsg();
			
			return false;
		
		}else{
		
			Greencss(one);	
		
		}
	
		if(empty(t.val())){
		
			Redcss(t);
		
			PopMsg();
		
			return false;
		
		}else{
		
			Greencss(t);	
		
		}
		
		if(empty(z.val())){
		
			Redcss(z);
		
			PopMsg();
		
			return false;
		
		}else{
		
			Greencss(z);	
		
		}	
		
}

function GoLocation(){
	
	var Url = \"filemanager.php?dir=\" + $(\"#location\").val();
		
	location = Url;
}

function postEditor(){

	if($(\"#content\").val() == \"\"){
	
		var msg = window.confirm(window['confirmEditorMessage']);
			
		if(msg == false){
		
			return false;	
		}
	}
}

function SwitchTextarea(Name){

	var button = document.getElementById('switchButton');
	
	if(button.class == \"true\"){
	
		var ReNum  = document.getElementById('switchButton').class = \"false\";
	var ReEdit = $('#SwitchArea').html('<textarea name=\"'+Name+'\" cols=\"40\" rows=\"3\" class=\"Text\" id=\"KindBox\"></textarea>');
	
	}else{

		var ReNum  = document.getElementById('switchButton').class = \"true\";
	
		var ReEdit = $('#SwitchArea').html('<textarea name=\"'+Name+'\" cols=\"40\" rows=\"3\" class=\"Text\"></textarea>');

	}
	
}