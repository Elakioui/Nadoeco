<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Nadoeco\NadoecoBundle\Form\UtilisateursAdressesType;
use Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanierController extends Controller
{
    public function menuAction(){
        $session = $this->getRequest()->getSession();
        if(!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        return $this->render('NadoecoNadoecoBundle:default:panier/modulesUsed/panier.html.twig',array('articles'=>$articles));

    }

    public function  ajouterAction($id)
    {
        $session = $this->getRequest()->getSession();

        if(!$session->has('panier')) $session->set('panier',array());

        $panier = $session->get('panier');
        // die('hfhhhfjjdjls');
        if(array_key_exists($id,$panier))
        {

            if($this->getRequest()->query->get('qte') != null){
                $panier[$id] = $this->getRequest()->query->get('qte');
            }else{
                $panier[$id] = $panier[$id] + 1;
            }
        }else{
            if($this->getRequest()->query->get('qte') != null){
                $panier[$id] = $this->getRequest()->query->get('qte');
            }else{
                $panier[$id] = 1;
                $this->get('session')->getFlashBag()->add('success','Le produit  ajouté avec succée');
            }

        }
        $session->set('panier',$panier);

        return $this->redirect($this->generateUrl('panier'));
    }
    public function  supprimerAction($id)
    {
        //die('supprimer');

        $session = $this->getRequest()->getSession();
        $panier = $session->get('panier');
        if(array_key_exists($id ,$panier)){
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Le produit  supprimé avec succée');
        }

        return $this->redirect($this->generateUrl('panier'));
    }
    //panier
    public function panierAction()
    {
        $session = $this->getRequest()->getSession();
        if(!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('NadoecoNadoecoBundle:Produits')->findArray(array_keys($panier));
        return $this->render('NadoecoNadoecoBundle:default:panier/layout/panier.html.twig',array('produits'=>$produits,
            'panier'=>$panier));
    }

    public function adresseSuppressionAction($id){
        $em = $this->getDoctrine()->getManager();
        $Utilisateuradresse = $em->getRepository('NadoecoUtilisateurBundle:UtilisateursAdresses')->find($id);
        $em->remove($Utilisateuradresse);
        $em->flush();
        return $this->redirect($this->generateUrl('livraison'));
    }


    public function livraisonAction()
    {
        $request = $this->getRequest();
        //echo $request->getLocale();
        //die();
        $message = $this->container->get('translator')->trans('text.hey');
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->container->get('security.context')->getToken()->getUser();
        $entity = new UtilisateursAdresses();
        $form = $this->createForm(new UtilisateursAdressesType($em),$entity);
        if($this->get('request')->getMethod() == 'POST'){
            $form->handleRequest($this->get('request'));
            if($form->isValid()){
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('livraison'));
            }
        }

        return $this->render('NadoecoNadoecoBundle:default:panier/layout/livraison.html.twig',array('utilisateur'=>$utilisateur,'form'=>$form->createView(),
                                                                                                    'message'=> $message));
    }
    public function setLivraisonSession()
    {
        $session = $this->getRequest()->getSession();
        if(!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');
        if($this->getRequest()->request->get('livraison')!= null && $this->getRequest()->request->get('facturation')!= null){
            $adresse['livraison']   = $this->getRequest()->request->get('livraison');
            $adresse['facturation'] = $this->getRequest()->request->get('facturation');
        }else{
            return $this->redirect($this->generateUrl('livraison'));
        }
        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }
    public function validationAction()
    {
        if($this->getRequest()->getMethod()=='POST')
            $this->setLivraisonSession();
        $prepareCommande = $this->forward('NadoecoNadoecoBundle:Commande:prepareCommande');
        $em       = $this->getDoctrine()->getManager();;
        $commande = $em->getRepository('NadoecoNadoecoBundle:Commandes')->find($prepareCommande->getContent());


        return $this->render('NadoecoNadoecoBundle:default:panier/layout/validation.html.twig',array('commande'=>$commande));

    }

}
