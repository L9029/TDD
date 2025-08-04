<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repository;

class PageController extends Controller
{
    /**
     * Muestra la página de inicio con los repositorios más recientes.
     * 
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $repositories = Repository::latest()->get(); // Obtiene los repositorios más recientes

        return view('welcome', [
            "repositories" => $repositories,
        ]);
    }
}
