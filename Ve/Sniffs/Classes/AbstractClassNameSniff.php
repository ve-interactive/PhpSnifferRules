<?php

namespace Ve\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Checks if the abstract class name has the Abstract prefix.
 *
 * @author Nicola Puddu <nicola.puddu@veinteractive.com>
 * @author Jack Blower  <Jack@elvenspellmaker.co.uk>
 */
class AbstractClassNameSniff implements Sniff
{
	const PREFIX = 'Abstract';

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CLASS,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int  $stackPtr  The position of the current token in
     *                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $className = $tokens[$phpcsFile->findNext(T_STRING, $stackPtr)]['content'];

		if ($tokens[$stackPtr - 2]['code'] === T_ABSTRACT && strpos($className, self::PREFIX) !== 0)
		{
			$phpcsFile->addError('The abstract class "' . $className . '" does not have the "' . self::PREFIX . '" prefix in its name.', $stackPtr, 'WrongName');
		}
    }

}
