<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\Species;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    // form keturunan
    public function create()
    {
        $species = Species::orderBy('name')->get();
        return view('pet-haven.admin.add_breed', compact('species'));
    }

    // store keturunan baru
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'species_id' => 'required|exists:species,id',
        ]);

        Breed::create([
            'name'       => $request->name,
            'species_id' => $request->species_id,
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Breed added successfully!');
    }


}
