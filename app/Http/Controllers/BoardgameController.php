<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boardgame;
use App\Models\BoardgameFile;

use Illuminate\Support\Facades\Storage;

class BoardgameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $boardgames = Boardgame::all();
        // return view('boardgames.index', compact('boardgames'));

        // Si l'utilisateur est authentifié, utiliser la vue de gestion des jeux
        // if (auth()->check()) {
        //     $boardgames = Boardgame::orderBy('created_at', 'desc')->get();
        //     return view('boardgames.index', compact('boardgames'));
        // }

        // Sinon, utiliser la vue publique
        // return view('welcome');

        $boardgames = Boardgame::orderBy('created_at', 'desc')->get();
        return view('boardgames.index', compact('boardgames'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Boardgame $boardgame)
    {
        return view('boardgames.show', compact('boardgame'));
    }

}
