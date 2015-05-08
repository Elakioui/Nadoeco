<?php

namespace Nadoeco\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UtilisateursController extends Controller
{

    public function villesAction(Request $request, $cp){
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $villeCodePostale = $em->getRepository('NadoecoUtilisateurBundle:Villes')->findBy(array('villeCodePostal'=>$cp));
            if($villeCodePostale){
                $nomsVilles = array();
                foreach($villeCodePostale as $ville)
                    $nomsVilles[] = $ville->getVilleNom();
            }else{
                $nomsVilles = null;
            }
            //var_dump($nomsVilles);
            //die();

            $jsonResponse = new JsonResponse();
            return $jsonResponse->setData(array('villes'=> $nomsVilles));
        }else{
            throw new \Exception('Error');
        }

    }
    public function facturesAction()
    {

        $factures = $this->getDoctrine()->getManager()->getRepository('NadoecoNadoecoBundle:Commandes')->byFactures($this->getUser());

        return $this->render('NadoecoUtilisateurBundle:Default:layout/facture.html.twig',array('factures'=>$factures));
    }
    public function facturesPDFAction($id){
        $facture = $this->getDoctrine()->getManager()->getRepository('NadoecoNadoecoBundle:Commandes')
                                          ->findOneBy(array('utilisateur'=>$this->getUser(),
                                                            'valider'=>'1',
                                                             'id'=> $id
                                              ));
        if(!$facture){
            $this->get('session')->getFlashBag()->add('error','la requete n\'est pas trés bien éxécuté');
            return $this->redirect($this->generateUrl('factures'));
        }
        $html2pdf = $this->container->get('setNewFacture')->facture($facture);
        $html2pdf->Output('facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type','application/Pdf');
        return $response;

    }

}
