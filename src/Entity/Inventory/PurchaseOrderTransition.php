<?php

namespace App\Entity\Inventory;

class PurchaseOrderTransition
{

    public const GRAPH = 'stock_state_transition';

    public const TRANSITION_START = 'start';
    public const TRANSITION_DISPATCH = 'dispatch';
    public const TRANSITION_RECEIVE = 'receive';
    public const TRANSITION_APPROVE = 'approve';
    public const TRANSITION_PROCESS = 'process';
    public const TRANSITION_COMPLETE = 'complete';
    public const TRANSITION_CANCEL = 'cancel';
}
