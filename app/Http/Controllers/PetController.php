<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Species;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // list hewan
    public function index()
    {
        $pets = Pet::with(['species', 'breed'])->get();
        return view('pet-haven.admin.control_pets', compact('pets'));
    }

    // form tambah hewan
    public function create()
    {
        $species = Species::orderBy('name')->get();
        $breeds  = Breed::orderBy('name')->get();

        return view('pet-haven.admin.add_pet', compact('species', 'breeds'));
    }

    // simpan data hewan
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'species_id' => 'required|exists:species,id',
            'breed_id'   => 'nullable|exists:breeds,id',
            'age'        => 'nullable|integer|min:0',
            'description'=> 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name','species_id','breed_id','age','description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        Pet::create($data);

        return redirect()->route('admin.pets.index')->with('success', 'Pet added successfully!');
    }

    // form edit hewan
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        $species = Species::orderBy('name')->get();
        $breeds  = Breed::orderBy('name')->get();

        return view('pet-haven.admin.edit_pets', compact('pet', 'species', 'breeds'));
    }

    // update data hewan
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'species_id' => 'required|exists:species,id',
            'breed_id'   => 'nullable|exists:breeds,id',
            'age'        => 'nullable|integer|min:0',
            'description'=> 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name','species_id','breed_id','age','description']);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($pet->image) {
                Storage::disk('public')->delete($pet->image);
            }
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('admin.pets.index')->with('success', 'Pet updated successfully!');
    }

    // hapus hewan
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        return redirect()->route('admin.pets.index')->with('success', 'Pet deleted successfully!');
    }
}
