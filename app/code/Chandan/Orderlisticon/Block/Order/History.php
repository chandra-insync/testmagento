<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * Instead of changing the core file,
 * use the override method because with a new concept of dependency injection
 * where classes inject dependencies (different objects) for an object instead of that object manually creating them internally.
 * That way overriding and manipulating with classes is much easier and allows us more ways of extending the native functionalities.
 * There are three type
 * Preference
 * Event and Observer
 * Plugin
 */
namespace Chandan\Orderlisticon\Block\Order;

use \Magento\Framework\App\ObjectManager;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;

/**
 * Sales order history block
 * Override this block to render the history.phtml file using getTemplate()
 * @api
 * @since 100.0.2
 */
class History extends \Magento\Sales\Block\Order\History
{


    public function getTemplate()
    {
        return 'order/history.phtml';
    }
}
