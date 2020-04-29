<?php
namespace Lovely\AddtoCartLogin\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
class Redirect implements ObserverInterface
{
    /**
     * @var Session
     */
    public $customerSession;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    public $messageManager;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    public $url;
    /**
     * @var \Magento\Framework\App\ResponseFactory
     */
    public $responseFactory;

    /**
     * Redirect constructor.
     * @param Session $session
     * @param \Magento\Framework\App\ResponseFactory $responseFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        Session $session,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\UrlInterface $url

    ) {
        $this->customerSession = $session;
        $this->responseFactory = $responseFactory;
        $this->messageManager = $messageManager;
        $this->url = $url;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void @codeCoverageIgnore
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!$this->customerSession->isLoggedIn()) {
            $this->messageManager->addError('Before add to cart You need to login first');
            $redirectionUrl = $this->url->getUrl('customer/account/login');
            $this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
            die();
        }
    }
}
