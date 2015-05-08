<?php
   namespace Nadoeco\NadoecoBundle\Twig\Extension;

  class MontantTvaExtension extends \Twig_Extension{

       public function getFilters(){

          return array(new \Twig_SimpleFilter('montantTva',array($this,'montantTva')));
       }
       /**
        * Returns the name of the extension.
        *
        * @return string The extension name
        */
       public function getName()
       {
           return 'montant_tva_extension';
       }
      public function montantTva($prixHT,$tva){
          return round(($prixHT / $tva) - $prixHT,2);
      }
   }