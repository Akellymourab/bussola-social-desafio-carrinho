<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/products",
     * tags={"Product"},
     * summary="Lista todos os produtos",
     * @OA\Response(response="200", description="Lista de produtos retornada com sucesso.")
     * )
     */
    public function index(): Collection
    {
        return Product::all();
    }
}
