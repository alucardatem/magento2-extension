<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\Amazon\Search\Settings\ByQuery;

/**
 * Class \Ess\M2ePro\Model\Amazon\Search\Settings\ByQuery\Responser
 */
class Responser extends \Ess\M2ePro\Model\Amazon\Connector\Search\ByQuery\ItemsResponser
{
    //########################################

    /**
     * @return \Ess\M2ePro\Model\Listing\Product
     */
    protected function getListingProduct()
    {
        return $this->getObjectByParam('Listing\Product', 'listing_product_id');
    }

    //########################################

    public function failDetected($messageText)
    {
        parent::failDetected($messageText);

        /** @var \Ess\M2ePro\Model\Listing\Log $logModel */
        $logModel = $this->activeRecordFactory->getObject('Listing\Log');

        $logModel->setComponentMode(\Ess\M2ePro\Helper\Component\Amazon::NICK);

        $logModel->addProductMessage(
            $this->getListingProduct()->getListingId(),
            $this->getListingProduct()->getProductId(),
            $this->getListingProduct()->getId(),
            \Ess\M2ePro\Helper\Data::INITIATOR_UNKNOWN,
            null,
            \Ess\M2ePro\Model\Listing\Log::ACTION_UNKNOWN,
            $messageText,
            \Ess\M2ePro\Model\Log\AbstractModel::TYPE_ERROR
        );

        $amazonListingProduct = $this->getListingProduct()->getChildObject();

        $amazonListingProduct->setData('search_settings_status', null);
        $amazonListingProduct->setData('search_settings_data', null);
        $amazonListingProduct->save();
    }

    //########################################

    protected function processResponseData()
    {
        $responseData = $this->getPreparedResponseData();

        /** @var \Ess\M2ePro\Model\Amazon\Search\Settings $settingsSearch */
        $settingsSearch = $this->modelFactory->getObject('Amazon_Search_Settings');
        $settingsSearch->setListingProduct($this->getListingProduct());
        $settingsSearch->setStep($this->params['step']);
        if (!empty($responseData)) {
            $settingsSearch->setStepData([
                'params' => $this->params,
                'result' => $responseData,
            ]);
        }

        $settingsSearch->process();
    }

    //########################################
}
