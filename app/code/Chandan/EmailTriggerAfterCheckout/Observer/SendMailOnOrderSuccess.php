<?php
namespace Chandan\EmailTriggerAfterCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
class SendMailOnOrderSuccess implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderModel;
    /**
     * @var \Magento\Sales\Model\Order\Email\Sender\OrderSender
     */
    protected $orderSender;
    /**
     * @var \Magento\Sales\Model\OrderNotifier
     */
    protected $emailNotifier;

    /**
     * SendMailOnOrderSuccess constructor.
     * @param \Magento\Sales\Model\OrderFactory $orderModel
     * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
     * @param \Magento\Sales\Model\OrderNotifier $emailNotifier
     */
    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderModel,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Magento\Sales\Model\OrderNotifier $emailNotifier
    )
    {
        $this->orderModel = $orderModel;
        $this->orderSender = $orderSender;
        $this->emailNotifier = $emailNotifier;
    }

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\MailException
     */
    public function execute(Observer $observer)
    {
        $orderId = $observer->getEvent()->getOrder()->getId();
        if($orderId){
            $order = $this->orderModel->create()->load($orderId);
            $order->setCustomerEmail($order->getData('customer_email'));
            $this->emailNotifier->notify($order);
            $this->orderSender->send($order, true);
        }
    }
}
