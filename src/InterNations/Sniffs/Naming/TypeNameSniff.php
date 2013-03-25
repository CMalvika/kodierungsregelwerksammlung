<?php
use PHP_CodeSniffer_File as CodeSnifferFile;

// @codingStandardsIgnoreStart
class InterNations_Sniffs_Naming_TypeNameSniff implements PHP_CodeSniffer_Sniff
// @codingStandardsIgnoreEnd
{
    public function register()
    {
        return [T_INTERFACE, T_ABSTRACT, T_TRAIT];
    }

    public function process(CodeSnifferFile $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === T_ABSTRACT
            && !$phpcsFile->findNext(T_CLASS, $stackPtr + 1, $stackPtr + 3)) {
            return;
        }

        $namePtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1, $stackPtr + 6);

        if ($tokens[$stackPtr]['code'] === T_ABSTRACT && !preg_match('/^Abstract.*/', $tokens[$namePtr]['content'])) {
            $phpcsFile->addError(
                'Invalid name for abstract class. Expected "Abstract%1$s", got "%1$s"',
                $namePtr,
                'TypeNameNoAbstract',
                [$tokens[$namePtr]['content']]
            );
        }

        if ($tokens[$stackPtr]['code'] === T_INTERFACE && !preg_match('/Interface$/', $tokens[$namePtr]['content'])) {
            $phpcsFile->addError(
                'Invalid name for interface. Expected "%1$sInterface", got "%1$s"',
                $namePtr,
                'TypeNameNoInterface',
                [$tokens[$namePtr]['content']]
            );
        }

        if ($tokens[$stackPtr]['code'] === T_TRAIT && !preg_match('/Trait$/', $tokens[$namePtr]['content'])) {
            $phpcsFile->addError(
                'Invalid name for trait. Expected "%1$sTrait", got "%1$s"',
                $namePtr,
                'TypeNameNoTrait',
                [$tokens[$namePtr]['content']]
            );
        }
    }
}
