<?php

namespace Allman\Utilities;

/**
 * Allman CodeSniffer.
 *
 * Rewrite for just one stupid static method deprecated.
 */
class Allman_CodeSniffer
{
	/**
	 * An array of variable types for param/var we will check.
	 *
	 * @var array(string)
	 */
	public static $allowedTypes = array(
		'array',
		'boolean',
		'float',
		'integer',
		'mixed',
		'object',
		'string',
		'resource',
		'callable',
	);

	/**
	 * Returns a valid variable type for param/var tag.
	 *
	 * If type is not one of the standard type, it must be a custom type.
	 * Returns the correct type name suggestion if type name is invalid.
	 *
	 * DIFFERENCE: 'bool' instead of 'boolean' and 'int' instead of 'integer'.
	 *
	 * @param string $varType The variable type to process.
	 *
	 * @return string
	 */
	public static function suggestType($varType)
	{
		if ($varType === '')
		{
			return '';
		}
		if (in_array($varType, self::$allowedTypes) === true)
		{
			return $varType;
		}
		else
		{
			$lowerVarType = strtolower($varType);
			switch ($lowerVarType)
			{
				case 'bool':
				case 'boolean':
					return 'bool';
				case 'double':
				case 'real':
				case 'float':
					return 'float';
				case 'int':
				case 'integer':
					return 'int';
				case 'array()':
				case 'array':
					return 'array';
			}
			if (strpos($lowerVarType, 'array(') !== false)
			{
				// Valid array declaration:
				// array, array(type), array(type1 => type2).
				$matches = array();
				$pattern = '/^array\(\s*([^\s^=^>]*)(\s*=>\s*(.*))?\s*\)/i';
				if (preg_match($pattern, $varType, $matches) !== 0)
				{
					$type1 = isset($matches[1]) ? $matches[1] : '';
					$type2 = isset($matches[3]) ? $matches[3] : '';

					$type1 = self::suggestType($type1);
					$type2 = self::suggestType($type2);

					if ($type2 !== '')
					{
						$type2 = ' => '.$type2;
					}

					return "array($type1$type2)";
				}
				else
				{
					return 'array';
				}
			}
			elseif (in_array($lowerVarType, self::$allowedTypes) === true)
			{
				// A valid type, but not lower cased.
				return $lowerVarType;
			}
			else
			{
				// Must be a custom type name.
				return $varType;
			}
		}
	}
}
