<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\Commeninfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function getBranchesByCompany(Request $request)
    {
        $company_id = $request->input('company_id');

        if (empty($company_id) || !is_numeric($company_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid company ID'
            ], 400);
        }

        $branches = CompanyBranch::where('tbl_company_idtbl_company', intval($company_id))
            ->active()
            ->orderBy('branch', 'asc')
            ->get(['idtbl_company_branch', 'branch', 'code']);

        return response()->json([
            'status' => 'success',
            'branches' => $branches
        ]);
    }

    public function LoginUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $plainPassword = $request->input('password');

        $user = User::active()->where('username', $username)->first();

        if (!$user) {
            Session::flash('msg', 'Invalid Username or password');
            return redirect('/');
        }

        $authenticated = false;

        $stored = $user->password;

        // Detect common modern hash prefixes to avoid passing unsupported hashes to Hash::check
        $isBcrypt = str_starts_with($stored, '$2y$') || str_starts_with($stored, '$2a$') || str_starts_with($stored, '$2b$');
        $isArgon = str_starts_with($stored, '$argon2');

        if ($isBcrypt || $isArgon) {
            if (Hash::check($plainPassword, $stored)) {
                $authenticated = true;
            }
        } else {
            // Legacy fallback: compare MD5 or plain (depending on old storage).
            if ($stored === md5($plainPassword)) {
                $authenticated = true;
                // Rehash to bcrypt for improved security
                $user->password = Hash::make($plainPassword);
                $user->save();
            }
        }

        if (!$authenticated) {
            Session::flash('msg', 'Invalid Username or password');
            return redirect('/');
        }

<<<<<<< HEAD
<<<<<<< Updated upstream
=======
        $company_id = null;
        $branch_id = null;

>>>>>>> Stashed changes
=======
        $company_id = null;
        $branch_id = null;

>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
        Session::put('userid', $user->idtbl_user);
        Session::put('name', $user->name);
        Session::put('username', $user->username);
        Session::put('type', $user->tbl_user_type_idtbl_user_type);
        Session::put('typename', optional($user->type)->usertype);
        Session::put('company_id', $company_id);
        Session::put('company_name', null);
        Session::put('company_code', null);
        Session::put('branch_id', $branch_id);
        Session::put('branch_name', null);
        Session::put('branch_code', null);
        Session::put('loggedin', true);

        LoginLog::create([
            'tbl_user_idtbl_user' => $user->idtbl_user,
            'login_datetime' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect('Welcome/Dashboard');
    }

    public function Logout(Request $request)
    {
        $user_id = Session::get('userid');
        $company_id = Session::get('company_id');
        $branch_id = Session::get('branch_id');

        if ($user_id) {
            $lastLog = LoginLog::where('tbl_user_idtbl_user', $user_id)
                ->where('tbl_company_idtbl_company', $company_id)
                ->where('tbl_company_branch_idtbl_company_branch', $branch_id)
                ->whereNull('logout_datetime')
                ->orderBy('login_datetime', 'desc')
                ->first();

            if ($lastLog) {
                $lastLog->logout_datetime = now();
                $lastLog->save();
            }
        }

        Session::forget([
            'userid', 'name', 'username', 'type', 'typename',
            'company_id', 'company_name', 'company_code',
            'branch_id', 'branch_name', 'branch_code', 'loggedin',
        ]);

        return redirect('/');
    }

    public function Dashboard()
    {
        if (!Session::get('loggedin')) {
            return redirect('/');
        }

        $menuaccess = (new Commeninfo())->Getmenuprivilege();

        $company_info = [
            'company_name' => Session::get('company_name'),
            'company_code' => Session::get('company_code'),
            'branch_name' => Session::get('branch_name'),
            'branch_code' => Session::get('branch_code'),
        ];

        return view('dashboard', compact('menuaccess', 'company_info'));
    }
}
