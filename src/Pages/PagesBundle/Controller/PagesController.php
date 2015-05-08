<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
   public function menuAction(){
       $em = $this->getDoctrine()->getManager();
       $pages = $em->getRepository('PagesPagesBundle:Pages')->findAll();

       return $this->render('PagesPagesBundle:default:page/modulesUsed/menu.html.twig', array('pages'=>$pages));
       //die('hello');
   }
    public function pageAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesPagesBundle:Pages')->findOneBySlug($slug);
        if(!$page) throw $this->createNotFoundException('la page n\'existe pas !!');
        return $this->render('PagesPagesBundle:default:page/layout/page.html.twig',array('page'=>$page));
    }
}
