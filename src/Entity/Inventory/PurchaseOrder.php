<?php

namespace App\Entity\Inventory;

use App\Repository\Inventory\PurchaseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

/**
 * @ORM\Table(name="app_inventory_purchase_order")
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 */
class PurchaseOrder implements ResourceInterface, TimestampableInterface
{
    use TimestampableTrait {
        // __construct as private initializeTimestamps;
    }
    public const STATE_DRAFT =  'draft';
    public const STATE_PENDING =  'pending';
    public const STATE_INTRANSIT =  'intransit';
    public const STATE_DELIVERED =  'delivered';
    public const STATE_COMPLETED =  'completed';
    public const STATE_CANCELLED =  'cancelled';

    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @var string|null
     * @ORM\Column(length=64,unique=true)
     */
    // #[ORM\Column(length: 64, unique: true)]
    private ?string $code = null;

    /**
     * @var string|null
     * @ORM\Column(length=32)
     */
    #[ORM\Column(length: 32)]
    private ?string $state = self::STATE_DRAFT;

    /**
     * @var Collection<int, PurchaseOrderItem>
     * @ORM\OneToMany(targetEntity=PurchaseOrderItem::class, mappedBy="purchaseOrder", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private Collection $items;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="purchaseOrders")
     */
    private ?Supplier $supplier = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        // $this->initializeTimestamps();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state, bool $updateItems = true): static
    {

        $crntState = $this->state;
        if ($updateItems) {
            foreach ($this->items as $item) {
                if ($item->getState() === $crntState) {
                    $item->setState($state);
                }
            }
        }

        $this->state = $state;
        return $this;
    }

    /**
     * @return Collection<int, PurchaseOrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(PurchaseOrderItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setPurchaseOrder($this);
        }

        return $this;
    }

    public function removeItem(PurchaseOrderItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getPurchaseOrder() === $this) {
                $item->setPurchaseOrder(null);
            }
        }

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }
}
