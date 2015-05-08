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
use Nadoeco\NadoecoBundle\Entity\Produits;

class ProduitsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produits();
        $produit1->setNom('poivron')
                 ->setImage($this->getReference('media2'))
                 ->setCategories($this->getReference('categorie1'))
                 ->setDisponible(true)
                 ->setPrix('12..2')
                 ->setDescription('poivron description .......')
                  ->setTva($this->getReference('tva1'));
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setNom('artichaud')
            ->setImage($this->getReference('media3'))
            ->setCategories($this->getReference('categorie1'))
            ->setDisponible(true)
            ->setPrix('13..2')
            ->setDescription('artichaud description .......')
            ->setTva($this->getReference('tva2'));
        $manager->persist($produit2);




        $manager->flush();

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}