<?php

namespace Nadoeco\NadoecoBundle\Controller;

use Nadoeco\NadoecoBundle\Entity\Commandes;
use Nadoeco\NadoecoBundle\Form\UtilisateursAdressesType;
use Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends Controller
{
    public function facture()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $generator = $this->container->get('security.secure_random');
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;
        $totalTTC = 0;

        $facturation = $em->getRepository('NadoecoUtilisateurBundle:UtilisateursAdresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('NadoecoUtilisateurBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('NadoecoNadoecoBundle:Produits')->findArray(array_keys($session->get('panier')));

        foreach ($produits as $produit) {
            $prixHT    = round(($produit->getPrix() * $panier[$produit->getId()]),2);
            $prixTTC   = round($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate(),2);
            $totalHT  += $prixHT;
            $totalTTC += $prixTTC;

            if (!isset($commande['tva']['%' . $produit->getTva()->getValeur()])) {
                $commande['tva']['%' . $produit->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
            } else {
                $commande['tva']['%' . $produit->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);
            }
            $commande['produits'][$produit->getId()] = array('reference' => $produit->getNom(),
                'quantite' => $panier[$produit->getId()],
                'prixUnitaire' => round($produit->getPrix(), 2),
                'totalHT' => round($prixHT, 2),
                'totalTTC' => round($prixTTC,2)

            );
        }
        $commande['livraison'] = array('nom' => $livraison->getNom(),
            'prenom' => $livraison->getPrenom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement()
        );
        $commande['facturation'] = array('nom' => $facturation->getNom(),
            'prenom' => $facturation->getPrenom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCp(),
            'ville' => $facturation->getVille(),
            'pays' => $facturation->getPays(),
            'complement' => $facturation->getComplement()
        );
        $commande['totalHT'] = round($totalHT, 2);
        $commande['totalTTC'] = round($totalTTC, 2);
        $commande['token'] = bin2hex($generator->nextBytes(20));

        return $commande;

    }

    public function prepareCommandeAction()
    {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        if (!$session->has('commande')) {
            $commande = new Commandes();
        } else {
            $commande = $em->getRepository('NadoecoNadoecoBundle:commandes')->find($session->get('commande'));
        }
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
        $commande->setReference(0);
        $commande->setValider(0);
        $commande->setCommande($this->facture());

        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande', $commande);
        }
        $em->flush();

        return new Response($commande->getId());

    }

    /** Cette méthode remplace l'api banque
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validationCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('NadoecoNadoecoBundle:Commandes')->find($id);

        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('la commande n\'existe pas ');
        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference());//service
        $em->flush();

        $session = $this->get('session');
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');

        $this->get('sendEmail')->send('zouhaire.elakioui@gmail.com','validation de la commande',$commande->getUtilisateur());
        $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succé  '.$commande->getUtilisateur()->getEmailCanonical());

        return $this->redirect($this->generateUrl('factures'));
    }
}