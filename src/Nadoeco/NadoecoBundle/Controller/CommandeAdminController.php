<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Nadoeco\NadoecoBundle\Entity\Commandes;
use Nadoeco\NadoecoBundle\Form\UtilisateursAdressesType;
use Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommandeAdminController extends Controller
{
    public function commandesAction(){
        $em = $this->getDoctrine()->getManager();
        $commandes= $em->getRepository('NadoecoNadoecoBundle:commandes')->findAll();
        return $this->render('NadoecoNadoecoBundle:administration:commandes/layout/index.html.twig', array('commandes'=>$commandes));
    }
    public function showFactureAction($id){
        $facture = $this->getDoctrine()->getManager()->getRepository('NadoecoNadoecoBundle:Commandes')->find($id);
        if(!$facture){
            $this->get('session')->getFlashBag()->add('error','la requete n\'est pas trés bien éxécuté');
            return $this->redirect($this->generateUrl('adminCommandes'));
        }

        $html2pdf = $this->container->get('setNewFacture')->facture($facture);
        $html2pdf->Output('facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type','application/Pdf');
        return $response;
    }
}