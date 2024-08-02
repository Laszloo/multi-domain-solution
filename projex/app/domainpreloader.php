<?php
declare(strict_types=1);

return (function () {
    $host = $_SERVER['HTTP_HOST'];
    $domainList = [
        'localhost:8000' => 'TestShopOrg',
        'localhost:8001' => 'ExampleCom',
        'dummy.org' => 'DummyOrg',
        'dummy-shop.eu' => 'DummyShopEu',
    ];

    if (!array_key_exists($host, $domainList)) {
        throw new DomainException('Unknown host');
    }

    return $domainList[$host];
})();
