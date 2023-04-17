# OnChainPay PHP-API

This package makes it easy [OnChainPay Api](https://documenter.getpostman.com/view/21899690/UzJQptyu).

## Installation

Download this package and include `/php-api/vendor/autoload.php`

## Use

Go to your personal account
[https://onchainpay.io/merchant/api-keys](https://onchainpay.io/merchant/api-keys)
and get api-keys.

*Substitute keys in class call:*

```php
include_once ('php-api/vendor/autoload.php');

$onChainPayApi = new \OnChainPay\Api('__PUBLIC_KEY__', '__PRIVATE_KEY__');
```

### Check signature

You can test your signature within this method.

```php
$checkSignature = false;
try {
    $checkSignature = $onChainPayApi->verifySignature();
} catch (\OnChainPay\Exception $err) {
    echo $err;
}

echo $checkSignature ? 'Signature correct' : 'Signature incorrect';
```

### Fetch available currencies

Get list of available currencies for depositing/withdrawing

```php
$avalableCurrencies = [];
try {
    $avalableCurrencies = $onChainPayApi->getAvailableCurrenciesList();
} catch (\OnChainPay\Exception $err) {
    echo $err;
}

foreach ($avalableCurrencies as $coin) {
    echo sprintf("%s (%s) = %0.2f$\n",
                $coin['currency'], $coin['alias'], $coin['priceUSD']);
    if($coin['networks']) {
        echo "\t networks:\n";
        foreach ($coin['networks'] as $network)
            echo sprintf("\t\t%s (%s)\n", $network['name'], $network['alias']);
    }
}
```

### Get currencies price-rate

Get price rate from one currency to another


```php
$price = $onChainPayApi->priceRate('ETH', 'USDT');
```

### Get advanced balances info

Get info about advanced balance by its id

```php
$balance = null;
try {
    $balance = $onChainPayApi->getAdvancedBalanceInfo($balanceId);
} catch (\OnChainPay\Exception $err) {
    echo $err;
}

echo sprintf(
    "[%s] (%s)\n\tAvalable for deposit: %s\n",
    $balance['advancedBalanceId'],
    $balance['currency'],
    implode(', ', $balance['availableCurrenciesForDeposit'])
);
```

Or get list of advanced balances of user

```php
$balances = [];
try {
    $balances = $onChainPayApi->getAdvancedBalancesList();
} catch (\OnChainPay\Exception $err) {
    echo $err;
}

foreach ($balances as $balance) {
    echo sprintf(
        "[%s] (%s)\n\tAvalable for deposit: %s\n",
        $balance['advancedBalanceId'],
        $balance['currency'],
        implode(', ', $balance['availableCurrenciesForDeposit'])
    );
}
```