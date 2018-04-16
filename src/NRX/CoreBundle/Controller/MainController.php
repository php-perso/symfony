<?php

namespace NRX\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('NRXCoreBundle:Main:index.html.twig');
    }

    public function contactAction(Request $request)
    {
        $session = $request->getSession();
    
        $session->getFlashBag()->add('info', 'La page de contact n\'est pas disponible, merci de revenir plus tard');

        return $this->redirectToRoute('nrx_core_home');
        //return $this->render('NRXCoreBundle:Main:index.html.twig');
    }
}
