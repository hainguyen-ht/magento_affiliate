<?php
namespace Mageplaza\Affiliate\Model\ResourceModel\History;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'history_id';
    protected $_eventPrefix = 'affiliate_history_collection';
    protected $_eventObject = 'history_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\Affiliate\Model\History', 'Mageplaza\Affiliate\Model\ResourceModel\History');
    }

}
