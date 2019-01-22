<?php

namespace WakeOnWeb\SalesforceClient\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class AbstractNormalizer.
 */
abstract class AbstractNormalizer implements NormalizerInterface, DenormalizerInterface
{
    CONST ISO8601_EXTENDED = 'Y-m-d\TH:i:s.vO';

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $objectProperties = $this->getObjectProperties($object);
        $data             = [];

        foreach ($objectProperties as $propertyName) {
            $getter        = 'get'.ucfirst($propertyName);
            $propertyValue = $object->$getter();

            if (true === is_null($propertyValue)) {
                continue;
            }

            switch (gettype($propertyValue)) {
                case 'array':
                    $propertyValue = implode(';', $propertyValue);

                    break;
                case 'object':
                    if ($propertyValue instanceof \DateTime) {
                        // $propertyValue = $propertyValue->format(\DateTime::ISO8601);
                        $propertyValue = $propertyValue->format(static::ISO8601_EXTENDED);
                    }

                    break;
            }

            $data[$propertyName] = $propertyValue;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function supportsNormalization($data, $format = null);

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object           = isset($context['object_to_populate']) ? $context['object_to_populate'] : new $class();
        $objectProperties = $this->getObjectProperties($object);
        $data             = array_change_key_case($data, CASE_LOWER);

        /**
         * @internal full list of model properties that are of type array
         */
        $arrayModelProperties = [
            'language_new__c',
            'nationality_new__c',
            'interests_new__c',
            'relations_with_thecamp__c',
            'type_of_relationship_new__c',
        ];

        foreach ($objectProperties as $propertyName) {
            if (false === isset($data[$propertyName]) || true === is_null($data[$propertyName])) {
                // var_dump($propertyName. ' Not found');

                continue;
            }

            $value = $data[$propertyName];

            if (false !== strpos($propertyName, '_date__c')) {
                $value = new \DateTime($value);
            }

            $getter = 'get'.ucfirst($propertyName);
            $setter = 'set'.ucfirst($propertyName);
            $adder  = 'add'.ucfirst($propertyName);

            if (true === in_array($propertyName, $arrayModelProperties)) {
                $extractedValuesList = array_filter(explode(';', $value));
                $existingValues      = $object->$getter();

                if (false === empty($existingValues)) {
                    foreach ($extractedValuesList as $extractedValue) {
                        $object->$adder($extractedValue);
                    }
                } else {
                    $object->$setter($extractedValuesList);
                }
            } else {
                $object->$setter($value);
            }
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function supportsDenormalization($data, $type, $format = null);

    /**
     * Get object properties that has a public setter method
     *
     * @param Object $object
     *
     * @return array
     */
    protected function getObjectProperties($object)
    {
        $objectMethods = get_class_methods($object);
        $objectSetters = array_filter($objectMethods, function ($methodName) {
            return 0 === strpos($methodName, 'set');
        });
        $objectProperties = array_map(function ($setterName) {
            // return lcfirst(preg_replace('/^set/i', '', $setterName));
            return strtolower(preg_replace('/^set/i', '', $setterName));
        }, $objectSetters);

        return $objectProperties;
    }
}
