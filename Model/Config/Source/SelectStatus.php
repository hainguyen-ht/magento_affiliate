<?php

namespace Mageplaza\Affiliate\Model\Config\Source;

class SelectStatus implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Test One')],
            ['value' => 2, 'label' => __('Test Two')],
            ['value' => 3, 'label' => __('Test Three')],
        ];
    }
}
