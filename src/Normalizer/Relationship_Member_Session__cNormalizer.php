<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Relationship_Member_Session__c;

/**
 * Class Relationship_Member_Session__cNormalizer.
 */
class Relationship_Member_Session__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Relationship_Member_Session__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Relationship_Member_Session__c::class === $type;
    }
}
