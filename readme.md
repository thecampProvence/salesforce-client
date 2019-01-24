PHP Salesforce client
=====================

[![Build Status](https://api.travis-ci.org/WakeOnWeb/salesforce-client.svg)](https://travis-ci.org/WakeOnWeb/salesforce-client)

Supported technologies:

    - rest
        - oauth2 grant type: password.

Please, contribute to support other one.

# Usage

```php
use WakeOnWeb\SalesforceClient\REST;
use WakeOnWeb\SalesforceClient\ClientInterface;

$client = new REST\Client(
    new REST\Gateway('https://cs81.salesforce.com', '41.0'),
    new REST\GrantType\PasswordStrategy(
        'consumer_key',
        'consumer_secret',
        'login',
        'password',
        'security_token'
    )
);
```
Available exception -------------------

- DuplicatesDetectedException
- EntityIsDeletedException (when try to delete an entity already deleted)
- NotFoundException (when an object cannot be found)
- ...

## Get object

```php
try {
    $salesforceObject = $client->getObject( 'Account', '1337ID')); // all fields
} catch (\WakeOnWeb\SalesforceClient\Exception\NotFoundException) {
    // this object does not exist, do a specifig thing.
}

//$salesforceObject->getAttributes();
//$salesforceObject->getFields();

//$client->getObject( 'Account', '1337ID', ['Name', 'OwnerId', 'CreatedAt'] )); // specific fields
```

## Create object

```php
// creation will be a SalesforceObjectCreationObject
$creation = $client->createObject( 'Account', ['name' => 'Chuck Norrs'] );
// $creation->getId();
// $creation->isSuccess();
// $creation->getErrors();
// $creation->getWarnings();
```

## Edit object

```php
$client->patchObject( 'Account', '1337ID', ['name' => 'Chuck Norris'] ));
```

## Delete object

```
$client->deleteObject( 'Account', '1337ID'));
```

## SOQL

```php
// creation will be a SalesforceObjectCreationObjectResults
$client->searchSOQL('SELECT name from Account'); // NOT_ALL by default.
$client->searchSOQL('SELECT name from Account', ClientInterface::ALL);
// $creation->getTotalSize();
// $creation->isDone();
// $creation->getRecords();
```

## Other

```php
$client->getAvailableResources();
$client->getAllObjects();
$client->describeObjectMetadata('Account');
```

# Todos

## Refactoring notes

Migrate unit tests (ex: SOQLQueryBuilder)

middleware-components-lib:
 * Reorganize/rename salesforce/model/ classes
 * migrate EventData constants prefixed with `SF_` (Member special case not prefixed)
 * Member constant RELATIONSHIP_MAPPING deprecated => use RELATION_WITH_THECAMP constants instead
 * Member update RELATION_WITH_THECAMP handling (isBuyer(), isExpert()...)
 * Member check usage of deprecated constants (SALUTATION, MAILING_COUNTRY_CODES_LIST, SF_TYPE_OFRELATIONSHIP, ...)
Salesforce model:
 * Model Contact: add relation with account (on AccountId) ?

# Utils

## Trouver des données de référence dans Salesforce

Rdv dans Setup > User Interface > Translation Workbench > Translate

Dans les filters:
 * Language: english
 * Setup Component:
   > Picklist Value (si utilisé dans un seul objet)
   > Global Value (si sont partagées entre plusieurs objets)
 * Object: préciser l'objet dans le cas d'un Picklist Value component
