<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Controller\Adminhtml\Ebay;

/**
 * Class \Ess\M2ePro\Controller\Adminhtml\Ebay\GetGlobalMessages
 */
class GetGlobalMessages extends Main
{
    //########################################

    public function execute()
    {
        if ($this->getCustomViewHelper()->isInstallationWizardFinished()) {
            $this->addLicenseNotifications();
        }

        $this->addServerNotifications();
        $this->addCronErrorMessage();
        $this->getCustomViewControllerHelper()->addMessages();

        $messages = $this->getMessageManager()->getMessages(
            true,
            \Ess\M2ePro\Controller\Adminhtml\Base::GLOBAL_MESSAGES_GROUP
        )->getItems();

        foreach ($messages as &$message) {
            $message = [$message->getType() => $message->getText()];
        }

        $this->setJsonContent($messages);
        return $this->getResult();
    }

    //########################################
}
