<?php

namespace App\Http\Controllers;

use App\Models\DemandAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DemandAttachmentController extends Controller
{
    public function destroy(DemandAttachment $attachment)
    {
        $demand = $attachment->demand;        
        $user = Auth::user();
        if (!$user) abort(403);

        // Admin pode tudo; dono da demanda pode remover seus anexos
        if (!($user->email === 'admin@admin.com' || $demand->user_id === $user->id)) {
            abort(403);
        }

        // Remove arquivo físico se existir
        if ($attachment->path && Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }
        $attachment->delete();

        return back()->with('success', 'Anexo removido.');
    }
}
