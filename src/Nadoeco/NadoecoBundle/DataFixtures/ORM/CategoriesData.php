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
use Nadoeco\NadoecoBundle\Entity\Categories;

class CategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $categorie1 = new Categories();
        $categorie1->setNom('legumes');
        $categorie1->setImage($this->getReference('media1'));
        $manager->persist($categorie1);


        $categorie2 = new Categories();
        $categorie2->setNom('fruits');
        $categorie2->setImage($this->getReference('media6'));
        $manager->persist($categorie2);

        $manager->flush();

        $this->addReference('categorie1',$categorie1);
        $this->addReference('categorie2',$categorie2);

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}