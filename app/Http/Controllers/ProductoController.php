<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::where('is_visible', true)
            ->orderBy('nombre')
            ->paginate(10);
        return view('productos.index', [
            'productos' => $productos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', [
            'categorias' => $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'precio' => 'numeric|max:9999999',
            'categoria_id' => 'required',
            'descripcion' => 'required',
        ]);

        if($validator->fails()){
            return redirect()
                ->route('productos.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('status', 'El producto se ha agregado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return view('productos.show', [
            'producto' => $producto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', [
            'categorias' => $categorias,
            'producto' => $producto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'precio' => 'numeric|max:9999999',
            'categoria_id' => 'required',
            'descripcion' => 'required',
        ]);

        if($validator->fails()){
            return redirect()
                ->route('productos.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
        ]);
        return redirect()
            ->route('productos.index')
            ->with('status', 'El producto se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->update([
            'is_visible' => false,
        ]);
        return redirect()
            ->route('productos.index')
            ->with('status', 'El producto se ha eliminado correctamente.');
    }
}
