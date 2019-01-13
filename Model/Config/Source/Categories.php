<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\LazyloadingInfiniteScroll\Model\Config\Source;

/**
 * Categories
 * @package Tutorialstab_ImportExportCategories
 */
class Categories implements \Magento\Framework\Option\ArrayInterface {

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_categoryFactory;

    /**
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        $this->_categoryFactory = $categoryFactory;
    }
    
    /**
     * Get options array
     * 
     * @return array
     */
    public function toOptionArray() {
        $result = [];
        $items = $this->_categoryFactory->create()->getCollection()->addAttributeToSelect(
                        'name'
                )->addAttributeToSort(
                        'entity_id', 'ASC'
                )->load()->getItems();
        foreach ($items as $item) {
            $result[] = [
                'label' => $item->getName(),
                'value' => $item->getEntityId()
            ];
        }


        return $result;
    }

}
