<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\MessageQueue;

/**
 * Factory class for @see \Magento\Framework\MessageQueue\ExchangeInterface
 *
 * @api
 * @since 2.2.0
 */
class ExchangeFactory implements ExchangeFactoryInterface
{
    /**
     * @var ExchangeFactoryInterface[]
     * @since 2.2.0
     */
    private $exchangeFactories;

    /**
     * @var ConnectionTypeResolver
     * @since 2.2.0
     */
    private $connectionTypeResolver;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     * @since 2.2.0
     */
    protected $objectManager = null;

    /**
     * Initialize dependencies.
     *
     * @param ConnectionTypeResolver $connectionTypeResolver
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param ExchangeFactoryInterface[] $exchangeFactories
     * @since 2.2.0
     */
    public function __construct(
        ConnectionTypeResolver $connectionTypeResolver,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $exchangeFactories = []
    ) {
        $this->objectManager = $objectManager;
        $this->exchangeFactories = $exchangeFactories;
        $this->connectionTypeResolver = $connectionTypeResolver;
    }

    /**
     * {@inheritdoc}
     * @since 2.2.0
     */
    public function create($connectionName, array $data = [])
    {
        $connectionType = $this->connectionTypeResolver->getConnectionType($connectionName);

        if (!isset($this->exchangeFactories[$connectionType])) {
            throw new \LogicException("Not found exchange for connection name '{$connectionName}' in config");
        }

        $factory = $this->exchangeFactories[$connectionType];
        $exchange = $factory->create($connectionName, $data);

        if (!$exchange instanceof ExchangeInterface) {
            $exchangeInterface = \Magento\Framework\MessageQueue\ExchangeInterface::class;
            throw new \LogicException(
                "Exchange for connection name '{$connectionName}' " .
                "does not implement interface '{$exchangeInterface}'"
            );
        }
        return $exchange;
    }
}
