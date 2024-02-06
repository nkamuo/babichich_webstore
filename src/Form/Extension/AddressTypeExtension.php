<?php

namespace App\Form\Extension;

use Sylius\Bundle\AddressingBundle\Form\Type\AddressType;
use Sylius\Bundle\AddressingBundle\Form\Type\CountryCodeChoiceType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('company')
            ->add('countryCode', CountryCodeChoiceType::class, [
                'enabled' => true,
                'empty_data' => 'CI'
            ])
            ->add('postcode', TextType::class, [
                'label' => 'sylius.form.address.postcode',
                'empty_data' => '00000'
            ])
            ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [AddressType::class];
    }
}
