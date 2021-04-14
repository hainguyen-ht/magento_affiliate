<?php
namespace Mageplaza\Affiliate\Controller\Refer;
use Mageplaza\Affiliate\Model\AccountFactory;
use Magento\Framework\Controller\ResultFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Customer\Model\Session $customerSession,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->customerSession = $customerSession;
        $this->accountFactory = $accountFactory;
        $this->redirect = $redirect;
        $this->response = $response;
        parent::__construct($context);
    }
    public function redirect(){
        return $this->redirect->redirect($this->response, 'customer/account/login');
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $customerID = $this->customerSession->getCustomerId();
//check login
        if(!$customerID){
            return $this->redirect();
        }
        $account = $this->accountFactory->create()->load($customerID, 'customer_id')->getData();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//check affiliate
        if($account){
            return $resultRedirect;
        }
        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $code = $this->request->getParam($key);
        $cookieValue = $code;
        setcookie($key, $cookieValue, time() + (86400 * 365), '/');
        $this->messageManager->addSuccess(__('Refer Link success'));
        return $resultRedirect;
    }
}
