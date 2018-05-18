# PHP based EC recovery for Ethereum

This is the PHP equivalent to **web3.personal.ecRecover**.

```javascript
web3.personal.ecRecover (
   "I want to create a Account on this website. By I signing this text (using Ethereum personal_sign) I agree to the following conditions.",
"0xbbdcdfb9fbe24d460a683633475c77a44072b527a127b159ffaaa043f5dc944105a1671c8b9df95e377d89ec17a1a0ed13f5caa33e5fa80bdf12391bf2e04e4f1c",
(e,f)=>{console.log(e,f)}
)
```
## Usage

```php
use Ethereum\EcRecover;

$addrss = '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb';
$message = 'hello world';
$signature = '0xce909e8ea6851bc36c007a0072d0524b07a3ff8d4e623aca4c71ca8e57250c4d0a3fc38fa8fbaaa81ead4b9f6bd03356b6f8bf18bccad167d78891636e1d69561b';

// Verify known address
$valid = EcRecover::personalVerifyEcRecover($message,  $signature,  $address);

// Recover unknown address
$recoveredAddress = EcRecover::personalEcRecover($message, $signature);
if ($recoveredAddress === $address) {
  echo 'Jay! it was a long way here. '
}
```

## Testing

```bash
composer install 
vendor/bin/phpunit
```
