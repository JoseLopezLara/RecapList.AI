<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testComponent()
    {
        return view('test-page');
    }

    public function testRecap()
    {
        return view('test-recap');
    }
}
