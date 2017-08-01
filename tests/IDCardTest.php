<?php

use Leonis\IDCard\IDCard;
use PHPUnit\Framework\TestCase;

class IDCardTest extends TestCase
{
    protected $IDCard;

    public function setUp()
    {
        $this->IDCard = new IDCard('421381199303052110');
    }

    public function testCheck()
    {
        $this->assertTrue($this->IDCard->check());
    }

    public function testCheckAreaCode()
    {
        $this->assertTrue($this->IDCard->checkAreaCode());
    }

    public function testCheckBirthday()
    {
        $this->assertTrue($this->IDCard->checkBirthday());
    }

    public function testCheckCode()
    {
        $this->assertTrue($this->IDCard->checkCode());
    }

    public function testAddress()
    {
        $this->assertEquals($this->IDCard->address(), '湖北省随州市广水市');
    }

    public function testProvince()
    {
        $this->assertEquals($this->IDCard->province(), '湖北省');
    }

    public function testCity()
    {
        $this->assertEquals($this->IDCard->city(), '随州市');
    }

    public function testZone()
    {
        $this->assertEquals($this->IDCard->zone(), '广水市');
    }

    public function testBirthday()
    {
        $this->assertEquals($this->IDCard->birthday('Y-m-d'), '1993-03-05');
    }

    public function testYear()
    {
        $this->assertEquals($this->IDCard->year(), 1993);
    }

    public function testMonth()
    {
        $this->assertEquals($this->IDCard->month(), 3);
    }

    public function testDay()
    {
        $this->assertEquals($this->IDCard->day(), 5);
    }

    public function testAge()
    {
        $this->assertEquals($this->IDCard->age(), 24);
    }

    public function testSex()
    {
        $this->assertEquals($this->IDCard->sex(), '男');
    }

    public function testConstellation()
    {
        $this->assertEquals($this->IDCard->constellation(), '双鱼座');
    }

    public function testZodiac()
    {
        $this->assertEquals($this->IDCard->zodiac(), '鸡');
    }
}
