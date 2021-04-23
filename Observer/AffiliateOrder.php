<?php
namespace Mageplaza\Affiliate\Observer;

class AffiliateOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Mageplaza\Affiliate\Model\HistoryFactory $historyFactory,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Mageplaza\Affiliate\Helper\Email $helperEmail,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->customerSession = $customerSession;
        $this->_pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->historyFactory = $historyFactory;
        $this->accountFactory = $accountFactory;
        $this->orderFactory = $orderFactory;
        $this->helperEmail = $helperEmail;
        $this->checkoutSession= $checkoutSession;
    }
    public function getCustomerID(){
        return $this->customerSession->getCustomer()->getId();
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $commissionValue = $this->scopeConfig->getValue('affiliate/affiliate_rule/commission_value',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $commissionType = $this->scopeConfig->getValue('affiliate/affiliate_rule/commission_type',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        //get code session
        $codeSession = $this->checkoutSession->getCode();
        if(isset($codeSession)){
            $code = $codeSession;
        }else if(isset($_COOKIE[$key])){
            $code = $_COOKIE[$key];
        }

        if($code != null){
            //Create History
            $history = $this->historyFactory->create();
            $account = $this->accountFactory->create();
//            //Get ID aff of customer
            $affiliateID = $account->load($code, 'code')->getData('customer_id');
//
//            //Get data Order by customer
            $orders = array();
            foreach ($this->orderFactory->create()->getCollection()->getData() as $item){
                if($item['customer_id'] == $this->getCustomerID()){
                    $orders[] = $item;
                }
            }
//            //Get new order
            $newOrder = $orders[0];
            foreach ($orders as $item){
                if($newOrder['entity_id'] < $item['entity_id']){
                    $newOrder = $item;
                }
            }
//            // Get order total
            $grandTotal = $newOrder['subtotal'];
//          check commissiontype
            $per = 0;
            switch ($commissionType){
                case 'fixed':
                    $per = $commissionValue;
                    break;
                case 'percentage':
                    $per = $grandTotal / 100 * $commissionValue;
                    break;
                default:
                    $per = 0;
            }
            //Commisstion Affiliate
            $account->load($code, 'code');
            $addBalance = $account->addData([
                'balance' => $account->load($code, 'code')->getData()['balance'] + $per
            ])->save();
//            //save History
            if($addBalance){
                $history->addData([
                    'order_id' => $newOrder['entity_id'],
                    'order_increment_id' => $newOrder['increment_id'],
                    'customer_id' => $affiliateID,
                    'is_admin_change' => 0,
                    'amount' => $per,
                    'status' => 1
                ])->save();
            }
            $orderID = $observer->getEvent()->getOrder()->getId();
            //save sales_order
            $this->orderFactory->create()->load($orderID)->addData([
                'base_discount_referral_affiliate' => $_COOKIE['amountRefer'] ?? 0,
                'base_commisstion_referral_affiliate' => $per ?? 0
            ])->save();

            //Unset cookie
            unset($_COOKIE[$key]);
            setcookie($key, null, -1, '/');
//            sendMail
            if($per > 0){
                return $this->helperEmail->sendEmail();
            }
        }
    }
}
