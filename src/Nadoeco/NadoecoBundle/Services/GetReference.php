<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/03/15
 * Time: 18:39
 */
namespace Nadoeco\NadoecoBundle\Services;

use Symfony\Component\Security\Core\SecurityContext;


class GetReference {

    public function __construct($securityContext , $entityManager){
          $this->securityContext = $securityContext;
          $this->em = $entityManager;
    }
    public function reference(){
        $commande = $this->em->getRepository('NadoecoNadoecoBundle:Commandes')->findOneBy(array('valider'=> 1),
                                                                                          array('id'=> 'desc'),
                                                                                          1,
                                                                                           1
            );
        if(!$commande)return 1;
        else
            return $commande->getReference() + 1;

    }

}