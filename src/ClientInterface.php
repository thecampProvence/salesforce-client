<?php

namespace WakeOnWeb\SalesforceClient;

interface ClientInterface
{
    const ALL = true;
    const NOT_ALL = false;

    public function getAvailableResources(): array;

    public function getAllObjects(): array;

    public function getObjectMetadata(string $object, \DateTimeInterface $since = null): array;

    public function describeObjectMetadata(string $object, \DateTimeInterface $since = null): array;

    public function create(Model\SalesforceModelInterface $object): DTO\SalesforceObjectCreation;

    public function createObject(string $object, array $data): DTO\SalesforceObjectCreation;

    public function patch(Model\SalesforceModelInterface $object);

    public function patchObject(string $object, string $id, array $data);

    public function delete(Model\SalesforceModelInterface $object);

    public function deleteObject(string $object, string $id);

    public function getById(string $endpoint, string $id): DTO\SalesforceObject;

    public function getObject(string $object, string $id, array $fields = []): DTO\SalesforceObject;

    public function search(Query\QueryBuilder $queryBuilder): DTO\SalesforceObjectResults;

    public function searchSOQL(string $query, bool $all = false): DTO\SalesforceObjectResults;

    public function explainSOQL(string $query, bool $all = false): array;
}
