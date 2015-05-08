<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/15
 * Time: 14:43
 */
namespace Pages\PagesBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint  ;

/**
 * Class ConstraintsCheckUrl
 * @package Pages\PagesBundle\Validator\Constraints
 * @Annotation
 */
class ConstraintsCheckUrl  extends Constraint{

      public $message = 'validation d\'url ';

      public function validatedBy(){
            return 'validatorCheckUrl';
      }
}