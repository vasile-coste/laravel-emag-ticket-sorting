<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var User
     */
    private User $user;

    /**
     * @var AjaxResponse
     */
    private AjaxResponse $ajaxResponse;

    /**
     * @param User $user
     * @param AjaxResponse $ajaxResponse
     */
    public function __construct(User $user, AjaxResponse $ajaxResponse)
    {
        $this->user = $user;
        $this->ajaxResponse = $ajaxResponse;
    }

    /**
     * @param Request $request
     * 
     * @return string
     */
    public function login(Request $request): string
    {
        // validate the info, create rules for the inputs
        $rules = [
            'username'    => 'required', 
            'password' => 'required|min:3' // password has to be greater than 3 characters
        ];

        $data = $request->only('username', 'password');

        $validator = Validator::make($data,  $rules);

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());

        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($this->getValidatorMsg($errors))
                ->toJson();
        }

        $checkUser = $this->user->checkUser($data['username'], $data['password']);

        if ($checkUser) {
            $request->session()->put('data', $this->user->getResult()); //session(['key' => 'value']); // Via the global helper...

            return $this->ajaxResponse
                ->setLocation('/home')
                ->setData([$this->user->getResult()])
                ->setSuccess(true)
                ->setMessage("User logged succesfully!")
                ->toJson();
        }

        return $this->ajaxResponse
            ->setMessage("Email or password are not valid!")
            ->toJson();
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function register(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = [
            'username'    => 'required',
            'email'    => 'required|email',
            'password1' => 'required|min:3',
            'password2' => 'required|min:3',
        ];

        $data = $request->only('username', 'email', 'password1', 'password2', 'website', 'phone');

        $validator = Validator::make($data,  $rules);
        if ($data['password1'] != $data['password2']) {
            $validator->errors()->add('passwords', "Passwords don't match!");
        }

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());
        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($errors)
                ->toJson();
        }

        $addUser = $this->user->addUser($data['username'], $data['email'], $data['password1'], $data['phone'] ? $data['phone'] : '', $data['website'] ? $data['website'] : '');
        if ($addUser) {
            return $this->ajaxResponse
                ->setMessage("Registration succesfully")
                ->setSuccess(true)
                ->toJson();
        }

        return $this->ajaxResponse
            ->setMessage($this->user->getResult())
            ->toJson();
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function updateProfile(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = [
            'id' => 'required',
            'website' => 'required',
            'phone' => 'required'
        ];

        $data = $request->only('id', 'website', 'phone');

        $validator = Validator::make($data,  $rules);

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());
        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($errors)
                ->toJson();
        }

        $updateProfile = $this->user->updateProfile($data['id'], $data['website'], $data['phone']);

        if($updateProfile){
            $request->session()->put('data', $this->user->getResult());

            return $this->ajaxResponse
            ->setLocation('/profile')
            ->setData([$this->user->getResult()])
            ->setSuccess(true)
            ->setMessage("Profile updated succesfully!")
            ->toJson();
        }

        return $this->ajaxResponse
            ->setMessage($this->user->getResult())
            ->toJson();
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function updatePassword(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = [
            'id' => 'required',
            'old' => 'required',
            'password1' => 'required|min:3',
            'password2' => 'required|min:3'
        ];

        $data = $request->only('id', 'old', 'password1', 'password2');

        $validator = Validator::make($data,  $rules);
        if ($data['password1'] != $data['password2']) {
            $validator->errors()->add('passwords', "Passwords don't match!");
        }

        $errors = $this->getValidatorMsg($validator->errors()->getMessages());
        if (count($errors) > 0) {
            return $this->ajaxResponse
                ->setMessages($errors)
                ->toJson();
        }

        $updatePassword = $this->user->updatePassword($data['id'], $data['old'], $data['password1']);

        if($updatePassword){
            $request->session()->put('data', $this->user->getResult());
            
            return $this->ajaxResponse
            ->setLocation('/profile')
            ->setData([$this->user->getResult()])
            ->setSuccess(true)
            ->setMessage("Password updated succesfully!")
            ->toJson();
        }

        return $this->ajaxResponse
            ->setMessage($this->user->getResult())
            ->toJson();
    }

    /**
     * @return void
     */
    public function logout()
    {
        session()->forget('data');
        return redirect('/');
    }

    /**
     * @param array $msgs
     * 
     * @return array
     */
    private function getValidatorMsg(array $msgs): array
    {
        $result = [];
        foreach ($msgs as $msg) {
            $result[] = implode("\n", $msg);
        }

        return $result;
    }
}
