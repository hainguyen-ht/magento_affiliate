<?php
namespace Mageplaza\Affiliate\Controller\Adminhtml\Account;

class Delete extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory
    ) {
        parent::__construct($context);
        $this->accountFactory = $accountFactory;
    }
//    protected function _isAllowed()
//    {
//        return $this->_authorization->isAllowed('Mageplaza_GiftCard::giftcard');
//    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $postObj = $this->getRequest()->getPostValue();
        $id = $this->getRequest()->getParams('id')['id'] ?? null;
        $ids = $postObj['selected'] ?? null;
        $resultRedirect = $this->resultRedirectFactory->create();
        if($ids){
            foreach ($ids as $id){
                try {
                    $model = $this->accountFactory->create();
                    $model->load($id);
                    $model->delete();
                    $this->messageManager->addSuccess(__('The account has been deleted.'));
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    return $resultRedirect->setPath('*/*/index', ['id' => $id]);
                }
            }
            return $resultRedirect->setPath('*/*/');
        }

        if ($id) {
            try {
                $model = $this->accountFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The post has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/index', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a post to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
