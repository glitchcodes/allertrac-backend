<?php

namespace App\Http\Controllers;

use App\Actions\Meal\GetMeals;
use App\Actions\Meal\ScanMeal;
use App\Actions\Meal\SearchMeal;
use App\Enums\HttpCodes;
use App\Http\Requests\BookmarkMealRequest;
use App\Http\Requests\MealSearchRequest;
use App\Http\Requests\ScanMealRequest;
use App\Http\Requests\UpdateFoodDetails;
use App\Http\Resources\BookmarkedMealResource;
use App\Http\Resources\MealResource;
use App\Models\BookmarkedMeal;
use App\Models\Food;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealController extends Controller
{
    private Authenticatable|User $user;

    public function __construct()
    {
        if (auth()->check()) {
            $this->user = auth()->user();
        }
    }

    /**
     * Scan image for any ingredients
     *
     * This endpoint is used to upload the captured image into Foodvisor and returns
     * any detected ingredients
     *
     * @throws ConnectionException
     */
    public function scan(ScanMealRequest $request, ScanMeal $action): JsonResponse
    {
        // Decode the base64 string into image
        $data = $request->input('image');

        if (preg_match('/^data:image\/(?<type>.+);base64,(?<data>.+)$/', $data, $matches)) {
            $type = $matches['type'];
            $data = base64_decode($matches['data']);

            $tempFilePath = tempnam(sys_get_temp_dir(), 'image_') . '.' . $type;
            file_put_contents($tempFilePath, $data);
        }

        $imageInfo = [
            'file' => $tempFilePath,
            'type' => $type
        ];

        // Pass the image to the Foodvisor API
        $response = $action->execute($imageInfo);

        // Clean up the temp file
        unlink($tempFilePath);

        return $this->sendResponse([
            'payload' => $response->json(),
            'message' => 'Scan successful.'
        ]);
    }

    /**
     * Search for meals
     *
     * This endpoint is used to search for meals/recipe using Edamam API.
     *
     * @param MealSearchRequest $request
     * @param SearchMeal $action
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function search(MealSearchRequest $request, SearchMeal $action): JsonResponse
    {
        $query = $request->query('query');
        $nextPageKey = $request->filled('_cont') ? $request->query('_cont') : null;

        $response = $action->execute($query, $nextPageKey);

        if ($response->failed()) {
            // TODO: Implement error handler
            // return $this->sendErrorResponse()
        }

        return $this->sendResponse([
            'payload' => $response->json(),
            'message' => 'Search successful.'
        ]);
    }

    /**
     * Get bookmarked meals
     *
     * This endpoint allows the authenticated user to get their bookmarked meals.
     *
     * @param GetMeals $action
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function getBookmarks(GetMeals $action): JsonResponse
    {
        $bookmarks = $this->user->bookmarkedMeals;

        if ($bookmarks->isEmpty()) {
            return $this->sendResponse([
                'bookmarks' => [],
                'payload' => []
            ]);
        }

        $response = $action->execute($bookmarks->pluck('uri')->toArray());

        return $this->sendResponse([
            'bookmarks' => BookmarkedMealResource::collection($bookmarks),
            'payload' => $response->json()
        ]);
    }

    /**
     * Bookmark a meal
     *
     * This endpoint allows the authenticated user to bookmark a meal.
     *
     * @param BookmarkMealRequest $request
     * @return JsonResponse
     */
    public function createBookmark(BookmarkMealRequest $request, GetMeals $action): JsonResponse
    {
        // TODO: Limit the number of bookmarks a user can have (e.g. 20)

        // Create bookmark
        $this->user->bookmarkedMeals()->create(
            $request->validated()
        );

        // Fetch new data
        $bookmarks = $this->user->bookmarkedMeals;
        $response = $action->execute($bookmarks->pluck('uri')->toArray());

        return $this->sendResponse([
            'bookmarks' => BookmarkedMealResource::collection($bookmarks),
            'payload' => $response->json()
        ], HttpCodes::CREATED->getHttpStatusCode());
    }

    /**
     * Delete a bookmarked meal
     *
     * This endpoint allows the authenticated user to delete their bookmarked meal.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function deleteBookmark(int $id, GetMeals $action): JsonResponse
    {
        try {
            BookmarkedMeal::findOrFail($id)->delete();

            // Fetch new data
            $bookmarks = $this->user->bookmarkedMeals;
            if ($bookmarks->isEmpty()) {
                return $this->sendResponse([
                    'bookmarks' => BookmarkedMealResource::collection($bookmarks),
                    'payload' => []
                ]);
            } else {
                $response = $action->execute($bookmarks->pluck('uri')->toArray());

                return $this->sendResponse([
                    'bookmarks' => BookmarkedMealResource::collection($bookmarks),
                    'payload' => $response->json()
                ]);
            }
        } catch (ModelNotFoundException $exception) {
            return $this->sendErrorResponse('Bookmark not found.', HttpCodes::NOT_FOUND->getHttpStatusCode());
        }
    }

    /**
     * Get food list / database
     *
     * This endpoint is used to get the list of food items in the database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFoodDatabase(Request $request): JsonResponse
    {
        $filter = $request->query('filter');

        $meals = Food::when($filter, function (Builder $query) use ($filter) {
            return match ($filter) {
                'good' => $query->whereHas('allergens'),
                'bad' => $query->whereDoesntHave('allergens'),
            };
        })->with(['allergens'])->paginate(10);

        return $this->sendResponse([
            'payload' => MealResource::collection($meals)->response()->getData(true),
            'message' => 'Fetched meals successfully.'
        ]);
    }

    /**
     * Get food details
     *
     * This endpoint is used to get the details of a specific food item.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function getFoodDetails(string $id): JsonResponse
    {
        $meal = Food::with(['allergens'])->findOrFail($id);

        return $this->sendResponse([
            'payload' => new MealResource($meal),
            'message' => 'Fetched meal successfully.'
        ]);
    }

    /**
     * Update food details
     *
     * This endpoint is used to update the allergens of a specific food item.
     *
     * @param string $id
     * @param UpdateFoodDetails $request
     * @return JsonResponse
     */
    public function updateFoodDetails(string $id, UpdateFoodDetails $request): JsonResponse
    {
        $allergenIds = $request->input('allergens');

        $meal = Food::with(['allergens'])->where('food_id', $id)->firstOrFail();
        $meal->allergens()->sync($allergenIds);

        return $this->sendResponse([
            'payload' => new MealResource($meal),
            'message' => 'Updated meal successfully.'
        ]);
    }
}
