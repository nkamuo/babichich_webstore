<?php

// src/Form/Extension/RegistrationTypeExtension.php

namespace App\Form\Extension;

use Sylius\Bundle\UiBundle\Form\Type\SecurityLoginType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class LoginTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder
        //     ->add('customField', TextType::class, [
        //         'label' => 'Custom Field',
        //         // Add any other options as needed
        //     ]);

        // if ($builder->has("_username")) {
        //     $username = $builder->get("_username"); 
        //     $username->setAttribute("placeholder", "Email");
        //     // $builder->remove("_username");
        // }
    }

    public static function getExtendedTypes(): iterable
    {
        return [SecurityLoginType::class];
    }
}
