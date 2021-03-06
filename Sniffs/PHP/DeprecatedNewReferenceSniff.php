<?php
/**
 * PHPCompatibility_Sniffs_PHP_DeprecatedNewReferenceSniff.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   PHPCompatibility
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2012 Cu.be Solutions bvba
 */

/**
 * PHPCompatibility_Sniffs_PHP_DeprecatedNewReferenceSniff.
 *
 * Discourages the use of assigning the return value of new by reference
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   PHPCompatibility
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2012 Cu.be Solutions bvba
 */
class PHPCompatibility_Sniffs_PHP_DeprecatedNewReferenceSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    protected $error = false;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_NEW);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if (
            !isset($phpcsFile->phpcs->cli->settingsStandard['testVersion'])
            ||
            (
                isset($phpcsFile->phpcs->cli->settingsStandard['testVersion'])
                &&
                version_compare($phpcsFile->phpcs->cli->settingsStandard['testVersion'], '5.3') >= 0
            )
        ) {
            $tokens = $phpcsFile->getTokens();
            if ($tokens[$stackPtr - 1]['type'] == 'T_BITWISE_AND' || $tokens[$stackPtr - 2]['type'] == 'T_BITWISE_AND') {
                $error = 'Assigning the return value of new by reference is deprecated in PHP 5.3';
                $phpcsFile->addError($error, $stackPtr);
            }
        }

    }//end process()


}//end class
