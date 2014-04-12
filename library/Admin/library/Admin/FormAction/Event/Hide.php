<?php

class Admin_FormAction_Event_Hide extends Admin_FormAction_Abstract {

    protected function _getRequiredFields() {
        return array('eventId');
    }

    protected function _process(CM_Params $params, CM_Response_View_Form $response, CM_Form_Abstract $form) {
        /** @var Denkmal_Params $params */
        $event = $params->getEvent('eventId');

        $event->setHidden(true);
        $event->setEnabled(false);

        $response->reloadComponent();
    }
}
