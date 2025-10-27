<?php

namespace Modules\Product\Http\Controllers\Api;

use App\Traits\ImageTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Work;
use Modules\Product\Http\Requests\Api\WorkRequest;
use Modules\Product\Transformers\WorkResource;

class WorkController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $works = Work::with(['technician:id,name,phone,type_id', 'technician.typeRelation'])
                ->withAvg('ratings', 'rating')
                ->when($request->has('type'), function ($query) use ($request) {
                    $query->whereHas('technician', function ($q) use ($request) {
                        $q->where('type_id', $request->type);
                    });
                })
                ->orderByDesc('ratings_avg_rating')
                ->orderByDesc('id')
                ->paginate(10);

            $data = WorkResource::collection($works)->response()->getData(true);

            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(WorkRequest $request)
    {
        try {
            $data = $request->validated();

            // technician_id من Sanctum user
            $data['technician_id'] = sanctum()->id();


            $data['image'] = $request->hasFile('image') ? $this->image_manipulate($request->image, 'works') : null;


            Work::create($data);

            return api_response_success(__('product::work.Data_has_been_added_successfully'));
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return api_response_error();
        }
    }


    public function myWorks(Request $request)
    {
        try {
            // لو مفيش لا id ولا لوجن → Error
            if (!$request->id && !sanctum()) {
                return api_response_error(__('product::work.must_be_logged_in_or_provide_id'));
            }

            // لو في id في الريكوست هنشتغل عليه
            $technicianId = $request->id ?? sanctum()->id();


            $works = Work::with(['ratings', 'technician.typeRelation'])->withAvg('ratings', 'rating')
                ->where('technician_id', $technicianId)
                ->orderByDesc('id')
                ->paginate(10);

            $data = WorkResource::collection($works)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
