<?php
namespace Mageplaza\Affiliate\Controller\Mananger;
use Magento\Framework\Controller\ResultFactory;
class Register extends \Magento\Framework\App\Action\Action{
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->customerSession = $customerSession;
        $this->accountFactory = $accountFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    public function getCustomerID(){
        return $this->customerSession->getCustomerId();
    }
    protected function random($length){
        $iString = 'ABCDEFGHIJKLMLOPQRSTUVXYZ0123456789';
        $oString = '';
        for($i = 0; $i < $length; $i++) {
            $charS = $iString[mt_rand(0, strlen($iString) - 1)];
            $oString .= $charS;
        }
        return $oString;
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        if(!$this->getCustomerID()){
            return $this->redirect();
        }
        $account = $this->accountFactory->create();
        if($account->load($this->getCustomerID(), 'customer_id')->getData()){
            $this->messageManager->addWarning(__('You are already a Affiliate!'));
            return $resultRedirect;
        }
        else{
            $codeLength = $this->scopeConfig->getValue('affiliate/general/code_length',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $account->addData([
                'customer_id' => $this->getCustomerID(),
                'code' => strtolower($this->random($codeLength)),
                'status' => 1,
                'balance' => 0
            ])->save();
            $this->messageManager->addSuccess(__('You have become a Affiliate'));
            return $resultRedirect;
        }
    }
}
?>
