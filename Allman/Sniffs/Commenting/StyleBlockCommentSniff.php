<?php

namespace PHP_CodeSniffer\Standards\Allman\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Ensures correct indentation for doc blocks.
 */
class Allman_Sniffs_Commenting_StyleBlockCommentSniff implements Sniff
{
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(T_DOC_COMMENT_STAR, T_DOC_COMMENT_CLOSE_TAG);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param  File $phpcsFile The file being scanned.
	 * @param  int                  $stackPtr  The position of the current token in the.
	 * @return void
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();

		$open = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr);

		if ($tokens[$stackPtr]['type'] === 'T_DOC_COMMENT_CLOSE_TAG')
		{
			if ($tokens[$stackPtr]['content'] !== '*/')
			{
				$error = 'Expected */ as comment close tag; found “%s”.';
				$data = array($tokens[$stackPtr]['content']);

				if ($phpcsFile->addFixableError($error, $stackPtr, 'SimpleCommentCloseTag', $data))
				{
					$phpcsFile->fixer->replaceToken($stackPtr, '*/');
				}
			}
		}

		$before = $stackPtr - 1;
		if ($tokens[$before]['type'] !== 'T_DOC_COMMENT_WHITESPACE')
		{
			return;
		}

		$base = str_repeat("\t", round(substr_count($tokens[$open - 1]['content'], ' ') / 4));

		$raw = isset($tokens[$before]['orig_content']) ? $tokens[$before]['orig_content'] : $tokens[$before]['content'];

		if ($raw !== $base.' ')
		{
			$error = 'Indent expected as “%s”; found “%s”.';
			$data = array(
				str_replace(array("\n", "\t"), array('\n', '\t'), $base.' '),
				str_replace(array("\n", "\t"), array('\n', '\t'), $raw),
			);

			if ($phpcsFile->addFixableError($error, $before, 'WrongBlockCommentIndent', $data))
			{
				if ($tokens[$before]['content'] === "\n")
				{
					$phpcsFile->fixer->addContentBefore($stackPtr, " ");
				}
				else
				{
					$phpcsFile->fixer->replaceToken($before, $base.' ');
				}
			}
		}
	}
}
