<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Models\User;
use App\Services\UrlShortenerService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @OA\Info(
 *     title="URL Shortener API",
 *     version="1.0.0",
 *     description="API to shorten URLs and get original URLs."
 * )
 */
class UrlShortenerController extends Controller
{
    private $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    /**
     * @OA\Get(
     *     path="/api/url",
     *     tags={"URLs"},
     *     summary="Gets all shortened URLs",
     *     description="Returns a list of all stored shortened URLs.",
     *     @OA\Response(
     *         response=200,
     *         description="List of shortened URLs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="original_url", type="string", example="http://example.com"),
     *                 @OA\Property(property="short_code", type="string", example="abc123")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'urls' => Url::all(),
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/url",
     *     tags={"URLs"},
     *     summary="Creates a shortened URL",
     *     description="Receives a long URL and returns its shortened version.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", example="http://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Shortened URL created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="original_url", type="string", example="http://example.com"),
     *             @OA\Property(property="short_code", type="string", example="abc123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['url' => 'required|url']);

        $url = $this->urlShortenerService->createShortUrl($validated['url']);

        return response()->json($url, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/{shortCode}",
     *     tags={"URLs"},
     *     summary="Retrieve the original URL by its short code",
     *     description="Searches and returns the original URL associated with the provided short code.",
     *     @OA\Parameter(
     *         name="shortCode",
     *         in="path",
     *         description="Short code of the URL",
     *         required=true,
     *         @OA\Schema(type="string", example="abc123")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Original URL found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="url", type="object", example={"id": 1, "original_url": "http://example.com", "short_code": "abc123"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="URL not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="URL not found")
     *         )
     *     )
     * )
     */
    public function show($shortCode)
    {
        $url = $this->urlShortenerService->getOriginalUrl($shortCode);

        if (!$url) {
            return response()->json(['error' => 'URL not found'], 404);
        }

        return response()->json(["url" => $url]);
    }

    /**
     * @OA\Delete(
     *     path="/api/url/{ID}",
     *     tags={"URLs"},
     *     summary="Delete a shortened URL",
     *     description="Deletes a shortened URL using its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the URL to delete",
     *         @OA\Schema(type="integer", example="123")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="URL successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="URL not found"
     *     )
     * )
     */
    public function delete($id)
    {
        $url = Url::where('id', $id)->first();

        if (!$url) {
            return response()->json(['error' => 'URL not found'], 404);
        }

        $url->delete();

        return response()->noContent();
    }
}
