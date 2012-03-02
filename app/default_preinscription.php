<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>CheckMinder - Application e-learning gratuite</title> 
	<link rel="stylesheet" href="http://www.checkminder.com/wp-content/themes/checkminder/style.css" type="text/css" media="screen" /> 
</head> 
 
<body> 
 
<div id="header"> 
<div id="header_content"> 
		<div id="logo" style="width: 40px; float: left;	padding-top: 5px;"><img src="/temp/logo-checkminder.png" width="28" height="34" /></div> 
        <div id="logotext" style="width: 400px; float: left; padding-top: 10px;"><img src="/temp/checkminder.png" width="145" height="21" /></div> 
<div id="menu" style="padding-top: 10px;"> 
        </div> 
    </div> 
</div>

<?php
if(!empty($_SESSION['mess'])){
?>
<div id="notification">
	<div id="mess" style="background-color: #FF9; text-align: center; padding: 10px;">
    	<?php echo $_SESSION['mess']; ?>
    </div>
</div>
<?php
$_SESSION['mess']='';
}
?>

<div id="main"> 
    <div id="content"> 
		<div style="padding-top: 40px; margin-bottom: 40px;"> 
		
			<div id="bloc_left">
			</div> 
			
			
			<div id="bloc_right"> 
				<div id="bloc_right_menu"> 
					<div style="float: left; width: 50%; text-align: left;"> 
						<div class="page_title">Pré-inscription</div> 
					</div> 
				</div> 
				<div id="bloc_right_content">
						
						La pré-inscription est gratuite. Dès que l'application sera disponible, vous recevrez un e-mail contenant vos identifiants.
						<br />
						<br />
						<form action="../req/sendPreinscription.php" method="post">
						Saisissez votre adresse e-mail :<br />
						<input name="email" type="text" value="<?php echo $_SESSION['email']; $_SESSION['email'] = ''; ?>" style="width: 200px;" />
						<br />
						<br />
						Choisissez un mot de passe :<br />
						<input type="password" value="" name="pass"  style="width: 200px;" />
						<br />
						<br />
						Confirmez votre mot de passe :<br />
						<input type="password" value="" name="pass2"  style="width: 200px;" />
						<br />
						<br />
						<label>
							<input type="submit" name="button" id="button" value="Envoyer" />
						</label>
						</form>
				</div> 
			</div> 
	
 
				
			</div> 
			
			<div class="clearer"></div> 
		</div> 
	</div> 
	
	
    <div id="footer"></div> 
</div> 
 
</body> 
</html> 