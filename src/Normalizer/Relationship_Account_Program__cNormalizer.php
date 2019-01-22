<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Relationship_Account_Program__c;

/**
 * Class Relationship_Account_Program__cNormalizer.
 */
class Relationship_Account_Program__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Relationship_Account_Program__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Relationship_Account_Program__c::class === $type;
    }
}
