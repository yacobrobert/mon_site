<?php
/* Si le formulaire est envoyé alors on fait les traitements */
if (isset($_POST['envoye']))
{
    /* Récupération des valeurs des champs du formulaire */
    if (get_magic_quotes_gpc())
    {
      $civilite		= stripslashes(trim($_POST['civilite']));
      $nom	     	= stripslashes(trim($_POST['nom']));
      $expediteur	= stripslashes(trim($_POST['email']));
      $sujet		= stripslashes(trim($_POST['sujet']));
      $message		= stripslashes(trim($_POST['message']));
    }
    else
    {
      $civilite		= trim($_POST['civilite']);
      $nom		    = trim($_POST['nom']);
      $expediteur	= trim($_POST['email']);
      $sujet		= trim($_POST['sujet']);
      $message		= trim($_POST['message']);
    }

    /* Expression régulière permettant de vérifier si le
    * format d'une adresse e-mail est correct */
    $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';

    /* Expression régulière permettant de vérifier qu'aucun
    * en-tête n'est inséré dans nos champs */
    $regex_head = '/[\n\r]/';

      if(empty($civilite)
           || empty($nom)
           || empty($expediteur)
           || empty($sujet)
           || empty($message))
    {
      $alert = 'Tous les champs doivent être renseignés';
    }
    /* On vérifie que le format de l'e-mail est correct */
    elseif (!preg_match($regex_mail, $expediteur))
    {
      $alert = 'L\'adresse '.$expediteur.' n\'est pas valide';
    }
    /* On vérifie qu'il n'y a aucun header dans les champs */
    elseif (preg_match($regex_head, $expediteur)
            || preg_match($regex_head, $nom)
            || preg_match($regex_head, $sujet))
    {
        $alert = 'En-têtes interdites dans les champs du formulaire';
    }
    /* Si aucun problème et aucun cookie créé, on construit le message et on envoie l'e-mail */
    elseif (!isset($_COOKIE['sent']))
    {
        /* Destinataire (votre adresse e-mail) */
        $to = 'postmaster@yacobrobert.fr';

        /* Construction du message */
        $msg  = 'Bonjour,'."\r\n\r\n";
        $msg .= 'Ce mail a été envoyé depuis monsite.com par '.$civilite.' '.$nom."\r\n\r\n";
        $msg .= 'Voici le message qui vous est adressé :'."\r\n";
        $msg .= '***************************'."\r\n";
        $msg .= $message."\r\n";
        $msg .= '***************************'."\r\n";

        /* En-têtes de l'e-mail */
        $headers = 'From: '.$nom.' <'.$expediteur.'>'."\r\n\r\n";

        /* Envoi de l'e-mail */
        if (mail($to, $sujet, $msg, $headers))
        {
            $alert = 'E-mail envoyé avec succès';

            /* On créé un cookie de courte durée (ici 120 secondes) pour éviter de
            * renvoyer un mail en rafraichissant la page */
            setcookie("sent", "1", time() + 120);

            /* On détruit la variable $_POST */
            unset($_POST);
        }
        else
        {
            $alert = 'Erreur d\'envoi de l\'e-mail';
        }

    }
    /* Cas où le cookie est créé et que la page est rafraichie, on détruit la variable $_POST */
    else
    {
        unset($_POST);
    }
}
?>
<!doctype html>
	<html lang="fr">
		<head>
		 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    		<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="css/monsite.css">
			<meta charset="utf-8">
			<title>YACOB Robert, développeur WEB</title>
			<meta name="description" content="Yacob Robert développeur WEB JavaScript angular 2">
			<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
			 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		    <!-- Include all compiled plugins (below), or include individual files as needed -->
		    <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
         
$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
        </script>


		</head>
		<body>
			<main>
			<div class="row">
					<div class="col-sm-8 col-sm-offset-2 conteneur">
						<header>
							<div class="photo">
								<a href="index.php"><img src="img/laptop.jpg" class="img-responsive" alt="image du logo"></a>
							</div>
							<div class="nom_site"><h1>YACOB Robert,<br />Développeur - intégrateur WEB</h1></div>
						</header>

						<nav class="navbar navbar-default">
						  <div class="container-fluid">
						    <!-- Brand and toggle get grouped for better mobile display -->
						    <div class="navbar-header">
						      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						        <span class="sr-only">Toggle navigation</span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						      </button>
						    </div>

						    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						      <ul class="nav navbar-nav">
						        <li><a href="index.php">Accueil</a></li>
						      	<li><a href="#competences">Mes compétences</a></li>
						        <li><a href="#moncv">Mon CV</a></li>
						        <li><a href="#projets">Réalisations</a></li>
						        <li><a href="#contact">Contact</a></li>
						      </ul>

						    </div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
            
						<section> <!-- présentation -->
							<div id="bandeau">
								<img src="img/computer.jpg" class="img-responsive" alt="image ordinateur" />
							</div>
							<div class="row">
								<div class="zone1 col-sm-6">
									<p class="text">Passionné du Web depuis des années, des nouvelles technologies et toujours à l'affût des dernières innovations techniques et technologiques, ma motivation est de contribuer à bâtir le WEB de demain avec vous et de mettre à profit mes compétences de développeur et d'intégrateur web.
									</p>
								</div>
								<div class="zone2 col-sm-6">
									<div class="row">
										<div class="col-sm-4 col-xs-4">
											<img src="img/me.jpg" class="img-responsive" alt="photo du developpeur" />
										</div>
										<div class="col-sm-8 col-xs-8">
											<b>Robert</b><br />
											<span class="text">
												Zone d'activité : Val d'oise (95) et Paris<br />Spécialisé dans le javascript et le framework ANGULAR2, j'ai aussi une connaissance approfondie du Php et du langage HTML/CSS.
											</span>
										</div>
									</div>
								</div>
							</div>

						<!-- -page compétences  -->

						<div class="bandeau">
								<img src="img/idea.png" id="competences" alt="image homme avec des idées">
							</div>
							<div class="row">
								<div class="col-sm-8 col-xs-8">
									<h2>Présentation</h2>
									<p class="text">
										Après une formation de base aux nombreux langages Web au sein de l'école WEBFORCE3, labellisée Grande Ecole du Numérique, je me suis formé pour me spécialiser dans le JavaScript et sur le framework JS : ANGULAR2</p>
								</div>
								<div class="col-sm-4 col-xs-4">
									<img src="img/angular2.png" class="img-logo" alt="logo angular 2" />
								</div>
							</div>

							<div class="row">
								<div class="col-sm-4 col-xs-4">
									<img src="img/wf3.png" class="img-logo" alt="logo webforce3" />
									<img src="img/langages.jpg" class="img-logo" alt="logo langages web" />
								</div>
								<div class="col-sm-8 col-xs-8">
									<h2>Mes compétences</h2>
									<p class="text">
										<b>Développeur / intégrateur Webforce3</b><br />
										<b>Langage WEB</b> : HTML5 / CSS3 / JavaScript / PHP / MySQL<br />
										<b>Framework</b> : ANGULAR / JQuery / Symfony<br />
										<b>Outils</b> : PhpMyAdmin / AJAX / CMS WordPress<br />
									</p>
								</div>
							</div>
		<!-- cv page -->
					<div class="bandeau">
						<img src="img/cv.jpg" alt="image cv" id="moncv">
					</div>
					<div class="row">
						<div class="col-sm-8 col-xs-8">
							<h2>Formation</h2>
								<ul class="text">
									<li><b>Webforce3 - 2017</b></li>
									Développeur/ intégrateur WEB
									Au Cargo (Paris 19)<br />
									<li><b>BTS Négociation Relation Client - 2011</b></li>
									IFCAE Cergy (95)<br />
									<li><b>Bac STT comptabilité et gestion - 1999</b></li>
									Lycée Alfred Kastler Cergy (95)<br >
									<b>Voir mon CV en cliquant sur le PDF : </b>
									<a href="img/CV YACOB Robert.pdf" target="_blank"><img src="img/cv-pdf-image.png"/></a>
								</ul>
						</div>
						<div class="col-sm-4 col-xs-4">
								<img src="img/diplome.jpg" class="img-logo" alt="diplome image" />
						</div>
					</div>
		<!-- page des réalisations -->
					<div class="bandeau">
						<img src="img/projets.jpg" alt="image projets" id="projets">
					</div>
					<h2>Mes réalisations</h2>
					<p class="text">La page est vide !!! Mes réalisations arrivent !</p>
					<div class="row">
            <div class="col-sm-12">
								<img src="img/under_construction.jpg" class="img-responsive" alt="photo du developpeur" />
						</div>
					</div>
			<!-- page de contact -->
								<div class="bandeau">
											<img src="img/contact_mail.jpg" alt="contact email" id="contact">
										</div>
								<div class="row>">
												<div class="col-sm-6">
													<h2>Formulaire de contact</h2>

													<?php
													if (!empty($alert))
													{
													    echo '<p style="color:red">'.$alert.'</p>';
													}
													?>

													<form action="#contact" method="post">
														<p>
																<label for="civilite"></label>
																<select id="civilite" name="civilite">
																		<option
																				value="mr"
																				<?php
																						if (!isset($_POST['civilite']) || $_POST['civilite'] == 'mr')
																						{
																								echo ' selected="selected"';
																						}
																				?>
																		>
																				Monsieur
																		</option>
																		<option
																				value="mme"
																				<?php
																						if (isset($_POST['civilite']) && $_POST['civilite'] == 'mme')
																						{
																								echo ' selected="selected"';
																						}
																				?>
																		>
																				Madame
																		</option>
																		<option
																				value="mlle"
																				<?php
																						if (isset($_POST['civilite']) && $_POST['civilite'] == 'mlle')
																						{
																								echo ' selected="selected"';
																						}
																				?>
																		>
																				Mademoiselle
																		</option>
																</select>
														</p>
														<p>
																<label for="nom"></label>
																<input type="text" id="nom" name="nom"
																	placeholder="Votre nom et prénom" value="<?php echo (isset($_POST['nom'])) ? $nom : '' ?>"
																/>
														</p>
														<p>
																<label for="email"></label>
																<input type="text" id="email" name="email" placeholder="Votre email"
																	value="<?php echo (isset($_POST['email'])) ? $expediteur : '' ?>"
																/>
														</p>
														<p>
																<label for="sujet"></label>
																<input type="text" id="sujet" name="sujet" placeholder="Sujet"
																	value="<?php echo (isset($_POST['sujet'])) ? $sujet : '' ?>"
																/>
														</p>
														<p>
																<label for="message"></label>
																<textarea id="message" name="message"  cols="40" rows="4">Votre message...
															<?php echo (isset($_POST['message'])) ? $message : '' ?>
																</textarea>
														</p>
														<p>
																<input type="submit" name="envoye" value="Envoyer" />
														</p>
													</form>
													</div>

												<div class="coordonnees col-sm-6">
														<h2>Mes coordonnées</h2><br>
														<strong>Adresse :</strong><br>
														<strong>95300 PONTOISE<strong><br>
														<strong>tél : 06 50 13 23 80 <strong><br>
														<strong>mon mail : <a href="mailto:yacobrobert@hotmail.com">yacobrobert@hotmail.com</strong><br />
												</div>
											</div>
									</section>
											<footer>
												<div class="row">
													<div class="col-sm-2 col-xs-3"><a href="https://www.facebook.com/yacob.robert.7"  target="_blank">
														<img src="img/fb.png" class="img-logo" alt="lien vers Facebook"></a>
													</div>
													<div class="menufooter col-sm-8 col-xs-6">
														2016 | Robert YACOB
													</div>
													<div class="col-sm-2 col-xs-3">
														<a href="https://www.linkedin.com/in/yacob-robert-95300"  target="_blank"><img src="img/linkedin.png" class="img-logo" alt="lien vers Linkedin"></a>
													</div>
												</div>
											</footer>
										</div>
									</div>

			</main>
		</body>

	</html>
