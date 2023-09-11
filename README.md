# Airtable API Wrapper
PHP wrapper for Airtable API. 


## Getting started

Airtable API does not allow to manipulate with bases or with fields in tables. So you must create tables and its fields manually in Airtable interface.

**Important**

Every base has own documentation where you find `base` identificator (starts with `app` e.g. `appGYr9gxkAk0wKNk`), which is required parameter. `API Key` is located in [account settings](https://airtable.com/account).

## Instalation

The best way to install davidzadrazil/airtable-api-php is using  [Composer](http://getcomposer.org/):

```sh
$ composer require davidzadrazil/airtable-api-php
```

# Usage
## Initialize
First of all, you must initialize Airtable class and Request handler:
```php
$airtable = new DavidZadrazil\AirtableApi\Airtable('API_KEY', 'BASE_ID');
$recordRequest = new DavidZadrazil\AirtableApi\Request\RecordRequest($airtable, 'TABLE_NAME');
$webhookRequest = new DavidZadrazil\AirtableApi\Request\WebhookRequest($airtable);
```

## Fetching records
**Important**:
Airtable limits response with maximum 100 records. 
```php
$tableRequest = $recordRequest->getTable();
do {
  foreach ($tableRequest->getRecords() as $record) {
    echo $record->getName();
    echo $record->getEmail();
    echo $record->getAnotherValue();
  }
} while ($tableRequest = $tableRequest->nextPage());
```

`getRecords()` returns array of [AirtableApi\Record](https://github.com/DavidZadrazil/airtable-api-php/blob/master/src/Record.php).

### Filtration & Other parameters
Fetching records from table can be used with available parameters like `filterByFormula`, `maxRecords`, `pageSize`, `sort` or `view`.
```php
$recordRequest->getTable(['pageSize' => 50, 'filterByFormula' => '{Name} = "test"']);
```

## Creating records
```php
$response = $recordRequest->createRecord(
  [
    'Name' => 'This appears in Name field',
    'Email' => 'john@doe.com',
    'LinkToAnotherTable' => ['recsH5WYbYpwWMlvb']
  ]
);

$response->isSuccess(); // true / false
$response->getRecords(); // returns newly created record with ID

```

## Updating records
Updates specific record with given record ID.
```php
$response = $recordRequest->updateRecord('recsH5WYbYpwWMlvb', ['Name' => 'Updated value']);
$response->isSuccess(); // true / false
```

## Deleting records
Delete specific record with given record ID.
```php
$response = $recordRequest->deleteRecord('recsH5WYbYpwWMlvb');
$response->isSuccess(); // true / false
```

## Fetching webhooks
```php
$response = $webhookRequest->getWebhooks();
foreach ($response->getWebhooks() as $webhook) {
    echo $webhook->getSpecification();
    echo $webhook->getNotificationUrl();
    echo $webhook->getExpirationTime();
}
```

`getWebhooks()` returns array of [AirtableApi\Webhook](https://github.com/DavidZadrazil/airtable-api-php/blob/master/src/Webhook.php).


## Creating webhooks
```php
$response = $webhookRequest->createWebhook(
  [
    'notificationUrl' => 'https://foo.com/receive-ping',
    'specification' => [
        'options' => [
            'filters' => [
                'dataTypes' => [
                    'tableData'
                ],
                'changeTypes' => [
                    'add',
                    'update',
                ]
            ]
        ]
    ]
  ]
);

$response->isSuccess(); // true / false
$response->getWebhooks(); // returns newly created webhook with ID
```

## Deleting webhooks
Delete specific webhook with given webhook ID.
```php
$response = $webhookRequest->deleteWebhook('achWucoiR59qA9cRq');
$response->isSuccess(); // true / false
```

## Refreshing webhooks
Refresh specific webhook with given webhook ID.
```php
$response = $webhookRequest->refreshWebhook('achWucoiR59qA9cRq');
$response->isSuccess(); // true / false
```