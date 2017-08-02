<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\MessageQueue;

/**
 * Class \Magento\Framework\MessageQueue\ExchangeRepository
 *
 * @since 2.0.0
 */
class ExchangeRepository
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     * @since 2.0.0
     */
    private $objectManager;

    /**
     * @var ExchangeFactoryInterface
     * @since 2.2.0
     */
    private $exchangeFactory;

    /**
     * Pool of exchange instances.
     *
     * @var ExchangeInterface[]
     * @since 2.2.0
     */
    private $exchangePool = [];

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string[] $exchanges
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @since 2.0.0
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, array $exchanges = [])
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $connectionName
     * @return ExchangeInterface
     * @throws \LogicException
     * @since 2.0.0
     */
    public function getByConnectionName($connectionName)
    {
        if (!isset($this->exchangePool[$connectionName])) {
            $exchange = $this->getExchangeFactory()->create($connectionName);
            $this->exchangePool[$connectionName] = $exchange;
        }
        return $this->exchangePool[$connectionName];
    }

    /**
     * Get exchange factory.
     *
     * @return ExchangeFactoryInterface
     * @deprecated 2.2.0
     * @since 2.2.0
     */
    private function getExchangeFactory()
    {
        if ($this->exchangeFactory === null) {
            $this->exchangeFactory = $this->objectManager->get(ExchangeFactoryInterface::class);
        }
        return $this->exchangeFactory;
    }
}
