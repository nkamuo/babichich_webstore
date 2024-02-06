<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use BitBag\SyliusElasticsearchPlugin\Model\ProductVariantTrait;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;
use BitBag\SyliusElasticsearchPlugin\Model\ProductVariantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_product_variant')]
class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{

    use ProductVariantTrait;
    protected function createTranslation(): ProductVariantTranslationInterface
    {
        return new ProductVariantTranslation();
    }
}
