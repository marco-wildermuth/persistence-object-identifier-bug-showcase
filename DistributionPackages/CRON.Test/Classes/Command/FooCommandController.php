<?php

namespace CRON\Test\Command;

use CRON\Test\Domain\Repository\FooRepository;
use Neos\Flow\Cli\CommandController;
use CRON\Test\Domain\Model\Foo;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Log\SystemLoggerInterface;

class FooCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var FooRepository
     */
    protected $fooRepository;

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     *
     */
    protected $systemLogger;

    public function __construct()
    {
        parent::__construct();
    }

    public function createFooCommand() {
        $foo = new Foo();
        $this->fooRepository->add($foo);
    }
}
