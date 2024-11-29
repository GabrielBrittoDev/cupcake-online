<?php

namespace App\Http\Controllers\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\IndexRequest;
use App\Http\Requests\V1\Product\StoreRequest;
use App\Http\Requests\V1\Product\UpdateRequest;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ProductController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        $pagination = Product::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->simplePaginate($request->perPage ?? 15);

        return $this->successResponse('Products retrieved successfully', $pagination);
    }

    public function list(): JsonResponse
    {
        $products = Product::query()
            ->where('active', true)
            ->get();

        return $this->successResponse('Products retrieved successfully', [
            'products' => $products,
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $image = $request->file('image');
        $data['imagePath'] = Storage::disk('public')->putFile('products', $image);

        $product = Product::query()->create($data);

        return $this->successResponse('Product created successfully', [
            'product' => $product,
        ], HttpResponse::HTTP_CREATED);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->successResponse('Product retrieved successfully', compact('product'));
    }

    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            $data['imagePath'] = Storage::disk('public')->putFile('products', $image);
        }

        $product->update($data);

        return $this->successResponse('Product updated successfully', compact('product'));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->successResponse('Product deleted successfully');
    }
}
