<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/02/15
 * Time: 22:49
 */
namespace Nadoeco\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Nadoeco\UtilisateurBundle\Entity\Utilisateur;

class UtilisateurData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{
    /*
       * @var ContainerInterface
    */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {


        $utilisateur1 = new Utilisateur();
        $utilisateur1->setUsername('zelakioui1')
                     ->setEnabled(true)
                    ->setEmail('el-asr@hotmail.fr')
                    ->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('zouhaire24', $utilisateur1->getSalt()));

        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setUsername('zelakioui2')
            ->setEnabled(true)
            ->setEmail('zouhaire.elakioui@gmail.com')
            ->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur2)->encodePassword('zouhaire24', $utilisateur2->getSalt()));

        $manager->persist($utilisateur2 );

        $manager->flush();

        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}