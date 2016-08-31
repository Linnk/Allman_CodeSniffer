<?php
/**
 * Tabs over spaces.
 */
class Allman_Sniffs_WhiteSpace_TabOverSpaceSniff implements PHP_CodeSniffer_Sniff
{
	/**
	 * @var int Tab columns lenght.
	 */
	private $_tabWidth = null;

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'JS',
		'CSS'
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(T_WHITESPACE);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token
	 *                                        in the stack passed in $tokens.
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();

		$whitespace = $tokens[$stackPtr];

		if ($tokens[$stackPtr]['content'] === "\n" || ($stackPtr > 0 && $tokens[$stackPtr - 1]['content'] !== "\n"))
		{
			return;
		}

		$raw = $tokens[$stackPtr]['content'];
		if (isset($tokens[$stackPtr]['orig_content']))
		{
			$raw = $tokens[$stackPtr]['orig_content'];
		}

		$spaces = substr_count($raw, ' ');
		if ($spaces > 0)
		{
			$tabs = strlen($tokens[$stackPtr]['content']) / 4;

			$spaces_found = $spaces === 1 ? '1 space' : $spaces.' spaces';
			$tabs_found = $tabs === 1 ? '1 tab' : $tabs.' tabs';

			$error = "Expected $tabs_found only; found $spaces_found.";

			if ($phpcsFile->addFixableError($error, $stackPtr, 'TabsIndentationOnly'))
			{
				$phpcsFile->fixer->replaceToken($stackPtr, str_repeat("\t", $tabs));
			}
		}
	}
}
