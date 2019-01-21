<?php

namespace WakeOnWeb\SalesforceClient\Model\Traits;

/**
 * Trait TypeOfRelationship
 *
 * @internal Works with constants prefixed with TYPE_OF_RELATIONSHIP
 */
trait TypeOfRelationship
{
    /**
     * @var array List of integers
     */
    protected $type_of_relationship_new__c = [];

    /**
     * @return array
     */
    public function getType_of_relationship_new__c(): array
    {
        return $this->type_of_relationship_new__c;
    }

    /**
     * @param array $type_of_relationship_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setType_of_relationship_new__c(array $type_of_relationship_new__c): self
    {
        foreach ($type_of_relationship_new__c as $value) {
            if (false === in_array($value, $this->getType_of_relationship_new__cList())) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown Type_of_relationship_new__c "%s"', $value)
                );
            }
        }

        $this->type_of_relationship_new__c = array_unique($type_of_relationship_new__c);

        return $this;
    }

    /**
     * @param int $type_of_relationship_new__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function addType_of_relationship_new__c($type_of_relationship_new__c): self
    {
        if (false === in_array($type_of_relationship_new__c, $this->getType_of_relationship_new__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Type_of_relationship_new__c "%s"', $type_of_relationship_new__c)
            );
        }

        $this->type_of_relationship_new__c[] = $type_of_relationship_new__c;
        $this->type_of_relationship_new__c   = array_unique($this->type_of_relationship_new__c);

        return $this;
    }

    /**
     * Get list of type_of_relationship_new__c
     *
     * @return array
     */
    public static function getType_of_relationship_new__cList(): array
    {
        return static::getClassConstantsFromPrefix('TYPE_OF_RELATIONSHIP');
    }
}
