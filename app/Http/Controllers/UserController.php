<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationMagicNumber;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Http\Controllers\VoyagerUserController;

class UserController extends VoyagerUserController
{
    public function changeLeader(User $user)
    {
        $user->leader = $user->leader?ApplicationMagicNumber::zero:ApplicationMagicNumber::one;
        $user->save();
        return back()->with([
            'message' => "Muvafaqiyatli o'zgartirildi!"
        ]);
    }
    public function changeStatus(User $user)
    {
        $user->status = $user->status?ApplicationMagicNumber::zero:ApplicationMagicNumber::one;
        $user->save();
        return back()->with([
            'message' => "Muvafaqiyatli o'zgartirildi!"
        ]);
    }
    public function update(Request $request, $id)
    {
        parent::update($request, $id); // TODO: Change the autogenerated stub
        return redirect()->back();
    }
}
