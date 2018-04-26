<?php
// src/NRX/PlatformBundle/Controller/AdvertController.php

namespace NRX\PlatformBundle\Controller;

// On va utiliser l'objet Controller et Response
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use NRX\PlatformBundle\Entity\Advert;


// On hérite AdvertController (notre controleur) à Controller (controleur de Symfony)
class AdvertController extends Controller
{	  
	  public function indexAction($page)
	  {
			// Notre liste d'annonce en dur
			$listAdverts = array(
				array(
					'title'   => 'Recherche développpeur Symfony2',
					'id'      => 1,
					'author'  => 'Alexandre',
					'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
					'date'    => new \Datetime()),
				array(
					'title'   => 'Mission de webmaster',
					'id'      => 2,
					'author'  => 'Hugo',
					'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
					'date'    => new \Datetime()),
				array(
					'title'   => 'Offre de stage webdesigner',
					'id'      => 3,
					'author'  => 'Mathieu',
					'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
					'date'    => new \Datetime())
			);
	
			// Et modifiez le 2nd argument pour injecter notre liste
			return $this->render('NRXPlatformBundle:Advert:index.html.twig', array(
				'listAdverts' => $listAdverts
			));
	  }
	
	  public function viewAction($id)
	  {

    // On récupère le repository
    $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('NRXPlatformBundle:Advert')
    ;

    // On récupère l'entité correspondante à l'id $id
    $advert = $repository->find($id);

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('NRXPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert
    ));
  

	  }
	
	  public function addAction(Request $request)
	  {
		// La gestion d'un formulaire est particulière, mais l'idée est la suivante :
	
		// Si la requête est en POST, c'est que le visiteur a soumis le formulaire
		/*if ($request->isMethod('POST')) {
		  // Ici, on s'occupera de la création et de la gestion du formulaire
	
		  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
	
		  // Puis on redirige vers la page de visualisation de cettte annonce
		  return $this->redirectToRoute('oc_platform_view', array('id' => 5));
		  
		 
			// Si on n'est pas en POST, alors on affiche le formulaire
			return $this->render('NRXPlatformBundle:Advert:add.html.twig');
			} 
			*/
		  // On récupère le service
		/*  $antispam = $this->container->get('oc_platform.antispam');

		  // Je pars du principe que $text contient le texte d'un message quelconque
		  $text = '...';
		  if ($antispam->isSpam($text)) {
			throw new \Exception('Votre message a été détecté comme spam !');
		  }*/
		  
		  // Ici le message n'est pas un spam

		  
			// Création de l'entité
			/*$advert = new Advert();
			$advert->setTitle('Recherche développeur Symfony.');
			$advert->setAuthor('Alexandre');
			$advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");
			// On peut ne pas définir ni la date ni la publication,
			// car ces attributs sont définis automatiquement dans le constructeur
		
			// On récupère l'EntityManager
			$em = $this->getDoctrine()->getManager();
		
			// Étape 1 : On « persiste » l'entité
			$em->persist($advert);
		
			// Étape 2 : On « flush » tout ce qui a été persisté avant
			$em->flush();
		
			// Reste de la méthode qu'on avait déjà écrit
			if ($request->isMethod('POST')) {
			  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
		
			  // Puis on redirige vers la page de visualisation de cettte annonce
			  return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
			}
		
			// Si on n'est pas en POST, alors on affiche le formulaire
			return $this->render('NRXPlatformBundle:Advert:add.html.twig', array('advert' => $advert));*/
			$em = $this->getDoctrine()->getManager();

			// On crée une nouvelle annonce
			/*$advert1 = new Advert;
			$advert1->setTitle('Recherche développeur.');
			$advert1->setContent("Pour mission courte");
			$advert1->setAuthor("moi");
			// Et on le persiste
			$em->persist($advert1);*/

			// On récupère l'annonce d'id 5. On n'a pas encore vu cette méthode find(),
			// mais elle est simple à comprendre. Pas de panique, on la voit en détail
			// dans un prochain chapitre dédié aux repositories
			$advert2 = $em->getRepository('NRXPlatformBundle:Advert')->find(5);

			// On modifie cette annonce, en changeant la date à la date d'aujourd'hui
			$advert2->setDate(new \Datetime());

			// Ici, pas besoin de faire un persist() sur $advert2. En effet, comme on a
			// récupéré cette annonce via Doctrine, il sait déjà qu'il doit gérer cette
			// entité. Rappelez-vous, un persist ne sert qu'à donner la responsabilité
			// de l'objet à Doctrine.

			// Enfin, on applique les deux changements à la base de données :
			// Un INSERT INTO pour ajouter $advert1
			// Et un UPDATE pour mettre à jour la date de $advert2
			$em->flush();
			
			// Reste de la méthode qu'on avait déjà écrit
			if ($request->isMethod('POST')) {
				$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
		  
				// Puis on redirige vers la page de visualisation de cettte annonce
				return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
			  }
		  
			  // Si on n'est pas en POST, alors on affiche le formulaire
			  return $this->render('NRXPlatformBundle:Advert:add.html.twig');
		}
	
	
	  public function editAction($id, Request $request)
	  {
			$advert = array(
				'title'   => 'Recherche développpeur Symfony',
				'id'      => $id,
				'author'  => 'Alexandre',
				'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
				'date'    => new \Datetime()
			);
	
			return $this->render('NRXPlatformBundle:Advert:edit.html.twig', array(
				'advert' => $advert
			));
	  }
	
	  public function deleteAction($id)
	  {
		// Ici, on récupérera l'annonce correspondant à $id
	
		// Ici, on gérera la suppression de l'annonce en question
	
		return $this->render('NRXPlatformBundle:Advert:delete.html.twig');
		}
		
		public function menuAction()
		{
			// On fixe en dur une liste ici, bien entendu par la suite
			// on la récupérera depuis la BDD !
			$listAdverts = array(
				array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
				array('id' => 5, 'title' => 'Mission de webmaster'),
				array('id' => 9, 'title' => 'Offre de stage webdesigner')
			);

			return $this->render('NRXPlatformBundle:Advert:menu.html.twig', array(
				// Tout l'intérêt est ici : le contrôleur passe
				// les variables nécessaires au template !
				'listAdverts' => $listAdverts
			));
		}
}
?>