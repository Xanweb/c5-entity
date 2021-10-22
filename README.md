# ConcreteCMS Entity
[![Latest Version on Packagist](https://img.shields.io/packagist/v/xanweb/c5-entity.svg?style=flat-square)](https://packagist.org/packages/xanweb/c5-entity)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Reusable classes for entities

## Installation

Include library to your composer.json
```bash
composer require xanweb/c5-entity
```

## Usage
Simply you can extend EntityService and EntityObject classes to benefit from predefined methods

```php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MyEntityTable")
 */
class MyEntity extends \Xanweb\C5\Entity\EntityObject {
    ...
} 

/**
 * @method MyEntity createEntity()
 * @method MyEntity create($data)
 * @method MyEntity getByID($id)
 * @method MyEntity[] getList()
 * 
 * or if your IDE supports generic type
 * @implements EntityService<MyEntity>
 */
class MyEntityService extends \Xanweb\C5\Entity\Service\EntityService {
    /**
     * {@inheritdoc}
     *
     * @see \Xanweb\C5\Entity\Service\EntityService::getEntityClass()
     */
    public function getEntityClass(): string
    {
        return MyEntity::class;
    }
}
```

Use TimeStampableTrait to include created date and last updated date fields to your entity.<br>
Please note that usage of this trait requires "HasLifecycleCallbacks" annotation.<br>
See https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/annotations-reference.html#annref_haslifecyclecallbacks

```php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MyEntityTable")
 * @ORM\HasLifecycleCallbacks
 */
class MyEntity extends \Xanweb\C5\Entity\EntityObject {
    use \Xanweb\C5\Entity\Traits\TimeStampableTrait;
    ...
} 
```