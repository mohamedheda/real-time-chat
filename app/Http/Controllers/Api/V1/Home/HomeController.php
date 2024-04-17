<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Home\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeService $home,
    ){

    }

    public function index(){
        return $this->home->index();
    }
}
