<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/03/15
 * Time: 18:39
 */
namespace Nadoeco\NadoecoBundle\Services;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;


class GetFacture {

    public function __construct(ContainerInterface $container ){
          $this->container = $container;

    }
    public function facture($facture){
        $html = $this->container->get('templating')->render('NadoecoUtilisateurBundle:Default:layout/facturePDF.html.twig',array('facture'=>$facture));

        $html2pdf = $this->container->get('html2pdf_factory')->create('P', 'A4', 'en', true, 'UTF-8', array(10, 15, 10, 15));
        $html2pdf->pdf->setTitle('facture'.$facture->getReference());
        $html2pdf->pdf->setAuthor('zelakioui');
        $html2pdf->pdf->setSubject('bon facture');
        $html2pdf->pdf->setDisplayMode('real');
        $html2pdf->writeHTML($html);

        return $html2pdf;


    }

}