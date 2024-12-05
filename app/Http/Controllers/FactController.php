<?php

namespace App\Http\Controllers;

use App\Enums\HttpCodes;
use App\Http\Requests\CreateFactRequest;
use App\Http\Resources\FactCategoryResource;
use App\Http\Resources\FactResource;
use App\Models\Fact;
use App\Models\FactCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * Get facts
     *
     * This endpoint returns a paginated collection of facts
     * Used on Admin Panel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFacts(Request $request): JsonResponse
    {
        $q = $request->query('query');
        $category = $request->query('category');

        $facts = Fact::when($category, function (Builder $query) use ($category) {
            return $query->where('category_id', $category);
        })->when($q, function (Builder $query) use ($q) {
            return $query->where('title', 'like', "%$q%");
        })->with(['author', 'category'])->paginate(10);

        return $this->sendResponse([
            'payload' => FactResource::collection($facts)->response()->getData(true),
            'message' => 'Fetched meals successfully.'
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
        $facts = Fact::published()->latest()->limit(5)->get();

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
     * @param int $categoryId
     * @return JsonResponse
     */
    public function getFactsByCategory(int $categoryId): JsonResponse
    {
        $category = FactCategory::where('id', $categoryId)->first();
        $facts = Fact::where('category_id', $categoryId)->published()->get();

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

    /**
     * Create Fact
     *
     * @param CreateFactRequest $request
     * @return JsonResponse
     */
    public function createFact(CreateFactRequest $request): JsonResponse
    {
        // Upload cover image to Backblaze
        $cover_image = null;

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'facts/' . $filename;

            Storage::disk('backblaze')->put($path, file_get_contents($image));

            $cover_image = $path;
        }

        $fact = Fact::create([
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'brief_description' => $request->input('brief_description'),
            'category_id' => $request->input('category_id'),
            'cover_image' => $cover_image,
            'references' => $request->input('references'),
            'is_published' => $request->input('is_published'),
        ]);

        return $this->sendResponse([
            'fact' => new FactResource($fact)
        ], HttpCodes::CREATED->getHttpStatusCode());
    }

    /**
     * Edit Fact
     *
     * @param Fact $fact
     * @param CreateFactRequest $request
     * @return JsonResponse
     */
    public function editFact(Fact $fact, CreateFactRequest $request): JsonResponse
    {
        // Upload cover image to Backblaze
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'facts/' . $filename;

            Storage::disk('backblaze')->put($path, file_get_contents($image));

            $fact->update([
                'cover_image' => $path
            ]);
        }

        $fact->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'brief_description' => $request->input('brief_description'),
            'category_id' => $request->input('category_id'),
            'references' => $request->input('references')
        ]);

        return $this->sendResponse([
            'fact' => new FactResource($fact)
        ], HttpCodes::ACCEPTED->getHttpStatusCode());
    }

    public function deleteFact(Fact $fact): JsonResponse
    {
        $fact->delete();

        return $this->sendResponse([], HttpCodes::NO_CONTENT->getHttpStatusCode());
    }
}
