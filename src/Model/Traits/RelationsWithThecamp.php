<?php

namespace WakeOnWeb\SalesforceClient\Model\Traits;

/**
 * Trait RelationsWithThecamp
 *
 * @internal Works with constants prefixed with RELATION_WITH_THECAMP
 */
trait RelationsWithThecamp
{
    /**
     * @var array   List of integers
     */
    protected $relations_with_thecamp__c = [];

    /**
     * @return array
     */
    public function getRelations_with_thecamp__c(): array
    {
        return $this->relations_with_thecamp__c;
    }

    /**
     * @param array $relations_with_thecamp__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setRelations_with_thecamp__c(array $relations_with_thecamp__c): self
    {
        foreach ($relations_with_thecamp__c as $value) {
            if (false === in_array($value, $this->getRelations_with_thecamp__cList())) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown Relations_with_thecamp__c "%s"', $value)
                );
            }
        }

        $this->relations_with_thecamp__c = array_unique($relations_with_thecamp__c);

        return $this;
    }

    /**
     * @param int $relations_with_thecamp__c
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function addRelations_with_thecamp__c($relations_with_thecamp__c): self
    {
        if (false === in_array($relations_with_thecamp__c, $this->getRelations_with_thecamp__cList())) {
            throw new \InvalidArgumentException(
                sprintf('Unknown Relations_with_thecamp__c "%s"', $relations_with_thecamp__c)
            );
        }

        $this->relations_with_thecamp__c[] = $relations_with_thecamp__c;
        $this->relations_with_thecamp__c   = array_unique($this->relations_with_thecamp__c);

        return $this;
    }

    /**
     * Get list of relations_with_thecamp__c
     *
     * @return array
     */
    public static function getRelations_with_thecamp__cList(): array
    {
        return $this->getClassConstantsFromPrefix('RELATION_WITH_THECAMP');
    }
}
