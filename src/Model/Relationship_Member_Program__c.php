<?php

namespace WakeOnWeb\SalesforceClient\Model;

/**
 * Class Relationship_Member_Program__c
 *
 * Represent a Salesforce object
 */
class Relationship_Member_Program__c implements SalesforceModelInterface,Relationship_Member_Program__cMappingConstantsInterface
{
    use Traits\ConstantMethods;
    use Traits\IsDeleted;
    use Traits\TypeOfRelationship;

    CONST TABLE_NAME = 'Relationship_Member_Program__c';


    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $program__c;

    /**
     * @var string
     */
    protected $member__c;

    /**
     * @var string
     */
    protected $transaction_digitick_id__c;

    /**
     * @var string
     */
    protected $ticket_digitick_id__c;

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
    public function getMember__c(): string
    {
        return $this->member__c;
    }

    /**
     * @param string $member__c
     *
     * @return self
     */
    public function setMember__c(string $member__c): self
    {
        $this->member__c = $member__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransaction_digitick_id__c(): ?string
    {
        return $this->transaction_digitick_id__c;
    }

    /**
     * @param string $transaction_digitick_id__c
     *
     * @return self
     */
    public function setTransaction_digitick_id__c(string $transaction_digitick_id__c): self
    {
        $this->transaction_digitick_id__c = $transaction_digitick_id__c;

        return $this;
    }

    /**
     * @return string
     */
    public function getTicket_digitick_id__c(): ?string
    {
        return $this->ticket_digitick_id__c;
    }

    /**
     * @param string $ticket_digitick_id__c
     *
     * @return self
     */
    public function setTicket_digitick_id__c(string $ticket_digitick_id__c): self
    {
        $this->ticket_digitick_id__c = $ticket_digitick_id__c;

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
