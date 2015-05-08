<?php

namespace Nadoeco\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Utilisateur
 *
 * @ORM\Table("utilisateur")
 * @ORM\Entity(repositoryClass="Nadoeco\UtilisateurBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected  $id;
   public function __construct(){
       parent::__construct();
       $this->commandes  = new \Doctrine\Common\Collections\ArrayCollection();
       $this->adresses   = new \Doctrine\Common\Collections\ArrayCollection();
   }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @ORM\OneToMany(targetEntity="Nadoeco\NadoecoBundle\Entity\Commandes", mappedBy="utilisateur",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;
    /**
     * @ORM\OneToMany(targetEntity="Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses", mappedBy="utilisateur",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;

    /**
     * Add commandes
     *
     * @param \Nadoeco\NadoecoBundle\Entity\Commandes $commandes
     * @return Utilisateur
     */
    public function addCommande(\Nadoeco\NadoecoBundle\Entity\Commandes $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \Nadoeco\NadoecoBundle\Entity\Commandes $commandes
     */
    public function removeCommande(\Nadoeco\NadoecoBundle\Entity\Commandes $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adresses
     *
     * @param \Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses $adresses
     * @return Utilisateur
     */
    public function addAdress(\Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses $adresses
     */
    public function removeAdress(\Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
