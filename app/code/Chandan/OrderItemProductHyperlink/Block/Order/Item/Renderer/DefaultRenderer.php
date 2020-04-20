<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Chandan\OrderItemProductHyperlink\Block\Order\Item\Renderer;

use Magento\Sales\Model\Order\CreditMemo\Item as CreditMemoItem;
use Magento\Sales\Model\Order\Invoice\Item as InvoiceItem;
use Magento\Sales\Model\Order\Item as OrderItem;

/**
 * Order item render block
 *
 * @api
 * @since 100.0.2
 */
class DefaultRenderer extends \Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer
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
        return 'order/items/renderer/default.phtml';
    }
}
