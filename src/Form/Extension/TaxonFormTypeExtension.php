<?php

namespace App\Form\Extension;

use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxonFormTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('megaMenuBlocs')
            ->add('megaMenu')
            ->add('inHomaPage')
            ;

    }

    public static function getExtendedTypes(): iterable
    {
        return [TaxonType::class];
    }
}
