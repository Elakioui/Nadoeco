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
use Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses;

class UtilisateursAdressesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $utilisateuradresse1 = new UtilisateursAdresses();
        $utilisateuradresse1->setNom('el akioui nador')
            ->setPrenom('zouhaire')
            ->setAdresse('pharmacie chamce')
            ->setCp('1620')
            ->setVille('Nador')
            ->setPays('Maroc')
            ->setTelephone('0612121312')
            ->setComplement('complement ...µ1')
            ->setUtilisateur($this->getReference('utilisateur1'));

        $manager->persist($utilisateuradresse1);

        $utilisateuradresse2 = new UtilisateursAdresses();
        $utilisateuradresse2->setNom('el akioui')
            ->setPrenom('zouhaire')
            ->setAdresse('pharmacie chamce')
            ->setCp('1620')
            ->setVille('Fes')
            ->setPays('Maroc')
            ->setTelephone('0612121212')
            ->setComplement('complement ...')
            ->setUtilisateur($this->getReference('utilisateur2'));

        $manager->persist($utilisateuradresse2);


        $manager->flush();

    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6; // l'ordre dans lequel les fichiers sont chargés
    }
}