<?php

namespace WakeOnWeb\SalesforceClient\Repository;

use Psr\Log\LoggerInterface;
use WakeOnWeb\SalesforceClient\ClientInterface;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObject;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectResults;
use WakeOnWeb\SalesforceClient\Exception\NotFoundException;
use WakeOnWeb\SalesforceClient\Exception\SalesforceClientException;
use WakeOnWeb\SalesforceClient\Model\Account;
use WakeOnWeb\SalesforceClient\Model\Contact;
use WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c;
use WakeOnWeb\SalesforceClient\Query\QueryBuilder;

/**
 * ModelRepository
 */
class ModelRepository
{
    /**
     * @deprecated
     * @see WakeOnWeb\SalesforceClient\Model\
     */
    // const OBJECT_AFFILIATION = 'npe5__Affiliation__c';
    // const OBJECT_CONTACT = 'Contact';
    // const OBJECT_ORGANIZATION = 'Account';

    /**
     * @var ClientInterface
     */
    private $_salesforceClient;

    /**
     * @var LoggerInterface
     */
    private $_logger;

    /**
     * @param ClientInterface   $salesforceClient   salesforceClient
     * @param LoggerInterface   $logger
     */
    public function __construct(ClientInterface $salesforceClient, LoggerInterface $logger = null)
    {
        $this->_salesforceClient = $salesforceClient;
        $this->_logger           = $logger;
    }

    /**
     * Check if given exception matches a 404
     *
     * @param SalesforceClientException $e
     *
     * @return bool
     */
    private function isNotFoundException(SalesforceClientException $e): bool
    {
        if ($e instanceof NotFoundException) {
            return true;
        }

        $previousException = $e->getPrevious();

        if ($previousException instanceof \GuzzleHttp\Exception\ClientException &&
            $previousException->getResponse()->getStatusCode() == 404
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $id id
     *
     * @return Account | null
     *
     * @throws SalesforceClientException
     */
    public function findAccount(string $id): ?Account
    {
        try {
            $salesforceObject = $this->_salesforceClient->getById(Account::TABLE_NAME, $id);
        } catch (SalesforceClientException $e) {
            if ($this->isNotFoundException($e)) {
                 return null;
            }

            throw $e;
        }

        return $salesforceObject->getObject();
    }

    /**
     * @param string $id id
     *
     * @return Contact | null
     *
     * @throws SalesforceClientException
     */
    public function findContact(string $id): ?Contact
    {
        try {
            $salesforceObject = $this->_salesforceClient->getById(Contact::TABLE_NAME, $id);
        } catch (SalesforceClientException $e) {
            if ($this->isNotFoundException($e)) {
                 return null;
            }

            throw $e;
        }

        return $salesforceObject->getObject();
    }

    /**
     * Clone of findContact
     *
     * @param string $id id
     *
     * @return Contact | null
     *
     * @throws SalesforceClientException
     */
    public function findRequiredContact(string $id): ?Contact
    {
        return $this->findContact($id);
    }

    /**
     * @param string $id id
     *
     * @return Npe5__Affiliation__c | null
     *
     * @throws SalesforceClientException
     */
    public function findAffiliation(string $id): ?Npe5__Affiliation__c
    {
        try {
            $salesforceObject = $this->_salesforceClient->getById(Npe5__Affiliation__c::TABLE_NAME, $id);
        } catch (SalesforceClientException $e) {
            if ($this->isNotFoundException($e)) {
                 return null;
            }

            throw $e;
        }

        return $salesforceObject->getObject();
    }

    /**
     * @param string $id id
     *
     * @return Npe5__Affiliation__c | null
     */
    public function findAffiliationEvenDeleted(string $id): ?Npe5__Affiliation__c
    {
        $queryBuilder = new QueryBuilder(Npe5__Affiliation__c::class, QueryBuilder::WITH_SOFT_DELETED);

        $queryBuilder
            ->select([
                'Id',
                'IsDeleted',
                'Name',
                'npe5__Contact__c',
                'npe5__Organization__c',
                'npe5__Primary__c',
                'npe5__Status__c',
                'npe5__Role__c',
            ])
            ->where(sprintf("Id = '%s'", $id))
        ;
        $salesforceObjectResults = $this->_salesforceClient->search($queryBuilder);

        if ($salesforceObjectResults->getTotalSize() === 1) {
            $salesforceObject = $salesforceObjectResults->getRecords()[0];

            return $salesforceObject->getObject();
        } else if ($salesforceObjectResults->getTotalSize() > 1) {
            // alert ?
            // $this->_logger->alert('Salesforce Model Repository - Find more than one result on findAffiliationEvenDeleted with id ' . $id);
        } else if ($salesforceObjectResults->getTotalSize() === 0) {
            // alert ?
            // $this->_logger->alert('Salesforce Model Repository - Can not find result on findAffiliationEvenDeleted with id ' . $id);
        }

        return null;
    }


    /**
     * @param string $contactId
     *
     * @return SalesforceObjectResults  Collection of Npe5__Affiliation__c
     */
    public function findAffilationFromContact(string $contactId): SalesforceObjectResults
    {
        $soqlQuery = new QueryBuilder(Npe5__Affiliation__c::class);
        $soqlQuery
            ->select([
                'Id',
                'IsDeleted',
                'Name',
                'npe5__Contact__c',
                'npe5__Organization__c',
                'npe5__Primary__c',
                'npe5__Status__c',
                'npe5__Role__c',
            ])
            ->where(sprintf("npe5__Contact__c = '%s'", $contactId))
        ;

        return $this->_salesforceClient->search($soqlQuery);
    }

    /**
     * @param string $contactId id
     *
     * @return Npe5__Affiliation__c | null
     */
    public function findMainAffiliationForContact(string $contactId): ?Npe5__Affiliation__c
    {
        $soqlQuery = new QueryBuilder(Npe5__Affiliation__c::class);
        $soqlQuery
            ->select([
                'Id',
                'IsDeleted',
                'Name',
                'npe5__Contact__c',
                'npe5__Organization__c',
                'npe5__Primary__c',
                'npe5__Status__c',
                'npe5__Role__c',
            ])
            ->where(sprintf("npe5__Contact__c = '%s' AND npe5__Primary__c = true", $contactId))
        ;
        $salesforceObjectResults = $this->_salesforceClient->search($soqlQuery);

        if ($salesforceObjectResults->getTotalSize() > 0) {
            if ($salesforceObjectResults->getTotalSize() > 1) {
                // $this->_logger->alert('Salesforce Model Repository - Find more than one main affiliation with id ' . $contactId);
            }

            $salesforceObject = $salesforceObjectResults->getRecords()[0];

            return $salesforceObject->getObject();
        }

        return null;
    }

    /**
     * @param string $objectName
     * @param string $id
     * @param $data
     *
     * @return mixed
     *
     * @internal Useless function that must be removed
     * @deprecated Use $this->_salesforceClient->patch($object) instead
     */
    public function patchObject(string $objectName, string $id, $data)
    {
        $response = $this->_salesforceClient->patchObject(
            $objectName,
            $id,
            $data
        );

        return $response;
    }
}
