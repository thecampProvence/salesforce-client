<?php

namespace WakeOnWeb\SalesforceClient\Repository;

use Psr\Log\LoggerInterface;
use WakeOnWeb\SalesforceClient\ClientInterface;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObject;
use WakeOnWeb\SalesforceClient\DTO\SalesforceObjectResults;
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
     * @param string $id id
     *
     * @return Contact | null
     */
    public function findRequiredContact(string $id): ?Contact
    {
        $salesforceObject = $this->_salesforceClient->getById(Contact::TABLE_NAME, $id);

        return $salesforceObject->getObject();
    }

    /**
     * @param string $id id
     *
     * @return Npe5__Affiliation__c | null
     */
    public function findAffiliation(string $id): ?Npe5__Affiliation__c
    {
        $salesforceObject = $this->_salesforceClient->getById(Npe5__Affiliation__c::TABLE_NAME, $id);

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

            // var_dump('--------------- findAffiliationEvenDeleted', $salesforceObjectResults->getRecords()); exit;

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

        // try {
        //     $soQuery = "SELECT Id,IsDeleted,Name,npe5__Contact__c,npe5__Organization__c," .
        //         "npe5__Primary__c,npe5__Status__c,npe5__Role__c " .
        //         "FROM npe5__Affiliation__c WHERE Id = '%s'";
        //     $salesforceObjectResults = $this->_salesforceClient->searchSOQL(sprintf($soQuery, $id), $this->_salesforceClient::ALL);
        //     if ($salesforceObjectResults->getTotalSize() > 1) {
        //         $this->_logger->alert('Salesforce Model Repository - Find more than one result on findAffiliationEvenDeleted with id ' . $id);
        //     } else if (0 === $salesforceObjectResults->getTotalSize()) {
        //         $this->_logger->alert('Salesforce Model Repository - Can not find result on findAffiliationEvenDeleted with id ' . $id);
        //     }
        //     $salesforceObject = $salesforceObjectResults->getRecords()[0];
        // } catch (\Exception $e) {
        //     $this->_logger->debug('Salesforce Model Repository - Can not find result on findAffiliationEvenDeleted with id ' . $id . ' | ' . $e->getMessage());
        //     return null;
        // }
        // return $this->_denormalizer->denormalize($salesforceObject->getFields(), Affiliation::class);
    }


    /**
     * @param string $contactId
     *
     * @return SalesforceObjectResults  Collection of Npe5__Affiliation__c
     */
    public function findAffilationFromContact(string $contactId): SalesforceObjectResults
    {
        $soqlQuery = new QueryBuilder(
            Npe5__Affiliation__c::class,
            QueryBuilder::WITH_SOFT_DELETED
        );
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

        // $aAffilation = [];
        // try {
        //     $soQuery = "SELECT Id,IsDeleted,Name,npe5__Contact__c,npe5__Organization__c," .
        //         "npe5__Primary__c,npe5__Status__c,npe5__Role__c " .
        //         "FROM npe5__Affiliation__c WHERE npe5__Contact__c = '%s'";
        //     $salesforceResults = $this->_salesforceClient->searchSOQL(sprintf($soQuery, $id));

        //     if ($salesforceResults->getTotalSize() > 0) {
        //         foreach ($salesforceResults->getRecords() as $record) {
        //             $aAffilation[] = $this->_denormalizer->denormalize($record->getFields(), Affiliation::class);
        //         }
        //     }
        // } catch (\Exception $e) {
        //     /**
        //      * @todo faire un log pour cette erreur
        //      */
        // }
        // return $aAffilation;
    }

    /**
     * @param string $contactId id
     *
     * @return Npe5__Affiliation__c | null
     */
    public function findMainAffiliationForContact(string $contactId): ?Npe5__Affiliation__c
    {
        $soqlQuery = new QueryBuilder(
            Npe5__Affiliation__c::class,
            QueryBuilder::WITH_SOFT_DELETED
        );
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
     * @param string $id id
     *
     * @return Account | null
     */
    public function findAccount(string $id): ?Account
    {
        $salesforceObject = $this->_salesforceClient->getById(Account::TABLE_NAME, $id);

        return $salesforceObject->getObject();
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
