<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Created By : Rohan Hapani
 */
namespace Mageplaza\Affiliate\Controller\Adminhtml\Account;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_adminSession;

    public function __construct(
        Action\Context $context,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Mageplaza\Affiliate\Model\HistoryFactory $historyFactory,
        \Mageplaza\Affiliate\Helper\Email $helperEmail,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        $this->_adminSession = $adminSession;
        $this->accountFactory = $accountFactory;
        $this->historyFactory = $historyFactory;
        $this->helperEmail = $helperEmail;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
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

        $postObj = $this->getRequest()->getPostValue();

        $date = date("Y-m-d");
        $username = $this->_adminSession->getUser()->getFirstname();
        $userDetail = ["name" => $username, "created_at" => $date];
        $data = array_merge($postObj, $userDetail);
        $resultRedirect = $this->resultRedirectFactory->create();
        $customer = $this->customerFactory->create();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($postObj);


        if ($data) {
            $customerByID = $customer->load($data['customer_id'])->getEntityId();
            $account = $this->accountFactory->create();
            $history = $this->historyFactory->create();
            $id = $postObj['account_id'] ?? null;
            if ($id) {
               // edit Account
                if(!$account->load($id)->getData()){
                    $this->messageManager->addWarning(__('Account not found!'));
                    return $resultRedirect->setPath('*/*/');
                }

                $account->addData(
                    [
                        'status' => $data['status'],
                        'balance'=> $data['balance']
                    ]
                )->save();
                if($data['balance'] > 0){
                    $history->addData([
                        'customer_id'           => $account->load($id)->getData('customer_id'),
                        'is_admin_change'       => 1,
                        'amount'                => $data['balance'],
                        'status'                => $data['status']
                    ])->save();
                    //send Mail
                    $this->helperEmail->sendEmail();

                }
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->_adminSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('account/*/edit', ['id' => $account->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } else {
                //check customerID
                if(!$customerByID){
                    $this->messageManager->addError(__('ID customer does not exist in the table customer_entity'));
                    return $resultRedirect->setPath('*/*/');
                }else if($account->load($data['customer_id'], 'customer_id')->getData()){
                    $this->messageManager->addWarning(__('This customer is already an affiliate'));
                    return $resultRedirect->setPath('*/*/');
                }
                //CREATE Account
                if($data['balance'] < 0){
                    $this->messageManager->addWarning('Validate');
                    return $resultRedirect->setPath('*/*/');
                }
                //auto generate code => code
                $code = $this->random($postObj['code_length']);
                $addAccount = $account->addData([
                        'customer_id' => $data['customer_id'],
                        'code'        => strtolower($code),
                        'balance'     => $data['balance'],
                        'status'      => $data['status']
                    ])->save();
                if($data['balance'] > 0){
                    $history->addData([
                        'order_id'     => 1,
                        'order_increment_id' => 1,
                        'customer_id' =>$data['customer_id'],
                        'is_admin_change' => 1,
                        'amount' => $data['balance'],
                        'status' => $data['status']
                    ])->save();
                    //send Mail
                    $this->helperEmail->sendEmail();
                }
                $this->messageManager->addSuccess(__('The data has been saved.'));
                return $resultRedirect->setPath('*/*/');
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
