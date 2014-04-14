<?php
namespace InterNations\Sniffs\Naming;

use PHP_CodeSniffer_File as CodeSnifferFile;
use PHP_CodeSniffer_Sniff as CodeSnifferSniff;

class MethodNameSniff implements CodeSnifferSniff
{
    public function register()
    {
        return [T_FUNCTION];
    }

    public function process(CodeSnifferFile $file, $stackPtr)
    {
        $namePtr = $file->findNext(T_STRING, $stackPtr, $stackPtr + 3);

        $tokens = $file->getTokens();
        $methodName = $tokens[$namePtr]['content'];

        if (preg_match('/^getIs(?P<remainder>[A-Z].*)$/', $methodName, $matches)) {
            $file->addError(
                sprintf(
                    'Method name "%s()" is not allowed. Use "is%s()" instead',
                    $methodName,
                    $matches['remainder']
                ),
                $stackPtr,
                'BadIsser'
            );
        } elseif (preg_match('/^setIs(?P<remainder>[A-Z].*)$/', $methodName, $matches)) {
            $file->addError(
                sprintf(
                    'Method name "%s()" is not allowed. Use "set%s()" instead',
                    $methodName,
                    $matches['remainder']
                ),
                $stackPtr,
                'BadSetter'
            );
        }
    }
}
