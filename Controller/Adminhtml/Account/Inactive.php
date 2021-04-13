<?php
namespace Mageplaza\Affiliate\Controller\Adminhtml\Account;

class Inactive extends \Magento\Backend\App\Action{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory
    )
    {
        $this->accountFactory = $accountFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $postObj = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $ids = $postObj['selected'] ?? null;
        if($ids){
            foreach ($ids as $id){
                $account = $this->accountFactory->create();
                $account->load($id);
                $account->addData(['status' => 0])->save();
                $this->messageManager->addSuccess(__('The account has been inActived.'));
            }
            return $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect->setPath('*/*/');

    }
}
?>
