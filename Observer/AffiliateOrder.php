<?php
namespace Mageplaza\Affiliate\Observer;

class AffiliateOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
        \Mageplaza\GiftCard\Model\OrderFactory $orderCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
    }
    public function getCustomerID(){
        return $this->customerSession->getCustomer()->getId();
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        unset($_COOKIE[$key]);
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($_COOKIE);

    }
}
