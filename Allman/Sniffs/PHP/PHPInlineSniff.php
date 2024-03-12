<?php
/**
 * Allman_Sniffs_PHP_PHPInlineSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2010-2014 Stefano Kowalke
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

namespace PHP_CodeSniffer\Standards\Allman\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Checks that code inside inline-PHP tags has proper spacing and do
 * not contains semicolons.
 */
class Allman_Sniffs_PHP_PHPInlineSniff implements Sniff
{
	/**
	 * If TRUE, inline PHP code can contain semicolons.
	 *
	 * @var boolean
	 */
	public $allowSemicolons = false;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(T_OPEN_TAG);
	}

	/**
	 * Processes this sniff, when one of its tokens is encountered.
	 *
	 * @param File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token in
	 *                                        the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		$closeTag = $phpcsFile->findNext(T_CLOSE_TAG, $stackPtr);

		if (strpos($tokens[$stackPtr]['content'], PHP_EOL))
		{
			if (!isset($tokens[$closeTag - 1]) || $tokens[$closeTag - 1]['content'] === PHP_EOL)
			{
				return;
			}

			if (trim($tokens[$closeTag - 1]['content']) === '' && $tokens[$closeTag - 2]['content'] === PHP_EOL)
			{
				return;
			}

			$error = 'Expected a newline before %s keyword; %s found';
			$data  = array(trim($tokens[$closeTag]['content']), $tokens[$closeTag - 1]['content']);

			if ($phpcsFile->addFixableError($error, $closeTag, 'NewlineBeforeKeyword', $data))
			{
				if (isset($tokens[$closeTag - 1]) && $tokens[$closeTag - 1]['type'] === T_WHITESPACE)
				{
					$phpcsFile->fixer->replaceToken($closeTag - 1, PHP_EOL);
				}
				else
				{
					$phpcsFile->fixer->addNewlineBefore($closeTag);
				}
			}
		}
		else
		{
			$php_code = $phpcsFile->getTokensAsString($stackPtr, $closeTag - $stackPtr);

			if (strpos($php_code, PHP_EOL) !== false)
			{
				$error = 'Not expected a newline between <?php ... ?>';
				$phpcsFile->addError($error, $stackPtr, 'Found');
			}

			$semicolon = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);

			if ($semicolon && $semicolon < $closeTag)
			{
				$error = 'Expected no semicolons inside inline code.';
				$tokens_in_between = $closeTag - $semicolon - 1;
				if ($tokens_in_between <= 1)
				{
					if ($phpcsFile->addFixableError($error, $semicolon, 'SemicolonNotAllowed'))
					{
						if ($tokens_in_between === 1)
						{
							$phpcsFile->fixer->replaceToken($semicolon, '');
						}
						else
						{
							$phpcsFile->fixer->replaceToken($semicolon, ' ');
						}
					}
				}
				else
				{
					$phpcsFile->addError($error, $semicolon, 'Found');
				}
			}

			if (isset($tokens[$closeTag - 1]) && $tokens[$closeTag - 1]['content'] !== ' ')
			{
				$error = 'Expected a single whitespace before %s tag; "%s" found.';
				$data = array(trim($tokens[$closeTag]['content']), $tokens[$closeTag - 1]['content']);

				if (trim($tokens[$closeTag - 1]['content']) === '')
				{
					if ($phpcsFile->addFixableError($error, $closeTag - 1, 'WhitespaceBeforeKeyword', $data))
					{
						$phpcsFile->fixer->replaceToken($closeTag - 1, ' ');
					}
				}
				else
				{
					$phpcsFile->addError($error, $closeTag - 1, 'WhitespaceBeforeKeyword', $data);
				}
			}
		}
	}
}
