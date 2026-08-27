<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user && $user->is_logged_in == true){
            return redirect()->back();
        }else{
            return view('auth.index');
        }
        
    }

     /**
     * Show the form for creating a new resource.
     */

    public function loginuser(Request $request)
    {
        // Validate login inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Handle the case when the user is not found
            return redirect()->back()->with('error', 'This user not found.');
        }

        $diffranceinmin = $user->updated_at->diffInMinutes(now(), false);

        if($diffranceinmin > 1){

            $userId = $user->id;
            $currentSessionId = Session::getId();

            DB::table('sessions')
                ->where('user_id', $userId)
                ->where('id', '!=', $currentSessionId)
                ->delete();

            $user->is_logged_in = false;
            $user->save();

        }else{

            if ($user && $user->is_logged_in == true) {
                return redirect()->back()->with('error', 'This user is already logged in.');
            }
        }

        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {

            Auth::logoutOtherDevices($request->password);
                // Update user login status to true
                $user->is_logged_in = true;
                $user->save();

                $username = Auth::user()->name;
                $subject = "User login the CRM Portal, username:-".$username;
                addToLog($customerId ='', $id ='', $subject, $oldData ='', $newData ='');

                $role_id = Auth::user()->role_id;

                if(in_array($role_id, [7, 8, 9,24])){
                    return redirect()->intended('account/accounting');
                }else if(in_array($role_id, [4, 5, 6])){
                    return redirect()->intended('account/vendor-system');
                }else if(in_array($role_id, [10, 11, 12])){
                    return redirect()->intended('account/compliance');
                }else if(in_array($role_id, [19, 20, 21])){
                    return redirect()->intended('broker/load'); 
                }else if(in_array($role_id, [1, 2, 3, 22])){
                    return redirect()->intended('admin/admin_home'); 
                }else if(in_array($role_id, [13, 14, 15])){
                    return redirect()->intended('account/reporting'); 
                }else if(in_array($role_id, [16, 17, 18])){
                    return redirect()->intended('account/reporting'); 
                }
            
                // Store the user's session
                //return redirect()->route('home');
                return redirect()->intended('home');
            }else{
                return redirect()->back()->with('error', "Invalid credentials. or user isn't active");
            }
        
        
    }

    public function logout()
    {
        // Get the current user
        $user = Auth::user();

        // Set the user's login status to false
        $user->is_logged_in = false;
        $user->save();

        $username = Auth::user()->name;
        $subject = "User logout the CRM Portal, username:-".$username;
        addToLog($customerId ='', $id ='', $subject, $oldData ='', $newData ='');

        // Log out the user
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
