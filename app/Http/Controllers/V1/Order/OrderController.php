<?php

namespace App\Http\Controllers\V1\Order;

use App\Enums\Order\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Order\IndexRequest;
use App\Http\Requests\V1\Order\StoreRequest;
use App\Http\Requests\V1\Order\UpdateRequest;
use App\Models\Address;
use App\Models\Client\Client;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        $pagination = Order::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->orderBy('createdAt', 'DESC')
            ->with(['client', 'address'])
            ->paginate($request->perPage ?? 15);

        return $this->successResponse('Orders retrieved successfully', $pagination);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $items = $request->get('items', []);
        $products = Product::query()->whereIn('id', array_column($items, 'productId'))->get();

        $data['total'] = $products->sum(function (Product $product) use ($items) {
            $item = collect($items)->firstWhere('productId', $product->id);
            return $product->price * $item['quantity'];
        });
        $data['status'] = StatusEnum::PROCESSING;

        $client = Client::query()->create($data['client']);
        $data['clientId'] = $client->id;

        $address = $client->addresses()->create($data['address']);
        $data['addressId'] = $address->id;

        /** @var Order $order */
        $order = Order::query()->create($data);

        $items = $products->map(function (Product $product) use ($items) {
            $item = collect($items)->firstWhere('productId', $product->id);
            return [
                'productId' => $product->id,
                'quantity' => $item['quantity'],
                'total' => $product->price * $item['quantity'],
            ];
        });
        $order->items()->createMany($items);

        return $this->successResponse('Order created successfully', [
            'order' => $order,
        ], HttpResponse::HTTP_CREATED);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load([
            'client',
            'address',
            'items.product',
        ]);

        return $this->successResponse('Order retrieved successfully', [
            'order' => $order,
        ]);
    }

    public function update(UpdateRequest $request, Order $order): JsonResponse
    {
        $order->update($request->all());

        return $this->successResponse('Order updated successfully', [
            'order' => $order,
        ]);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return $this->successResponse('Order deleted successfully');
    }

    public function listQueue(): JsonResponse
    {
        $orders = Order::query()
            ->whereIn('status', [StatusEnum::PENDING, StatusEnum::PROCESSING])
            ->orderBy('createdAt')
            ->whereHas('items')
            ->with(['client', 'address', 'items.product'])
            ->get();

        return $this->successResponse('Orders retrieved successfully', [
            'orders' => $orders,
        ]);
    }
}
