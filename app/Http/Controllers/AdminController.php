<?php

namespace App\Http\Controllers;

use App\Traits\ProductManager;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  use ProductManager;

  public function index() {
    return view("admin.dashboard", []);
  }

}
