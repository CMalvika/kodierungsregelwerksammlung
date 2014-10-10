<?php
require_once __DIR__ . '/../AbstractTestCase.php';

class InterNations_Tests_Sniffs_Naming_AlternativeFunctionSniffTest extends InterNations_Tests_Sniffs_AbstractTestCase
{
    public static function provideAlternativeNames()
    {
        return [
            ['join', 'implode()'],
            ['sizeof', 'count()'],
            ['fputs', 'fwrite()'],
            ['chop', 'rtrim()'],
            ['is_real', 'is_float()'],
            ['strchr', 'strstr()'],
            ['doubleval', 'floatval()'],
            ['key_exists', 'array_key_exists()'],
            ['is_double', 'is_float()'],
            ['ini_alter', 'ini_set()'],
            ['is_long', 'is_int()'],
            ['is_integer', 'is_int()'],
            ['is_real', 'is_float()'],
            ['pos', 'current()'],
            ['sha1', 'hash(\'sha256\', ...)']
        ];
   }

    /**
     * @param $method
     * @param $alternative
     * @dataProvider provideAlternativeNames
     */
    public function testMethodNames($method, $alternative)
    {
        $file = __DIR__ . '/Fixtures/AlternativeFunction/FunctionNames.php';
        $errors = $this->analyze(['InterNations/Sniffs/Naming/AlternativeFunctionSniff'], [$file]);

        $this->assertReportCount(17, 0, $errors, $file);
        $this->assertReportContains(
            $errors,
            $file,
            'errors',
            'Function "' . $method . '()" is not allowed. Use "' . $alternative . '" instead',
            'InterNations.Naming.AlternativeFunction.UseAlternative',
            5
        );
    }
}
