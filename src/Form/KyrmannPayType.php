<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class KyrmannPayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user', TextType::class);
        $builder->add('pass', TextType::class);
        $builder->add('afid', TextType::class);
        $builder->add('offerid', TextType::class);
        $builder->add('encryptKey', TextType::class);
    }
}
