<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
  // Show registration form (if needed)
  public function AdminDashboard()
  {
      return view('components/pages/admin/dashboard');
  }

  public function createBlog(){
    return view('components.pages.admin.create_blog');
  }

  
}
