<?php
session_start();
session_destroy();
include_once('config.php');

?>
<html>
	<head>
		<style type="text/css">@import url("css/main.css");</style>
		<!-- jquery -->
		<script type="application/x-javascript" src="js/jquery-1.7.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
                
		});
		
		function auth(){
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
		}
		
		function readresponse(xml){
			$(xml).find("response").each(function(){
			    var access = $(this).find("access").text();
			    //alert(access);
			    if(access=="OK"){
				//alert("access ok");
				window.location = "presence.php";
			    }else{
				alert(access);
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
	<body onload="document.getElementById('login').focus();">
		<div name="message" id="message" ></div>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<div name="divlogin" id="divlogin">
			<table name="tbllogin" id="tbllogin" class="tblform">
				<thead>
					<tr>
						<th colspan="2">Pr&eacute;sence</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Utilisateur</td><td class="inputbox"><input type="text" name="login" id="login" value="" maxlength="10" size="20" onkeydown="checkenter(event);"/></td>
					</tr>
					<tr>
						<td>Mot de passe</td><td class="inputbox" ><input type="password" name="password" id="password"value="" maxlength="10" size="20" onkeydown="checkenter(event);"/></td>
					</tr>
					<tr>
						<td colspan="2" class="inputbox"><input type="button" name="reset" id="reset" value="Annuler" onclick="reset()" /><input type="button" name="submit" id="submit" value="Entrer" onclick="auth()" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
<html>
