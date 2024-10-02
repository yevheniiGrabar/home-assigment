<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordStoreRequest;
use App\Http\Requests\RecordUpdateRequest;
use App\Models\Record;
use App\Notifications\RecordCreated;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role_id == '1') {
            $records = Record::where(function($query) use ($user) {
                $query->where('employee_id', $user->id)
                ->orWhereHas('employee', function($subQuery) use ($user) {
                    $subQuery->where('manager_id', $user->id);
                });
            })->paginate(10);
        } else {
            $records = $user->records()->paginate(10);
        }

        return response()->json($records);
    }

    /**
     * @param RecordStoreRequest $request
     * @return JsonResponse
     */
    public function store(RecordStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $record = Record::create([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
        ]);

       Auth::user()->notify(new RecordCreated($record));

        return response()->json($record, 201);
    }

    /**
     * @param RecordUpdateRequest $request
     * @param Record $record
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(RecordUpdateRequest $request, Record $record): JsonResponse
    {
        $this->authorize('update', $record);

        $validated = $request->validated();

        $record->update($validated);

        return response()->json($record);
    }

    /**
     * @param Record $record
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Record $record): JsonResponse
    {
        $this->authorize('delete', $record);
        $record->delete();
        return response()->json(null, 204);
    }
}
