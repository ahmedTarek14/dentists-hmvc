<?php

namespace Modules\Product\Http\Controllers\Dashboard;

use App\Traits\ImageTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Work;
use Modules\Product\Http\Requests\Api\WorkRequest;

class WorkController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $works = Work::latest()->paginate(15);
        return view("product::work.index", compact("works"));
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Work $work)
    {
        return view('product::work.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(WorkRequest $request, Work $work)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $this->image_delete($work->image, 'works');
                $data['image'] = $this->image_manipulate($request->image, 'works');
            }

            $work->update($data);
            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function destroy(Work $work)
    {
        try {
            $this->image_delete($work->image, 'works');
            $work->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return error_response();
        }
    }
}
