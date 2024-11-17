<?php

namespace App\Http\Controllers;

use App\Enums\HttpCodes;
use App\Http\Resources\FactCategoryResource;
use App\Http\Resources\FactResource;
use App\Models\Fact;
use App\Models\FactCategory;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
class FactController extends Controller
{
    /**
     * Get all fact categories
     *
     * This endpoints returns all fact categories stored in the database
     *
     * NOTE: This is not paginated because the number of categories is expected to be small
     *
     * @unauthenticated
     * @return JsonResponse
     */
    public function getAllCategories(): JsonResponse
    {
        $categories = FactCategory::all();

        return $this->sendResponse([
            'categories' => FactCategoryResource::collection($categories)
        ]);
    }

    /**
     * Get random fact categories
     *
     * This endpoint returns 4 random fact categories
     *
     * @unauthenticated
     * @return JsonResponse
     */
    public function getRandomCategories(): JsonResponse
    {
        $categories = FactCategory::inRandomOrder()->limit(4)->get();

        return $this->sendResponse([
            'categories' => FactCategoryResource::collection($categories)
        ]);
    }

    /**
     * Get recent facts
     *
     * This endpoint returns 5 recently created facts
     *
     * @unauthenticated
     * @return JsonResponse
     */
    public function getRecentFacts(): JsonResponse
    {
        $facts = Fact::latest()->limit(5)->get();

        return $this->sendResponse([
            'facts' => FactResource::collection($facts)
        ]);
    }

    /**
     * Get facts by category
     *
     * This endpoint returns a collection of facts with the given `category_id`
     *
     * @unauthenticated
     * @param int $category
     * @return JsonResponse
     */
    public function getFactsByCategory(int $categoryId): JsonResponse
    {
        $category = FactCategory::where('id', $categoryId)->first();
        $facts = Fact::where('category_id', $categoryId)->get();

        return $this->sendResponse([
            'name' => $category->name,
            'facts' => FactResource::collection($facts)
        ]);
    }

    /**
     * Get fact by id
     *
     * This endpoint returns a fact with the given `id`
     *
     * @unauthenticated
     * @param int $id
     * @return JsonResponse
     */
    public function getFactById(int $id): JsonResponse
    {
        $fact = Fact::find($id);

        if (!$fact) {
            return $this->sendErrorResponse(
                'Fact not found',
                HttpCodes::NOT_FOUND->value,
                null,
                HttpCodes::NOT_FOUND->getHttpStatusCode()
            );
        }

        return $this->sendResponse([
            'fact' => new FactResource($fact)
        ]);
    }
}
