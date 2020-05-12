<?php

namespace CRON\Test\Command;

use CRON\Test\Domain\Model\Order;
use CRON\Test\Domain\Repository\OrderRepository;
use Neos\Flow\Cli\CommandController;

use Neos\Flow\Annotations as Flow;

class OrderCommandController extends CommandController
{

    /**
     * @Flow\Inject
     * @var OrderRepository
     */
    protected $orderRepository;


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Log\SystemLoggerInterface
     *
     */
    protected $systemLogger;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * OrderCommandController constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * Create Fake Orders
     *
     * Create a bunch of fake order items for testing purposes
     *
     * @param int $count number of fake items to create (defaults to 100)
     * @param int $sampleProductsCount number of sample products to prepare (defaults to 50)
     */
    public function createFakeOrdersCommand($count = 100, $sampleProductsCount = 50) {
        $this->outputLine('Creating %s orders...', [$count], LOG_INFO);

        for ($i=0; $i < $count; $i++) {

            $order = new Order();

            $this->orderRepository->add($order);
        }

        $this->persistenceManager->persistAll();

        $this->outputLine('Created %s orders', [$count], LOG_INFO);

    }

    /**
     * {@inheritdoc}
     */
    protected function outputLine($text = '', array $arguments = [], $logLevel = null)
    {

        parent::outputLine($text, $arguments);

        // log to systemLog if a logLevel was given
        if ($logLevel !== null) {
            array_unshift($arguments, $this->commandMethodName);
            $this->systemLogger->log(vsprintf('[CLI] category:%s - ' . $text, $arguments), $logLevel);
        }
    }
}
