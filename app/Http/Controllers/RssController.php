<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ListFacade;

class RssController extends Controller
{
    public function index()
    {
        $list_facade = new ListFacade();
        $list = $list_facade->returnWordList();
        return view('list')->with('list', $list);
    }
}
