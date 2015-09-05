<?php

class Denkmal_Push_SubscriptionList_AllTest extends CMTest_TestCase {

    public function tearDown() {
        CMTest_TH::clearEnv();
    }

    public function testGetItems() {
        $pushSubscription1 = Denkmal_Push_Subscription::create('https://twitter.com/foo/foo1');
        $pushSubscription2 = Denkmal_Push_Subscription::create('https://google.com/foo/foo2');
        $this->assertEquals(array($pushSubscription1, $pushSubscription2), new Denkmal_Push_SubscriptionList_All());

        $pushSubscription3 = Denkmal_Push_Subscription::create('https://twitter.com/foo/foo3');
        $this->assertEquals(array($pushSubscription1, $pushSubscription2, $pushSubscription3), new Denkmal_Push_SubscriptionList_All());

        $pushSubscription3->delete();
        $this->assertEquals(array($pushSubscription1, $pushSubscription2), new Denkmal_Push_SubscriptionList_All());
    }
}
