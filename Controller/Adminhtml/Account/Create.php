<?php
namespace Mageplaza\Affiliate\Controller\Adminhtml\Account;
use Magento\Backend\App\Action;
/**
 * Edit form controller
 */
class Create extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Session $adminSession
    ) {
        $this->_coreRegistry = $registry;
        $this->adminSession = $adminSession;
        parent::__construct($context);
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $this->_forward('edit');

    }
}
