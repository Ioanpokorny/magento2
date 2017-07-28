<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\MessageQueue;

/**
 * Producer to publish messages via a specific transport to a specific queue or exchange.
 *
 * @api
 * @since 2.0.0
 */
interface PublisherInterface
{
    /**
     * Publishes a message to a specific queue or exchange.
     *
     * @param string $topicName
     * @param array|object $data
     * @return null|mixed
     * @throws \InvalidArgumentException If message is not formed properly
     * @since 2.0.0
     */
    public function publish($topicName, $data);
}
