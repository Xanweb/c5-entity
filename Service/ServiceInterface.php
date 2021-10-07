<?php

namespace Xanweb\C5\Entity\Service;

/**
 * Interface ServiceInterface
 *
 * @template T
 * @psalm-template T
 */
interface ServiceInterface
{
    /**
     * Get full entity class name.
     *
     * @return class-string<T>
     */
    public function getEntityClass(): string;

    /**
     * Create New Entity instance.
     *
     * @return T
     * @psalm-return T
     */
    public function createEntity(): object;

    /**
     * Finds all entities in the repository.
     *
     * @return array<int, T>
     * @psalm-return array<int, T>
     */
    public function getList(): array;

    /**
     * Finds all entities in the repository sorted by given fields.
     *
     * @param array $orderBy
     *
     * @return array<int, T>
     * @psalm-return array<int, T>
     */
    public function getSortedList(array $orderBy = []): array;

    /**
     * Finds the entity by its primary key / identifier.
     *
     * @param mixed $id The identifier
     *
     * @return T|null The entity instance or NULL if the entity can not be found
     * @psalm-return T|null
     */
    public function getByID($id): ?object;

    /**
     * Create Entity.
     *
     * @param array $data
     *
     * @return T
     * @psalm-return T
     */
    public function create(array $data = []): object;

    /**
     * Update Entity.
     *
     * @param T $entity
     *
     * @return bool
     * @psalm-param T $entity
     */
    public function update($entity, array $data = []): bool;

    /**
     * Persist a list of entities and flush all changes.
     *
     * @param array<int, T> $entities
     *
     * @psalm-param array<int, T> $entities
     */
    public function bulkSave(array $entities);

    /**
     * Delete Entity.
     *
     * @param T $entity
     *
     * @return bool
     * @psalm-param T $entity
     */
    public function delete($entity): bool;

    /**
     * Delete a list of entities and flush all changes.
     *
     * @param array<int, T> $entities
     *
     * @psalm-param array<int, T> $entities
     */
    public function bulkDelete(array $entities);
}
