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
use Nadoeco\NadoecoBundle\Entity\Media;

class MediaData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('http://www.jefaismoimeme.com/wp-content/uploads/2013/10/tomate.jpg');
        $media1->setAlt('pomme de terre');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setPath('http://cuisine.larousse.fr/lcfilestorage/8A/DA/POIVRON_D_636x380.jpg');
        $media2->setAlt('poivron');
        $manager->persist($media2);


        $media3 = new Media();
        $media3->setPath('http://www.consoglobe.com/wp-content/uploads/2013/05/artichaut-248x3001.jpg');
        $media3->setAlt('artichaud2');
        $manager->persist($media3);

        $media4 = new Media();
        $media4->setPath('http://www.consoglobe.com/wp-content/uploads/2013/05/artichaut-248x3001.jpg');
        $media4->setAlt('artichaud');
        $manager->persist($media4);

        $media5 = new Media();
        $media5->setPath('http://p1.storage.canalblog.com/19/87/784507/57812293_p.jpg');
        $media5->setAlt('legume vert');
        $manager->persist($media5);

        $media6 = new Media();
        $media6->setPath('http://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Strawberry444.jpg/250px-Strawberry444.jpg');
        $media6->setAlt('freise');
        $manager->persist($media6);



        $manager->flush();

        $this->addReference('media1',$media1);
        $this->addReference('media2',$media2);
        $this->addReference('media3',$media3);
        $this->addReference('media4',$media4);
        $this->addReference('media5',$media5);
        $this->addReference('media6',$media6);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}