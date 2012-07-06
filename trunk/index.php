<?php
include_once('config.php');
include_once('headers.php');

if($_GET['logout']==1){setcookie("user","",time()-1);}

if($_COOKIE['user']>0){header("Location: presence.php");}

?>
<html>
	<head>
		<?php echo $title.$icon.$charset.$nocache.$defaultcss.$jquery.$jqueryui.$message_div ?>

		<script type="text/javascript">
		$(document).ready(function () {
			
			$("#login").keydown(function (e){
				if(e.keyCode == 13){
				    login();
				}
			})
			
			$("#password").keydown(function (e){
				if(e.keyCode == 13){
				    login();
				}
			})
			
			$( "#dialog-form" ).dialog({
				height: 160,
				width: 300,
				modal: false,
				resizable: false,
				buttons: {
					"Se connecter": function() {
						login();
					},
					RAZ: function() {
						reset();
					}
				},
				beforeclose : function() { return false; }
			});
			$('#login').focus();
		});
		
		function login(){
			var login = $("#login").val();
			var password = $("#password").val();
			$.post("auth.php", {login:login,password:password},
			function(response) {
			readresponse(response);
			//alert(response);
			},'xml');
		}
		
		function reset() {
			$("#login").val("");
			$("#password").val("");
			$('#login').focus();
		}
		
		function readresponse(xml){
			$(xml).find("response").each(function(){
			    var access = $(this).find("access").text();
			    var id = $(this).find("userid").text();
			    var login = $(this).find("login").text();
			    var nom = $(this).find("nom").text();
			    var prenom = $(this).find("prenom").text();
			    var svc = $(this).find("svc").text();
			    //alert(svc);
			    if(access=="OK"){
				//alert("access ok");
				var today = new Date();
				today.setTime( today.getTime() );
				expires = 1000 * 60 * 60 * 12;
				var expires_date = new Date( today.getTime() + (expires) );
				
				document.cookie = "user="+id+";expires=" + expires_date.toGMTString();
				//alert(today.toGMTString());
				//alert("user="+id+";expires=" + expires_date.toGMTString());
				document.cookie = "nom="+nom;
				document.cookie = "prenom="+prenom;
				document.cookie = "login="+login;
				document.cookie = "svc="+svc;
				window.location = "presence.php";
			    }else{
				message(access);
				reset();
			    }
			});
		}
		
		function checkenter(e){
			var unicode=e.keyCode? e.keyCode : e.charCode
			if(unicode=="13"){
			    auth();
			}
		}
		</script>
	</head>
	<body>
		<div name="message" id="message" ></div>
		<div id="dialog-form" title="Pr&eacute;sence">
			<form style="text-align:right;">
				Utilisateur : <input type="text" name="login" id="login" value="" maxlength="10" size="20" autocomplete="off" /><br/>
				Mot de passe : <input type="password" name="password" id="password"value="" maxlength="10" size="20" autocomplete="off" />
			</form>
		</div>
	</body>
<html>