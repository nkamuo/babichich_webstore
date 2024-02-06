<?php

namespace App\Controller\Admin\Stock;

use App\Entity\Inventory\PurchaseOrder;
use App\Entity\Inventory\PurchaseOrderTransition;
use App\Form\Inventory\PurchaseOrder1Type;
use App\Repository\Inventory\PurchaseOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SM\Factory\Factory as StateMachineFactory;

#[Route('/admin/stock/purchase-orders')]
class PurchaseOrderController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private StateMachineFactory $stateMachineFactory,
    ){

    }
    // #[Route('/', name: 'app_admin_stock_purchase_order_index', methods: ['GET'])]
    // public function index(PurchaseOrderRepository $orderRepository): Response
    // {
    //     return $this->render('admin/stock/purchase_order/index.html.twig', [
    //         'purchase_orders' => $orderRepository->findAll(),
    //     ]);
    // }

    // #[Route('/new', name: 'app_admin_stock_purchase_order_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $order = new PurchaseOrder();
    //     $form = $this->createForm(PurchaseOrder1Type::class, $order);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($order);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_admin_stock_purchase_order_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/stock/purchase_order/new.html.twig', [
    //         'purchase_order' => $order,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_admin_stock_purchase_order_show', methods: ['GET'])]
    // public function show(PurchaseOrder $order): Response
    // {
    //     return $this->render('admin/stock/purchase_order/show.html.twig', [
    //         'purchase_order' => $order,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_admin_stock_purchase_order_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, PurchaseOrder $order, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(PurchaseOrder1Type::class, $order);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_admin_stock_purchase_order_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/stock/purchase_order/edit.html.twig', [
    //         'purchase_order' => $order,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_admin_stock_purchase_order_delete', methods: ['POST'])]
    // public function delete(Request $request, PurchaseOrder $order, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($order);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_admin_stock_purchase_order_index', [], Response::HTTP_SEE_OTHER);
    // }


    #[Route('/{order}/receive', name: 'app_admin/stock_purchase_order_receive', methods: ['GET', 'POST'])]
    public function receive(Request $request, PurchaseOrder $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurchaseOrder1Type::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sm = $this->stateMachineFactory->get($order, PurchaseOrderTransition::GRAPH);
            $sm->apply(PurchaseOrderTransition::TRANSITION_RECEIVE);


            // $order->setState('received');
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_stock_purchase_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/stock/purchase_order/receive.html.twig', [
            'purchase_order' => $order,
            'form' => $form,
        ]);
    }



    #[Route('/{id}/{$transition}', name: 'app_admin_stock_purchase_order_apply_transition', methods: ['PATCH', 'POST'])]
    public function applyTransition(PurchaseOrder $order, string $transition, Request $request): Response
    {
        $route = $request->headers->get('referer');
        try {
            $sm = $this->stateMachineFactory->get($order, PurchaseOrderTransition::GRAPH);
            $sm->apply($transition);

            $this->entityManager->persist($order);
            $this->entityManager->flush();

            $this->addFlash('success', 'Transition applied successfully');
            return $this->redirect($route);

        } catch (\Throwable $err) {
            $this->addFlash('error', $err->getMessage());
            return $this->redirect($route);
        }
    }
}
