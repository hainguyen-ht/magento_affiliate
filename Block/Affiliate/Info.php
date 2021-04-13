<?php
namespace Mageplaza\Affiliate\Block\Affiliate;

class Info extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Mageplaza\GiftCard\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Mageplaza\Affiliate\Model\HistoryFactory $historyFactory,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->scopeConfig = $scopeConfig;
        $this->accountFactory = $accountFactory;
        $this->historyFactory = $historyFactory;
        parent::__construct($context, $data);
    }
    public function getCustomerID(){
        return $this->customerSession->getCustomer()->getId();
    }
    public function getCustomers(){
        return $this->customerFactory->create();
    }
    public function getModelAccountAff(){
        return $this->accountFactory->create();
    }
    public function getModelHistory(){
        return $this->historyFactory->create();
    }
    public function referLink(){
        $urlRefer = 'http://localhost.com/affiliate/refer/index/';
        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $urlRefer = $urlRefer . $key . '/';
    }
//    public function isEnableConfig(){
//        return $this->scopeConfig->getValue('giftcard/general/enable_giftcard',
//            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//    }
    public function getFormAction()
    {
        return $this->getUrl('affiliate/mananger/register');
    }
}
