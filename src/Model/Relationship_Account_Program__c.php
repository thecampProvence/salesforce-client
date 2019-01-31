<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Relationship_Account_Program__c
 *
 * Represent a Salesforce object
 */
class Relationship_Account_Program__c implements Relationship_Account_Program__cMappingConstantsInterface
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;
    use Traits\TypeOfRelationship;

    CONST TABLE_NAME = 'Relationship_Account_Program__c';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $program__c;

    /**
     * @var string Account id
     */
    protected $account_name__c;

    /**
     * @var string
     */
    protected $account_program_key__c;

    /**
     * @var \DateTime
     */
    protected $subscription_date__c;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgram__c(): string
    {
        return $this->program__c;
    }

    /**
     * @param string $program__c
     *
     * @return self
     */
    public function setProgram__c(string $program__c): self
    {
        $this->program__c = $program__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount_name__c(): string
    {
        return $this->account_name__c;
    }

    /**
     * @param string $account_name__c
     *
     * @return self
     */
    public function setAccount_name__c(string $account_name__c): self
    {
        $this->account_name__c = $account_name__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount_program_key__c(): string
    {
        return $this->account_program_key__c;
    }

    /**
     * @param string $account_program_key__c
     *
     * @return self
     */
    public function setAccount_program_key__c(string $account_program_key__c): self
    {
        $this->account_program_key__c = $account_program_key__c;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSubscription_date__c(): ?\DateTime
    {
        return $this->subscription_date__c;
    }

    /**
     * @param \DateTime $subscription_date__c
     *
     * @return self
     */
    public function setSubscription_date__c(\DateTime $subscription_date__c): self
    {
        $this->subscription_date__c = $subscription_date__c;

        return $this;
    }
}
