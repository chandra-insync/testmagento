<?php
namespace Chandan\SalesOrderMessageCustomerAccount\Block\Account\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;

class Info extends \Magento\Customer\Block\Account\Dashboard\Info
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollectionFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $_orderConfig;
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var \Appseconnect\B2BMage\Helper\ContactPerson\Data
     */
    public $helperContactPerson;

    protected $orders;

    protected $total;

    /**
     * Info constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param \Magento\Customer\Helper\View $helperView
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperContactPerson
     * @param \Magento\Sales\Model\Order\Config $orderConfig
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Customer\Helper\View $helperView,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Appseconnect\B2BMage\Helper\ContactPerson\Data $helperContactPerson,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    )
    {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_customerSession = $customerSession;
        $this->helperContactPerson = $helperContactPerson;
        $this->orderRepository = $orderRepository;
        $this->_orderConfig = $orderConfig;
        parent::__construct(
            $context,
            $currentCustomer,
            $subscriberFactory,
            $helperView,
            $data
        );
    }
    public function getOrders()
    {
        $this->total=[];
        if (!($customerId = $this->_customerSession->getCustomerId())) {
            return false;
        }
        $contactPersonRole = null;
        $salesrepId = null;
        $contactId = [];
        $customerType = $this->_customerSession->getCustomer()->getCustomerType();
        if ($customerType == 2) {
            $salesrepId = $customerId;
        } elseif ($customerType == 3) {
            $contactPersonId = $this->_customerSession->getCustomerId();
            $contactPersonRole = $this->_customerSession->getCustomer()->getContactpersonRole();
            $parentCustomerMapData = $this->helperContactPerson->getCustomerId($contactPersonId);
            $contactId[] = $parentCustomerMapData['customer_id'];
        }
        if (!$this->orders) {
            if ($contactPersonRole == 2) {
                $orderCollection = $this->_orderCollectionFactory->create()
                    ->addFieldToFilter('contact_person_id', $contactPersonId);
            } elseif ($salesrepId) {
                $orderCollection = $this->_orderCollectionFactory->create()
                    ->addFieldToFilter('salesrep_id', $salesrepId);
            } elseif ($contactId) {
                $orderCollection = $this->_orderCollectionFactory->create()
                    ->addFieldToFilter('customer_id', [
                        'in' => $contactId
                    ]);
            } else {
                $orderCollection = $this->_orderCollectionFactory->create()
                    ->addFieldToFilter('customer_id', $customerId);
            }
            $this->orders = $orderCollection->addFieldToSelect('*')
                ->addFieldToFilter('status', [
                    'in' => $this->_orderConfig->getVisibleOnFrontStatuses()
                ])
                ->setOrder('created_at', 'desc');
        }
        return $this->orders;
    }
    public function getOrderItems($order_id)
    {
        return $this->orderRepository->get($order_id);
    }
    public function getDifferentSku($order_items)
    {
        $Sku = $this->total;
        foreach ($order_items->getAllVisibleItems() as $key_items => $value_items) {
            $Sku[] = $value_items->getSku();
        }
        $this->total = $Sku;
        return array_unique($this->total);
    }
    public function getTemplate()
    {
        return 'account/dashboard/info.phtml';
    }
}
