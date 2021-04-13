<?php

namespace Mageplaza\Affiliate\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => ('Active')],
            ['value' => 0, 'label' => ('InActive')]
        ];
    }
}
