<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.base_url', $this->baseUrl);
    }

    /**
     * Search domestic destinations using RajaOngkir API
     */
    public function searchDestination(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        if (empty($search)) {
            return response()->json([
                'meta' => [
                    'message' => 'Search parameter is required',
                    'code' => 422,
                    'status' => 'error'
                ],
                'data' => null
            ], 422);
        }

        try {
            \Log::info('Searching destination from RajaOngkir API', [
                'search' => $search,
                'limit' => $limit,
                'offset' => $offset,
                'api_key' => $this->apiKey
            ]);
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/domestic-destination', [
                'search' => $search,
                'limit' => $limit,
                'offset' => $offset
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                \Log::error('Failed to fetch destination data from RajaOngkir API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'search' => $search,
                    'limit' => $limit,
                    'offset' => $offset
                ]);
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to fetch destination data',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }

    /**
     * Calculate shipping cost using RajaOngkir API
     */
    public function calculateCost(Request $request): JsonResponse
    {
        $request->validate([
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string',
            'price' => 'nullable|in:lowest,highest'
        ]);


        try {
            $payload = [
                'origin' => (int) $request->origin,
                'destination' => (int) $request->destination,
                'weight' => (int) $request->weight,
                'courier' => $request->courier,
            ];

            if ($request->filled('price')) {
                $payload['price'] = $request->price;
            }

            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->asForm()->post($this->baseUrl . '/calculate/domestic-cost', $payload);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to calculate shipping cost',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }

    /**
     * Get list of provinces using RajaOngkir API
     */
    public function getProvinces(): JsonResponse
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/province');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to fetch provinces data',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }

    /**
     * Get list of cities using RajaOngkir API
     */
    public function getCities(Request $request): JsonResponse
    {
        $provinceId = $request->get('province_id');

        try {
            $url = $this->baseUrl . '/city';
            $params = [];

            if ($provinceId) {
                $params['province_id'] = $provinceId;
            }

            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to fetch cities data',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }

    /**
     * Get city by ID using RajaOngkir API
     */
    public function getCityById(Request $request): JsonResponse
    {
        $request->validate([
            'city_id' => 'required|integer'
        ]);

        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/city/' . $request->city_id);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to fetch city data',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }

    /**
     * Get province by ID using RajaOngkir API
     */
    public function getProvinceById(Request $request): JsonResponse
    {
        $request->validate([
            'province_id' => 'required|integer'
        ]);

        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/province/' . $request->province_id);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'meta' => [
                        'message' => 'Failed to fetch province data',
                        'code' => $response->status(),
                        'status' => 'error'
                    ],
                    'data' => null
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'message' => 'Internal server error: ' . $e->getMessage(),
                    'code' => 500,
                    'status' => 'error'
                ],
                'data' => null
            ], 500);
        }
    }
}
