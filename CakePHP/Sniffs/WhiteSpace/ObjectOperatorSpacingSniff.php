<?php
/**
 * PHP Version 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * This file is originally written by Greg Sherwood and Marc McIntyre, but
 * modified for CakePHP.
 *
 * @copyright     2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @link          http://pear.php.net/package/PHP_CodeSniffer_CakePHP
 * @since         CakePHP CodeSniffer 0.1.1
 * @license       https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */


namespace PHP_CodeSniffer\Standards\CakePHP\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;


/**
 * Ensure there is no whitespace before a semicolon.
 *
 */
class CakePHP_Sniffs_WhiteSpace_ObjectOperatorSpacingSniff implements Sniff
{

/**
 * Returns an array of tokens this test wants to listen for.
 *
 * @return array
 */
    public function register()
    {
        return array(T_OBJECT_OPERATOR);
    }

/**
 * Processes this test, when one of its tokens is encountered.
 *
 * @param File $phpcsFile The file being scanned.
 * @param integer $stackPtr The position of the current token in the stack passed in $tokens.
 * @return void
 */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $nextType = $tokens[($stackPtr + 1)]['code'];
        if (in_array($nextType, Tokens::$emptyTokens) === true) {
            $error = 'Space found after object operator';
            $phpcsFile->addError($error, $stackPtr, 'After');
        }
    }
}
