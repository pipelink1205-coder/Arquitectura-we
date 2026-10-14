<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ObraController extends Controller
{
    public function index(): View
    {
        return view('admin.obras.index', [
            'obras' => Obra::query()->ordenados()->get(),
            'categorias' => config('sitio.categorias'),
        ]);
    }

    public function create(): View
    {
        return view('admin.obras.form', [
            'obra' => new Obra,
            'categorias' => config('sitio.categorias'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['img'] = $this->storeImage($request);

        Obra::query()->create($data);

        return redirect()->route('admin.obras.index')->with('ok', 'Proyecto creado.');
    }

    public function edit(Obra $obra): View
    {
        return view('admin.obras.form', [
            'obra' => $obra,
            'categorias' => config('sitio.categorias'),
        ]);
    }

    public function update(Request $request, Obra $obra): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['img'] = $this->storeImage($request);
        }

        $obra->update($data);

        return redirect()->route('admin.obras.index')->with('ok', 'Proyecto actualizado.');
    }

    public function destroy(Obra $obra): RedirectResponse
    {
        $obra->delete();

        return redirect()->route('admin.obras.index')->with('ok', 'Proyecto eliminado.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $cats = array_keys(config('sitio.categorias'));

        $request->validate([
            'cat' => ['required', 'string', 'in:'.implode(',', $cats)],
            'titulo' => ['required', 'string', 'max:160'],
            'texto' => ['required', 'string', 'max:2000'],
            'w' => ['required', 'integer', 'min:100', 'max:4000'],
            'h' => ['required', 'integer', 'min:100', 'max:4000'],
            'alt' => ['required', 'string', 'max:255'],
            'etiqueta' => ['nullable', 'string', 'max:80'],
            'orden' => ['nullable', 'integer', 'min:0', 'max:999'],
            'activo' => ['nullable', 'boolean'],
            'foto' => [$request->isMethod('post') ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);

        return [
            'cat' => $request->string('cat')->toString(),
            'titulo' => $request->string('titulo')->toString(),
            'texto' => $request->string('texto')->toString(),
            'w' => (int) $request->input('w'),
            'h' => (int) $request->input('h'),
            'alt' => $request->string('alt')->toString(),
            'etiqueta' => $request->filled('etiqueta') ? $request->string('etiqueta')->toString() : null,
            'orden' => (int) $request->input('orden', 0),
            'activo' => $request->boolean('activo'),
        ];
    }

    private function storeImage(Request $request): string
    {
        $file = $request->file('foto');
        $name = time().'_'.$file->hashName();
        $file->move(public_path('images/obras'), $name);

        return 'images/obras/'.$name;
    }
}
