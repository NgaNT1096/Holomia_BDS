<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\History_Account;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\Analytic_user;
use App\Models\Project\Project;
use App\Models\SettingUser;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Cache;
use App\Jobs\CreateSettingVR;
use App\Models\SettingVR;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Emargareten\InertiaModal\Modal;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.SUBADMIN')) || Gate::allows(config('constants.CREATE_USER'))) {
            $users = User::with('roles')->get();
            $roles = Role::get();
            return Inertia::render('Admin/User',compact('users','roles'));
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function show(User $user): Modal
    {
        return Inertia::modal('Users/Show', ['user' => $user])->baseRoute('users.index')->refreshBackdrop();
    }
    public function store(Request $request)
    {
        dd($request);
        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.CREATE_USER')) || Gate::allows(config('constants.SUBADMIN'))) {
            ///admin tạo mới một thằng subadmin hoặc manager_sale
            $this->validate(

                $request,
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|unique:users,phone|max:15',
                    'password' => 'required',
                    'roles' => 'required',
                    'start_date' => 'nullable|date',
                    'end_date'   => 'nullable|date|after:start_date',
                    'number_sale' => 'nullable|numeric|gt:0',
                    'limit_booth' => 'nullable|numeric|gt:0',
                    'setting_start_date' => 'nullable|date',
                    'setting_end_date'   => 'nullable|date|after:setting_start_date',
                    'join_limit'  => 'required|numeric|gt:1',

                ]
            );
            if (Auth::user()->hasRole('administrator')) {
                $user = User::create($request->all());
                // $timezone = new Timezone();
                $user->save();

                // $user->jwt = $this->token($user->name, $user->id);
                $user->created_byId = Auth::user()->id;
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->assignRole($roles);
                $user->verified = 1;
                $user->email_verified_at = Carbon::now();
                $user->save();
                if ($user->hasRole('subadmin') || $user->hasRole('manager_sale')) {
                    $history_acc = new History_Account();
                    $history_acc->start_date = $request->start_date;
                    $history_acc->end_date = $request->end_date;
                    $history_acc->number_sale = $request->number_sale;
                    $history_acc->time_bought = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;
                    $history_acc->user_id = $user->id;
                    $history_acc->number_sale_present = 0;
                    $history_acc->save();
                } elseif ($user->hasRole('create_booth') || $user->hasRole('manager_event')) {
                    SettingUser::create([
                        'limit_booth' => $request->limit_booth,
                        'start_date' => $request->setting_start_date,
                        'end_date' => $request->setting_end_date,
                        'user_id' => $user->id
                    ]);
                }
            } elseif (Auth::user()->hasRole('subadmin') || Auth::user()->hasRole('manager_sale')) {
                $limit =  History_Account::where('user_id', Auth::user()->id)->latest()->first()->number_sale_present;
                $number_sale = History_Account::where('user_id', Auth::user()->id)->latest()->first();



                if ($number_sale->number_sale > $limit) {
                    // $user = User::create($request->all());
                    // $user->created_byId = Auth::user()->id;
                    // $roles = $request->input('roles') ? $request->input('roles') : [];
                    // $user->assignRole($roles);


                    $user = $this->create_new_user($request);

                    if ($user->hasRole('manager_sale')) {
                        $history_acc = new History_Account();
                        $history_acc->start_date = $number_sale->start_date;
                        $history_acc->end_date = $number_sale->end_date;
                        if (($limit + 1 + $request->number_sale) > $number_sale->number_sale) {
                            // $history_acc->user_id = $user->id;
                            $user->delete();
                            return redirect()->back()->with('warning', 'Số tài khoản muốn gán cho manager vượt quá giới hạn của subadmin  ,Bạn đã sử dụng ' . $number_sale->number_sale_present);
                        } else {
                            // $user->jwt =   $this->token($user->name, $user->id);
                            $user->email_verified_at = Carbon::now();
                            $user->save();
                            $history_acc = $user->create_history_acc($number_sale->start_date, $number_sale->end_date, $request->number_sale);
                            $number_sale->number_sale_present = $limit + 1 + $history_acc->number_sale;
                            $number_sale->save();
                            return redirect()->back()->with('success', 'Update role successfully');
                        }
                    } else {
                        $number_sale->number_sale_present = $limit + 1;
                        $number_sale->save();
                        // $user->jwt =   $this->token($user->name, $user->id);
                        $user->email_verified_at = Carbon::now();
                        $user->save();
                    }
                } else {
                    return redirect()->back()->with('warning', 'Giới hạn khi tạo tài khoản');
                }
            } else {
                $user = User::create($request->all());
                $user->created_byId = Auth::user()->id;
                $roles = $request->input('roles') ? $request->input('roles') : [];
                $user->assignRole($roles);
                $user->email_verified_at = Carbon::now();
                // $user->jwt =   $this->token($user->name, $user->id);
                $user->save();
            }

            return redirect()->back()->with('success', "Tạo mới thành công ");
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function create_new_user($request)
    {
        $user = User::create($request->all());
        $user->created_byId = Auth::user()->id;
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
        $user->save();
        return $user;
    }

    public function update(Request $request, $id)
    {

        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.CREATE_USER')) || Gate::allows(config('constants.SUBADMIN'))) {
            $user = User::findOrFail($id);

            $this->validate(
                $request,
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'roles' => 'required',
                    'join_limit'  => 'nullable|numeric|gt:1',

                ]
            );
            $user->update($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);
            $user->email_verified_at = Carbon::now();
            $user->save();

            return redirect()->back()->with('success', "Update tài khoản  thành công");
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }


    public function updateSettingVR($user){
        if($user->setting_vr ==null){
            $setting_vr = new SettingVR();
            $setting_vr->big_screen = true;
            $setting_vr->model_3d = true;
            $setting_vr->vr_portal = true;
            $setting_vr->manage = true;
            $setting_vr->tools = true;
            $setting_vr->space = true;
            $setting_vr->screen = true;
            $setting_vr->metatour = true;
            $setting_vr->creator = true;
            $setting_vr->background_music = true;
            $setting_vr->group_teleport = true;
            $setting_vr->talk = true;
            $setting_vr->user_id = $user->id;
            $setting_vr->save();
        }
    }
    public function destroy($id)
    {
        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.CREATE_USER')) || Gate::allows(config('constants.SUBADMIN'))) {

            $user = User::findOrFail($id);
            $history = History_Account::where('user_id', $user->created_byId)->latest()->first();


            $manager = History_Account::where('user_id', $user->id)->latest()->first();


            if ($history != null) {
                if ($user->hasRole('manager_sale') || $user->hasRole('subadmin') || $user->hasRole('administrator')) {

                    if ($manager != null && $manager->number_sale_present > 0) {

                        $history->number_sale_present = $history->number_sale_present - 1;
                    }

                    $entries = User::where('created_byId', $user->id)->get();
                    $user->delete();
                    if (count($entries) > 0) {
                        foreach ($entries as $entry) {
                            $entry->created_byId = $user->created_byId;
                            $entry->save();
                        }
                        $history->number_sale_present = $history->number_sale_present - 1;
                        $history->save();
                    } else {

                        $history->number_sale_present = $history->number_sale_present - $manager->number_sale - 1;
                        $history->save();
                    }
                } else {
                    $user->delete();
                    $history->number_sale_present = $history->number_sale_present - 1;
                    $history->save();
                }
            } else {
                $user->delete();
            }

            return redirect()->back()->with('success', "Xóa tài khoản  thành công");
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function import(Request $request)
    {
        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.SUBADMIN')) || Gate::allows(config('constants.MANAGER_SALE'))) {
            $user = Auth::user();
            if ($user->hasRole('administrator')) {
                $this->validate($request, [
                    'projects' => 'required',
                    'managers' => 'required',
                    'user_file' => 'required|mimes:xlsx,csv,xls'
                ]);
            } else {
                $this->validate($request, [
                    'projects' => 'required',
                    'user_file' => 'required|mimes:xlsx,csv,xls'
                ]);
            }
            Excel::import(new UsersImport, request()->file('user_file'));
            File::deleteDirectory('/storage/framework/laravel-excel/*');
            return redirect()->back()->with('success', 'Import thành công');
        }
        return view('errors.404');
    }
    public function addAnalyticCode(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $user = User::findOrFail($id);
        } else {
            //sale
            $user = Auth::user();
        }

        if ($user && $request->code != null) {

            if ($user->analytic_user == null) {
                $new_code = new Analytic_user;
                $new_code->tracking_code = $request->code;
                $new_code->user_id = $user->id;
                $new_code->save();
            } else {

                $user->analytic_user->tracking_code = $request->code;
                $user->analytic_user->save();
            }
        }
        return back();
    }

    public function language(Request $request)
    {
        if (Gate::allows(config('constants.USER_PERMISSION')) || Gate::allows(config('constants.SUBADMIN')) || Gate::allows(config('constants.MANAGER_SALE'))) {
            // $import =Excel::import( new ImportLanguage( ), request()->file('language'));
            $this->validate($request, [
                'language' => 'required',
                'language_file' => 'required|mimes:xlsx,csv,xls'
            ]);


            $path = $request->file('language_file');

            if ($request->file('language_file') != null) {
                $collection = (new FastExcel)->import($path);
                $data =  $collection[0];
                $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE);

                $name_language = $request->language;

                file_put_contents(base_path('resources/lang/vuejs/' . $name_language . '.json'), stripslashes($newJsonString));
                File::deleteDirectory('/storage/framework/laravel-excel/*');
                return redirect()->back()->with('success', 'Import thành công');
            } else {
                return redirect()->back()->with('warning', 'Import Không Thành Công');
            }
        }
        return view('errors.404');
    }

    public function verifyEmail(Request $request){
        $user = User::findOrFail($request->id);
        if($request->verified ==0){
            $user->email_verified_at =null;
            $user->save();

        }
        else{
            $user->email_verified_at =Carbon::now();
            $user->save();
        }
        return response()->json('Change successfully', Response::HTTP_OK);

    }
}
