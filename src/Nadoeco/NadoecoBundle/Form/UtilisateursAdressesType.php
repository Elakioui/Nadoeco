<?php

namespace Nadoeco\NadoecoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class UtilisateursAdressesType extends AbstractType
{
    private $em;
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,array('label'=> 'label.name'))
            ->add('prenom')
            ->add('telephone')
            ->add('adresse')
            ->add('cp',null, array('attr'=>array('class' => 'cp','maxlength'=> 5)))
            ->add('pays')
            ->add('ville','choice', array('attr'=>array('class' => 'ville')))
            ->add('complement',null,array('required'=> false));
            //->add('utilisateur')
        ;
        $entitymanager = $this->em;
        $city = function(FormInterface $form, $cp)use ($entitymanager){
                    $villeCodePostale = $entitymanager->getRepository('NadoecoUtilisateurBundle:Villes')->findBy(array('villeCodePostal'=>$cp));
                    if($villeCodePostale){
                        $nomsVilles = array();
                        foreach($villeCodePostale as $ville)
                            $nomsVilles[] = $ville->getVilleNom();
                    }else{
                        $nomsVilles = null;
                    }
                    $form->add('ville','choice', array('attr'=>array('class' => 'ville'),
                                                       'choices'=>$nomsVilles
                    ));

        };
        $builder->get('cp')->addEventListener(FormEvents::POST_SUBMIT,function(FormEvent $event )use($city){
                        $city($event->getForm()->getParent(),$event->getForm()->getData());
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nadoeco\UtilisateurBundle\Entity\UtilisateursAdresses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nadoeco_Nadoecobundle_utilisateursadresses';
    }
}
