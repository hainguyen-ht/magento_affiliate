<?php
namespace Mageplaza\Affiliate\Controller\Mananger;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action {
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customer,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->customer = $customer;
        $this->response = $response;
        $this->redirect = $redirect;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function getCustomerID(){
        return $this->customer->getCustomerId();
    }
    public function redirect(){
        return $this->redirect->redirect($this->response, 'customer/account/login');
    }
//    public function execute() {
//        if(!$this->getCustomerID()){
//            return $this->redirect();
//        }
//        $this->_view->loadLayout();
//        $this->_view->renderLayout();
//    }
    public function execute()
    {

        if(!$this->getCustomerID()){
            return $this->redirect();
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('My Affiliate'));
        return $resultPage;
    }
}
?>
