<?php 

namespace tests;

use Calculator\ParenthesesException;
use Calculator\UnknownOperatorException;
use PHPUnit\Framework\TestCase;
use Calculator\Calculator;
use Calculator\Factory;

class CalculatorTests extends TestCase
{
    private Calculator $calculator;

    public function setUp():void
    {
        $factory=new Factory();
        $this->calculator=$factory->create();
    }

    /**
     * @test
     */
    public function simpleTest()
    {
        $s = '13-2*3';

        $e=$this->calculator->calculate($s);

        $this->assertEquals(7, $e);
    }

    /**
     * @test
     */
    public function simpleTest2()
    {
        $s = '32⋅2+4+((57-2-7+9)*2)÷3+(3+3*2)';

        $e=$this->calculator->calculate($s);

        $this->assertEquals(115, $e);
    }

    /**
     * @test
     */
    public function simpleTest3()
    {
        $s = '32⋅2+4+{[(57-2-7+9)*2]÷3}/2+(3+3*2)';

        $e=$this->calculator->calculate($s);

        $this->assertEquals(96, $e);
    }

    /**
     * @test
     */
    public function simpleTest4()
    {
        $s = '[-4-9-65](-17)';

        $e=$this->calculator->calculate($s);

        $this->assertEquals(1326, $e);
    }

    /**
     * @test
     */
    public function simpleTest5()
    {
        $s = '[-4(-99+3*17)-65](-17)';

        $e=$this->calculator->calculate($s);

        $this->assertEquals(-2159, $e);
    }

    /**
     * @test
     */
    public function testWithoutMulcipl()
    {
        $s='(32(5-2))3-2';
        $e=$this->calculator->calculate($s);

        $this->assertEquals(286, $e);
    }

    /**
     * @test
     */
    public function testWithoutMulcipl2()
    {
        $s='(3-1)(7-3)';
        
        $e=$this->calculator->calculate($s);
        $this->assertEquals(8, $e);
    }

    /**
     * @test
     */
    public function testParentheses1()
    {
        $this->expectException(ParenthesesException::class);
        $s='(32(5-2)))3-2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testParentheses2()
    {
        $this->expectException(ParenthesesException::class);

        $s='32)5-2(3-2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testParentheses3()
    {
        $this->expectException(ParenthesesException::class);

        $s='32((5-2)3-2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testParentheses4()
    {
        $this->expectException(ParenthesesException::class);

        $s='32(5-2]3-2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testUnidentifiedOperator()
    {
        $this->expectException(UnknownOperatorException::class);

        $s='2¤2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testUnidentifiedOperator2()
    {
        $this->expectException(UnknownOperatorException::class);

        $s='2I2';
        
        $e=$this->calculator->calculate($s);
    }

    /**
     * @test
     */
    public function testNegativeNumbers()
    {
        $s='-4-4+(-2)*2+(-4+9)';
        
        $e=$this->calculator->calculate($s);
        $this->assertEquals(-7, $e);
    }

    /**
     * @test
     */
    public function testNegativeNumbers2()
    {
        $s='(-2)7';
        
        $e=$this->calculator->calculate($s);
        $this->assertEquals(-14, $e);
    }
}