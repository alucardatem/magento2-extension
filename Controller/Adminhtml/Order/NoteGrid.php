<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Controller\Adminhtml\Order;

use Ess\M2ePro\Controller\Adminhtml\Order;

/**
 * Class \Ess\M2ePro\Controller\Adminhtml\Order\NoteGrid
 */
class NoteGrid extends Order
{
    public function execute()
    {
        $grid = $this->createBlock('Order_Note_Grid');

        $this->setAjaxContent($grid->toHtml());
        return $this->getResult();
    }
}
