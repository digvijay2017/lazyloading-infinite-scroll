<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\LazyloadingInfiniteScroll\Helper;

/**
 * Data
 * @package Tutorialstab_ImportExportCategories
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var lazyloadinginfinitescroll/general/enabled
     */
    const XML_PATH_GENERAL_ENABLED = 'lazyloadinginfinitescroll/general/enabled';


    /**
     * __construct
     * 
     * @param \Magento\Framework\App\Helper\Context      $context        
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager   
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider 
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider
        ) {
        parent::__construct($context);
        $this->_storeManager   = $storeManager;
        $this->_filterProvider = $filterProvider;
    }

    /**
     * Return brand config value by key and store
     *
     * @param string $field
     * @param \Magento\Store\Model\Store|int|string $store
     * @return string|null
     */
     public function getConfig($field, $default="", $store = null)
     {
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        if($result == "") {
            $result = $default;
        }
        return $result;
    }
    
    /**
     * Get config data
     * 
     * @param string $field
     * @param null $store
     * @return string
     */
    public function getConfigData($field, $store = null)
    {
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            $field,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store); 
        return $result;
    }
    
    /**
     * Get filter string
     * 
     * @param string $str
     * @return string
     */
    public function filter($str)
    {
    	$html = $this->_filterProvider->getPageFilter()->filter($str);
    	return $html;
    } 
    
    /**
     * Get config data according store
     * 
     * @param int $storeId
     * @return array
     */
    public function isEnabled($storeId = null)
    {
        return $this->getConfigData(self::XML_PATH_GENERAL_ENABLED, $storeId);
    }
 
    
    /**
     * Escape quotes in java script
     *
     * @param mixed $data
     * @param string $quote
     * @return mixed
     */
    public function jsQuoteEscape($data, $quote='\'')
    {
        if (is_array($data)) {
            $result = array();
            foreach ($data as $item) {
                $result[] = str_replace($quote, '\\'.$quote, $item);
            }
            return $result;
        }
        return str_replace($quote, '\\'.$quote, $data);
    }

    
}