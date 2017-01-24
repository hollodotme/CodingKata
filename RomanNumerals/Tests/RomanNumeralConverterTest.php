<?php declare(strict_types = 1);

namespace CodingKata\RomanNumerals\Tests;

use CodingKata\RomanNumerals\RomanNumeralConverter;

/**
 * @author hollodotme
 */
class RomanNumeralConverterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @param string $romanNumeral
	 * @param int    $expectedDecimal
	 *
	 * @dataProvider romanNumeralProvider
	 */
	public function testCanConvertNumber( string $romanNumeral, int $expectedDecimal )
	{
		$converter = new RomanNumeralConverter();

		$decimal = $converter->toDecimal( $romanNumeral );

		$this->assertSame( $expectedDecimal, $decimal );
	}

	public function romanNumeralProvider(): array
	{
		return [
			['I', 1],
			['II', 2],
			['III', 3],
			['IV', 4],
			['V', 5],
			['VI', 6],
			['X', 10],
			['XLII', 42],
			['XCIX', 99],
			['MMXIII', 2013],
		];
	}

	/**
	 * @param string $romanNumeral
	 *
	 * @expectedException \CodingKata\RomanNumerals\Exceptions\InvalidRomanNumeral
	 * @dataProvider invalidRomanNumeralsProvider
	 */
	public function testInvalidRomanNumeralsThrowException( string $romanNumeral )
	{
		$converter = new RomanNumeralConverter();

		$converter->toDecimal( $romanNumeral );
	}

	public function invalidRomanNumeralsProvider(): array
	{
		return [
			["I X"],
			["IC"],
			["VV"],
			["DD"],
			["LL"],
			["XMI"],
			["ICCC"],
			["XMM"],
			["ICM"],
			["IVIV"],
			["IXIV"],
		];
	}
}
