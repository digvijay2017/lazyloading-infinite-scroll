<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\LazyloadingInfiniteScroll\Block;

/**
 * Init
 * @package Tutorialstab_LazyloadingInfiniteScroll
 */
class Init extends \Magento\Framework\View\Element\Template
{   
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;
    
    /**
     * @var \Tutorialstab\LazyloadingInfiniteScroll\Helper\Data
     */
    public $helperData; 
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * __construct
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Tutorialstab\LazyloadingInfiniteScroll\Helper\Data $helperData
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tutorialstab\LazyloadingInfiniteScroll\Helper\Data $helperData,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
        ) {
        parent::__construct($context, $data);  
        $this->helperData    = $helperData; 
        $this->coreRegistry = $registry;
        $this->storeManager = $storeManager;
    }
    
    /**
     * Get product list mode
     * 
     * @return string
     */
    public function getProductListMode()
    {  
        if ($currentMode = $this->getRequest()->getParam('product_list_mode')) {
            switch($currentMode){
                case 'grid':
                $productListMode = 'grid';
                break;
                case 'list':
                $productListMode = 'list';
                break;
                default:
                $productListMode = 'grid';
            }
        }
        else {
            $defaultMode = $this->helperData->getConfig('catalog/frontend/list_mode'); 
            switch($defaultMode){
                case 'grid-list':
                $productListMode = 'grid';
                break;
                case 'list-grid':
                $productListMode = 'list';
                break;
                case 'list':
                $productListMode = 'list';
                break;
                case 'grid':
                $productListMode = 'grid';
                break;
                default:
                $productListMode = 'grid';
            }
        }

        return $productListMode;
    }
    
    /**
     * Check if module enable
     * 
     * @return boolean
     */
    public function isEnable() {
        $fullAction       = $this->getRequest()->getFullActionName();
        if ($fullAction == 'catalog_category_view' && $category_obj = $this->coreRegistry->registry('current_category')) {
            $category = $category_obj->getId();
            $categories = explode(',', $this->helperData->getConfig('lazyloadinginfinitescroll/instances/categories'));  
            if($categories){
                foreach ($categories as $catid) {
                    if($category == $catid){
                        return true;
                    }
                } 
            }
        }
        $enabled_search   = $this->helperData->getConfig('lazyloadinginfinitescroll/instances/enabled_search');
        $enabled_advanced = $this->helperData->getConfig('lazyloadinginfinitescroll/instances/enabled_advanced');
        if (($enabled_search && $fullAction == 'catalogsearch_result_index') || ($enabled_advanced && $fullAction == 'catalogsearch_advanced_result')) {
            return true;
        }
        return false;  
    } 

    /**
     * @return bool|false
     */
    public function getLoaderImage()
    {

        $url = $this->helperData->getConfig('lazyloadinginfinitescroll/design/loading_image');
        if(!empty($url)) {
            $url = strpos($url, 'http') === 0 ? $url : $this->getViewFileUrl($url);
        } 
        return empty($url) ? false : $url;
    }
    // public function getViewFileUrl($url) {
    //     return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA . $url);
    // }
}
