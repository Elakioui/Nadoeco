<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{
    public function menuAction(){
        $em = $this->getDoctrine()->getManager();
        $categories= $em->getRepository('NadoecoNadoecoBundle:Categories')->findAll();

        return $this->render('NadoecoNadoecoBundle:default:categories/modulesUsed/menu.html.twig', array('categories'=>$categories));
        //die('hello');
    }
    public function categorie($id){
        die('hello');
    }

}
