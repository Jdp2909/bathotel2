<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adoption;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdoptionController extends Controller
{
    public function create($petId)
    {
        $pet = \App\Models\Pet::findOrFail($petId);
        return view('pet-haven.form_adop', compact('pet'));
    }
public function exportPdf()
{
    $adoptions = Adoption::with('pet')->orderBy('created_at', 'desc')->get();

    $pdf = Pdf::loadView('pet-haven.admin.adoptions_pdf', compact('adoptions'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('data_pengajuan_adopsi.pdf');
}

    public function adminIndex()
    {
        $adoptions = Adoption::with('pet')->get();
        return view('pet-haven.admin.admin_dashboard', compact('adoptions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $adoption = Adoption::findOrFail($id);
        $adoption->status = $request->status;
        $adoption->save();

        //kalau ada yang di setujui/approved yang lain kalo petnya sama bakal di reject/tolak
        if ($adoption->status === 'approved' && $adoption->pet) {
        $pet = $adoption->pet;
        $pet->available = false;
        $pet->save();

        Adoption::where('pet_id', $pet->id)
            ->where('id', '!=', $adoption->id)
            ->where('status', '!=', 'rejected')
            ->update(['status' => 'rejected']);
        }


        return redirect()->back()->with('success', 'Status adopsi berhasil diperbarui!');
    }

    public function index()
    {
        $pets = \App\Models\Pet::where('available', true)->get();
        return view('pet-haven.adopsi', compact('pets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'reason' => 'required|string',
            'pet_id' => 'required|exists:pets,id',
        ]);

        $existing = Adoption::where('pet_id', $request->pet_id)
            ->where('email', $request->email)
            ->first();

        if ($existing) {
            return redirect()->route('adopsi')
                ->with('error', 'Kamu sudah mengajukan adopsi untuk hewan ini!');
        }

        // ✅ Create adoption
        Adoption::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'reason' => $request->reason,
            'pet_id' => $request->pet_id,
            'status' => 'pending',
        ]);

        return redirect()->route('adopsi')
            ->with('success', 'Permohonan adopsi berhasil dikirim!');
    }
  public function userHistory()
    {
        // Only show adoptions linked to this user's email
        $email = Auth::user()->email;
        $adoptions = Adoption::where('email', $email)->with('pet')->get();

        return view('pet-haven.riwayat', compact('adoptions'));
    }
}
