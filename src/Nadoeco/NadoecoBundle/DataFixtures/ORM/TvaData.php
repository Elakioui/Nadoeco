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
use Nadoeco\NadoecoBundle\Entity\Tva;

class TvaData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $tva1 = new Tva();
        $tva1->setNom('Tva 1.75%')
            ->setMultiplicate('0.982')
            ->setValeur('1.75');
        $manager->persist($tva1);

        $tva2 = new Tva();
        $tva2->setNom('Tva 20%')
            ->setMultiplicate('0.888')
            ->setValeur('20');
        $manager->persist($tva2);



        $manager->flush();

        $this->addReference('tva1',$tva1);
        $this->addReference('tva2',$tva2);

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // l'ordre dans lequel les fichiers sont chargés
    }
}