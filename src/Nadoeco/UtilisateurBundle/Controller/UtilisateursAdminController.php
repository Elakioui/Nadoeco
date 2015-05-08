<?php

namespace Nadoeco\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UtilisateursAdminController extends Controller
{
    public function indexAction()
    {
        $utilisateurs = $this->getDoctrine()->getManager()->getRepository('NadoecoUtilisateurBundle:Utilisateur')->findAll();
        return $this->render('NadoecoUtilisateurBundle:administration:utilisateurs/layout/index.html.twig',array('utilisateurs'=>$utilisateurs));
    }
    public function utilisateurAction($id){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository('NadoecoUtilisateurBundle:Utilisateur')->find($id);
        $route = $this->container->get('request')->get('_route');
        if($route == 'adminAdressesUtilisateur')
           return $this->render('NadoecoUtilisateurBundle:administration:utilisateurs/layout/adresses.html.twig',array('utilisateur'=>$utilisateur));
         else if($route =='adminFacturesUtilisateur'){
            return $this->render('NadoecoUtilisateurBundle:administration:utilisateurs/layout/factures.html.twig',array('utilisateur'=>$utilisateur));

        }
        else throw $this->createNotFoundException('la vue n\'existe pas');


    }

}
