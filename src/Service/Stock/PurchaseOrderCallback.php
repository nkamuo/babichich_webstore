<?php
namespace App\Service\Stock;

use App\Entity\Inventory\PurchaseOrder;
use App\Entity\Inventory\PurchaseOrderItem;
use App\Repository\Inventory\PurchaseOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseOrderCallback
{


    public function __construct(
        private EntityManagerInterface $entityManager,
        private PurchaseOrderRepository $orderRepository,
    ) {
    }
    public function approve(PurchaseOrder $order): PurchaseOrder
    {
        $this->commit($order, flush: true);
        return $order;
    }


    public function commit(PurchaseOrder|PurchaseOrderItem $item, bool $flush = true): void
    {
        if ($item instanceof PurchaseOrder) {
            foreach ($item->getItems() as $item) {
                $this->commit($item, flush: false);
            }
            if ($flush) {
                $this->entityManager->flush();
            }
        }
        $stockable = $item->getStockable();
        $crntQty = $item->getStockable()->getOnHand();
        $newQty = $crntQty + $item->getQuantity();
        $stockable->setOnHand($newQty);
        $item->setState(PurchaseOrder::STATE_COMPLETED);
        $this->entityManager->persist($item);
        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
