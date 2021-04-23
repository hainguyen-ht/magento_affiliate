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
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Mageplaza\Affiliate\Model\HistoryFactory $historyFactory,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->accountFactory = $accountFactory;
        $this->historyFactory = $historyFactory;
        $this->priceCurrency = $priceCurrency;
        $this->response = $response;
        $this->redirect = $redirect;
        parent::__construct($context, $data);
    }
    public function getCustomerID(){
        return $this->customerSession->getCustomer()->getId();
    }
    public function getModelAccountAff(){
        return $this->accountFactory->create();
    }
    public function getModelHistory(){
        return $this->historyFactory->create();
    }
    public function referLink(){
        $urlRefer = '127.0.0.1/magento/affiliate/refer/index/';
        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $urlRefer . $key . '/';
    }
    public function isEnableModule(){
        return $isEnable = $this->scopeConfig->getValue('affiliate/general/enable_affiliate',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    public function getFormAction()
    {
        return $this->getUrl('affiliate/mananger/register');
    }
    public function formatCurrency($price){
        return $this->priceCurrency->convertAndFormat($price);
    }
    public function redirect(){
        return $this->redirect->redirect($this->response, 'customer/account');
    }
}
