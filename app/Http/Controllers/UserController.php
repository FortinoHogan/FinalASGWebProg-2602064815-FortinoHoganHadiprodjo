<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FieldOfWork;
use App\Models\Profession;
use App\Models\User;
use App\Models\UserField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        session()->forget('register_data');

        $searchQuery = request('search');
        $genderFilters = request('gender', []);
        $fieldFilters = request('field', []);
        $usersQuery = User::query();

        if (Auth::check()) {
            $usersQuery->where('id', '!=', Auth::user()->id);
        }

        if ($searchQuery) {
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('gender', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('profession', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('userFields', function ($query) use ($searchQuery) {
                        $query->whereHas('fieldOfWork', function ($query) use ($searchQuery) {
                            $query->where('name', 'like', '%' . $searchQuery . '%');
                        });
                    });
            });
        }

        if (!empty($genderFilters)) {
            $usersQuery->whereIn('gender', $genderFilters);
        }

        if (!empty($fieldFilters)) {
            $usersQuery->whereHas('userFields', function ($query) use ($fieldFilters) {
                $query->whereHas('fieldOfWork', function ($query) use ($fieldFilters) {
                    $query->whereIn('name', $fieldFilters);
                });
            });
        }

        $users = $usersQuery->paginate(8)->appends([
            'search' => $searchQuery,
            'gender' => $genderFilters,
            'field' => $fieldFilters,
        ]);

        $fields = FieldOfWork::get();

        return view('pages.home', compact('users', 'fields'));
    }

    public function login()
    {
        session()->forget('register_data');

        return view('pages.login');
    }

    public function register()
    {
        session()->forget('register_data');

        $fields = FieldOfWork::get();
        $professions = Profession::get();

        return view('pages.register', compact('fields', 'professions'));
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => __('lang.email_required'),
            'email.email' => __('lang.email_email'),
            'password.required' => __('lang.password_required'),
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user);
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('error', __('lang.login_failed'));
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'gender' => 'required',
            'fields' => 'required|array|min:3',
            'profession' => 'required',
            'linkedin' => 'required',
            'phone_number' => 'required|numeric',
            'experience' => 'required',
            'password' => 'required',
        ], [
            'email.required' => __('lang.email_required'),
            'email.unique' => __('lang.email_unique'),
            'email.email' => __('lang.email_email'),
            'name.required' => __('lang.name_required'),
            'gender.required' => __('lang.gender_required'),
            'fields.required' => __('lang.fields_required'),
            'fields.min' => __('lang.fields_min'),
            'profession.required' => __('lang.profession_required'),
            'linkedin.required' => __('lang.linkedin_required'),
            'phone_number.required' => __('lang.phone_number_required'),
            'phone_number.numeric' => __('lang.phone_number_numeric'),
            'experience.required' => __('lang.experience_required'),
            'password.required' => __('lang.password_required'),
        ]);

        session()->put('register_data', $request->all());

        return redirect()->route('payment');
    }

    public function payment()
    {
        if (!session()->has('register_data')) {
            abort(404);
        }
        $price = session('register_data')['price'];

        return view('pages.payment', compact('price'));
    }

    public function payment_post(Request $request)
    {
        if ($request->payment < $request->price) {
            return redirect()->route('payment')->with('error', __('lang.underpaid_message', ['amount' => $request->price - $request->payment]));
        } else if ($request->payment > $request->price) {
            return redirect()->route('payment')->with([
                'overpaid' => true,
                'amount' => $request->payment - $request->price,
                'price' => $request->price
            ]);
        } else {
            $user = User::create([
                'name' => session('register_data')['name'],
                'email' => session('register_data')['email'],
                'password' => Hash::make(session('register_data')['password']),
                'gender' => session('register_data')['gender'],
                'profession_id' => session('register_data')['profession'],
                'linkedin_username' => session('register_data')['linkedin'],
                'phone_number' => session('register_data')['phone_number'],
                'experience' => session('register_data')['experience'],
            ]);

            foreach (session('register_data')['fields'] as $field) {
                UserField::create([
                    'user_id' => $user->id,
                    'field_of_work_id' => $field,
                ]);
            }

            Auth::login($user);
            return redirect()->route('home');
        }
    }

    public function overpaid(Request $request)
    {
        $user = User::create([
            'name' => session('register_data')['name'],
            'email' => session('register_data')['email'],
            'password' => Hash::make(session('register_data')['password']),
            'gender' => session('register_data')['gender'],
            'profession_id' => session('register_data')['profession'],
            'linkedin_username' => session('register_data')['linkedin'],
            'phone_number' => session('register_data')['phone_number'],
            'experience' => session('register_data')['experience'],
            'coins' => 100 + $request->amount
        ]);

        foreach (session('register_data')['fields'] as $field) {
            UserField::create([
                'user_id' => $user->id,
                'field_of_work_id' => $field,
            ]);
        }

        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }
}
