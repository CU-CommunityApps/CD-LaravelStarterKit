<?php

namespace CornellCustomDev\LaravelStarterKit\Tests\Unit\Contact;

use CornellCustomDev\LaravelStarterKit\Contact\PhoneNumber;
use CornellCustomDev\LaravelStarterKit\Tests\TestCase;
use Propaganistas\LaravelPhone\PhoneNumber as LaravelPhoneNumber;

class PhoneNumberTest extends TestCase
{
    public function testCanValidateNumber()
    {
        $phoneNumber = LaravelPhoneNumber::make('6072551111', 'US');
        $isValid = PhoneNumber::isValidNumber($phoneNumber);
        $this->assertTrue($isValid);

        $phoneNumber = LaravelPhoneNumber::make('2551111', 'US');
        $isValid = PhoneNumber::isValidNumber($phoneNumber);
        $this->assertFalse($isValid);
    }

    public function testCanParseNumber()
    {
        $phoneNumber = new PhoneNumber('6072551111');
        $this->assertTrue($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('607-255-1111');
        $this->assertTrue($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('(607) 255-1111');
        $this->assertTrue($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('2551111');
        $this->assertFalse($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('6072551111', '1');
        $this->assertTrue($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('6072551111', '001');
        $this->assertTrue($phoneNumber->isValid());

        $phoneNumber = new PhoneNumber('607255123x4', '1');
        $this->assertFalse($phoneNumber->isValid());
    }

    public function testCanParseNumberWithoutCallingCode()
    {
        $phoneNumber = new PhoneNumber('6072551111');

        $this->assertTrue($phoneNumber->isValid());
    }

    public function testCanGetCallingCode()
    {
        $phoneNumber = new PhoneNumber('6072551111');

        $this->assertEquals('+1', $phoneNumber->getCallingCode());
    }

    public function testCanGetNumberWithoutCallingCode()
    {
        $phoneNumber = new PhoneNumber('+16072551111');

        $this->assertEquals('6072551111', $phoneNumber->getNumberWithoutCallingCode());
    }

    public function testCanGetFormattedNumber()
    {
        $phoneNumber = new PhoneNumber('6072551111');

        $this->assertEquals('+16072551111', $phoneNumber->getNumber());
    }

    public function testCanDefaultToSourceNumber()
    {
        $phoneNumber = new PhoneNumber('607-255-1111', '+255');

        $this->assertEquals('+255 607-255-1111', $phoneNumber->getNumber());
    }

    public function testCanGetNumberFormattedForUS()
    {
        $phoneNumber = PhoneNumber::formatNumberForUS('6072551111');

        $this->assertEquals('(607) 255-1111', $phoneNumber);
    }

    public function testCanGetInternationalNumberFormattedForUS()
    {
        $phoneNumber = new PhoneNumber('+41446681800');
        $this->assertEquals('+41 44 668 18 00', $phoneNumber->getNumberFormattedForUS());

        $phoneNumber = new PhoneNumber('44 668 1800', '41');
        $this->assertEquals('+41 44 668 18 00', $phoneNumber->getNumberFormattedForUS());

        // If no region code is unambiguous, present the number as provided
        $phoneNumber = new PhoneNumber('41 44 668 1800');
        $this->assertEquals('41 44 668 1800', $phoneNumber->getNumberFormattedForUS());
    }

    public function testCanGetNumberFormattedForTel()
    {
        $phoneNumber = PhoneNumber::formatNumberForTel('6072551111');
        $this->assertEquals('+16072551111', $phoneNumber);

        $phoneNumber = new PhoneNumber('44 668 1800', '41');
        $this->assertEquals('+41446681800', $phoneNumber->getNumberFormattedForTel());
    }

    public function testCanGetCallingCodeForRegion()
    {
        $phoneNumber = PhoneNumber::getCountryCallingCode('US');

        $this->assertEquals('+1', $phoneNumber);
    }

    public function testCanGetCountryList()
    {
        $list = PhoneNumber::getCountryListWithIntlCode();

        $this->assertArrayHasKey('US', $list);
        $this->assertEquals('United States (1)', $list['US']);
    }
}
