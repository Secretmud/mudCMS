<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class content_tester extends TestCase
{

    public function testCodeBlockClosing(): void {
        include("src/assets/posts/content_verify.php");
        $verify = new ContentVerify();

        $test = [
            [True, ["~","~","~","~","~","~"]],
            [False, ["","~","~","~","~","~"]],
            [True, ["","","","","",""]],
            [True, ["","","","","~","~"]],
            [False, ["","","","","","~"]],
            [True, ["~","","","","","~"]],
            [True, ["","","","","",""]]
        ];

        foreach ($test as $k) {
            if ($k[0]) $this->assertTrue($verify->verify_code_tags($k[1]));
            else $this->assertFalse($verify->verify_code_tags($k[1]));
        }
        
    }
    
}