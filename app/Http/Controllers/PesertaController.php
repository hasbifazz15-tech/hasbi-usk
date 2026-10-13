<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pesertas = Peserta::with('skema')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nik', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peserta.index', compact('pesertas', 'search'));
    }

    public function create()
    {
        $skemas = Skema::orderBy('nama')->get();

        return view('peserta.create', compact('skemas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:pesertas,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:pesertas,email'],
            'no_hp' => ['required', 'regex:/^[0-9]{5,20}$/'],
            'alamat' => ['required', 'string'],
            'skema_id' => ['required', 'exists:skemas,id'],
            'tanggal_daftar' => ['required', 'date'],
            'status' => ['required', Rule::in([
                'Terdaftar',
                'Proses',
                'Lulus',
                'Tidak Lulus'
            ])],
        ]);

        Peserta::create($validated);

        return redirect()
            ->route('peserta.index')
            ->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function show(Peserta $peserta)
    {
        $peserta->load('skema');
        $skemas = Skema::orderBy('nama')->get();

        return view('peserta.show', compact('peserta'));
    }

    public function edit(Peserta $peserta)
    {
        $skemas = Skema::orderBy('nama')->get();

        return view('peserta.edit', compact('peserta', 'skemas'));
    }

    public function update(Request $request, $id)
{
    $peserta = Peserta::findOrFail($id);

    $validated = $request->validate([
        'nik' => [
            'required',
            'digits:16',
            Rule::unique('pesertas', 'nik')->ignore($peserta->id),
        ],
        'nama' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('pesertas', 'email')->ignore($peserta->id),
        ],
        'no_hp' => ['required', 'regex:/^[0-9]{5,20}$/'],
        'alamat' => ['required', 'string'],
        'skema_id' => ['required', 'exists:skemas,id'],
        'tanggal_daftar' => ['required', 'date'],
        'status' => ['required', Rule::in([
            'Terdaftar',
            'Proses',
            'Lulus',
            'Tidak Lulus'
        ])],
    ]);

    $peserta->update($validated);

    return redirect()
        ->route('peserta.index')
        ->with('success', 'Data peserta berhasil diperbarui.');
}
    public function destroy(Peserta $peserta)
    {
        $peserta->delete();

        return redirect()
            ->route('peserta.index')
            ->with('success', 'Data peserta berhasil dihapus.');
    }
}