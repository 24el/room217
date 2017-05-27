<?php


class addOrderCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/orders/add_order');
        $I->see('Order info');
        $I->submitForm('#orderAdd-form', array(
            'Title' => 'sLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum',
            'orderDate' => '2017-05-13',
            'startHour' => '12',
            'startMinutes' => '25',
            'endHour' => '15',
            'endMinutes' => '30',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
             Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
             Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
             Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'price' => '123123'
        ));
        $I->see('sLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum');
    }
}
