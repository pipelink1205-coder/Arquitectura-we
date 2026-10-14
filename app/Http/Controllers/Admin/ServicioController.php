<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicioController extends Controller
{
    public function index(): View
    {
        return view('admin.servicios.index', [
            'servicios' => Servicio::query()->ordenados()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.servicios.form', ['servicio' => new Servicio]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['img'] = $this->storeImage($request, 'images');

        Servicio::query()->create($data);

        return redirect()->route('admin.servicios.index')->with('ok', 'Servicio creado.');
    }

    public function edit(Servicio $servicio): View
    {
        return view('admin.servicios.form', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['img'] = $this->storeImage($request, 'images');
        }

        $servicio->update($data);

        return redirect()->route('admin.servicios.index')->with('ok', 'Servicio actualizado.');
    }

    public function destroy(Servicio $servicio): RedirectResponse
    {
        $servicio->delete();

        return redirect()->route('admin.servicios.index')->with('ok', 'Servicio eliminado.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'texto' => ['required', 'string', 'max:2000'],
            'w' => ['required', 'integer', 'min:100', 'max:4000'],
            'h' => ['required', 'integer', 'min:100', 'max:4000'],
            'alt' => ['required', 'string', 'max:255'],
            'orden' => ['nullable', 'integer', 'min:0', 'max:999'],
            'activo' => ['nullable', 'boolean'],
            'foto' => [$request->isMethod('post') ? 'required' : 'nullable', 'image', 'max:5120'],
        ]);

        return [
            'titulo' => $request->string('titulo')->toString(),
            'texto' => $request->string('texto')->toString(),
            'w' => (int) $request->input('w'),
            'h' => (int) $request->input('h'),
            'alt' => $request->string('alt')->toString(),
            'orden' => (int) $request->input('orden', 0),
            'activo' => $request->boolean('activo'),
        ];
    }

    private function storeImage(Request $request, string $folder): string
    {
        $file = $request->file('foto');
        $name = time().'_'.$file->hashName();
        $file->move(public_path($folder), $name);

        return $folder.'/'.$name;
    }
}
