<?php
if (! defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'History_Test_AllTests::main');
}

require_once dirname(__FILE__) . '/../../../../tests/TestHelper.php';

class History_Test_AllTests
{
    public static function main ()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
    
    public static function suite ()
    {
        $suite = new PHPUnit_Framework_TestSuite('Modules History');
        
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'History_Test_AllTests::main') {
    Modules_AllTests::main();
}