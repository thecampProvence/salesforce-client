<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use WakeOnWeb\SalesforceClient\Model\Npe5__Affiliation__c;

/**
 * Class Npe5__Affiliation__cNormalizer.
 */
class Npe5__Affiliation__cNormalizer extends AbstractNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Npe5__Affiliation__c;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Npe5__Affiliation__c::class === $type;
    }
}
