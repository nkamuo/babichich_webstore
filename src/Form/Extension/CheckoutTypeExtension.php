<?php

// src/Form/Extension/RegistrationTypeExtension.php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\AddressingBundle\Form\Type\CountryCodeChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType;
use Sylius\Bundle\AddressingBundle\Form\Type\AddressType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CheckoutTypeExtension extends AbstractTypeExtension
{
    public const COUNTRY_CODE = 'US';
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        // if ($builder->has("postcode")) {
        //     $builder->remove("postcode");
        // }
        // if ($builder->has("countryCode")) {
        //     $postcode = $builder->get("postcode");
        //     $postcode->setRequired(false); // Make the postcode field optional
        //     $builder->remove("postcode");
        // }

        if ($builder->has("countryCode")) {
            $builder->remove("countryCode");
        }
        if ($builder->has("postcode")) {
            $builder->remove("postcode");
        }
        if ($builder->has("company")) {
            $builder->remove("company");
        }
        if ($builder->has("provinceCode")) {
            $builder->remove("provinceCode");
        }
        if ($builder->has("provinceName")) {
            $builder->remove("provinceName");
        }

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($form->has("postcode")) {
                $form->remove("postcode");
            }

            $form->add('postcode', TextType::class, [
                'label' => 'sylius.form.address.postcode',
                'empty_data' => '00000'
            ]);

            $form->add('countryCode', CountryCodeChoiceType::class, [
                'enabled' => true,
                'empty_data' => self::COUNTRY_CODE,
            ]);
        });

            //    $builder->add('countryCode', CountryCodeChoiceType::class, [
            //         'enabled' => true,
            //         'empty_data' => self::COUNTRY_CODE,
            //     ])
            // ->add('postcode', TextType::class, [
            //     'label' => 'sylius.form.address.postcode',
            //     'empty_data' => '00000'
            // ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [AddressType::class];
    }
}
