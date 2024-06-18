<?php

namespace App\Repositories;

use App\Repositories\Interfaces\HomePageRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomePageRepository implements HomePageRepositoryInterface {
    public function index() {
        if(Auth::check()) {
            return Redirect::route('contacts.index');
        }
        
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}