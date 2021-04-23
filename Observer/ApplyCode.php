<?php
namespace Mageplaza\Affiliate\Observer;
use Mageplaza\Affiliate\Model\Account;

class ApplyCode implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Framework\UrlInterface $url
    )
    {
        $this->accountFactory = $accountFactory;
        $this->checkoutSession = $checkoutSession;
        $this->messageManager = $messageManager;
        $this->actionFlag = $actionFlag;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $account = $this->accountFactory->create();
        //get Ccde
        //Magento\Checkout\Controller\Cart\CouponPost
        $code = $observer->getControllerAction()->getRequest()->getParam('coupon_code');
        //get action 0->apply, 1->cancel
        $actionS = $observer->getControllerAction()->getRequest()->getPostValue('remove');

        if($actionS == 0){
            foreach ($account->getCollection()->getData() as $item){
                if($item['code'] == $code){
                    $this->checkoutSession->setCode($code);
                    $this->messageManager->addSuccess('You applied coupon code success!');
                    $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                }
            }
        }
        if($actionS == 1){
            $this->checkoutSession->setCode(null);
            $this->messageManager->addWarning('You cancel coupon code!');
            $this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
        }

        $redirectionUrl = $this->url->getUrl('checkout/cart/index/');
        return $observer->getControllerAction()->getResponse()->setRedirect($redirectionUrl);
    }
}
