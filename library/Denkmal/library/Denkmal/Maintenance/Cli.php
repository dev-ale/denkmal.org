<?php

class Denkmal_Maintenance_Cli extends CM_Maintenance_Cli {

    /**
     * @synchronized
     */
    protected function _registerCallbacks() {
        parent::_registerCallbacks();

        $this->_registerClockworkCallbacks('12 hours', array(
            'Scraper' => function () {
                $scraperManager = new Denkmal_Scraper_Manager($this->_getStreamOutput());
                $scraperManager->process(true);
            }
        ));

        $this->_registerClockworkCallbacks('18:00', array(
            'Daily event tweets' => function () {
                $settings = new Denkmal_App_Settings();
                $tweeterDaily = new Denkmal_EventTweeter_Daily();
                $tweeterDaily->run($settings->getCurrentDate());
            }
        ));

        $this->_registerClockworkCallbacks('1 hour', array(
            'Delete expired invites' => function () {
                /** @var Denkmal_Model_UserInvite $userInvite */
                foreach ((new Denkmal_Paging_UserInvite_Expired())->getItems() as $userInvite) {
                    $userInvite->delete();
                }
            }
        ));

        $this->_registerClockworkCallbacks('1 hour', array(
            'Delete expired push subscriptions'         => function () {
                /** @var Denkmal_Push_Subscription $pushSubscription */
                foreach ((new Denkmal_Push_SubscriptionList_Expired())->getItems() as $pushSubscription) {
                    $pushSubscription->delete();
                }
            },
            'Delete expired push notification messages' => function () {
                /** @var Denkmal_Push_Notification_Message $pushNotificationMessage */
                foreach ((new Denkmal_Push_Notification_MessageList_Expired())->getItems() as $pushNotificationMessage) {
                    $pushNotificationMessage->delete();
                }
            },
        ));
    }

    public static function getPackageName() {
        return 'maintenance';
    }
}
