<?php
/**
 * @author hollodotme
 */

namespace CodingKata\RomanNumerals;

use CodingKata\RomanNumerals\Exceptions\InvalidRomanNumeral;

/**
 * Class RomanNumeralConverter
 */
final class RomanNumeralConverter
{
	private const MAP = [
		''  => 0,
		'I' => 1,
		'V' => 5,
		'X' => 10,
		'L' => 50,
		'C' => 100,
		'D' => 500,
		'M' => 1000,
	];

	private const REPEATABLE = [
		'I', 'X', 'C', 'M',
	];

	public function toDecimal( string $romanNumeral ): int
	{
		$this->guardValidRomanNumeral( $romanNumeral );

		$decimal = 0;
		$length  = strlen( $romanNumeral );
		for ( $i = 0; $i < strlen( $romanNumeral ); $i++ )
		{
			$current = $romanNumeral{$i};
			$next    = ($i < $length - 1) ? $romanNumeral{$i + 1} : '';

			$decC = self::MAP[ $current ];
			$decN = self::MAP[ $next ];

			$posC = array_search( $decC, array_values( self::MAP ) );
			$posN = array_search( $decN, array_values( self::MAP ) ) ?: 0;

			if ( $current == $next && !in_array( $current, self::REPEATABLE ) )
			{
				throw new InvalidRomanNumeral( $romanNumeral );
			}

			if ( $decC < $decN && abs( $posC - $posN ) > 2 )
			{
				throw new InvalidRomanNumeral( $romanNumeral );
			}

			if ( $decC == $decN || $decC > $decN )
			{
				$decimal += $decC;
			}
			else
			{
				$decimal -= $decC;
			}
		}

		return $decimal;
	}

	private function guardValidRomanNumeral( string $romanNumeral )
	{
		$pattern = "#^[" . preg_quote( join( '', array_keys( self::MAP ) ), '#' ) . "]+$#";

		if ( !preg_match( $pattern, $romanNumeral ) )
		{
			throw new InvalidRomanNumeral( $romanNumeral );
		}
	}

}
