<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\ListFactory;

class RssController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_factory = new ListFactory();
        $list = $list_factory->returnWordList();
        return view('list')->with('list', $list);
    }
}
