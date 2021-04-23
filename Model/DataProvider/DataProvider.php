<?php
namespace Mageplaza\Affiliate\Model\DataProvider;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $test;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Mageplaza\Affiliate\Model\ResourceModel\History\CollectionFactory $historyCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $historyCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $arr = array();
        $data = $this->collection->getData();
        $sample = [
            'items' => [
                [
                    'id' => 1,
                    'name' => 'First Item',
                    'amount' => 200
                ],
                [
                    'id' => 2,
                    'name' => 'Second Item',
                    'amount' => 200
                ],
                [
                    'id' => 3,
                    'name' => 'Third Item',
                    'amount' => 200
                ]
            ],
            'totalRecords' => 3
        ];
        $arr[] = $data;
        $arr = array_fill_keys(['items'], $data);
//        $data[] = $data;

//        $arr = json_encode($arr);
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/testc.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($arr);
        return $arr;
    }
}
