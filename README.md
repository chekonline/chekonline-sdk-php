Chekonline PHP SDK
======

SDK для работы с API облачного сервиса [Чек онлайн](http://chekonline.ru/)

* [Cloud API Сценарий работы с устройством, арендованном в «облачном» сервисе для устройств версии 3.4.6](http://chekonline.ru/docs/cloudapi_complex.pdf)

* [Протокол взаимодействия с ККТ версии 3.10.0. JSON API](http://chekonline.ru/docs/protocol.pdf)

Отлично подходит для любых интернет магазинов.
## Пример использования
```php
use Chekonline\Cashbox\DocumentType;
use Chekonline\Cashbox\PayAttribute;
use Chekonline\Cashbox\Line;
use Chekonline\Cashbox\Commands\ComplexCommand;
use Chekonline\Cashbox\Api;

try {
    $host = 'https://fce.chekonline.ru:4443';
    $api  = new Api($host);
    $api->setClientName('custom');
    $api->setClientVer('1.0');
    $api->setCertificate(
        'cert',
        'cert_key',
        'cert_password'
    );

    $requestId = 'orderId';
    $total     = 100 * 10;
    $command   = new ComplexCommand($requestId);
    $command->setPhoneOrEmail('customer@example.com')
        ->setClientId('clientId')
        ->setNonCash([0, $total, 0])
        ->setTaxMode(pow(2, 0))
        ->setMaxDocumentsInTurn(20)
        ->setDocumentType(DocumentType::DEBIT)
        ->setPassword(1)
        ->setFullResponse(false)
        ->setDevice('auto');

//Product
    $subtotal   = 90 * 10;
    $isShipping = false;
    $line       = new Line($isShipping);
    $line->setDescription('Товар')
        ->setPayAttribute(PayAttribute::FULL_PAYMENT)
        ->setPrice($subtotal)
        ->setQty(1000)
        ->setTaxId(2);
    $line->validate();

    $command->addLine($line);

//Shipping
    $subtotal   = 10 * 10;
    $isShipping = true;
    $line       = new Line($isShipping);
    $line->setDescription('Доставка')
        ->setPayAttribute(PayAttribute::FULL_PAYMENT)
        ->setPrice($subtotal)
        ->setQty(1000)
        ->setTaxId(2);
    $line->validate();

    $command->addLine($line);

    $command->normalizeBySubTotal($total);
    $command->validate();

    $api->validate();
    $response = $api->executeCommand($command);

    $request = $response->getRequest();

    if (isset($log) == true && empty($log) == false) {
        Helper::writeLog('request', $request);
        Helper::writeLog('response', $response);
    }

    if ($response->getHttpStatusCode() != 200 &&
        $response->getApiErrorCode() != 0 &&
        $response->getHttpError() != '') {
        writeLog($request);
        writeLog($response);
    }

} catch (ChekonlineLineException $exception) {
    $logMessage = "chekonline line receipt exception:\n\tMessage: {$exception->getMessage()}";
    $logMessage .= "\n\tLine:" . var_export($exception->getReceiptLine()->getParam(), true);
    $logMessage .= "\n\tAt: {$exception->getFile()}\n";
    $logMessage .= "Trace:\n{$exception->getTraceAsString()}\n";
    writeLog($logMessage);
    writeLog($request);
    writeLog($response);
} catch (ChekonlineCommandException $exception) {
    $logMessage = "chekonline command exception: \n\tMessage: {$exception->getMessage()}";
    $logMessage .= "\n\tCommand:" . var_export($exception->getCommand()->getParams(), true);
    $logMessage .= "Trace:\n{$exception->getTraceAsString()}\n";
    writeLog($logMessage);
    writeLog($request);
    writeLog($response);
} catch (ChekonlineSDKException $exception) {
    $logMessage = "chekonline exception: \n\tMessage: {$exception->getMessage()}";
    $logMessage .= "\n\tAt: {$exception->getFile()}\n";
    $logMessage .= "Trace:\n{$exception->getTraceAsString()}\n";
    writeLog($logMessage);
    writeLog($request);
    writeLog($response);
}

```
## Установка
<pre><code>composer require chekonline/chekonline-sdk-php</code></pre>