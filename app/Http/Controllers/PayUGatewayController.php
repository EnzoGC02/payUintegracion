<?php

namespace App\Http\Controllers;
use App\Lib\PayU;
use App\Lib\PayUParameters;
use App\Lib\PayUCountries;
use App\Lib\PayUPayments;
use App\Lib\SupportedLanguages;
use App\Lib\Environment;
use App\Lib\PayUReports;
use GuzzleHttp\Client;

class PayUGatewayController extends Controller
{

    public function __construct()
    {
        PayU::$apiKey = "4Vj8eK4rloUd272L48hsrarnUA"; //Ingrese aquí su propio apiKey.
        PayU::$apiLogin = "pRRXKOl8ikMmt9u"; //Ingrese aquí su propio apiLogin.
        PayU::$merchantId = "508029"; //Ingrese aquí su Id de Comercio.
        PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
        PayU::$isTest = true; //Dejarlo True cuando sean pruebas.
        // URL de Pagos
        Environment::setPaymentsCustomUrl("https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi");
        Environment::setReportsCustomUrl("https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi");
    }
   // OpenPayU_Configuration::setEnvironment('sandbox');

    public function tarjetaDeCredito(){
        //echo "negro re puto";
        $reference =uniqid('');
        $value = "100";
        $parameters = array(
            //Ingrese aquí el identificador de la cuenta.
            PayUParameters::ACCOUNT_ID => "512322",
            //Ingrese aquí el código de referencia.
            PayUParameters::REFERENCE_CODE => $reference,
            //Ingrese aquí la descripción.
            PayUParameters::DESCRIPTION => "payment test",

            // -- Valores --
            //Ingrese aquí el valor.
            PayUParameters::VALUE => $value,
            //Ingrese aquí la moneda.
            PayUParameters::CURRENCY => "ARS",

            // -- Comprador
            //Ingrese aquí el nombre del comprador.
            PayUParameters::BUYER_NAME => "Enzo Calderon",
            //Ingrese aquí el email del comprador.
            PayUParameters::BUYER_EMAIL => "enzogclcc2@gmail.com",
            //Ingrese aquí el teléfono de contacto del comprador.
            PayUParameters::BUYER_CONTACT_PHONE => "2644623323",
            //Ingrese aquí el documento de contacto del comprador.
            PayUParameters::BUYER_DNI => "39790627",
            //Ingrese aquí la dirección del comprador.
            PayUParameters::BUYER_STREET => "Viamonte",
            PayUParameters::BUYER_STREET_2 => "1366",
            PayUParameters::BUYER_CITY => "Buenos Aires",
            PayUParameters::BUYER_STATE => "Buenos Aires",
            PayUParameters::BUYER_COUNTRY => "AR",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "7563126",

            // -- pagador --
            //Ingrese aquí el nombre del pagador.
            PayUParameters::PAYER_NAME => "First name and second payer name",
            //Ingrese aquí el email del pagador.
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            //Ingrese aquí el teléfono de contacto del pagador.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del pagador.
            PayUParameters::PAYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del pagador.
            PayUParameters::PAYER_STREET => "Avenida entre rios",
            PayUParameters::PAYER_STREET_2 => "452",
            PayUParameters::PAYER_CITY => "La Plata",
            PayUParameters::PAYER_STATE => "Buenos Aires",
            PayUParameters::PAYER_COUNTRY => "AR",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",

            //Ingrese aquí el número de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_NUMBER => "4842192998668940",
            //Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => "2026/06",
            //Ingrese aquí el código de seguridad de la tarjeta de crédito
            PayUParameters::CREDIT_CARD_SECURITY_CODE => "700",
            //Ingrese aquí el nombre de la tarjeta de crédito
            // "MASTERCARD" || "AMEX" || "ARGENCARD" || "CABAL" || "NARANJA" || "CENCOSUD" || "SHOPPING"
            PayUParameters::PAYMENT_METHOD => "VISA",

            //Ingrese aquí el número de cuotas.
            PayUParameters::INSTALLMENTS_NUMBER => "1",
            //Ingrese aquí el nombre del pais.
            PayUParameters::COUNTRY => PayUCountries::AR,

            // //Session id del device.
            // PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            // //IP del pagadador
            // PayUParameters::IP_ADDRESS => "127.0.0.1",
            // //Cookie de la sesión actual.
            // PayUParameters::PAYER_COOKIE => "pt1t38347bs6jc9ruv2ecpv7o2",
            // //Cookie de la sesión actual.
            // PayUParameters::USER_AGENT => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        if ($response) {
            var_dump($response);
            // $response->transactionResponse->orderId;
            // $response->transactionResponse->transactionId;
            // $response->transactionResponse->state;
            // if ($response->transactionResponse->state == "PENDING") {
            //     $response->transactionResponse->pendingReason;
            // }
            // $response->transactionResponse->paymentNetworkResponseCode;
            // $response->transactionResponse->paymentNetworkResponseErrorMessage;
            // $response->transactionResponse->trazabilityCode;
            // $response->transactionResponse->responseCode;
            // $response->transactionResponse->responseMessage;
        }
    }

    public function getOrden(){
        //orden test generada para  tarjeta de credito: "120291744"
        //orden test generada para  pago efectivo:"853418669"
        $parameters = array(PayUParameters::ORDER_ID => "120291744");
        $order = PayUReports::getOrderDetail($parameters);
        if($order){
            var_dump($order);
        }else{
            echo "a ver a ver que paso";
        }

    }

    public function efectivo(){
        $reference =uniqid('');
        $value = "100";
        $parameters = array(
            //Ingrese aquí el identificador de la cuenta.
            PayUParameters::ACCOUNT_ID => "512322",
            //Ingrese aquí el código de referencia.
            PayUParameters::REFERENCE_CODE => $reference,
            //Ingrese aquí la descripción.
            PayUParameters::DESCRIPTION => "payment test",

            // -- Valores --
            //Ingrese aquí el valor.
            PayUParameters::VALUE => $value,
            //Ingrese aquí la moneda.
            PayUParameters::CURRENCY => "ARS",

            // -- Comprador
            //Ingrese aquí el nombre del comprador.
            PayUParameters::BUYER_NAME => "Enzo Calderon",
            //Ingrese aquí el email del comprador.
            PayUParameters::BUYER_EMAIL => "enzogclcc2@gmail.com",
            //Ingrese aquí el teléfono de contacto del comprador.
            PayUParameters::BUYER_CONTACT_PHONE => "2644623323",
            //Ingrese aquí el documento de contacto del comprador.
            PayUParameters::BUYER_DNI => "39790627",
            //Ingrese aquí la dirección del comprador.
            PayUParameters::BUYER_STREET => "Viamonte",
            PayUParameters::BUYER_STREET_2 => "1366",
            PayUParameters::BUYER_CITY => "Buenos Aires",
            PayUParameters::BUYER_STATE => "Buenos Aires",
            PayUParameters::BUYER_COUNTRY => "AR",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "7563126",

            // -- pagador --
            //Ingrese aquí el nombre del pagador.
            PayUParameters::PAYER_NAME => "First name and second payer name",
            //Ingrese aquí el email del pagador.
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            //Ingrese aquí el teléfono de contacto del pagador.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            //Ingrese aquí el documento de contacto del pagador.
            PayUParameters::PAYER_DNI => "5415668464654",
            //Ingrese aquí la dirección del pagador.
            PayUParameters::PAYER_STREET => "Avenida entre rios",
            PayUParameters::PAYER_STREET_2 => "452",
            PayUParameters::PAYER_CITY => "La Plata",
            PayUParameters::PAYER_STATE => "Buenos Aires",
            PayUParameters::PAYER_COUNTRY => "AR",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",

            //Ingrese aquí el nombre del método de pago
                //COBRO_EXPRESS || PAGOFACIL || RAPIPAGO || BAPRO || RIPSA
            PayUParameters::PAYMENT_METHOD => "RAPIPAGO",
            //Ingrese aquí el nombre del pais.
            PayUParameters::COUNTRY => PayUCountries::AR,

            // //Session id del device.
            // PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            // //IP del pagadador
            PayUParameters::IP_ADDRESS => "127.0.0.1",
            // //Cookie de la sesión actual.
            // PayUParameters::PAYER_COOKIE => "pt1t38347bs6jc9ruv2ecpv7o2",
            // //Cookie de la sesión actual.
            // PayUParameters::USER_AGENT => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        if ($response) {
            var_dump($response);
            // $response->transactionResponse->orderId;
            // $response->transactionResponse->transactionId;
            // $response->transactionResponse->state;
            // if ($response->transactionResponse->state == "PENDING") {
            //     $response->transactionResponse->pendingReason;
            // }
            // $response->transactionResponse->paymentNetworkResponseCode;
            // $response->transactionResponse->paymentNetworkResponseErrorMessage;
            // $response->transactionResponse->trazabilityCode;
            // $response->transactionResponse->responseCode;
            // $response->transactionResponse->responseMessage;
        }
    }

    public function metodosDePago(){
        $array = PayUPayments::getPaymentMethods();
        var_dump($array->paymentMethods);
        // $payment_methods = $array->paymentMethods;
        // foreach ($payment_methods as $payment_method) {
        //     $payment_method->country;
        //     $payment_method->description;
        //     $payment_method->id;
        // }
    }

    public function getCheckOut()
    {
       // header('Access-Control-Allow-Origin:*');
        $stack = \GuzzleHttp\HandlerStack::create();
        $lastRequest = null;
        // $stack->Push(\GuzzleHttp\Middleware::mapRequest(function (\Psr\Http\Message\RequestInterface $request) use (&$lastRequest) {
        //     $lastRequest = $request;
        //     return $request;
        // }));
        $reference = uniqid();
        //$redirect;
        $signature = md5('4Vj8eK4rloUd272L48hsrarnUA~508029~' . $reference . '~25000~ARS');
        $client = new Client(['base_uri' => 'https://sandbox.checkout.payulatam.com/']);
        $response = $client->request('POST', 'ppp-web-gateway-payu', [
            'form_params' => [
                'merchantId' => "508029",
                'referenceCode' => $reference,
                'description' => 'testing checkout',
                'amount' => "25000",
                'signature' => $signature,
                'accountId' => "512322",
                'currency' => "ARS",
                'buyerFullName' => "Enzo Calderon",
                "buyerEmail" => "enzogclcc2@gmail.com",
                "test"=>"1"
            ],
            'on_stats' => function (\GuzzleHttp\TransferStats $stats){
                    echo($stats->getHandlerStats()['redirect_url']);
                }
        ]);
    }
}