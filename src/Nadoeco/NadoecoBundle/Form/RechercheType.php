<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/02/15
 * Time: 15:46
 */
namespace Nadoeco\NadoecoBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recherche','text',array('attr'=>array('class'=>'input-medium search-query')));

    }

    public function getName(){
        return 'nadoeco_nadoecoBundle_recherche';
    }

}