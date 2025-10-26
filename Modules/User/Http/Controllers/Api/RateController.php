<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\Work;
use Modules\User\Entities\Rating;
use Modules\User\Http\Requests\Api\RateRequest;
use Modules\User\Transformers\RatingsResource;

class RateController extends Controller
{
    /**
     * تخزين تقييم جديد
     */
    public function store(RateRequest $request)
    {
        $user = sanctum()->user(); // user added rate

        // المنطق حسب نوع المستخدم
        if ($user->type === 'doctor') {
            // الدكتور يقيّم منتج أو عمل فقط
            if (!$request->product_id && !$request->work_id) {
                return api_response_error(__('user::rate.doctor_must_rate'));
            }
        } elseif ($user->type === 'technician') {
            // الفني يقيّم دكتور فقط
            if (!$request->rated_user_id) {
                return api_response_error(__('user::rate.technician_must_rate'));
            }
            $ratedUser = User::find($request->rated_user_id);
            if (!$ratedUser || $ratedUser->type !== 'doctor') {
                return api_response_error(__('user::rate.technician_only_doctor'));
            }
        } else {
            return api_response_error(__('user::rate.unauthorized_user_type'));
        }

        $rating = Rating::create([
            'user_id'       => $user->id,
            'rated_user_id' => $request->rated_user_id ?? null,
            'product_id'    => $request->product_id ?? null,
            'work_id'       => $request->work_id ?? null,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        return api_response_success($rating);
    }


    public function userRatings(Request $request)
    {
        try {
            // تحقق إن في ID أو مستخدم داخل
            if (!$request->id && !sanctum()->user()) {
                return api_response_error(__('product::work.must_be_logged_in_or_provide_id'));
            }

            $targetUser = $request->id
                ? User::find($request->id)
                : sanctum()->user();

            if (!$targetUser) {
                return api_response_error(__('user::rate.user_not_found'));
            }

            if ($targetUser->type == 'doctor') {
                $ratings = Rating::with(['user:id,name', 'work:id,title', 'product:id,name'])
                    ->where('rated_user_id', $targetUser->id)
                    ->latest()
                    ->paginate(10);
            } elseif ($targetUser->type == 'technician') {
                $workIds = Work::where('technician_id', $targetUser->id)->pluck('id');

                $ratings = Rating::with(['user:id,name', 'work:id,title', 'product:id,name'])
                    ->whereIn('work_id', $workIds)
                    ->latest()
                    ->paginate(10);
            } else {
                $ratings = collect();
            }

            $data = RatingsResource::collection($ratings)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error($th->getMessage());
        }
    }
}
