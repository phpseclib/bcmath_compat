<?php

use bcmath_compat\bcmath;

/**
 * @requires extension bcmath
 */
class BCMathTest extends PHPUnit\Framework\TestCase
{
    /**
     * Produces all combinations of test values.
     *
     * @return array
     */
    public function generateTwoParams()
    {
        return [
            ['9', '9'],
            ['9.99', '9.99'],
            ['9.99', '9.99', 2],
            ['9.99', '9.00009'],
            ['9.99', '9.00009', 4],
            ['9.99', '9.00009', 6],
            ['9.99', '-7', 6],
            ['9.99', '-7.2', 6],
            ['-9.99', '-3', 4],
            ['-9.99', '3.7', 4],
            ['-9.99', '-2.4', 5],
            ['0', '34'],
            ['0.15', '0.15', 1],
            ['0.15', '-0.1', 1],
            ['12', '19', 5],
            ['19', '12', 5],
            ['190', '2', 3],
            ['2', '190', 3],
            ['9', '0'],
            ['0', '9']
        ];
    }

    /**
     * @dataProvider generateTwoParams
     */
    public function testAdd(...$params)
    {
        $a = bcadd(...$params);
        $b = bcmath::add(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * @dataProvider generateTwoParams
     */
    public function testSub(...$params)
    {
        $a = bcsub(...$params);
        $b = bcmath::sub(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * @dataProvider generateTwoParams
     */
    public function testMul(...$params)
    {
        $a = bcmul(...$params);
        $b = bcmath::mul(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * @dataProvider generateTwoParams
     */
    public function testDiv(...$params)
    {
        if ($params[1] === '0') {
            $this->setExpectedException('PHPUnit_Framework_Error_Warning');
        }

        $a = bcdiv(...$params);
        $b = bcmath::div(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * @dataProvider generateTwoParams
     * @requires PHP 7.2
     */
    public function testMod(...$params)
    {
        if ($params[1] === '0') {
            $this->setExpectedException('PHPUnit_Framework_Error_Warning');
        }

        $a = bcmod(...$params);
        $b = bcmath::mod(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * Produces all combinations of test values.
     *
     * @return array
     */
    public function generatePowParams()
    {
        return [
            ['9', '9'],
            ['-9', '9'],
            ['9.99', '9'],
            ['9.99', '9', 4],
            ['9.99', '9', 6],
            ['9.99', '-7', 6],
            ['0', '34'],
            ['12', '19', 5],
            ['10', '-2', 10],
            ['-9.99', '-3', 10],
            ['0.15', '15', 10],
            ['0.15', '-1', 10],
        ];
    }

    /**
     * @dataProvider generatePowParams
     * @requires PHP 7.2
     */
    public function testPow()
    {
        $a = bcpow(...$params);
        $b = bcmath::pow(...$params);
        $this->assertSame($a, $b);
    }

    /**
     * Produces all combinations of test values.
     *
     * @return array
     */
    public function generatePowModParams()
    {
        return [
            ['9', '9', '17'],
            ['999', '999', '111', 5],
            ['-9', '1024', '123'],
            ['9', '-1024', '127', 5],
            ['3', '1024', '-149'],
            ['2', '12', '2', 5],
            ['3', '0', '13'],
            ['-3', '0', '13', 4],
        ];
    }

    /**
     * @dataProvider generatePowModParams
     */
    public function testPowMod()
    {
        $a = bcpowmod(...$params);
        $b = bcmath::powmod(...$params);
        $this->assertSame($a, $b);
    }

    public function testSqrt()
    {
        $a = bcsqrt('152.2756', 2, 4);
        $b = bcmath::powmod('152.2756', 2, 4);
        $this->assertSame($a, $b);

        $a = bcsqrt('40000');
        $b = bcmath::powmod('40000');
        $this->assertSame($a, $b);

        $a = bcsqrt('2', 4);
        $b = bcmath::powmod('2', 4);
        $this->assertSame($a, $b);
    }

    private function setExpectedException($name, $message = null, $code = null)
    {
        if (version_compare(PHP_VERSION, '7.0.0') < 0) {
            parent::setExpectedException($name, $message, $code);
            return;
        }
        switch ($name) {
            case 'PHPUnit_Framework_Error_Notice':
            case 'PHPUnit_Framework_Error_Warning':
                $name = str_replace('_', '\\', $name);
        }
        $this->expectException($name);
        if (!empty($message)) {
            $this->expectExceptionMessage($message);
        }
        if (!empty($code)) {
            $this->expectExceptionCode($code);
        }
    }
}