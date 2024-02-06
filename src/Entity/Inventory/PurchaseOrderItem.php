<?php

namespace App\Entity\Inventory;

use App\Entity\Product\ProductVariant;
use App\Repository\Inventory\PurchaseOrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_inventory_purchase_order_item")
 * @ORM\Entity(repositoryClass=PurchaseOrderItemRepository::class)
 */
class PurchaseOrderItem
{
    
    // public const STATE_DRAFT =  'draft';
    // public const STATE_PENDING =  'pending';
    // public const STATE_INTRANSIT =  'intransit';
    // public const STATE_DELIVERED =  'delivered';
    // public const STATE_COMPLETED =  'completed';
    // public const STATE_CANCELLED =  'cancelled';
  
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseOrder::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?PurchaseOrder $purchaseOrder = null;


    /**
     * @ORM\ManyToOne(targetEntity=ProductVariant::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?ProductVariant $stockable = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $unitPrice = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $total = null;

    /**
     * @ORM\Column(type="string", length=32, options={"default": PurchaseOrder::STATE_DRAFT})
     */
    private ?string $state = PurchaseOrder::STATE_DRAFT;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPurchaseOrder(): ?PurchaseOrder
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?PurchaseOrder $purchaseOrder): static
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    public function getStockable(): ?ProductVariant
    {
        return $this->stockable;
    }

    public function setStockable(?ProductVariant $stockable): static
    {
        $this->stockable = $stockable;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?int $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }
}
