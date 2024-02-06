<?php
namespace App\Payum;

use App\Payum\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class KyrmannPayGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'Kyrmann_pay',
            'payum.factory_title' => 'Kyrmann Payment',
            'payum.action.status' => new StatusAction(),
        ]);

        $config['payum.api'] = function (ArrayObject $config) {
            $user = $config['user'];
            $pass = $config['pass'];
            $afid = $config['afid'];
            $offerid = $config['offerid'];
            $encryptKey = $config['encryptKey'];
            return new KyrmannPayAPI($user, $pass, $afid, $offerid, $encryptKey);
        };
    }
}
