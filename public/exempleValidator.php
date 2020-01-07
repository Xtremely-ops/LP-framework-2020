<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;


$validator = Validation::createValidator();

$contrainte = new NotBlank();

$resultatTest = $validator->validate('g', $contrainte );

if ( count($resultatTest) > 0 )
{
    /** @var ConstraintViolation $error */
    foreach ($resultatTest as $error )
    {
        echo $error->getMessage();
    }
} else {
    echo "Validation passée sans problème détectés";
}