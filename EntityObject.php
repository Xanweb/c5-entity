<?php

namespace Xanweb\C5\Entity;

use Xanweb\Common\Traits\JsonSerializableTrait;
use Xanweb\Common\Traits\ObjectTrait;

abstract class EntityObject implements \JsonSerializable
{
    use JsonSerializableTrait;
    use ObjectTrait;
}