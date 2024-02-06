<?php

// src/Form/Extension/RegistrationTypeExtension.php

namespace App\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerRegistrationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder
        //     ->add('customField', TextType::class, [
        //         'label' => 'Custom Field',
        //         // Add any other options as needed
        //     ]);

        // if ($builder->has("email")) {
        //     $email = $builder->get("email");
        //     $email->setRequired(false); // Make the email field optional
        //     $builder->remove("email");
        // }
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerRegistrationType::class];
    }
}
