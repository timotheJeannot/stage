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

	/**
     * @Route("/createArticle", name="createArticle")
     */
	 public function createArticle(Request $request , ObjectManager $manager)
	 {
		$article = new Article();

		/*$form = $this->createFormBuilder($article);

		$form ->add('titre',TextType::class , 
				[
					'attr'=>
					[
						'placeholder' =>'Titre de l\'article',
						'class' => 'form-control'
					]
				])
			 ->add('image',TextType::class, 
				[
					'attr'=>
					[
						'placeholder' =>'Image de l\'article',
						'class' => 'form-control'
					]
				])
			 ->add('contenu', TextareaType::class,
				[
					'attr'=>
					[
						'placeholder' =>'Contenue de l\'article',
						'class' => 'form-control'
					]
				]);*/

		$form2 = $this->createForm(FormArticleType::class , $article);


		//$form2 =$form->getForm();
		$form2->handleRequest($request);
		//dumb($article) ;

		if($form2->isSubmitted() && $form2->isValid())
		{
			if($article->getId() == null)
			{
				$article->setCreatedAt(new \DateTime( "now" , new \DateTimeZone("Europe/Paris")));
			}

			$manager->persist($article);
			$manager->flush();
			//return $this->redirectToRoute('blog_show',['id' => $article->getId()]);
			return $this->redirectToRoute('article');
		}

	 	 return $this->render('/site/form_article.html.twig'	,[
		 'formArticle'=> $form2->createView() ,
		 'editmode' => false
		 ]);
			
	 }


	 
	/**
     * @Route("/createEvenement", name="createEvenement")
     */
	 public function createEvenement(Request $request , ObjectManager $manager , LieuRepository $repoLieu , ValidatorInterface $validator)
	 {
		$evenement = new Evenement();

		$lieu = new Lieu();

		$evenement->setLieu($lieu);

		$periode1 = new IntervalleTemps();

		$organisateur = new Organisateur();

		/*$contact = new Contact();

		$organisateur->addContact($contact);*/

		$evenement->addOrganisateur($organisateur);

		$evenement->addPeriode($periode1);

		$errors = null;
		$erreurDejaPris = null;

		$form2 = $this->createForm(FormEvenementType::class , $evenement);

		$form2->handleRequest($request);
		if($form2->isSubmitted() && $form2->isValid())
		{
			if($evenement->getId() == null)
			{
				$evenement->setPublishedAt(new \DateTime( "now" , new \DateTimeZone("Europe/Paris")));
			}
			
			$errors = $validator->validate($lieu);
			if (count($errors) > 0) {

				return $this->render('/site/form_evenement.html.twig'	,[
				'formEvenement'=> $form2->createView() ,
				'editmode' => false , 
				'errors' => $errors,
				'erreurDejaPris' =>$erreurDejaPris
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

			if($lieuDejaPris)
			{
				// il faut voir quoi faire ici , pour l'instant on va juste afficher une erreur'
				// Indiquer un message sur la page du formulaire pour dire à l'utilisateur ce qui ne passe pas'
				$erreurDejaPris = "l'évenement: ".$nomEvenement." utilise déja le lieu dans un même créneau horaire";
				return $this->render('/site/form_evenement.html.twig'	,[
						 'formEvenement'=> $form2->createView() ,
						 'editmode' => false , 
						 'errors' => $errors ,
						 'erreurDejaPris' =>$erreurDejaPris
						 ]);
				
			}
			else 
			{
				foreach($evenement->getPeriode() as $key )
				{
					$errors = $validator->validate($key);
					if (count($errors) > 0) {

						return $this->render('/site/form_evenement.html.twig'	,[
						 'formEvenement'=> $form2->createView() ,
						 'editmode' => false , 
						 'errors' => $errors,
						 'erreurDejaPris' =>$erreurDejaPris
						 ]);
					}
					$manager->persist($key);
				}


				// il faudra changer pour le contact une fois qu'on aura fait l'insertion
				// dynamique de formulaire
				$errors = $validator->validate($contact);
				if (count($errors) > 0) {

					return $this->render('/site/form_evenement.html.twig'	,[
					'formEvenement'=> $form2->createView() ,
					'editmode' => false , 
					'errors' => $errors,
					'erreurDejaPris' =>$erreurDejaPris
					]);
				}
				$manager->persist($contact);
				foreach($evenement->getOrganisateurs() as $key )
				{
					$errors = $validator->validate($key);
					if (count($errors) > 0) {

						return $this->render('/site/form_evenement.html.twig'	,[
						 'formEvenement'=> $form2->createView() ,
						 'editmode' => false , 
						 'errors' => $errors ,
						 'erreurDejaPris' =>$erreurDejaPris
						 ]);
					}
					$manager->persist($key);
				}
				$manager->persist($evenement);
				$manager->flush();
				return $this->redirectToRoute('evenement');
				//return $this->redirectToRoute('blog_show',['id' => $article->getId()]);*/
			}
		}
	 	 return $this->render('/site/form_evenement.html.twig'	,[
		 'formEvenement'=> $form2->createView() ,
		 'editmode' => false, 
		'errors' => $errors ,
		'erreurDejaPris' =>$erreurDejaPris
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
     * @Route("/erreur/", name="erreur")
     */
	 public function erreur($mess)
	 {
		return $this->render('site/erreur.html.twig',[ 'mess'=> $mess ]);
	 }
}
