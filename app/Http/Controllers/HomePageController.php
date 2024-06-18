<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\HomePageRepositoryInterface;


use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomePageController extends Controller
{
    public function index(HomePageRepositoryInterface $homePageRepository) {
        return $homePageRepository->index();
    }
}
