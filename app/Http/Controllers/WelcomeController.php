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

class WelcomeController extends Controller
{
    public function index()
    {
        $companies = Company::active()->orderBy('company', 'asc')->get();
        return view('login', compact('companies'));
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
            'company' => 'required|integer|exists:tbl_company,idtbl_company',
            'branch' => 'required|integer|exists:tbl_company_branch,idtbl_company_branch',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $company_id = $request->input('company');
        $branch_id = $request->input('branch');
        $username = $request->input('username');
        $password = md5($request->input('password'));

        $user = User::active()
            ->where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$user) {
            Session::flash('msg', 'Invalid Username or password');
            return redirect('/');
        }

        $company = Company::active()->find($company_id);
        $branch = CompanyBranch::active()->find($branch_id);

        if (!$company || !$branch || $branch->tbl_company_idtbl_company != $company_id) {
            Session::flash('msg', 'Invalid company or branch selection');
            return redirect('/');
        }

        Session::put('userid', $user->idtbl_user);
        Session::put('name', $user->name);
        Session::put('username', $user->username);
        Session::put('type', $user->tbl_user_type_idtbl_user_type);
        Session::put('typename', optional($user->type)->usertype);
        Session::put('company_id', $company_id);
        Session::put('company_name', $company->company);
        Session::put('company_code', $company->code);
        Session::put('branch_id', $branch_id);
        Session::put('branch_name', $branch->branch);
        Session::put('branch_code', $branch->code);
        Session::put('loggedin', true);

        LoginLog::create([
            'tbl_user_idtbl_user' => $user->idtbl_user,
            'tbl_company_idtbl_company' => $company_id,
            'tbl_company_branch_idtbl_company_branch' => $branch_id,
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
