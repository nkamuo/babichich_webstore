<?php

namespace App\Entity\Inventory;

use App\Repository\Inventory\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Metadata\Resource;
use Sylius\Component\Resource\Model\ResourceInterface;// as ResourceMetadata;


// #[Resource(alias: 'app.supplier')]
/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 * @ORM\Table(name="app_inventory_supplier")
 */
class Supplier implements ResourceInterface
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=32, unique=true)
     */
    private ?string $code = null;

    /**
     * @ORM\Column(length=64)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type=Types::TEXT,length=255, nullable=true)
     */
    // #[ORM\Column(type: Types::TEXT, length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $enabled = null;

    // #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: PurchaseOrder::class)]
    /**
     * @ORM\OneToMany(targetEntity=PurchaseOrder::class, mappedBy="supplier")
     */
    private Collection $purchaseOrders;

    public function __construct()
    {
        $this->purchaseOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseOrder>
     */
    public function getPurchaseOrders(): Collection
    {
        return $this->purchaseOrders;
    }

    public function addPurchaseOrder(PurchaseOrder $purchaseOrder): static
    {
        if (!$this->purchaseOrders->contains($purchaseOrder)) {
            $this->purchaseOrders->add($purchaseOrder);
            $purchaseOrder->setSupplier($this);
        }

        return $this;
    }

    public function removePurchaseOrder(PurchaseOrder $purchaseOrder): static
    {
        if ($this->purchaseOrders->removeElement($purchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($purchaseOrder->getSupplier() === $this) {
                $purchaseOrder->setSupplier(null);
            }
        }

        return $this;
    }
}
