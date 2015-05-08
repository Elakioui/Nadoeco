<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/02/15
 * Time: 22:49
 */
namespace Nadoeco\NadoecoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nadoeco\NadoecoBundle\Entity\Commandes;
use Symfony\Component\Validator\Constraints\DateTime;

class CommandeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $commande1 = new Commandes();
        $commande1->setUtilisateur($this->getReference('utilisateur1'))
                  ->setReference('R12223')
                  ->setValider(true)
                  ->setDate(new \DateTime('NOW'))
                  ->setProduits(array(
                      '0'=>array('43'=>'4'),
                      '1'=>array('44'=> '2')
                  ));

        $manager->persist($commande1);

        $commande2 = new Commandes();
        $commande2->setUtilisateur($this->getReference('utilisateur2'))
            ->setReference('R12423')
            ->setValider(true)
            ->setDate(new \DateTime('NOW'))
            ->setProduits(array(
                                  '0'=>array('43'=>'4'),
                                  '1'=>array('44'=> '2')
                          ));

        $manager->persist($commande2);

        $manager->flush();

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 7; // l'ordre dans lequel les fichiers sont chargés
    }
}