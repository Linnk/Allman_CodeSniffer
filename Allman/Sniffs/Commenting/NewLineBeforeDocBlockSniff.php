<?php
/**
 * Ensures a new line (or an opening brace) before a doc block.
 */
class Allman_Sniffs_Commenting_NewLineBeforeDocBlockSniff implements PHP_CodeSniffer_Sniff
{
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(T_DOC_COMMENT_OPEN_TAG);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param  PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param  int                  $stackPtr  The position of the current token in the
	 *                                 stack passed in $tokens.
	 * @return void
	 */
	public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();

		if (!isset($tokens[$stackPtr - 1]) || $tokens[$stackPtr - 1]['type'] !== 'T_WHITESPACE')
		{
			return;
		}

		$previous = $stackPtr - ($tokens[$stackPtr - 1]['content'] !== "\n" ? 2 : 1);

		if ($tokens[$previous]['content'] !== "\n")
		{
			$error = 'Unexpected token “%s”. Block comment should start on its own line.';
			$data = array($tokens[$previous]['content']);

			return $phpcsFile->addError($error, $previous, 'UnexpectedToken', $data);
		}

		if (!isset($tokens[$previous - 1]) || $tokens[$previous - 1]['type'] === 'T_OPEN_CURLY_BRACKET')
		{
			return;
		}

		if ($tokens[$previous - 1]['content'] !== "\n")
		{
			$error = 'Expected a new line before doc block.';

			if ($phpcsFile->addFixableError($error, $previous, 'NewlineBeforeDocBlock'))
			{
				$phpcsFile->fixer->addNewlineBefore($previous);
			}
		}
	}
}
