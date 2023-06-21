$(function(){
     $('#tabsSlide #nav li a').click(function(){
         var currentNum = $(this).attr('id').slice(-1);
         $('#tabsSlide #nav li a').removeClass('current');
         $(this).addClass('current');

         $('#tabsSlide #content .tab-slide').hide();
         $('#tabsSlide #content #slide-'+currentNum+'.tab-slide').fadeIn(300);
     });
});

// register
function send_data(){
		
	var username = $('#username').val();
	var password = $('#password').val();	
	var age = $('#age').val();	
	var signt = $('#signt').val();
	var email = $('#email').val();
	if(username.length < 1 || username == ""){
	$('#username').css({"border":"solid 1px #f00"});
	return false;	
	}else{
	$('#username').css({"border":"solid 1px green"});	
	}
	if(email.length < 1 || email == ""){
	$('#email').css({"border":"solid 1px #f00"});
	return false;	
	}else{
	$('#email').css({"border":"solid 1px green"});	
	var repass = $('#repass').val();	
	var avatar = $('#avatar').val();	
	var from = $('#from').val();
	}
	if(password.length < 5 || password == ""){
	$('#password').css({"border":"solid 1px #f00"});
	return false;	
	}else{
	$('#password').css({"border":"solid 1px green"});	
	}if(repass !== password || repass == ""){
	$('#repass').css({"border":"solid 1px #f00"});
	return false;	
	}else{
	$('#repass').css({"border":"solid 1px green"});	
	}
	}
	function user_finde(username){
		
		$('#userfinde').html("<img src='images/loading.gif' />");

		$.get('index.php', {
			"act" : "search_user" , 
			"find_user" : username 
			} , function(data){
			
				$('#userfinde').hide().html(data).fadeIn(300);
			
			});	
	}
	
	function passvild(){

		var password = $('#password').val();
		
		if(password.length < 5){
			$('#passvild').html('<span class="bad"></span>');
		}
		
		if(password.length < 9 && password.length > 5){
			$('#passvild').html('<span class="notbad"></span>');
		}
		
		if(password.length > 9){
			$('#passvild').html('<span class="good"></span>');	
		}

	}
	
	function login(){

		var username = $('#log_username').val();	
		if(username.length < 1 || username == ""){
		$('#log_username').css({"border":"solid 1px #f00"});
		return false;	
		}else{
		$('#log_username').css({"border":"solid 1px green"});	
		}
		var password = $('#log_password').val();	
		if(password.length < 1 || password == ""){
		$('#log_password').css({"border":"solid 1px #f00"});
		return false;	
		}else{
		$('#log_password').css({"border":"solid 1px green"});	
		}
}

function DeleteTopic(tid){
	var doit = window.confirm(window['ConfirmMessage']);
	var msg  = window.confirm(window['ConfirmMessageDeleteTopic']);
	var page = "index.php?act=delete_topic&tid="+tid+"";
	if(doit == true  && msg == true){location = page;}	
}
	
function DeletePost(pid){
	var doit = window.confirm(window['ConfirmMessage']);
	var page = "index.php?act=delete_post&pid="+pid+"";
	if(doit == true){location = page;}
}
	
function checkAll(form){
  for (var i = 0; i < form.elements.length; i++){
    eval("form.elements[" + i + "].checked = form.elements[0].checked");
  }
}

function str_replace(search, replace, subject) {
	var Str = subject.toString();
	return Str.replace(search, replace);
}

function jump(to){
location = to;	
}

function reStyle(id){
location = '?action=change&style=' + id;	
}

function DeleteAttach(id){
	var doit = window.confirm(window['ConfirmMessage']);
	var page = "index.php?act=delete_attach&id="+id+"";
	if(doit == true){
	location = page;
	}
}

function Upavatar(Do){
	if(Do == "Url"){
		
			$('#AvatarUrl').show();
			$('#UpText').show();
			$('#UrlText').hide();
			$('#AvatarUp').hide();
			var CleanValue = document.getElementById('AvatarUp').value = "";
	}else{
		
			$('#AvatarUp').show();
			$('#UrlText').show();
			$('#UpText').hide();
			$('#AvatarUrl').hide();
			var CleanValue = document.getElementById('AvatarUrl').value = "";
	
	}
}

function ToolsMenu(){
	var Div = document.getElementById("toolsMenu");

	if(Div.style.display != 'none'){
		$('.tools .menu').slideUp('slow');
		$('.tools #hide').hide();	
		$('.tools #view').show();	

	}else{
		$('.tools .menu').slideDown('slow');
		$('.tools #view').hide();	
		$('.tools #hide').show();
	}
}

function addfriend(id){
	
	var userid = id;
	
	var Gid    = $('#AlertSystem');
	
	var page   = "index.php?action=addfriend&id=" + userid;
					
    $('#AlertSystem').show();
			
	$("#AlertSystem").load(page).delay(5000).fadeOut(300);
	
	}

$(document).ready(function(){

  $("body").append('<div id="AlertSystem" style="display:none;"></div>');	
  $("#AlertSystem").html('...');
  
	$(".theardRow").hover(function(){
		
		var Subjects = $(this).find("td");
		
		for(var q=0;q<=Subjects.length;q++){
		
			$(Subjects[q]).css({"background":"#f3eedd"});		
	
		}
	});
	
	$(".theardRow").mouseout(function(){
		
		var Subjects = $(this).find("td");
		
		for(var q=0;q<=Subjects.length;q++){
		
			$(Subjects[q]).css({"background":""});		
	
		}
	});

});

function AddvMsg(){

	var To = $("#to").val();	
	var Text = $("#text").val();	
	var Num = $("#num").val();	
	var Page = $("#Page").val();
	
	if(Text == ""){
		
		$("#text").css({"border" : "1px solid red"});
		
		return false;	
	}
	
	$("#AddInfo").hide().fadeIn().html('<img src="images/loading.png" />');
	
	$.post("index.php?action=addvistormsg&do=ajax",{
	
		uid : To,
		msg : Text,
		"addvmsg":"addnew"	
	
	},function(date){
	
		$("#AddInfo").hide().fadeIn().html('<img src="images/ok.png" />');
		
		document.getElementById('text').value = "";
		
		document.location.reload();
	
	});
	
	return false;
}

function AddSmile(url,Id){

	var ID = document.getElementById(Id);
	object = ID.contentWindow.document; 
	if(object){
			
		var Editor = object.body;
		var src = '<img src="'+url+'" />';
		//document.getElementById(Id).contentWindow.document.execCommand('InsertImage',true,url) 
		Editor.execCommand('insertimage', false, url);
		//object.execCommand(object, false, src);
		
	}else{
	
		$("#" + ID).append(url);	
	}
}

function rating(id){

	var page = "index.php?action=rating&tid=" + id;
		
	$("#RatingDo").html('<img src="images/loading.gif" />').delay(1500).load(page);	
}

function Editvmsg(id){
			
		var Editor = $("#VEditor-" + id).val();
		
		Editor = Editor.replace(/<(.*?)>(.*?)<\/(.*?)>/gi , "$2");
		HTML = Editor.replace(/\n/gi,'<br />');
	
		$("#alert-" + id).html('<img src="images/loading.gif" />');

		$.post("index.php?action=editvistormsg&do=ajax",{
		
				"msg_id" : id ,
				"msg_text" : Editor ,				
				"msg_post" : "edit_vmsg"
					
		},function(){
									
			$("#Text-" + id).html(HTML);
			$("#alert-" + id).html("");
			jQuery.fancybox.close();		
		
		});	
	
}

function Deletevmsg(id){
	
	$("#Text-" + id).html('<img src="images/loading.gif" />').delay(1500);
	
	$("#Text-" + id).load("index.php?action=deletevistormsg&do=ajax&id=" + id).delay(1500);
	
	$("#TBody-" + id).hide();		

}

function GetUser(username,Input){
	
	var Id = "getUser";
	
	var page = "index.php?action=getname&do=ajax&p=" + username + "&n=" + Input;
	
	$("#" + Id).show();
		
	$("#" + Id).load(page);
	
}

function InputInsert(id,ivalue){

	var empty = document.getElementById(id).value = null;
	
	var insert= document.getElementById(id).value = ivalue;
	
	$("#getUser").hide();			
}

function _NextPage(Dir){
		
	$("#AlertSystem").fadeIn(300);
	
	location = Dir;	
}

function loginDialog(){
	
	if($('#loginArea').css("display") == "none"){
	
		$('#loginArea').slideDown(300);
		
	}else{

		$('#loginArea').slideUp(300);
		
	}
	
}
