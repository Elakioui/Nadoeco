<?php
   namespace Nadoeco\NadoecoBundle\Twig\Extension;

  class TvaExtension extends \Twig_Extension{

       public function getFilters(){

          return array(new \Twig_SimpleFilter('tva',array($this,'calculTva')));
       }
       /**
        * Returns the name of the extension.
        *
        * @return string The extension name
        */
       public function getName()
       {
           return 'tva_extension';
       }
      public function calculTva($prixHT,$tva){
          return round($prixHT / $tva,2);
      }
   }