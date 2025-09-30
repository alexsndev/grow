<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demand;
use App\Models\DemandAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DemandController extends Controller
{
    public function index($slug)
    {
        $demands = Demand::with(['attachments', 'user'])
            ->where('company_slug', $slug)
            ->orderBy('created_at', 'desc')
            ->get();
        // Contagem de credenciais para tabs (não quebra caso tabela inexistente em ambientes antigos)
        try {
            $credentialsCount = \App\Models\CompanyCredential::where('company_slug', $slug)->count();
        } catch (\Throwable $e) { $credentialsCount = null; }
        return view('demands.index', [
            'demands' => $demands,
            'slug' => $slug,
            'credentialsCount' => $credentialsCount,
        ]);
    }

    public function store(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachments.*' => 'file|mimes:png,jpg,jpeg,webp,gif,mp4,mov,avi,mkv|max:25600',
        ]);

        if ($request->file('attachments') && count($request->file('attachments')) > 10) {
            return back()->withErrors(['attachments' => 'Máximo de 10 anexos.'])->withInput();
        }

        $demand = Demand::create([
            'company_slug' => $slug,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        if ($request->hasFile('attachments')) {
            $current = 0;
            foreach ($request->file('attachments') as $file) {
                if (!$file->isValid()) { continue; }
                $ext = strtolower($file->getClientOriginalExtension());
                // limit accepted types
                $allowed = ['png','jpg','jpeg','webp','gif','mp4','mov','avi','mkv'];
                if (!in_array($ext, $allowed)) { continue; }
                if ($current >= 10) { break; }
                $path = $file->store('demands/'.date('Y/m'), 'public');
                DemandAttachment::create([
                    'demand_id' => $demand->id,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
                $current++;
            }
        }

        return redirect()->back()->with('success', 'Demanda criada.');
    }

    public function update(Request $request, Demand $demand)
    {
        $this->authorize('update', $demand);
        $isAdmin = Auth::user()->email === 'admin@admin.com';

        // Se somente status for enviado → requer admin
        if ($request->has('status') && !$request->has('title')) {
            abort_unless($isAdmin, 403);
            $validated = $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);
            $demand->update(['status' => $validated['status']]);
            return back()->with('success', 'Status atualizado.');
        }

        // Edição de conteúdo (autor ou admin). Se incluir status junto e não for admin, remove.
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'attachments.*' => 'file|mimes:png,jpg,jpeg,webp,gif,mp4,mov,avi,mkv|max:25600'
        ];
        $validated = $request->validate($rules);
        if (!$isAdmin) {
            unset($validated['status']);
        }
        $demand->update($validated);

        // Adicionar novos anexos mantendo limite total de 10
        if ($request->hasFile('attachments')) {
            $existing = $demand->attachments()->count();
            $space = max(0, 10 - $existing);
            if ($space <= 0) {
                return back()->with('success', 'Demanda atualizada (limite de 10 anexos atingido).');
            }
            $added = 0;
            foreach ($request->file('attachments') as $file) {
                if ($added >= $space) break;
                if (!$file->isValid()) continue;
                $ext = strtolower($file->getClientOriginalExtension());
                $allowed = ['png','jpg','jpeg','webp','gif','mp4','mov','avi','mkv'];
                if (!in_array($ext, $allowed)) continue;
                $path = $file->store('demands/'.date('Y/m'), 'public');
                DemandAttachment::create([
                    'demand_id' => $demand->id,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
                $added++;
            }
        }
        return back()->with('success', 'Demanda atualizada.');
    }

    public function destroy(Demand $demand)
    {
        $this->authorize('delete', $demand);
        $demand->delete();
        return redirect()->back()->with('success', 'Demanda removida.');
    }
}
