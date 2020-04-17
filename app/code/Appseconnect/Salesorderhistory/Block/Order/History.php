<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Appseconnect\Salesorderhistory\Block\Order;

use \Magento\Framework\App\ObjectManager;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;

/**
 * Sales order history block
 *
 * @api
 * @since 100.0.2
 */
class History extends \Magento\Sales\Block\Order\History
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();

    }

    public function getTemplate()
    {
        return 'order/history.phtml';
    }
}
