<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Demouser ;
use Carbon\Carbon;
use App\Mail\UserReport;
use Illuminate\Support\Facades\Mail;
use App\Jobs\EmailSend;


use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('datatables.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($user=Demouser::create([
            'name' => request('name'),
            'email' => request('email'),
            'created_at' => Carbon::now(),
            'password' => bcrypt(request('password')),
        ])) {
            $result['code'] = 200;
            $result['messsage'] = "You are successfully added in HirenDemo App";
            // $user->first_name = request('name');
            
            $result['firstName'] = $user->first_name;

            // $user["massage"]=$result['messsage'];
            //dispatch(new EmailSend($user));
            $user->setSubscribe(30);
            Mail::to($user->email)->queue(new UserReport($user));
        // Mail::to($user)->queue(new UserReport($user));
        } else {
            $result['code'] = 400;
            $result['messsage'] = "Something went wrong while inserting record";
        }
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users=Demouser::find($id);
        return $users;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = [];
        $userdata = [];
        
        if ($user=Demouser::find($id)->update([
                'name' => request('name'),
                'email' => request('email'),
                'updated_at' => Carbon::now(),
            ])) {
            $result['code'] = 200;
            $result['messsage'] = "Your data successfully updated in HirenDemo App";
            $userdata=Demouser::findOrFail($id);
            $userdata["massage"]=$result['messsage'];
            //dispatch(new EmailSend($userdata));
            Mail::to($userdata->email)->queue(new UserReport($userdata));
        //ail::to($user)->queue(new UserReport($userdata));
        } else {
            $result['code'] = 400;
            $result['messsage'] = "Something went wrong while updating record";
        }
       
        
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = [];
        $user=Demouser::find($id);
        $userdata=Demouser::findOrFail($id);
            


        if ($user->delete()) {
            $result['code'] = 200;
            $result['messsage'] = "You are successfully deleted from HirenDemoApp";
            $userdata["massage"]=$result['messsage'];
            //Mail::to($user)->queue(new UserReport($userdata));
            Mail::to($user->email)->queue(new UserReport($user));

        //Mail::to($user)->send(new UserReport($userdata));
        } else {
            $result['code'] = 400;
            $result['messsage'] = "Something went wrong while deleting record";
        }
        return response()->json($result);
    }
    public function displaydata()
    {
        return Datatables::of(Demouser::query())->make(true);
    }
}
