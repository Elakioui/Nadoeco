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


class SendEmail {

    public function __construct(ContainerInterface $container ){
          $this->container = $container;

    }
    public function send($sendFrom,$subject,$utilisateur){
        $body=$this->container->get('templating')->render('NadoecoNadoecoBundle:default:swiftLayout/validation.html.twig',array('utilisateur'=> $utilisateur));

        //envoi email de validation
        $message = \Swift_Message::newInstance()
            ->setSubject('Validation de votre commande')
            ->setFrom(array("$sendFrom"=>'Nadoeco'))
            ->setTo($utilisateur->getEmailCanonical())
            ->setCharset('UTF-8')
            ->setContentType('text/html')
            ->setBody($body);
        $this->container->get('mailer')->send($message);
    }

}