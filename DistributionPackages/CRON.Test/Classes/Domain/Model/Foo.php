<?php

namespace CRON\Test\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Foo
{
    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    protected $idx;
}
