<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->orderByDesc('id')
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
            'imagen' => 'required|mimes:jpg,bmp,png',
        ]);

        if($validator->fails()){
            return redirect()
                ->route('productos.create')
                ->withErrors($validator)
                ->withInput();
        }

        //Guardamos el nombre del archivo, modificando el nombre original del cliente con time.
        $imagen_nombre = time() . $request->file('imagen')->getClientOriginalName();

        //Subimos el archivo a una carpeta del proyecto y guardamos el nombre con el que subió el archivo.
        $imagen = $request->file('imagen')->storeAs('productos', $imagen_nombre, 'public');
        
        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
            'imagen' => $imagen
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

        $rules = [
            'nombre' => 'required|max:255',
            'precio' => 'numeric|max:9999999',
            'categoria_id' => 'required',
            'descripcion' => 'required',
        ];

        //Solamente valido la imagen si el usuario están intentando subirla.
        if($request->file('imagen')){
            $rules['imagen'] = 'required|mimes:jpg,bmp,png';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()
                ->route('productos.edit', $producto)
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
        ];

        //Guardamos el nuevo archivo.
        if($request->file('imagen')){
            //Guardamos el nombre del archivo, modificando el nombre original del cliente con time.
            $imagen_nombre = time() . $request->file('imagen')->getClientOriginalName();
            //Subimos el archivo a una carpeta del proyecto y guardamos el nombre con el que subió el archivo.
            $imagen = $request->file('imagen')->storeAs('productos', $imagen_nombre, 'public');
            //Elimina la imagen vieja.
            Storage::delete('public/' . $producto->imagen);
            $data['imagen'] = $imagen;
        }

        $producto->update($data);

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
