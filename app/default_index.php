
<?php
/* ----------------------------------------
	Protection which prevents people to load the page without index.php
---------------------------------------- */

if (!$protection) {
	header('location: /login/');
	exit;
}


/* ----------------------------------------
	Others
---------------------------------------- */

$infosMembre = $membre->getInfos($id_membre);
$mode = $_GET['mode'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CheckMinder - Application e-learning gratuite</title>
	<link rel="stylesheet" href="http://www.checkminder.com/wp-content/themes/checkminder/style.css" type="text/css" media="screen" />
    <script language="javascript">
	function masquernotification()
	{
	  document.getElementById("notification").innerHTML="";
	}
	 window.setTimeout(masquernotification, 5000);
	</script>
	<?php
	if($_GET['mode']=="intro") {
		echo '<meta http-equiv="Refresh" content="4;URL=index.php?mode=question">';
	}
	?>
</head>

<body>

<div id="header">
<div id="header_content">
		<div id="logo" style="width: 40px; float: left;	padding-top: 5px;"><a href="http://www.checkminder.com/app/"><img src="/temp/logo-checkminder.png" width="28" height="34" /></a></div>
        <div id="logotext" style="width: 276px; float: left; padding-top: 10px;"><a href="http://www.checkminder.com/app/"><img src="/temp/checkminder.png" width="145" height="21" /></a></div>
<div id="menu" style="padding-top: 10px;"> 
			<div class="tab"><a href="/logout/">Logout <img src="themes/default/img/arrow-down-white.png"></a></div> 
			<div class="tab"><a href="index.php?mode=stats">Statistiques</a></div> 
			<div class="tab"><a href="index.php?mode=history">Historique</a></div>
			<div class="tab"><a href="index.php">Accueil</a></div>
        </div>
    </div>
</div>

<div>
	<div id="mess" style="background-color: red; color: #FFF; text-align: center; padding: 10px;">
    	Le site CheckMinder est en version beta.
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

if($question->isPendingQuestionnaire($id_membre)===true AND $_GET['mode']!='question' AND $_GET['mode']!='intro'){
?>
<div id="notification2">
	<div id="mess" style="background-color: #FF9; text-align: center; padding: 10px;">
		Vous n'avez pas fini de répondre à votre dernier questionnaire. <a href="index.php?mode=question">Cliquez ici pour continuer</a>.
    </div>
</div>	
<?php
}
?>


<div id="main">
    <div id="content">
		<div style="padding-top: 40px; margin-bottom: 40px;">
		
			<div id="bloc_left">
				<div id="bloc_left_stats">
					<div>
						<div id="profilepic" style="float: left; margin: 6px; height: 50px; width: 50px;"><img src="themes/default/img/profile.png" /></div>
						<div id="name" style="padding-top: 10px;"><strong><?php echo $infosMembre->prenom_membre; ?> <?php echo $infosMembre->nom_membre; ?></strong></div>
						<div id="name">Rang :  <?php
						
						$rank = $infosMembre->rank_membre;
						$nbMembers = $membre->getNbMembers($id_membre);
						
						if($rank==0) {
							echo $nbMembers;
						} else {
							echo $rank;
						}
						?> (sur <?php echo $nbMembers; ?>)</div>
						<div class="clearer"></div>
					</div>
					<div id="quickstats">
						<div class="quickstats_item">
							<?php
							if($infosMembre->points_membre<2) {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->points_membre; ?></div>
								<div style="font-size: 12px;">point</div>
							<?php
							} else {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->points_membre; ?></div>
								<div style="font-size: 12px;">points</div>
							<?php
							}
							?>
						</div>
						<div class="quickstats_item" style="margin-left: 5px; margin-right: 5px;">
							<?php
							if($infosMembre->questions_membre<2) {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->questions_membre; ?></div>
								<div style="font-size: 12px;">question</div>
							<?php
							} else {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->questions_membre; ?></div>
								<div style="font-size: 12px;">questions</div>
							<?php
							}
							?>
						</div>
						<div class="quickstats_item">
							<?php
							if($infosMembre->level_membre<2) {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->level_membre; ?></div>
								<div style="font-size: 12px;">niveau</div>
							<?php
							} else {
							?>
								<div style="font-size: 20px; padding-bottom: 2px;"><?php echo $infosMembre->level_membre; ?></div>
								<div style="font-size: 12px;">niveaux</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
				$admin = $infosMembre->admin;
				if($admin==1 OR $admin==2) {
				?>

				<div id="bloc_left_stats" style="margin-top: 15px; width: 220px;">
					<div style="padding-left: 20px; padding-top: 5px;"><strong>Outils</strong></div>
					<ul>
						<li><a href="index.php?mode=addquestion" style="text-decoration: none; color: #000;">Ajouter une question</a></li>
						<li><a href="index.php?mode=addrecommendation" style="text-decoration: none; color: #000;">Ajouter recommandation</a></li>
						<li><a href="index.php?mode=showmypendingquestions" style="text-decoration: none; color: #000;">Questions en attente</a> 
						(<?php
							$nbSuggested = $question->getSuggestedQuestions($id_membre);
							echo $nbSuggested->nb;
						?>)</li>
						<li><a href="index.php?mode=showmyacceptedquestions" style="text-decoration: none; color: #000;">Questions acceptées</a>
						(<?php 
							$nbAccepted = $question->getAcceptedQuestions($id_membre);
							echo $nbAccepted->nb;
						?>)</li>
					</ul>
				</div>
				<?php
				}
				?>
				
				<div class="clearer"></div>

			</div>
			
			
			<div id="bloc_right">
				<div id="bloc_right_menu">
					<div style="float: left; width: 50%; text-align: left;">
						<div class="page_title">
						<?php
							switch($mode) {
								case 'start':
									$titre = "Choix du questionnaire";
									break;
									
								case 'report':
									$titre = "Bilan";
									break;
									
								case 'intro':
									$titre = 'Questionnaire';
									break;
									
								case 'question':
									$titre = 'Question';
									$id_questionnaire = $question->getPendingQuestionnaire($id_membre);
									$infosQuestionnaire = $question->getInfosQuestionnaire($id_questionnaire);
									if(is_numeric($id_questionnaire)) {
										$titre = 'Question n°'.$question->getNbCurrentQuestion($id_questionnaire).' (sur '.$infosQuestionnaire->question_total.')';
									}
									break;
									
								case 'addquestion':
									$titre = "Ajouter une question (1/2)";
									break;

								case 'addrecommendation':
									$titre = "Ajouter une recommandation (2/2)";
									break;
									
								case 'showmyacceptedquestions':
									$titre = "Liste des questions acceptées";
									break;
									
								case 'showmypendingquestions':
									$titre = "Liste des questions en attente";
									break;
									
								case 'stats':
									$titre = "Statistiques";
									break;
									
								case 'history':
									$titre = "Historique";
									break;
								default:
									$titre = "Tableau de bord";
							}
							echo $titre;
							?>
						</div>
					</div>
					<div style="text-align:right;">
						<?php
						if($mode=='' AND $question->isPendingQuestionnaire($id_membre)===false){
						?>
						<a class="button" style="background-color: #004372; text-decoration: none; color: #FFF; padding-left: 10px; padding-right: 10px; padding-top: 3px; padding-bottom: 3px;" href="index.php?mode=start">Lancer un questionnaire</a>
						<?php
						}
						if($mode=='question') {
							$id_questionnaire = $question->getPendingQuestionnaire($id_membre);
							
							if(is_numeric($id_questionnaire)) {
						?>
						<form method="post" action="../req/closeQuestionnaire.php">
							<input type="hidden" name="id_questionnaire" value="<?php echo $id_questionnaire; ?>" />
							<input type="submit" value="Abandonner" />
						</form>
						<?php
							}
						}
						?>
					</div>
					<div class="clearer"></div>
					<div class="greyline"></div>
				</div>
				<div id="bloc_right_content">
					<?php
					switch($mode) {
						case 'start':
							startApp($id_membre, $theme);
							break;
						
						case 'intro':
							showIntro($id_membre);
							break;
							
						case 'question':
							showQuestion($id_membre, $question);
							break;
							
						case 'addquestion':
							showAddTempQuestion($id_membre, $theme);
							break;
						case 'addrecommendation':
							showAddRecommendation($id_membre, $_GET['id_question_temp'], $question, $recommendation);
							break;
						case 'showmypendingquestions':
							showMyPendingQuestions ($id_membre, $question);
							break;
						case 'showmyacceptedquestions':
							showMyAcceptedQuestions($id_membre, $question);
							break;
										
						case 'report':
							showReport($id_membre, $question, $recommendation);
							break;
						
						case 'stats':
							showStats($id_membre, $membre, $theme, $question, $statistics);
							break;

						case 'history':
							showHistory($id_membre, $question, $theme);
							break;
						
						default:
							homeApp($id_membre, $theme);	
					}
					?>
				</div>
			</div>
	

				
			</div>
			
			<div class="clearer"></div>
		</div>
		<div style="height: 40px;"></div>
	</div>
	
    <div id="footer"></div>
</div>

</body>
</html>
