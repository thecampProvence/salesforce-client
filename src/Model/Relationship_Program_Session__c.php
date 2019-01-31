<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Relationship_Program_Session__c
 *
 * Represent a Salesforce object
 */
class Relationship_Program_Session__c
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;

    CONST TABLE_NAME = 'Relationship_Program_Session__c';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $session__c;

    /**
     * @var string
     */
    protected $program__c;

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
    public function getSession__c(): string
    {
        return $this->session__c;
    }

    /**
     * @param string $session__c
     *
     * @return self
     */
    public function setSession__c(string $session__c): self
    {
        $this->session__c = $session__c;

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
}
