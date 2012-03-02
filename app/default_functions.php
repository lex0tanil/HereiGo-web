<?php
// On affiche le thème sur lequel on veut s'entrainer + nombre de questions souhaitées

function homeApp($id_membre, $theme) {

	$activatedThemes = $theme->getActivatedThemes($id_membre);
	$inactiveThemes = $theme->getInactiveThemes($id_membre);
	$desactivatedThemes = $theme->getDesactivatedThemes($id_membre);
	
	if ($activatedThemes->nb > 0) {
		echo '
		<table width="100%" border="0" cellspacing="4" cellpadding="0">
		  <tr>
		    <td width="30%" align="left"></td>
		    <td width="15%" align="right"><strong>Niveau</strong></td>
		    <td width="15%" align="right"><strong>Rang</strong></td>
		    <td width="40%" align="right"></td>
		  </tr>
		';
		
		for ($i=0; $i < $activatedThemes->nb; $i++) {
			$infosTheme = $theme->getInfos($activatedThemes->id_theme);
			$infosForMember = $theme->getInfosForMember($id_membre,$activatedThemes->id_theme[$i]);
			echo '
			<td width="30%">'.$activatedThemes->nom_theme[$i].'</td>
					<td width="15%" align="right">
					';
					
					if($infosForMember->level_membre==0){
						echo '-';
					} else {
						echo $infosForMember->level_membre;
					}
					
					echo '
					</td>
					<td width="15%" align="right">
					';
					
					if($infosForMember->rank_membre==0) {
						echo '-';
					} else {
						echo $infosForMember->rank_membre.'/'.$theme->getNbUsers($activatedThemes->id_theme);	
					}
					
					echo '
					</td>
					 <td width="40%" align="center">
				     	<a href="index.php?mode=stats"><img src="themes/default/img/icon-stats.png" alt="Voir mes statistiques" /></a>&nbsp;
				     	<a href="../req/desactivateTheme.php?id_theme='.$activatedThemes->id_theme[$i].'" alt="Désactiver le questionnaire"><img src="themes/default/img/icon-desactivate.png" /></a>&nbsp;
						<a href="index.php?mode=start&id_theme='.$activatedThemes->id_theme[$i].'"><img src="themes/default/img/icon-start.png" alt="Lancer un questionnaire pour ce thème" /></a>
					</td>
			</tr>
			';
		}
		echo '</table>';
	} else {
		echo 'Vous devez activer un thème pour répondre à un questionnaire.';	
	}
	
	if ($inactiveThemes->nb > 0) {
		?>
		<div id="subtitle">
			Thèmes disponibles
			<div class="greyline"></div>
		</div>
		<form action="../req/activateTheme.php" method="post">
		<?php
		
		for ($i=0; $i < $inactiveThemes->nb; $i++) {
				echo '<div style="float: left; width: 210px;"><input type="radio" name="id_theme" value="'.$inactiveThemes->id_theme[$i].'"> '.$inactiveThemes->nom_theme[$i].'</div>';
		}
		echo '
			<div class="clearer"></div>
			<br />
			<input type="submit" value="Activer le thème" />
			</form>
		';
	}

	if ($desactivatedThemes->nb > 0) {
		?>
		<div id="subtitle">
			Thèmes désactivés
			<div class="greyline"></div>
		</div>
		<form action="../req/reactivateTheme.php" method="post">
		<?php
		
		for ($i=0; $i < $desactivatedThemes->nb; $i++) {
			echo '<div style="float: left; width: 210px;"><input type="radio" name="id_theme" value="'.$desactivatedThemes->id_theme[$i].'"> '.$desactivatedThemes->nom_theme[$i].'</div>';
		}
		echo '
			<div class="clearer"></div>
			<br />
			<input type="submit" value="Activer le thème" />
			</form>
		';
	}
}


function startApp($id_membre, $theme) {
	
	$activatedThemes = $theme->getActivatedThemes($id_membre);
	
	if ($activatedThemes->nb > 0) {
		?>
		Choisissez le thème sur lequel vous souhaitez vous améliorer :
		<form action="../req/generateQuestionnaire.php" method="post">
		<?php
		if(isset($_GET['id_theme']) AND is_numeric($_GET['id_theme'])) {
			$id_theme = $_GET['id_theme'];
		} else {
			$id_theme = '';
		}
		
		for ($i=0; $i < $activatedThemes->nb; $i++) {
			
			if($id_theme==$activatedThemes->id_theme[$i]) {
				$checked = 'checked="checked"';
			} else {
				$checked = '';
			}
			
			echo '<div><label><input type="radio" name="id_theme" value="'.$activatedThemes->id_theme[$i].'"'.$checked.'> '.$activatedThemes->nom_theme[$i].'</label></div>';
		}
		?>
		<br />
		<br />
		Choisissez le nombre de questions souhaité :<br />
		<input type="radio" name="nbQuestions" value="10" /> 10 questions<br />
		<input type="radio" name="nbQuestions" value="20" /> 20 questions<br />
		<br />
		<input type="submit" value="Démarrer" />
		</form>
		<?php
	} else {
		// si aucun thème actif, on indique au membre qu'il faut activer un thème pour s'entrainer
		?>
		Pour lancer un questionnaire, vous devez obligatoirement <a href="index.php" style="text-decoration: underline;">activer un thème</a>.
		
		<?php
	}
}


function showIntro($id_membre) {
?>
<div style="margin: auto; width: 400px; padding-top: 30px; padding-bottom: 50px;">
		<div align="center">Préparation des questions en cours.<br /><br /><a href="index.php?mode=question"><img src="themes/default/img/loader.gif" /></a></div>
</div>
<?php
}

function showQuestion($id_membre, $question) {
	$questiontoshow = $question->getPendingQuestions($id_membre);
	$answers = $question->getAnswersQuestion($questiontoshow->id_question,4);
	
		if($questiontoshow->nb==0) {
			echo 'Vous devez lancer un questionnaire pour répondre à une question.';
		} else {
?>
<div id="showquestion">
	<form method="post" action="../req/sendAnswer.php">
	<div id="question"><?php echo $questiontoshow->texte_question; ?></div>
	<div id="reponses">
		<?php
		// on génère un chiffre aléatoire entre 1 et 4
		$proposition = array(0,1,2,3);
		shuffle($proposition);

		for($i=0;$i<4; $i++) {
			$j = $proposition[$i];
		?>
			<label><input type="radio" name="id_proposition" value ="<?php echo $answers->id_proposition[$j]; ?>" /> <?php echo $answers->texte_proposition[$j]; ?></label><br />
		<?php
		}
		?>
		<br />
		<input type="submit" value="Valider ma réponse" />
	</div>
	<input type="hidden" name="id_question" value="<?php echo $questiontoshow->id_question; ?>" />
	<input type="hidden" name="id_questionnaire" value="<?php echo $questiontoshow->id_questionnaire; ?>" />
	</form>
</div>
<?php
	}
}


function showReport($id_membre,$question, $recommendation) {
	// Récupération de l'id du dernier questionnaire
	$lastQuestionnaire = $question->getLastQuestionnaire($id_membre);
	
	if($lastQuestionnaire===false) {
		echo "Vous n'avez répondu à aucun questionnaire.";
	} else {
		$questionnaire = $question->getInfosQuestionnaire($lastQuestionnaire);
?>
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td width="70%" align="left" valign="top"><table width="82%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><strong>Calcul des points :</strong><br />
          <br /></td>
        <td width="2%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
      </tr>
      <tr>
        <td width="9%"></td>
        <td width="81%" align="left">Score obtenu</td>
        <td></td>
        <td align="right"><?php echo $questionnaire->reponses_justes; ?></td>
      </tr>
     <?php
     if($questionnaire->bonus_firstquestionnaire>0) {
     ?> 
      <tr>
        <td width="9%" align="left">&nbsp;</td>
        <td width="81%" align="left">Premier questionnaire du thème</td>
        <td></td>
        <td align="right"><?php echo $questionnaire->bonus_firstquestionnaire; ?></td>
      </tr>
     <?php
     }

     if($questionnaire->bonus_perfectscore>0) {
     ?>
      <tr>
        <td></td>
        <td align="left">Sans faute</td>
        <td></td>
        <td align="right"><?php echo $questionnaire->bonus_perfectscore; ?></td>
      </tr>
     <?php
     }
     
     if($questionnaire->bonus_firstoftheday>0) {
     ?>
      <tr>
        <td></td>
        <td align="left">1er questionnaire du jour</td>
        <td></td>
        <td align="right"><?php echo $questionnaire->bonus_firstoftheday; ?></td>
      </tr>
     <?php
     }
     ?>
       <tr>
        <td></td>
        <td></td>
        <td height="1" bgcolor="#000000"></td>
        <td height="1" bgcolor="#000000"></td>
      </tr>
       <tr>
        <td></td>
        <td></td>
        <td>=</td>
        <td align="right"><?php echo $questionnaire->points_obtenus; ?></td>
      </tr>
    </table></td>
    <td width="30%" align="center" valign="top"><table width="118" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td width="110" height="110" align="center" valign="middle" bgcolor="#66CC66">Score :<br />
            <span style="font-size: 30px;"><?php echo $questionnaire->reponses_justes; ?> / <?php echo $questionnaire->question_total; ?> </span></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$recommendations = $recommendation->getRecommendationsQuestionnaire($lastQuestionnaire);

if($recommendations->nb>0) {
	?>
	<br />
	<br />
	<strong>Recommandations pour vous améliorer :</strong>
	<ul>
	<?php
	for($i=0; $i<$recommendations->nb; $i++) {
	?>
		<li><em><?php echo $recommendations->text_type[$i]; ?> :</em>
			<ul>
				<li><?php echo $recommendations->title_recommendation[$i]; ?> <?php echo $recommendations->author_recommendation[$i]; ?> <?php echo $recommendations->date_recommendation[$i]; ?></li>
				<li><a href="<?php echo $recommendations->link_recommendation[$i]; ?>" target="_blank">Lien vers la ressource</a></li>
			</ul>
		</li>
	<?php
	}
	echo '</ul>';
}
?>
	<br />
	<br />
	<br />
		<div align="center">
			<a class="button" style="background-color: #004372; text-decoration: none; color: #FFF; padding-left: 10px; padding-right: 10px; padding-top: 3px; padding-bottom: 3px;" href="index.php?mode=start">Nouveau questionnaire</a>&nbsp;&nbsp;&nbsp;&nbsp;
														<a class="button" style="background-color: #004372; text-decoration: none; color: #FFF; padding-left: 10px; padding-right: 10px; padding-top: 3px; padding-bottom: 3px;" href="index.php">Retour à l'accueil</a>
		</div> 
	<?php
		}
}

function showStats($id_membre, $membre, $theme, $question, $statistics) {
	
$globalLevel = ($membre->getLevel($id_membre)/40)*100;
$statsDay = $statistics->getStatsDay($id_membre);

$levelMember = '';
$pointsMember = '';

for ($i=0; $i<=$statsDay->nb; $i++) {
	$levelMember = $levelMember.','.$statsDay->level_member[$i];
	$pointsMember = $pointsMember.','.$statsDay->points_member[$i];
}	

if(!empty($levelMember)) {
	$chartLevelMember = Tool::google_chart_encode($levelMember, "s");
}

if(!empty($pointsMember)) {
	$chartPointsMember = Tool::google_chart_encode($pointsMember, "s");
}
?>
<div>Mon niveau global :</div>
<div align="center">
	<img src="http://chart.apis.google.com/chart?chxr=0,0,40&chxs=0,000000,10.167,0,l,676767&chxt=y&chs=353x149&cht=gm&chds=-5,105&chd=t:<?php echo $globalLevel; ?>&chma=0,2,0,3|5,2" />
</div>
<br />
<br />
<br />
<div>Evolution de mon niveau global :</div>
<br />
<div align="center">
	<img src="http://chart.apis.google.com/chart?chxr=0,0,40&chxt=y&chs=500x225&cht=lc&chco=224499&chds=3.333,60&chd=t:<?php echo $chartLevelMember; ?>&chg=14.3,-1,1,1&chls=2&chm=B,BBCCED,0,0,0">
</div>
<br />
<br />
<br />
<div>Evolution de mes points :</div>
<br />
<div align="center">
	<img src="http://chart.apis.google.com/chart?chxr=0,0,400&chxt=y&chs=500x225&cht=lc&chco=224499&chds=3.333,60&chd=t:<?php echo $chartPointsMember; ?>&chg=14.3,-1,1,1&chls=2&chm=B,BBCCED,0,0,0">
</div>
		<br />
		<br />
		<em>Note : les statistiques sont calculées tous les jours à minuit.</em>
<?php
}


function showHistory($id_membre, $question, $theme) {
	$allQuestionnaires = $question->getAllResultsQuestionnaires($id_membre);
	if($allQuestionnaires->nb>0) {
	?>
		<table width="503" border="0" cellspacing="4" cellpadding="0">
			<tr>
				<td width="29%">&nbsp;</td>
				<td width="23%"><strong>Thème</strong></td>
				<td width="21%" align="right"><strong>Score obtenu</strong></td>
				<td width="27%" align="right"><strong>Points gagnés</strong></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
			<?php
			$date2 = '';
			for ($i=$allQuestionnaires->nb-1; $i >= 0 ; $i--) {
			$date = 'Le '.Tool::dateEnLettres_sansJH($allQuestionnaires->date_finished[$i]);
			if($date!=$date2) {
			?>
			<tr>
				<td><br /></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><em><?php echo $date; ?></em></td>
				<td><?php echo $theme->getNameThemeById($allQuestionnaires->id_theme[$i]); ?></td>
				<td align="right"><?php echo $allQuestionnaires->reponses_justes[$i]; ?>/<?php echo $allQuestionnaires->question_total[$i]; ?>
				</td>
 				<td align="right"><?php echo $allQuestionnaires->points_obtenus[$i]; ?></td>
			</tr>
			<?php
			} else {
			?>
			<tr>
				<td></td>
				<td><?php echo $theme->getNameThemeById($allQuestionnaires->id_theme[$i]); ?></td>
				<td align="right"><?php echo $allQuestionnaires->reponses_justes[$i]; ?>/<?php echo $allQuestionnaires->question_total[$i]; ?>
				</td>
				<td align="right"><?php echo $allQuestionnaires->points_obtenus[$i]; ?></td>
			</tr>
			<?php
			}
			?>
			<?php
			$date2 = $date;
			}
			?>
		</table>
	<?php
	} else {
		echo "Aucun historique disponible.";	
	}
}


function showAddTempQuestion ($id_membre, $theme) {
?>
<form method="post" action="../req/addTempQuestion.php">
  Question : <br />
  <input type="text" name="askedquestion" style="width: 400px;" />
  <br />
  <br />
  Thèmes :
<br />
  <select name="id_theme" id="select">
   <?php
   		$allthemes = $theme->getAllThemes($id_membre);
   		echo 'hello: '.$allthemes->nb;
		for ($i=0; $i < $allthemes->nb; $i++) {
			echo '<option value="'.$allthemes->id_theme[$i].'"> '.$allthemes->nom_theme[$i].' ('.$theme->getNbQuestionsTheme($allthemes->id_theme[$i]).')</option>';
		}
   ?>
  </select>
  <br />
  <br />
  Réponse correcte :<br />
  <input type="text" name="correctanswer" style="width: 400px;" /><br />
  <br />
  Réponses fausses (obligatoires) :<br />
  <input type="text" name="wronganswer1" style="width: 400px;" /><br />
  <input type="text" name="wronganswer2" style="width: 400px;" /><br />
  <input type="text" name="wronganswer3" style="width: 400px;" /><br />
  <br />
  <label>
    <input type="submit" name="button" id="button" value="Envoyer" />
  </label>
  <br />
  <br />
</form>
<?php	
}


function showMyAcceptedQuestions ($id_membre, $question) {
	$acceptedQuestions = $question->getAcceptedQuestions($id_membre);
	
	if($acceptedQuestions->nb==0) {
		echo "Aucune question n'a encore été validée.<br /><br />";	
	}
	
	for ($i=0; $i < $acceptedQuestions->nb; $i++) {
	?>
		<div>
			<div style="float: left; width: 40px;"><img src="/img/tick.png"></div>
			<div style="float: left; width: 540px;"><?php echo $acceptedQuestions->texte_question[$i]; ?></div>
			<div class="clearer"></div>
		</div>
	<?php
	}
	?>
	<br />
	<br />
	<br />
	<?php
}

function showMyPendingQuestions ($id_membre, $question) {
	$suggestedQuestions = $question->getSuggestedQuestions($id_membre);
	
	if($suggestedQuestions->nb==0) {
		echo "Vous n'avez aucune question en attente de validation.<br /><br />";
	}
	
	for ($i=0; $i < $suggestedQuestions->nb; $i++) {
	?>
		<div>
			<div style="float: left; width: 40px;">
			
<a href="javascript:if(confirm('Êtes-vous sûr de vouloir supprimer la question ?')) document.location.href='/req/deleteTempQuestion.php?id_question=<?php echo $suggestedQuestions->id_question[$i]; ?>'"><img src="/img/cross.png"></a></div>
			<div style="float: left; width: 540px;"><?php echo $suggestedQuestions->texte_question[$i]; ?>
				<div style="padding-left: 40px;">
				<?php
				$answers = $question->getAnswersTempQuestion($suggestedQuestions->id_question[$i],4);
				for ($j=0; $j < $answers->nb; $j++) {
					echo $answers->texte_proposition[$j].'<br />';
				}
				?>
				</div>
			</div>
			<div class="clearer"></div>
			<br />
		</div>
	<?php
	}
	?>
	<br />
	<br />
	<br />
	<?php
}

function showAddRecommendation($id_membre, $id_question, $question, $recommendation) {
	$allTypes = $recommendation->getAllTypesRecommendation();
	$acceptedQuestions = $question->getAcceptedQuestions($id_membre);
	$questionToShow = $question->getInfosQuestionTemp($id_question);
	?>
	<form method="post" action="../req/sendRecommendation.php">
	<?php
	if(!is_numeric($id_question)) {
	?>
	Votre question :<br />
	<select name="id_question_temp">
		<?php
		for ($i=0; $i < $acceptedQuestions->nb; $i++) {
			echo '<option value="'.$acceptedQuestions->id_question[$i].'">'.$acceptedQuestions->texte_question[$i].'</option>';
		}
		?>
	</select>	
	<?php
	} else {
	?>
	Votre question :<br />
	<?php echo $questionToShow->texte_question; ?>
	<input type="hidden" name="id_temp_question" value="<?php echo $questionToShow->id_question; ?>" />
	<?php
	}
	?>
	<br />
	<br />
	Titre (obligatoire) :<br />
	<input type="text" name="recommendation_title" value="" style="width: 300px;" /><br />
	<br />
	Type de recommandation (obligatoire) :<br />
	<select name="recommendation_type">
		<?php
		for($i=0; $i<$allTypes->nb; $i++) {
			echo '<option value="'.$allTypes->id_type[$i].'">'.$allTypes->text_type[$i].'</option>';	
		}
		?>
	</select>
	<br />
	<br />
	URL (obligatoire) :<br />
	<input type="text" name="recommendation_url" value="" style="width: 300px;" /><br />
	<br />
	Auteur :<br />
	<input type="text" name="recommendation_author" value="" style="width: 300px;" /><br />
	<br />
	Année : <br />
	<input type="text" name="recommendation_date" value="" style="width: 300px;" /><br />
	<br />
	<input type="submit" value="Ajouter" />
	</form>
	
	<?php
}


?>