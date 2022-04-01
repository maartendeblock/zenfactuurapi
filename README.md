# Zenfactuur API
PHP service to connect to the Zenfactuur API at https://app.zenfactuur.be/api_docs/v2.en.html

##Installation
```shell
composer require maartendeblock/zenfactuurapi
```
##Recourses
Resources are grouped. See src/Apis directory.

##Usage
```php
// You can find the api token in the settings of ZenFactuur.
$api_token = 'YOUR API_TOKEN';

// Create an instance of the ZenFactuur Client.
$zenfactuur = new \MaartenDeBlock\ZenFactuurApi\ZenFactuurApiClient($api_token);

// Get all the customers.
$customers = $zenfactuur->Customer->getAllCustomers();

var_dump($customers);
```