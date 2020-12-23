<?php
namespace CkAmaury\PhpDatetimeTests;

use CkAmaury\PhpDatetime\DateTime;
use PHPUnit\Framework\TestCase;

class DatetimeTest extends TestCase{

    public function testBasicFunctions(): void{
        $datetime = new DateTime('1900-02-01');
        $datetime->nextMonth();
        self::assertEquals(3,$datetime->getMonth());

        $datetime = new DateTime('1900-01-31');
        $datetime->nextMonth();
        self::assertNotEquals(2,$datetime->getMonth());

        $datetime = new DateTime('1900-01-31');
        $datetime->nextMonth(TRUE);
        self::assertEquals(2,$datetime->getMonth());

        $datetime = new DateTime('1900-03-31');
        $datetime->previousMonth();
        self::assertNotEquals(2,$datetime->getMonth());

        $datetime = new DateTime('1900-03-31');
        $datetime->previousMonth(TRUE);
        self::assertEquals(2,$datetime->getMonth());

        $datetime = new DateTime('1900-04-30');
        $datetime->previousMonth();
        self::assertEquals(3,$datetime->getMonth());

        $datetime = new DateTime('1900-01-01');
        self::assertEquals('January',$datetime->getMonthName());
        self::assertEquals('Janvier',$datetime->getMonthName('french'));
        self::assertEquals('Januar',$datetime->getMonthName('german'));
        self::assertEquals('January',$datetime->getMonthName('idoesntexist'));
        self::assertEquals('January',$datetime->getMonthName());

        $datetime = new DateTime('2020-02-29');
        $datetime->previousYear();
        self::assertEquals(2019,$datetime->getYear());

        $datetime = new DateTime('1900-04-01');
        self::assertNotEquals("1",$datetime->getDayString());
        self::assertEquals("01",$datetime->getDayString());




    }
}
