<?php
namespace Mageplaza\Affiliate\Controller\Adminhtml\Account;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->accountFactory = $accountFactory;
        $this->_coreRegistry = $registry;
        $this->adminSession = $adminSession;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->accountFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This account record no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->adminSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('affiliate_form_data', $model);
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
