<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class ProductController extends Controller
{
    public function index(){
        $productos = ProductoModel::all();
        return view('Productos.listado', compact('productos'));
    }

    public function form_registro(){
        /*
        Esta función sera invocada cuando el usuario le de clic en Adicionar
        */
        $categorias = CategoriaModel::all();
        return view('Productos.form_registro', compact('categorias'));
    }

    public function registrar(Request $r){
        $r->validate([
            'nombre_producto' => 'required|string',
            'cantidad_producto' => 'required|integer|min:1',
            'precio_producto' => 'required|numeric|min:0',
            'foto_producto' => 'file', // o 'required|image' si es un archivo
            'categoria' => 'required|integer',
        ]);

        $product= new ProductoModel();
        $product->nombreProducto= $r->input('nombre_producto');
        $product->cantidadProducto= $r->input('cantidad_producto');
        $product->precioProducto= $r->input('precio_producto');
        $product->fotoProducto= $r->input('foto_producto');
        $product->categoria= $r->input('categoria');
        $product->save();
        return redirect()->route('productos');
    }

    public function form_edicion($id){
        /*
        Esta función sera invocada cuando el usuario le de clic en Editar
        */
        $product= ProductoModel::findOrFail($id); // Retorna el registro cuyo id corresponda
        $categorias = CategoriaModel::all();
        return view('Productos.form_edicion', compact('product', 'categorias'));
    }

    public function actualizar(Request $r, $id){
        $product = ProductoModel::findOrFail($id);
        $r->validate([
            'nombre_producto' => 'required|string',
            'cantidad_producto' => 'required|integer|min:1',
            'precio_producto' => 'required|numeric|min:0',
            'foto_producto' => 'file', // o 'required|image' si es un archivo
            'categoria' => 'required|integer',
        ]);

        $product->nombreProducto= $r->input('nombre_producto');
        $product->cantidadProducto= $r->input('cantidad_producto');
        $product->precioProducto= $r->input('precio_producto');
        $product->fotoProducto= $r->input('foto_producto');
        $product->categoria= $r->input('categoria');
        $product->save();
        return redirect()->route('productos');
    }

    public function eliminar($id){
        $category = ProductoModel::findOrFail($id);
        $category->delete();
        return redirect()->route('productos');
    }
    
}
