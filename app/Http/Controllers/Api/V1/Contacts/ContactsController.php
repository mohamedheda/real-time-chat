<?php

namespace App\Http\Controllers\Api\V1\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Contacts\ContactsService;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    public function __construct(private readonly ContactsService $contactsService){

    }
    public function index(){
        return $this->contactsService->index();
    }
}
