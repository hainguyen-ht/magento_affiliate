<?php
namespace Mageplaza\Affiliate\Block\Adminhtml\Account\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    )
    {
        $this->accountFactory = $accountFactory;
        $this->scopeConfig = $scopeConfig;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('affiliate_form_data');

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Account Infomation')]);
        //get name customer
        if($model->getID()){
            $customer = $this->customerFactory->create();
            $customerById = $customer->load($model->getData()['customer_id'])->getData();
            $cName = $customerById['firstname'] . ' ' .$customerById['lastname'] . ' (' . $customerById['email'] . ')' ;
        }

        if($model->getID())
        {
            $fieldset->addField(
                'customer_text',
                'label', [
                    'name'     => 'customer',
                    'label'    => __('Customer ID'),
                    'title'    => __('customer_id'),
                    'value'    => $model->getData()['customer_id']
                ]
            );

            $fieldset->addField(
                'customer_id',
                'hidden', [
                    'name'     => 'customer_id',
                    'label'    => __('Customer ID'),
                    'title'    => __('customer_id'),
                    'required' => true
                ]
            );

            $fieldset->addField(
                'account_id',
                'hidden',
                [
                    'name' => 'account_id',
                    'label' => __('ID'),
                    'title' => __('ID'),
                    'disabled' => false,
                ]
            );

            $fieldset->addField(
                'customer_name',
                'label',
                [
                    'label' => __('Customer Name'),
                    'title' => __('Customer Name'),
                    'name' => 'customer_name',
                    'value' => $cName
                ]
            );
            $fieldset->addField(
                'code',
                'label',
                [
                    'label' => __('Code'),
                    'title' => __('Code'),
                    'name' => 'code'
                ]
            );
        }
        else
        {
            $fieldset->addField(
                'customer_id',
                'text', [
                    'name'     => 'customer_id',
                    'label'    => __('Customer ID'),
                    'title'    => __('customer_id'),
                    'required' => true
                ]
            );
            $codeLength = $this->scopeConfig->getValue('affiliate/general/code_length',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

            $fieldset->addField(
                'code_length',
                'hidden', [
                    'name'     => 'code_length',
                    'label'    => __('Customer ID'),
                    'title'    => __('code_length')
                ]
            );

            $model->addData(['code_length'=> $codeLength]);
        }

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => ('Active'), '0' => ('InActive')]
            ]
        );

        $fieldset->addField(
            'balance',
            'text', [
                'name'     => 'balance',
                'label'    => __('Balance'),
                'title'    => __('balance'),
                'required' => true
            ]
        );
        if($model->getID()){
            $fieldset->addField(
                'created_at',
                'label', [
                    'name'     => 'created_at',
                    'label'    => __('Created At'),
                    'title'    => __('created_at')
                ]
            );
        }
        $form->addValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return __('Account information');
    }
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
?>

