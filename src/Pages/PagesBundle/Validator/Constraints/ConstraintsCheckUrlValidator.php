<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/15
 * Time: 14:43
 */
namespace Pages\PagesBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint  ;
use Symfony\Component\Validator\ConstraintValidator  ;
use Pages\PagesBundle\Services\CurlUrl;
class ConstraintsCheckUrlValidator  extends  ConstraintValidator{

    private $curl;
    public function __construct(CurlUrl $curl){
        $this->curl = $curl;
    }
    public function validate($value, Constraint $constraint){
       // die($constraint->test);
        if($this->curl->findUrl($value))$this->context->addViolation($constraint->message);
    }
}