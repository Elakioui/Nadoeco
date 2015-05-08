<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Nadoeco\NadoecoBundle\Entity\Categories;
use Nadoeco\NadoecoBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProduitsController extends Controller
{
    public function produitsAction(Categories $categorie = null)
    {
        $array = array(1,2,2,3);
        dump($array,$this->getDoctrine()->getManager());
        //die();
        $em = $this->getDoctrine()->getManager();

        if($categorie != null){
            $findProduits = $em->getRepository('NadoecoNadoecoBundle:Produits')->byCategorie($categorie);
        }else{
            $findProduits = $em->getRepository('NadoecoNadoecoBundle:Produits')->findBy(array('disponible'=>'1'));
        }

        $session = $this->getRequest()->getSession();
        if($session->has('panier')){
            $panier = $session->get('panier');
        }else
            $panier= false;

        $paginator  = $this->get('knp_paginator');
        $produits = $paginator->paginate(
            $findProduits,
            $this->get('request')->query->get('page', 1)/*page number*/,
            1/*limit per page*/
        );


        return $this->render('NadoecoNadoecoBundle:default:produits/layout/produits.html.twig',array('produits' => $produits,'panier'=> $panier));
    }
    
    public function presentationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('NadoecoNadoecoBundle:Produits')->find($id);

        $session = $this->getRequest()->getSession();
        if($session->has('panier')){
            $panier = $session->get('panier');
        }else
            $panier= false;
        return $this->render('NadoecoNadoecoBundle:default:produits/layout/presentation.html.twig',array('produit'=>$produit,'panier' => $panier));
    }

    public function rechercheAction()
    {
         $form = $this->createForm(new RechercheType());
         return $this->render('NadoecoNadoecoBundle:default:recherche/modulesUsed/recherche.html.twig',array('form'=>$form->createView()));
    }

    public function rechercheTraitementAction()
    {
        if($this->get('request')->getMethod()=='POST'){
            $form = $this->createForm(new RechercheType());
            $form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('NadoecoNadoecoBundle:Produits')->recherche($form['recherche']->getData());
        }else{
            $this->createNotFoundException('La page n\'existe pas');
        }
        return $this->render('NadoecoNadoecoBundle:default:produits/layout/produits.html.twig',array('produits' => $produits));

    }
}
