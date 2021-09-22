<?php

namespace App\Http\Controllers;

use App\Traits\SmtpConfigTrait;
use Illuminate\Http\Request;

class SMTPController extends Controller
{
    use SmtpConfigTrait;

    public function testMail() {
        if ( $this->testSMTP() ) {
            abort(403, 'Successfully sent email!'); 
        } 

        abort(403, 'Failed smtp email!');
    }
}
