<?php

namespace App\Payum\Action;

use App\Payum\KyrmannPayAPI;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Payum\Core\Request\Capture;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

final class CaptureAction implements ActionInterface, ApiAwareInterface
{
    private Client $client;
    private KyrmannPayAPI $api;
    private RouterInterface $router;

    public function __construct(Client $client, RouterInterface $router)
    {
        $this->client = $client;
        $this->router = $router;
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);



        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getModel();
        dd($payment->getOrder()->getId());

        $redirectUrlBase64 = urlencode($this->router->generate('app_kyrmann_pay_callback_controller', ['id' => $payment->getOrder()->getId()], 3));
        $data = array();
        $data["user"] = $this->api->getUser();
        $data['pass'] = $this->api->getPass();
        $data["id_cart"] = $payment->getOrder()->getId();
        $data["id_customer"] = $payment->getOrder()->getCustomer()->getId();
        $data["total_cart"] = $payment->getAmount();
        $data["url"] = $redirectUrlBase64;
        $data["afid"] = $this->api->getAfid();
        $data["offreid"] = $this->api->getOfferid();
        $data['redirectType'] = "POST";
        $data['infos'] = $payment->getCurrencyCode();
        $json = json_encode($data);

        $key = "58SYA4I5IAKHHESP";
        $cipher ="aes-128-cbc";
        $secret = openssl_encrypt($json, $cipher, $key, true, $key);
        $secret = base64_encode(urlencode($secret));

        $URL = 'https://kyrmannpay.com/kpayment?secret=' . $secret . '&login='.$this->api->getUser();

        header('Location: ' . $URL);
        exit;
    }

    public function supports($request): bool
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof SyliusPaymentInterface;
    }

    public function setApi($api): void
    {
        if (!$api instanceof KyrmannPayAPI) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . KyrmannPayAPI::class);
        }

        $this->api = $api;
    }
}
