<?php

namespace WakeOnWeb\SalesforceClient\Query;

use WakeOnWeb\SalesforceClient\Model;

/**
 * Class SOQL QueryBuilder
 *
 * @todo Add LIMIT
 * @todo Add ORDER BY
 */
class QueryBuilder
{
    CONST WITH_SOFT_DELETED    = true;
    CONST WITHOUT_SOFT_DELETED = false;

    /**
     * Array containing the query data.
     *
     * @var array
     */
    protected $query = [];

    /**
     * ReflectionClass of object used in query
     *
     * @var \ReflectionClass
     */
    protected $objectInfo;

    /**
     * @var bool
     */
    protected $includeSoftDeleted;

    /**
     * Create a new query builder.
     *
     * @param string $objectNamespace
     */
    public function __construct(string $objectNamespace, bool $includeSoftDeleted = self::WITHOUT_SOFT_DELETED)
    {
        $this->from($objectNamespace);
        $this->includeSoftDeleted = $includeSoftDeleted;
    }

    /**
     * Get value of includeSoftDeleted
     *
     * @return bool
     */
    public function includeSoftDeleted()
    {
        return $this->includeSoftDeleted;
    }

    /**
     * Get model class name from objectInfo
     *
     * @return string
     */
    public function getModelClassName()
    {
        return $this->objectInfo->getShortName();
    }

    /**
     * Add FROM statement to SOQL query
     *
     * @param string $objectNamespace
     *
     * @return self
     *
     * @throws \ReflectionException
     */
    protected function from(string $objectNamespace)
    {
        $this->objectInfo    = new \ReflectionClass($objectNamespace);
        $this->query['from'] = $this->objectInfo->getConstant('TABLE_NAME');

        return $this;
    }

    /**
     * Add SELECT statement to SOQL query
     *
     * @param string $fieldsNames
     *
     * @return self
     */
    public function select(array $fieldsNames = ['id'])
    {
        // $fieldsNames = array_map('strtolower', $fieldsNames);

        foreach ($fieldsNames as $fieldName) {
            /**
             * @internal hasProperty is case sensitive but hasMethod is not
             */
            // if (false === $this->objectInfo->hasProperty($fieldName)) {
            if (false === $this->objectInfo->hasMethod('set'.$fieldName)) {
                throw new \InvalidArgumentException(sprintf(
                    'Field name "%s" does not exist in %s model',
                    $fieldName,
                    $this->objectInfo->getShortName()
                ));
            }
        }

        $this->query['select'] = $fieldsNames;

        return $this;
    }

    /**
     * Set WHERE statement to SOQL query
     *
     * @param string $whereStatement
     *
     * @return self
     */
    public function where(string $whereStatement)
    {
        $this->query['where'] = $whereStatement;

        return $this;
    }

    /**
     * Generate SOQL final query
     *
     * @return string
     */
    public function getQuery()
    {
        $query = sprintf("SELECT %s", implode(', ', $this->query['select']));
        $query .= sprintf(" FROM %s", $this->query['from']);
        $query .= sprintf(" WHERE %s", $this->query['where']);

        return $query;
    }
}