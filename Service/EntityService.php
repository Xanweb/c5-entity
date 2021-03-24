<?php

namespace Xanweb\C5\Entity\Service;

use Concrete\Core\Support\Facade\Application;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class EntityService implements ServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the repository for the entity class.
     */
    protected function repo(): EntityRepository
    {
        if (!$this->repo) {
            $this->repo = $this->entityManager->getRepository($this->getEntityClass());
        }

        return $this->repo;
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::createEntity()
     */
    public function createEntity()
    {
        $app = Application::getFacadeApplication();

        return $app->make($this->getEntityClass());
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::getList()
     */
    public function getList()
    {
        return $this->repo()->findAll();
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::getSortedList()
     */
    public function getSortedList($orderBy = [])
    {
        return $this->repo()->findBy([], $orderBy);
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::getByID()
     */
    public function getByID($id)
    {
        return $this->repo()->find($id);
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::create()
     */
    public function create(array $data = [])
    {
        $entity = $this->createEntity();
        $entity->setPropertiesFromArray($data);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * {@inheritdoc}
     *
     * @see ServiceInterface::update()
     */
    public function update($entity, array $data = [])
    {
        $entity->setPropertiesFromArray($data);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return true;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
