<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();


        return view('admin.member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'ms_name'=>['required'],
            'ms_email'=>['required'],
            'ms_password'=>['required'],
            'ms_phone_number'=>['required'],
            'ms_address'=>['required']]);

        Member::create($request->all());

        return redirect('members')->with('success', 'Member Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        // return $member;
        return view('admin.member.edit',compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {

        $this->validate($request,[
            'ms_name'=>['required'],
            'ms_email'=>['required'],
            'ms_password'=>['required'],
            'ms_phone_number'=>['required'],
            'ms_address'=>['required']]);

        $member->update($request->all());
        return redirect('/members')->with('success', 'Member Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect('/members')->with('success', 'Member Deleted Successfully');
    }
}
