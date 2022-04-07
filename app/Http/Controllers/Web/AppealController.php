<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppealFormRequest;
use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;

class AppealController extends Controller
{
    public function show()
    {
        return view('appeal', ['success' => session('success', false)]);
    }

    public function send(AppealFormRequest $request)
    {
        $data = $request->only(['name', 'email', 'message']);
        $data['phone'] = PhoneSanitizer::sanitize($request->input('phone'));
        Appeal::create($data);

        return redirect(route('appeal.show'))->with(['success' => true]);
    }
}
