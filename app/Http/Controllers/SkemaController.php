<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkemaController extends Controller
{
    public function index()
    {
        $skemas = Skema::latest()->get();

        return view('skema.index', compact('skemas'));
    }

    public function create()
    {
        return view('skema.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:skemas,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'lembaga' => ['nullable', 'string', 'max:255'],
        ]);

        Skema::create($validated);

        return redirect()
            ->route('skema.index')
            ->with('success', 'Skema berhasil ditambahkan.');
    }

    public function show(Skema $skema)
    {
        return view('skema.show', compact('skema'));
    }

    public function edit(Skema $skema)
    {
        return view('skema.edit', compact('skema'));
    }

    public function update(Request $request, Skema $skema)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('skemas', 'kode')->ignore($skema->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'lembaga' => ['nullable', 'string', 'max:255'],
        ]);

        $skema->update($validated);

        return redirect()
            ->route('skema.index')
            ->with('success', 'Skema berhasil diperbarui.');
    }

    public function destroy(Skema $skema)
    {
        if ($skema->pesertas()->exists()) {
            return back()->with('error', 'Skema tidak bisa dihapus karena masih memiliki peserta.');
        }

        $skema->delete();

        return redirect()
            ->route('skema.index')
            ->with('success', 'Skema berhasil dihapus.');
    }
}