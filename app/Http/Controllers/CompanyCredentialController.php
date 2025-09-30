<?php

namespace App\Http\Controllers;

use App\Models\CompanyCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class CompanyCredentialController extends Controller
{
    protected function ensureAdmin() {
        abort_unless(Auth::check() && Auth::user()->email === 'admin@admin.com', 403);
    }

    public function index($slug)
    {
        $creds = CompanyCredential::where('company_slug', $slug)->orderBy('label')->get();
        $isAdmin = Auth::check() && Auth::user()->email === 'admin@admin.com';
        try { $demandsCount = \App\Models\Demand::where('company_slug',$slug)->count(); } catch (\Throwable $e) { $demandsCount = null; }
        return view('credentials.index', [
            'creds' => $creds,
            'slug' => $slug,
            'isAdmin' => $isAdmin,
            'demandsCount' => $demandsCount,
        ]);
    }

    public function hub()
    {
        $this->ensureAdmin();
        $companies = [
            ['slug' => 'feiradasfabricas', 'name' => 'Feira das Fábricas'],
            ['slug' => 'goldbank', 'name' => 'Goldbank'],
            ['slug' => 'ibams', 'name' => 'Ibams'],
        ];
        return view('credentials.hub', compact('companies'));
    }

    public function store(Request $request, $slug)
    {
        $this->ensureAdmin();
        $data = $request->validate([
            'category' => 'nullable|string|max:100',
            'label' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:1000',
            'notes' => 'nullable|string'
        ]);
        CompanyCredential::create([
            'company_slug' => $slug,
            'category' => $data['category'] ?? null,
            'label' => $data['label'],
            'username' => $data['username'],
            'password_encrypted' => Crypt::encryptString($data['password']),
            'notes' => $data['notes'] ?? null,
        ]);
        return back()->with('success','Credencial adicionada.');
    }

    public function update(Request $request, CompanyCredential $credential)
    {
        $this->ensureAdmin();
        $data = $request->validate([
            'category' => 'nullable|string|max:100',
            'label' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:1000',
            'notes' => 'nullable|string'
        ]);
        $credential->label = $data['label'];
        $credential->category = $data['category'] ?? null;
        $credential->username = $data['username'];
        if(!empty($data['password'])) {
            $credential->password_encrypted = Crypt::encryptString($data['password']);
        }
        $credential->notes = $data['notes'] ?? null;
        $credential->save();
        return back()->with('success','Credencial atualizada.');
    }

    public function destroy(CompanyCredential $credential)
    {
        $this->ensureAdmin();
        $credential->delete();
        return back()->with('success','Credencial removida.');
    }
}
