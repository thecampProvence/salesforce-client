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
     * @var \ReflectionClass
     */
    private $objectInfo;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $objectProperties = $this->getObjectProperties($object);
        $data             = [];

        // var_dump('-------------- normalize', get_class($object));

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
                    } else {
                        throw new \UnexpectedValueException(sprintf(
                            'Handler of property type "%s" is not implemented (property name: "%s")',
                            get_class($propertyValue),
                            $propertyName
                        ));
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
         * @internal list of object properties that are of type array
         */
        $objectArrayProperties = $this->getObjectArrayProperties($object);

        // var_dump('-------------- denormalize', $class, $data, $objectProperties);

        foreach ($objectProperties as $propertyName) {
            if (false === isset($data[$propertyName]) || true === is_null($data[$propertyName])) {
                continue;
            }

            $value = $data[$propertyName];

            if (false !== strpos($propertyName, '_date__c')) {
                $value = new \DateTime($value);
            }

            $getter = 'get'.ucfirst($propertyName);
            $setter = 'set'.ucfirst($propertyName);
            $adder  = 'add'.ucfirst($propertyName);

            if (true === in_array($propertyName, $objectArrayProperties)) {
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
        if (!isset($this->objectInfo)) {
            $this->objectInfo = new \ReflectionClass($object);
        }

        return array_keys(
            array_change_key_case($this->objectInfo->getDefaultProperties(), CASE_LOWER)
        );
    }

    /**
     * Get object properties that are of type array
     *
     * @param Object $object
     *
     * @return array
     */
    protected function getObjectArrayProperties($object)
    {
        if (!isset($this->objectInfo)) {
            $this->objectInfo = new \ReflectionClass($object);
        }

        $properties      = $this->objectInfo->getDefaultProperties();
        $arrayProperties = array_filter($properties, function ($propertyValue) {
            return true === is_array($propertyValue);
        });

        return array_keys($arrayProperties);
    }
}
