<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\User\Entities\Rating;
use Modules\User\Http\Requests\Api\RateRequest;

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
}
