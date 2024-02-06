<?php

namespace App\Form\Inventory;

use App\Entity\Inventory\PurchaseOrder;
use App\Entity\Inventory\PurchaseOrderItem;
use App\Entity\Product\ProductVariant;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

// $value = Entity::class;

class PurchaseOrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class,[
                // 'data' => '1',
                'attr' => [
                'min' => '1',
                ],
                'constraints' => [
                    new Assert\GreaterThanOrEqual(1),
                ]
            ])
            ->add('unitPrice',MoneyType::class,[
                'constraints' => [
                    new Assert\GreaterThanOrEqual(1),
                ]
            ])
            // ->add('total')
//             ->add('purchaseOrder', EntityType::class, [
//                 'class' => PurchaseOrder::class,
// 'choice_label' => 'id',
//             ])
            ->add('stockable', EntityType::class, [
                'class' => ProductVariant::class,
// 'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PurchaseOrderItem::class,
        ]);
    }
}
