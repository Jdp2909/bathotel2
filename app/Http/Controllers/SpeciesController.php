<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    // form spesies
    public function create()
    {
        return view('pet-haven.admin.add_species');
    }

     // store spesies baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:species,name|max:255',
        ]);

        Species::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Species added successfully!');
    }

  
}
