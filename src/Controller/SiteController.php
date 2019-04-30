<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\FormArticleType;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use App\Form\FormEvenementType;
use App\Entity\Lieu;
use App\Repository\LieuRepository;
use App\Form\FormLieuType;
use App\Entity\IntervalleTemps;
use App\Repository\IntervalleTempsRepository;
use App\Form\FormIntervalleTempsType;
use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;
use App\Form\FormOrganisateurType;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Form\FormContactType;
use App\Entity\ListeContact;
use App\Repository\ListeContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class SiteController extends AbstractController
{
    /**
     *@Route("/accueil", name="accueil")
	 *@Route("/", name="accueil2")
     */
    public function accueil()
    {
        return $this->render('site/accueil.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

	/**
     * @Route("/article", name="article")
     */
    public function article(ArticleRepository $repository)
    {
		$articles = $repository->findAll();

        return $this->render('site/article.html.twig', [
           'articles'=> $articles
        ]);
    }

	/**
     * @Route("/evenement", name="evenement")
     */
    public function evenement(EvenementRepository $repository)
    {
		$evenements = $repository->findAll();

        return $this->render('site/evenement.html.twig', [
           'evenements'=> $evenements
        ]);
    }

	/**
     * @Route("/document", name="document")
     */
    public function document()
    {
        return $this->render('site/document.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

	/**
     * @Route("/chat", name="chat")
     */
    public function chat()
    {
        return $this->render('site/chat.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

	/**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('site/contact.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

	/**
     * @Route("/info", name="info")
     */
    public function info()
    {
        return $this->render('site/info.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

	
	/**
     * @Route("/mission", name="mission")
     */
    public function mission()
    {
        return $this->render('site/missionEcoleEntreprise.html.twig', [
            'controller_name' => 'SiteController',
        ]);
	}
	
	/* regarder https://www.youtube.com/watch?v=_cgZheTv-FQ
	 vers 44min40 , il explique comment faire la création et la modification en même temps*/


	/**
     * @Route("/createArticle", name="createArticle")
	 * @Route("/modifArticle/{id}", name="modifArticle")
     */
	 public function createArticle(Article $article = null,Request $request , ObjectManager $manager , LieuRepository $repoLieu, ContactRepository $repoContact , OrganisateurRepository $repoOrga , IntervalleTempsRepository $repoPeriode , ListeContactRepository $repoListeContact , ValidatorInterface $validator )
	 {
		$editmode = true;
		if(!$article )
		{
			$article = new Article();

			// cette evénement est là pour pouvoir rentrer dans la boucle for dans le twig
			// pareil pour l'organisteur		
			$event = new Evenement();

			$orga = new Organisateur();
			$event->addOrganisateur($orga);
			$article->addEvenement($event);
			$editmode = false;
		}

		$form2 = $this->createForm(FormArticleType::class , $article);


		$form2->handleRequest($request);

		$lieuDejaPrisForm = null;
		$lieuDejaPrisBd = null;
		$erreurValidation = null;
		$erreurPeriode = null;

		if($form2->isSubmitted() /*&& $form2->isValid()*/)
		{

			if($article->getId() == null)
			{
				$article->setCreatedAt(new \DateTime( "now" , new \DateTimeZone("Europe/Paris")));
			}


			// on va supprimer les espcases blancs des numéros de téléphone
			// commencer les prénoms et les noms avec des majuscules
			//voir ici si il y a d'autres saisies qu'il faut modifier
			//code postal ? (modifier l'expression régulière pour accepeter les espaces)
			foreach($article->getEvenements() as $key)
			{
				foreach($key->getOrganisateurs() as $key2)
				{
					foreach($key2->getContacts() as $key3)
					{
						$key3->setTelephone(str_replace(" ","",$key3->getTelephone()));
						$key3->setNom(trim($key3->getNom()));
						$key3->setPrenom(trim($key3->getPrenom()));
						//$key3->setNom(str_replace(substr($key3->getNom(),0,1),strtoupper(substr($key3->getNom(),0,1)),$key3->getNom()));
						//$key3->setPrenom(str_replace(substr($key3->getPrenom(),0,1),strtoupper(substr($key3->getPrenom(),0,1)),$key3->getPrenom()));
						// on n'a pas pris en compte les noms et prenoms composés

						// le code au dessus va changer les répétions de la première lettre en majuscule aussi
						// essayer le code suivant

						/*
							$key3->setNom()

						*/


					}
				}
			}

			// on va appeller le validateur sur les événements avant la suppression des doublons du formulaire
			// pour envoyer un message d'erreur si il y a des doublons contacts au sein du même organisateur
			// il faudra enlever la validation des événements plus bas

			$test1 = 0 ; // est ici pour ne pas traité le premier événement qui est crée juste pour les for du rendu

			if($editmode)
			{
				$test1 = 1;
			}

			foreach($article->getEvenements() as $key)
			{
				if($test1 ==1)
				{
					$erreurValidation = $validator->validate($key);
						if (count($erreurValidation) > 0) {

							return $this->render('/site/form_article.html.twig'	,[
								'formArticle'=> $form2->createView() ,
								'editmode' => $editmode,
								'lieuDejaPrisForm' => $lieuDejaPrisForm,
								'lieuDejaPrisBd' => $lieuDejaPrisBd,
								'erreurValidation' => $erreurValidation,
								'erreurPeriode'	=>$erreurPeriode,
								]);
						}
				}
				$test1 =1;	
			}


			// les variable testi sont la pour ne pas prendre en compte le 1er événement ($event)
			// qui est là pour faciliter le rendu dans twig
			$test1 =0;
			$test2 =0;

			if($editmode)
			{
				$test1 = 1;
				$test2 = 1;
			}

			// on va effectuer des tests sur le lieu (lieu déja occupé ?)
			//lieu déja occupé dans les événements du formulaires ?
			//voir pour la complexité avec floriant si c'est important
			//ici on ne manipule pas beaucoups de données
			// mais si le serveur recoit beaucoup de requêtes
			// il faut peut être quand même voir si on n'abuse pas trop
		
			
			foreach($article->getEvenements() as $key)
			{
				if($test1 !=0)
				{
					foreach($article->getEvenements() as $key2)
					{
						if($test2 !=0)
						{
							//https://www.php.net/manual/fr/language.oop5.object-comparison.php
							//si ce n'est pas le même événement
							if($key !== $key2)
							{
								// si c'est le même lieu et avec le test d'avant on sait que c'est
								// deux événements différents
								if($key->getLieu() == $key2->getLieu())
								{
									foreach($key->getPeriode() as $key3)
									{
										foreach($key2->getPeriode() as $key4)
										{
											// un intervalle de temps en commun ?
											
											if($key3->isInSameTime($key4))
											{
												$lieuDejaPrisForm = "Les événements ".$key->getNom()." et ".$key2->getNom()." ont lieu au même endroit pendant un même intervaller de temps";

												return $this->render('/site/form_article.html.twig'	,[
													'formArticle'=> $form2->createView() ,
													'editmode' => $editmode,
													'lieuDejaPrisForm' => $lieuDejaPrisForm,
													'lieuDejaPrisBd' => $lieuDejaPrisBd,
													'erreurValidation' => $erreurValidation,
													'erreurPeriode'	=>$erreurPeriode,
													]);
											}

										}
									}
								}
							}
						}
						$test2=1;
					}
				}

				$test1 =1;
				$test2= 0;
				if($editmode)
				{
					$test2 = 1;
				}
			}
			
			// on va faire en sorte de ne pas insérer de doublons qui serait présent dans 
			//le formulaire 

			for($i =0 ; $i < count($article->getEvenements()) ; $i++)
			{
				//on va regarder si deux intervalles de temps sont identique
				foreach($article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->getPeriode() as $key)
				{
					//Il ne peut pas y avoir deux fois le même intervalle de temps
					// au sein du même événement , sinon on renvoie une erreur
					// de validation (validator appellé sur les événements plus loin)
					//(voir le Assert CallBack dans Evenement.php)

					for( $j =$i+1 ; $j <count($article->getEvenements()) ; $j++)
					{
						foreach($article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->getPeriode() as $key2)
						{
							if($key == $key2)
							{
								$article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->removePeriode($key2);
								$article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->addPeriode($key);
							}
						}
					}
				}

				// on va créer la liste de contacts des organisateurs et les rattacher à l'événement
				foreach($article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->getOrganisateurs() as $key)
				{
					$listeContact = new ListeContact();
					foreach($key->getContacts() as $key2)
					{
						$listeContact->addContact($key2);
					}
					$key->addListeContact($listeContact);
					$article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->addListesContact($listeContact);
				}
			}
			
			for($i =0 ; $i < count($article->getEvenements()) ; $i++)
			{
				// on va regarder si il y a plusieurs fois le même contact
				// situé chez des organisateurs différents (quelque soit l'événement)
				// et si il y a plusieurs fois le même organisateur
				//situé sur des événements différents

				// si un contact apparait plusierus fois chez le même organisateur
				// on doit sortir une erreur de validation plus loin
				// voir la validation plus loin et Evenement.php

				for($k=0 ; $k<count( $article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->getOrganisateurs() ) ; $k++)
				{

					// on va s'occuper des contacts 

					for( $j=$i ; $j<count($article->getEvenements()) ; $j++)
					{
						for($n=0 ; $n<count( $article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->getOrganisateurs() ) ; $n++)
						{
							if($i == $j && $k == $n)
							{
								//on est dans le même organisateur du même événement, on a rien à faire
								// il ne peut y avoir plusieurs fois le même contact (validation)
							}
							else
							{
								$orgaI = $article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->getOrganisateurs();
								$orgaJ = $article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->getOrganisateurs();
								foreach($orgaI[$orgaI->getKeys()[$k]]->getContacts() as $key)
								{
									// on en profite pour supprimer les espaces dans le numéro de téléphone
									//$key->setTelephone(str_replace(" ","",$key->getTelephone()));
									foreach($orgaJ[$orgaJ->getKeys()[$n]]->getContacts() as $key2)
									{
										//$key2->setTelephone(str_replace(" ","",$key2->getTelephone()));

										if($key == $key2)
										{
											$orgaJ[$orgaJ->getKeys()[$n]]->removeContact($key2);
											$orgaJ[$orgaJ->getKeys()[$n]]->addContact($key);

											// ne pas oublier de remove et add dans la seule (pour l'instant) liste des contacts de l'organisateur
											$orgaJ[$orgaJ->getKeys()[$n]]->getListeContact()[0]->removeContact($key2);
											$orgaJ[$orgaJ->getKeys()[$n]]->getListeContact()[0]->addContact($key);
										}
									}
								}
							}
						}
					}
					
					// on va s'occuper des organisateurs

					for( $j =$i+1 ; $j <count($article->getEvenements()) ; $j++)
					{
						for($n=0 ; $n<count( $article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->getOrganisateurs() ) ; $n++)
						{
							//https://www.php.net/manual/fr/language.oop5.references.php

							//les variables sont juste là pour plus de lisibilité
							$orgaI = $article->getEvenements()[$article->getEvenements()->getKeys()[$i]]->getOrganisateurs();
							$orgaJ = $article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->getOrganisateurs() ;

							// on va supposer que deux organisateurs différents ne peuvent pas avoir le même nom
							if($orgaI[$orgaI->getKeys()[$k]]->getNom() == $orgaJ[$orgaJ->getKeys()[$n]]->getNom())
							{
								// on n'oublie pas d'associer les contacts et les listes de contacts 

								foreach($orgaJ[$orgaJ->getKeys()[$n]]->getContacts() as $key)
								{
									$orgaI[$orgaI->getKeys()[$k]]->addContact($key);
								}
								// on rajoute la liste de contact du formulaire
								$orgaI[$orgaI->getKeys()[$k]]->addListeContact($orgaJ[$orgaJ->getKeys()[$n]]->getListeContact()[0]);

								$article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->removeOrganisateur($orgaJ[$orgaJ->getKeys()[$n]]);
								$article->getEvenements()[$article->getEvenements()->getKeys()[$j]]->addOrganisateur($orgaI[$orgaI->getKeys()[$k]]);
							}
						}
					}
				}
			}


			// la variable test est la pour ne pas prendre en compte le 1er événement ($event)
			// qui est là pour faciliter le rendu dans twig
			$test =0;
			if($editmode)
			{
				$test = 1;
			}
			foreach($article->getEvenements() as $key)
			{
				// il faudra rajouter la validation aussi et le test du lieu avant
				// attention pour le test du lieu , il faut le faire avec
				// les informations du formulaire en plus des infos qui sont en
				// base de données
				if($test !=0)
				{
					foreach($key->getPeriode() as $key2)
					{
						//on va valider 
						$erreurValidation = $validator->validate($key2);
						if (count($erreurValidation) > 0) {

							return $this->render('/site/form_article.html.twig'	,[
								'formArticle'=> $form2->createView() ,
								'editmode' => $editmode,
								'lieuDejaPrisForm' => $lieuDejaPrisForm,
								'lieuDejaPrisBd' => $lieuDejaPrisBd,
								'erreurValidation' => $erreurValidation,
								'erreurPeriode'	=>$erreurPeriode,
								]);
						}
						//on va faire en sorte de pas mettre de doublons dans la bd
						$periode2 = $repoPeriode->findOneBy([
							"debut"=>$key2->getDebut(),
							"fin"=>$key2->getFin()
						]);

						if($periode2 == null)
						{
							$manager->persist($key2);
						}
						else
						{
							$key->removePeriode($key2);
							$key->addPeriode($periode2);
						}
					}
					foreach($key->getOrganisateurs() as $key3)
					{
						foreach($key3->getContacts() as $key4)
						{
							//on va valider 
							$erreurValidation = $validator->validate($key4);
							if (count($erreurValidation) > 0) {

								return $this->render('/site/form_article.html.twig'	,[
									'formArticle'=> $form2->createView() ,
									'editmode' => $editmode,
									'lieuDejaPrisForm' => $lieuDejaPrisForm,
									'lieuDejaPrisBd' => $lieuDejaPrisBd,
									'erreurValidation' => $erreurValidation,
									'erreurPeriode'	=>$erreurPeriode,
									]);
							}
							//on va faire en sorte de pas mettre de doublons dans la bd
							$contact2 = $repoContact->findOneBy([
								"nom"=>$key4->getNom(),
								"prenom"=>$key4->getPrenom(),
								"mail"=>$key4->getMail(),
								"telephone"=>$key4->getTelephone()
							]);
							if($contact2 == null)
							{
								$manager->persist($key4);
							}
							else
							{
								$key3->removeContact($key4);
								$key3->addContact($contact2);

								// on va fait attention aux doublons dans les liste des contacts aussi
								foreach($key3->getListeContact() as $key5)
								{
									foreach($key5->getContact() as $key6)
									{
										if($key6 == $key4)
										{
											$key5->removeContact($key4);
											$key5->addContact($contact2);
										}
									}
								}

							}
						}
						
						

						//on va valider 
						$erreurValidation = $validator->validate($key3);
						if (count($erreurValidation) > 0) {

							return $this->render('/site/form_article.html.twig'	,[
								'formArticle'=> $form2->createView() ,
								'editmode' => $editmode,
								'lieuDejaPrisForm' => $lieuDejaPrisForm,
								'lieuDejaPrisBd' => $lieuDejaPrisBd,
								'erreurValidation' => $erreurValidation,
								'erreurPeriode'	=>$erreurPeriode,
								]);
						}
						//on va faire en sorte de pas mettre de doublons dans la bd

						$orga2 = $repoOrga->findOneBy([
							"nom"=>$key3->getNom(),
							"siteWeb"=>$key3->getSiteWeb(),
							"mail"=>$key3->getMail(),
							"image"=>$key3->getImage()
						]);
						if($orga2 == null)
						{
							// on va persist les listes de contacts

							foreach($key3->getListeContact() as $key4)
							{
								// j'ai eu une erreur me disant qu'une entité non persisté
								// avait été trouvé par la relation listeContact#Contact
								// j'ai du coup rajouté le persist pour les contacts dans la liste de contact
								foreach($key4->getContact() as $key5)
								{
									$manager->persist($key5);
								}
								//$key->addListesContact($key4);
								$manager->persist($key4);
							}
							$manager->persist($key3);
						}
						else
						{
							//l'organisateur existe déja en base de donné , donc
							// on va vérifier que notre liste de contact n'existe pas déja en base de donnée
							$listeContactKey3 = $repoListeContact->findOneBy([
								"organisateur_id"=>$key3->getId(),
								"evenement_id"=>$key->getId(),
							]);
							
							if($listeContactKey3 != null)
							{
								// on va enlever les contacts de cette liste
								//puis on va rajouter les contacts de la bonne liste

								foreach($listeContactKey3->getContact() as $key4)
								{
									$listeContactKey3->removeContact($key4);
								}

								foreach($key->getListesContact() as $key4)
								{
									if($key4->getOrganisateur()->getNom() == $key3->getNom())
									{
										foreach($key4->getContact() as $key5)
										{
											$listeContactKey3->addContact($key5);
										}

										$key4 = $listeContactKey3 ; // on garde l'ancient id comme ca
										
									}
								}
							}

							/*
							$listesContactKey3 = $repoListeContact->findBy([
								"organisateur_id"=>$key3->getId()
							]);

							$testListeContact1 = false;
							$testListeContact2 = true;

							// des while seraient plus appropriés. Il faudra voir l'optimisation du code car
							//on a vraimment abusé dans le controller
							foreach($listeContactKey3 as $key4)
							{

								foreach($key3->getListeContact() as $key5)
								{
									foreach($key5->getContact() as $key6)
									{
										foreach($key4->getContact() as $key7)
										{
											if($key7 == $key6)
											{
												$testListeContact1 = true;
											}
										}
										if($testListeContact1 == false)
										{
											$testListeContact2 = false;
										}
										$testListeContact1 = false;
									}
									if($testListeContact2)
									{
										$key5 = $key4;
									}
									$testListeContact2 = true;
								}
							}
							*/
							/* on rajoute les contacts dans la relation organisateur_contacts*/
							foreach($key3->getContacts() as $key4)
							{
								$orga2->addContact($key4);
							}

							// on rajoute les listes de contacts pour $orga2

							foreach($key3->getListeContact() as $key4)
							{
								$orga2->addListeContact($key4);


								// j'ai eu une erreur me disant qu'une entité non persisté
								// avait été trouvé par la relation listeContact#Contact
								// j'ai du coup rajouté le persist pour les contacts dans la liste de contact
								foreach($key4->getContact() as $key5)
								{
									$manager->persist($key5);
								}

								//$key->addListesContact($key4);
								$manager->persist($key4);
							}


							$key->removeOrganisateur($key3);
							$key->addOrganisateur($orga2);
						}
					}

					//on va valider 
					$erreurValidation = $validator->validate($key->getLieu());
					if (count($erreurValidation) > 0) {

						return $this->render('/site/form_article.html.twig'	,[
							'formArticle'=> $form2->createView() ,
							'editmode' => $editmode,
							'lieuDejaPrisForm' => $lieuDejaPrisForm,
							'lieuDejaPrisBd' => $lieuDejaPrisBd,
							'erreurValidation' => $erreurValidation,
							'erreurPeriode'	=>$erreurPeriode,
							]);
					}
					//on va faire en sorte de pas mettre de doublons dans la bd
					
					$lieu2 = $repoLieu->findOneBy([
						"ville" =>$key->getLieu()->getVille() ,
						"nom" => $key->getLieu()->getNom(),
						"adresse" => $key->getLieu()->getAdresse(),
						"codePostal" => $key->getLieu()->getCodePostal()
					]);

					if($lieu2 != null)
					{
							
						//on récupère les événements lié au lieu
						$evenements = $lieu2->getEvenement();

						//on fait en sorte de pas mettre de doublons dans la bd
						$key->setLieu($lieu2);

						//on va vérifier que le lieu n'est pas pris par un autre événements au même moment
						foreach($evenements as $key2)
						{
							if($key2->getId() != $key->getId())
							{

								foreach($key2->getPeriode() as $key3)
								{
									foreach($key->getPeriode() as $key4)
									{
										if($key3->isInSameTime($key4))
										{
											$lieuDejaPrisBd = "l'événement ".$key2->getNom()."qui est déja enregistré en base de donnée
											utilise déja ce lieu à un même créneau horaire , veuillez changer le lieu ou les créneaux horaires pour l'évenement
											".$key->getNom();

											return $this->render('/site/form_article.html.twig'	,[
												'formArticle'=> $form2->createView() ,
												'editmode' => $editmode,
												'lieuDejaPrisForm' => $lieuDejaPrisForm,
												'lieuDejaPrisBd' => $lieuDejaPrisBd,
												'erreurValidation' => $erreurValidation,
												'erreurPeriode'	=>$erreurPeriode,
												]);
										}
									}
								}

							}
						}
						
					}

					$manager->persist($key->getLieu());

					$key->setPublishedAt($article->getCreatedAt());
					$manager->persist($key);	
				}
				
				$test = 1;
			}
			if(!$editmode)
			{
				$article->removeEvenement($event);
			}

			$manager->persist($article);

			$manager->flush();
			//return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
			return $this->redirectToRoute('article');
		}


		return $this->render('/site/form_article.html.twig'	,[
			'formArticle'=> $form2->createView() ,
			'editmode' => $editmode,
			'lieuDejaPrisForm' => $lieuDejaPrisForm,
			'lieuDejaPrisBd' => $lieuDejaPrisBd,
			'erreurValidation' => $erreurValidation,
			'erreurPeriode'	=>$erreurPeriode,
			]);
			
	 }


	 
	/**
     * @Route("/createEvenement", name="createEvenement")
	 * @Route("/modifEvenement/{id}", name="modifEvenement")
     */
	 public function createEvenement( Evenement $evenement = null ,Request $request , ObjectManager $manager , LieuRepository $repoLieu , ContactRepository $repoContact , OrganisateurRepository $repoOrga , IntervalleTempsRepository $repoPeriode , ListeContactRepository $repoListeContact ,ValidatorInterface $validator)
	 {

		$editmode = true;
		if(!$evenement)
		{

			$evenement = new Evenement();

			$lieu = new Lieu();

			$evenement->setLieu($lieu);

			$periode1 = new IntervalleTemps();

			$organisateur = new Organisateur();

			/*$contact = new Contact();
			$organisateur->addContact($contact);*/

			$contact2 = $organisateur->getContacts();

			$evenement->addOrganisateur($organisateur);

			$evenement->addPeriode($periode1);

			$editmode = false;

		}
		else
		{
			$lieu = $evenement->getLieu();
		}

		$errors = null;
		$erreurDejaPris = null;
		$erreurPeriode = null;

		$form2 = $this->createForm(FormEvenementType::class , $evenement);

		$form2->handleRequest($request);
		if($form2->isSubmitted() && $form2->isValid())
		{
			if($evenement->getId() == null)
			{
				$evenement->setPublishedAt(new \DateTime( "now" , new \DateTimeZone("Europe/Paris")));
			}

			// on va modifier un peu la saisie de l'utilisateur
			
			foreach($evenement->getOrganisateurs() as $key)
			{
				foreach($key->getContacts() as $key2)
				{
					$key2->setTelephone(str_replace(" ","",$key2->getTelephone()));
					$key2->setNom(trim($key2->getNom()));
					$key2->setPrenom(trim($key2->getPrenom()));
					/*$key2->setNom(str_replace(substr($key2->getNom(),0,1),strtoupper(substr($key2->getNom(),0,1)),$key2->getNom()));
					$key2->setPrenom(str_replace(substr($key2->getPrenom(),0,1),strtoupper(substr($key2->getPrenom(),0,1)),$key2->getPrenom()));
					*/
				}
			}
			
			
			$errors = $validator->validate($lieu);
			if (count($errors) > 0) {

				return $this->render('/site/form_evenement.html.twig'	,[
					'formEvenement'=> $form2->createView() ,
					'editmode' => $editmode, 
				   'errors' => $errors ,
				   'erreurDejaPris' =>$erreurDejaPris,
				   'erreurPeriode' => $erreurPeriode ,
				]);
			}
			
			/*	On vérifie que $lieu n'est pas déja enregistré dans la base de données */
			$lieu2 = $repoLieu->findOneBy([
				"ville" =>$lieu->getVille() ,
				"nom" => $lieu->getNom(),
				"adresse" => $lieu->getAdresse(),
				"codePostal" => $lieu->getCodePostal()
			]);
			/* Il va falloir voir au niveau de la validation des champs de lieu (à faire dans Lieu.php) (voir si on peut pas utiliser des 
				expressions régulières)*/

			$lieuDejaPris = false;
			if($lieu2 == null)
			{
				$manager->persist($lieu);
			}
			else 
			{
				$evenement->setLieu($lieu2)	;
				/* On va vérifier si le lieu sert déja de lieu d'événement déja enregistré pendant une
				des périodes de l'événement qu'on essaye d'enregistrer.*/
				$evenements= $lieu2->getEvenement();

				/* des whiles sont plus adapté car des que $lieuDejaPris = true on peut sortir*/
				$nomEvenement = null;
				foreach($evenements as $key)
				{
					/*if($editmode)
					{
						$eveId = $evenement->getId();
					}*/
					// il ne faut pas tester si on modifie et que $key est le même événement
					if($key->getId() != $evenement->getId())
					{
						foreach($evenement->getPeriode() as $key2)
						{
							foreach($key->getPeriode() as $key3)
							{
								if($key2->isInSameTime($key3))
								{
									$nomEvenement = $key->getNom();
									$lieuDejaPris= true;
								}
							}
						}
					}	
					
				}
			}

			if($lieuDejaPris)
			{
				// il faut voir quoi faire ici , pour l'instant on va juste afficher une erreur'
				// Indiquer un message sur la page du formulaire pour dire à l'utilisateur ce qui ne passe pas'
				$erreurDejaPris = "l'évenement: ".$nomEvenement." utilise déja le lieu dans un même créneau horaire";
				return $this->render('/site/form_evenement.html.twig'	,[
					'formEvenement'=> $form2->createView() ,
					'editmode' => $editmode, 
				   'errors' => $errors ,
				   'erreurDejaPris' =>$erreurDejaPris,
				   'erreurPeriode' => $erreurPeriode ,
				]);
				
			}
			else 
			{
				
				// on va faire en sorte de ne pas insérer les doublons qui sont dans le formulaire

				for ($i =0 ; $i < count($evenement->getOrganisateurs()) ; $i++)
				{
					/* je n'ai pas compris le code que j'ai fais qui est en commentaire
					juste en dessous si il y a deux fois le même organisateur dans l'événement , c'est
					une erreur de validation que le validateur indiquera
					je le laisse en commentaire pour le moment , mais si jamais il n'y a pas de bug ,
					il faudra l'enlever
					je pense que j'avais copier le code de createArticle et que je l'ai mal
					adapté

					*/

					/*for($j = $i+1 ; $j < count($evenement->getOrganisateurs()) ; $j++ )
					{
						if($evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$i]]->getNom() == $evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$j]]->getNom() )
						{
							$evenement->removeOrganisateur($evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$j]]);
							$evenement->addOrganisateur($evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$i]]);
						}
					}*/

					foreach($evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$i]]->getContacts() as $key)
					{
						for($j = $i+1 ; $j < count($evenement->getOrganisateurs()) ; $j++ )
						{

							foreach($evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$j]]->getContacts() as $key2)
							{
								if($key == $key2)
								{
									$evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$j]]->removeContact($key2);
									$evenement->getOrganisateurs()[$evenement->getOrganisateurs()->getKeys()[$j]]->addContact($key);

									// ici on ne s'occupe pas des listes de contact des organisateurs pour l'instant car il ne peut y avoir 
									//plusieurs fois le même organisateur dans l'événement et donc 
									// il ne peut y avoir qu'une seule liste de contact pour l'organisateur <==> organisateur->getContacts()
								}
							}

						}


					}

					

				}

				foreach($evenement->getPeriode() as $key )
				{
					$errors = $validator->validate($key);
					if (count($errors) > 0) {

						return $this->render('/site/form_evenement.html.twig'	,[
							'formEvenement'=> $form2->createView() ,
							'editmode' => $editmode, 
						   'errors' => $errors ,
						   'erreurDejaPris' =>$erreurDejaPris,
						   'erreurPeriode' => $erreurPeriode ,
							]);
					}

					//on va faire en sorte de pas mettre de doublons dans la bd
					$periode2 = $repoPeriode->findOneBy([
						"debut"=>$key->getDebut(),
						"fin"=>$key->getFin()
					]);

					if($periode2 == null)
					{
						$manager->persist($key);
					}
					else
					{
						$evenement->removePeriode($key);
						$evenement->addPeriode($periode2);
					}
					
				}

				
				foreach($evenement->getOrganisateurs() as $key )
				{
					$errors = $validator->validate($key);
					if (count($errors) > 0) {

						return $this->render('/site/form_evenement.html.twig'	,[
							'formEvenement'=> $form2->createView() ,
							'editmode' => $editmode, 
						   'errors' => $errors ,
						   'erreurDejaPris' =>$erreurDejaPris,
						   'erreurPeriode' => $erreurPeriode ,
						]);
					}
					
					// on va vérifier les contacts et créer la liste de contact de l'organisateur

					$listeContact = new ListeContact();

					foreach($key->getContacts() as $key2)
					{
						$errors = $validator->validate($key2);
						if (count($errors) > 0) {

							return $this->render('/site/form_evenement.html.twig'	,[
								'formEvenement'=> $form2->createView() ,
								'editmode' => $editmode, 
							   'errors' => $errors ,
							   'erreurDejaPris' =>$erreurDejaPris,
							   'erreurPeriode' => $erreurPeriode ,
								]);
						}
						
						//on va faire en sorte de pas mettre de doublons dans la bd
						$contact2 = $repoContact->findOneBy([
							"nom"=>$key2->getNom(),
							"prenom"=>$key2->getPrenom(),
							"mail"=>$key2->getMail(),
							"telephone"=>$key2->getTelephone()
						]);
						if($contact2 == null)
						{
							$manager->persist($key2);
							$listeContact->addContact($key2);
						}
						else
						{
							$key->removeContact($key2);
							$key->addContact($contact2);
							$listeContact->addContact($contact2);
						}
						
						
					}

					//on va faire en sorte de pas mettre de doublons dans la bd

					$orga2 = $repoOrga->findOneBy([
						"nom"=>$key->getNom(),
						"siteWeb"=>$key->getSiteWeb(),
						"mail"=>$key->getMail(),
						"image"=>$key->getImage()
					]);
					if($orga2 == null)
					{
						$evenement->addListesContact($listeContact);
						$key->addListeContact($listeContact);
						$manager->persist($listeContact);
						$manager->persist($key);
					}
					else
					{
						//l'organisateur existe déja en base de donné , donc
						// on va vérifier que notre liste de contact n'existe pas déja en base de donnée
						$listeContactKey3 = $repoListeContact->findOneBy([
							"organisateur_id"=>$key->getId(),
							"evenement_id"=>$evenement->getId(),
						]);
						
						if($listeContactKey3 != null)
						{
							// on va enlever les contacts de cette liste
							//puis on va rajouter les contacts de la bonne liste
							/*foreach($listeContactKey3->getContact() as $key4)
							{
								$listeContactKey3->removeContact($key4);
							}
							foreach($evenement->getListesContact() as $key4)
							{
								if($key4->getOrganisateur()->getNom() == $key->getNom())
								{*/
									foreach($listeContact->getContact() as $key5)
									{
										$listeContactKey3->addContact($key5);
									}

									$listeContact = $listeContactKey3 ; // on garde l'ancient id comme ca
								/*		
								}
							}*/
						}
						/*

						$listesContactKey = $repoListeContact->findBy([
							"organisateur"=>$key->getId()
						]);

						$testListeContact1 = false;
						$testListeContact2 = true;

						// des while seraient plus appropriés. Il faudra voir l'optimisation du code car
						//on a vraimment abusé dans le controller
						foreach($listesContactKey as $key2)
						{
							foreach($listeContact->getContact() as $key3)
							{
								foreach($key->getContact() as $key4)
								{
									if($key4 == $key3)
									{
										$testListeContact1 = true;
									}
								}
								if($testListeContact1 == false)
								{
									$testListeContact2 = false;
								}
								$testListeContact1 = false;
							}
							if($testListeContact2)
							{
								$listeContact = $key2;
							}
							$testListeContact2 = true;
						}
						*/

						/* on rajoute les contacts dans dans la relation organisateur_contacts*/
						foreach($key->getContacts() as $key2)
						{
							$orga2->addContact($key2);
						}

						$evenement->addListesContact($listeContact);
						$evenement->removeOrganisateur($key);
						$orga2->addListeContact($listeContact);
						$evenement->addOrganisateur($orga2);
						$manager->persist($listeContact);
						$manager->persist($orga2);
					}
					
				}

				//on va vérifier que les intervalles de temps pour l'événement sont bien disjoint

				for($i =0 ; $i< count($evenement->getPeriode()) ; $i++)
				{
					if($i != count($evenement->getPeriode()) -1)
					{
						for($j=$i+1 ; $j<count($evenement->getPeriode()) ; $j++)
						{
							/*//if($evenement->getPeriode()[$i]->isInSameTime($evenement->getPeriode()[$j]))
							//{
								//echo get_class($evenement->getPeriode()[1]);
								//echo count($evenement->getPeriode());
								//echo $evenement->getPeriode()[0]->getDebut()->format('d/m/Y');
								$erreurPeriode = "deux intervalles de temps pour l'événement ".$evenement->getNom()." partagent un même créneau horaire ".$evenement->getPeriode()->getKeys()[1];
								return $this->render('/site/form_evenement.html.twig'	,[
									'formEvenement'=> $form2->createView() ,
									'editmode' => false, 
								   'errors' => $errors ,
								   'erreurDejaPris' =>$erreurDejaPris,
								   'erreurPeriode' => $erreurPeriode ,
									]);
							//}*/

							/*if($evenement->getPeriode()[$evenement->getPeriode()->getKeys()[$i]]->isInSameTime($evenement->getPeriode()[$evenement->getPeriode()->getKeys()[$j]]))
							{
								$erreurPeriode = "deux intervalles de temps pour l'événement ".$evenement->getNom()." partagent un même créneau horaire ";
								return $this->render('/site/form_evenement.html.twig'	,[
									'formEvenement'=> $form2->createView() ,
									'editmode' => false, 
								   'errors' => $errors ,
								   'erreurDejaPris' =>$erreurDejaPris,
								   'erreurPeriode' => $erreurPeriode ,
									]);
							}*/
						}
					}

				}

				$manager->persist($evenement);
				$manager->flush();
				return $this->redirectToRoute('evenement');
				//return $this->redirectToRoute('blog_show',['id' => $article->getId()]);*/
			}
		}
		return $this->render('/site/form_evenement.html.twig'	,[
			'formEvenement'=> $form2->createView() ,
			'editmode' => $editmode, 
		   'errors' => $errors ,
		   'erreurDejaPris' =>$erreurDejaPris,
		   'erreurPeriode' => $erreurPeriode ,
			]);
			
	 }

	 /**
     * @Route("/show_evenement/{id}", name="show_evenement")
     */
	 public function showEvenement(EvenementRepository $repository,$id)
	 {
		$evenement = $repository->find($id);
		return $this->render('site/show_evenement.html.twig',[ 'evenement'=> $evenement ]);
	 }

	 /**
     * @Route("/show_article/{id}", name="show_article")
     */
	public function showArticle(ArticleRepository $repository,$id)
	{
	   $article = $repository->find($id);
	   return $this->render('site/show_article.html.twig',[ 'article'=> $article ]);
	}

	 /**
     * @Route("/erreur/", name="erreur")
     */
	 public function erreur($mess)
	 {
		return $this->render('site/erreur.html.twig',[ 'mess'=> $mess ]);
	 }

	 /**
     * @Route("/suppression_evenement/", name="suppression_evenement")
     */
	 public function suppression_evenement(Request $request , ObjectManager $manager , LieuRepository $repoLieu)
	 {

		$evenement = new Evenement();

		$form2 = $this->createForm(FormEvenementType::class , $evenement);

		$form2->handleRequest($request);

		// on ne vas pas faire de validation du formulaire
		//car si ce n'est pas valide alors le repo trouvera rien
		if($form2->isSubmitted())
		{
			/* ici il va falloir voir qu'elle champ est vide ou non pour savoir ce qu'on supprime
			en base de donné */


			/*il faudra renvoyer sur une page qui indique combien d'événements ont été supprimé */ 

		}




		return $this->render('site/suppression_evenement.html.twig',[
								'formEvenement'=> $form2->createView(),
							]);
	 }

	  /**
     * @Route("/suppression_article/", name="suppression_article")
     */
	 public function suppression_article()
	 {
		

		return $this->render('site/suppression_article.html.twig');
	 }

	 /**
     * @Route("/suppression_show_article/{id}", name="suppression_show_article")
     */
	public function suppression_show_article(ArticleRepository $repository,$id, ObjectManager $manager)
	{
		$article = $repository->find($id);

		$manager->remove($article);

		$manager->flush();

	   return $this->render('site/accueil.html.twig');
	}

	/**
     * @Route("/suppression_show_evenement/{id}", name="suppression_show_evenement")
     */
	public function suppression_show_evenement(EvenementRepository $repository,$id, ObjectManager $manager)
	{
		$evenement = $repository->find($id);

		$manager->remove($evenement);

		$manager->flush();

	   return $this->render('site/accueil.html.twig');
	}


}
