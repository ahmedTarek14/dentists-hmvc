<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Type;
use Modules\User\Http\Requests\Dashboard\TypeRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $types = Type::latest()->paginate(15);
        return view('user::type.index', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TypeRequest $request)
    {
        try {
            Type::create($request->validated());
            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Type $type)
    {
        return view('user::type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TypeRequest $request, Type $type)
    {
        try {
            $type->update($request->validated());
            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function toggleStatus(Type $type)
    {
        if ($type->status == '1') {
            $type->status = '0';
        } else {
            $type->status = '1';
        }
        $type->save();

        return response()->json(['message' => __('Status updated successfully.')]);
    }
}
