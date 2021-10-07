<?php

namespace Xanweb\C5\Entity\Service;

use Concrete\Core\Support\Facade\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template T
 * @psalm-template T
 * @template-extends ServiceInterface<T>
 */
abstract class EntityService implements ServiceInterface
{
    private EntityRepository $repo;
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the repository for the entity class.
     */
    protected function repo(): EntityRepository
    {
        if (!isset($this->repo)) {
            $this->repo = $this->entityManager->getRepository($this->getEntityClass());
        }

        return $this->repo;
    }

    /**
     * {@inheritDoc}
     *
     * @return T
     * @psalm-return T
     * @see ServiceInterface::createEntity()
     */
    public function createEntity(): object
    {
        $app = Application::getFacadeApplication();

        return $app->make($this->getEntityClass());
    }

    /**
     * {@inheritDoc}
     *
     * @return array<int, T>
     * @psalm-return array<int, T>
     * @see ServiceInterface::getList()
     */
    public function getList(): array
    {
        return $this->repo()->findAll();
    }

    /**
     * {@inheritDoc}
     *
     * @return array<int, T>
     * @psalm-return array<int, T>
     * @see ServiceInterface::getSortedList()
     */
    public function getSortedList(array $orderBy = []): array
    {
        return $this->repo()->findBy([], $orderBy);
    }

    /**
     * {@inheritDoc}
     *
     * @return T|null The entity instance or NULL if the entity can not be found
     * @psalm-return T|null
     * @see ServiceInterface::getByID()
     */
    public function getByID($id): ?object
    {
        return $this->repo()->find($id);
    }

    /**
     * {@inheritDoc}
     *
     * @return T
     * @psalm-return T
     * @see ServiceInterface::create()
     */
    public function create(array $data = []): object
    {
        $entity = $this->createEntity();
        $entity->setPropertiesFromArray($data);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * {@inheritDoc}
     *
     * @param T $entity
     * @psalm-param T $entity
     *
     * @see ServiceInterface::update()
     */
    public function update($entity, array $data = []): bool
    {
        $entity->setPropertiesFromArray($data);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @param array<int, T> $entities
     * @psalm-param array<int, T> $entities
     *
     * @see ServiceInterface::bulkSave()
     */
    public function bulkSave(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

    /**
     * {@inheritDoc}
     *
     * @param T $entity
     * @psalm-param T $entity
     *
     * @see ServiceInterface::delete()
     */
    public function delete($entity): bool
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @param array<int, T> $entities
     * @psalm-param array<int, T> $entities
     *
     * @see ServiceInterface::bulkDelete()
     */
    public function bulkDelete(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }

        $this->entityManager->flush();
    }
}
