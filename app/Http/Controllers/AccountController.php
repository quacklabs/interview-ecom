<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use App\Models\BankInfo;
use App\Models\WalletInfo;

class AccountController extends Controller
{
    //
    public function wallet_balance(Request $request) {
        $user = $this->GetAuthUser();
        if($user != NULL) {
            return $this->success($user->wallet);
        }
    }

    public function update_password(Request $request) {
        $form = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required']
        ]);

        if($form->fails()) {
            return $this->failed($form->getMessageBag()->first());
        }
        $user = $this->GetAuthUser();
        if($user != NULL) {
            $valid = $form->validated();
            if(Hash::check($valid['old_password'], $user->password)) {
                $user->forceFill([
                    'password' => $valid['new_password']
                ]);
                $user->save();
                return $this->success(true);
            }
            return $this->failed('Invalid Password provided');
        } else {
            return $this->failed('Unable to validate user');
        }
    }

    public function get_profile(Request $request) {
        $user = $this->GetAuthUser();
        if($user != NULL) {
            $data = [
                'username' => $user->username,
                'email' => $user->email,// string
                'fullname' => $user->profile->fullname, // string
                'dob' => Carbon::parse($user->profile->dob)->toDateString(),
                'phone' => $user->profile->phone,
                'zip' => $user->profile->zip,
                'country' => $user->profile->country //: string
            ];
            return $this->success($data);
        } 

        return $this->failed('Unable to validate user');
    }

    public function update_profile(Request $request) {
        $form = Validator::make($request->all(), [
            'email' =>['required', 'email'],
            'fullname' => ['required'],
            'dob' => ['required'],
            'phone' => ['required'],
            'zip' => ['required'],
            'country' => ['required']
        ]);
        if($form->fails()) {
            return $this->failed($form->getMessageBag()->first());
        }
        $user = $this->GetAuthUser();
        $valid = $form->validated();
        if($user->email != $valid['email']) {
            $check = User::where('email', $valid['email'])->first();
            if($check != null) {
                return $this->failed('Email already exists');
            }

            if($user->username != $valid['username']) {
                $checks = User::where('username', $valid['username'])->first();
                if($checks != null) {
                    return $this->failed('Username already exists');
                }
            }
            Profile::updateOrCreate(['user_id' => $user->id],[
                'fullname' => $valid['fullname'],
                'dob' => Carbon::parse($valid['dob'])->toDateString(),
                'phone' => $valid['phone'],
                'zip' => $valid['zip'],
                'country' => $valid['country']
            ]);
            return $this->success('Profile updated successfully');
        }
    }

  
}
