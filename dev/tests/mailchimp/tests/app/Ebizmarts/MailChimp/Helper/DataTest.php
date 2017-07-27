<?php

class Ebizmarts_MailChimp_Helper_DataTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        Mage::app('default');
    }

    public function testGetLastDateOfPurchase()
    {
        /**
         * @var \Ebizmarts_MailChimp_Helper_Data $helperMock
         */
        $helperMock = $this->getMockBuilder(Ebizmarts_MailChimp_Helper_Data::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getOrderCollectionByCustomerEmail'))
            ->getMock();

        $helperMock->expects($this->once())->method('getOrderCollectionByCustomerEmail')->with("john@example.com")
            ->willReturn(array());

        $this->assertNull($helperMock->getLastDateOfPurchase("john@example.com"));
    }

    public function testCustomMergeFieldAlreadyExists()
    {
        /**
         * @var \Ebizmarts_MailChimp_Helper_Data $helperMock
         */
        $helperMock = $this->getMockBuilder(Ebizmarts_MailChimp_Helper_Data::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getCustomMergeFields'))
            ->getMock();

        $helperMock->expects($this->once())->method('getCustomMergeFields')->with(0, "default")
            ->willReturn(
                array(
                    array(
                        "value" => "FNAME"
                    )
                )
            );

        $this->assertTrue($helperMock->customMergeFieldAlreadyExists("FNAME", 0, "default"));
    }

    public function testIsCheckoutSubscribeEnabled()
    {
        /**
         * @var \Ebizmarts_MailChimp_Helper_Data $helperMock
         */
        $helperMock = $this->getMockBuilder(Ebizmarts_MailChimp_Helper_Data::class)
            ->disableOriginalConstructor()
            ->setMethods(array('isMailChimpEnabled', 'getCheckoutSubscribeValue'))
            ->getMock();
        $helperMock->expects($this->once())->method('isMailChimpEnabled')->with(1, 'stores')
            ->willReturn(true);

        $helperMock->expects($this->once())->method('getCheckoutSubscribeValue')->with(1, 'stores')
            ->willReturn(Ebizmarts_MailChimp_Model_System_Config_Source_Checkoutsubscribe::NOT_CHECKED_BY_DEFAULT);

        $this->assertTrue($helperMock->isCheckoutSubscribeEnabled(1, "stores"));
    }

    public function testDeleteStore()
    {
        $scopeId = 1;
        $scope = 'stores';
        $helperMock = $this->getMockBuilder(Ebizmarts_MailChimp_Helper_Data::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getMCStoreId', 'getApiStores', 'getGeneralList', 'deleteCurrentWebhook', 'deleteLocalMCStoreData'))
            ->getMock();
        $apiStoresMock = $this->getMockBuilder(Ebizmarts_MailChimp_Model_Api_Stores::class)
            ->disableOriginalConstructor()
            ->getMock();

        $helperMock->expects($this->once())->method('getMCStoreId')->with($scopeId, $scope)->willReturn('a18a1a8a1aa7aja1a');
        $helperMock->expects($this->once())->method('getApiStores')->willReturn($apiStoresMock);
        $helperMock->expects($this->once())->method('getGeneralList')->with($scopeId, $scope)->willReturn('listId');
        $helperMock->expects($this->once())->method('deleteCurrentWebhook')->with($scopeId, $scope, 'listId');
        $helperMock->expects($this->once())->method('deleteLocalMCStoreData')->with($scopeId, $scope);

        $helperMock->deleteStore($scopeId, $scope);
    }
}