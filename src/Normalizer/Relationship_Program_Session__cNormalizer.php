<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Relationship_Program_Session__c;

/**
 * Class Relationship_Program_Session__cNormalizer.
 */
class Relationship_Program_Session__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Relationship_Program_Session__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Relationship_Program_Session__c::class === $type;
    }
}
