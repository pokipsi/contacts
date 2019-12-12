<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $group_id = $request->query('group_id');
        $ret = Contact::
            when($group_id, function ($query, $group_id) {
                    return $query->where('group_id', $group_id);
            })->
            orderBy('created_at', 'desc')->
            paginate(20);
        
        return $ret;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|string|max:20',
            'lastName' => 'required|string|max:20',
            'email' => 'required|string|email|max:255'
        ]);

        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone = $request->phone;
        $group_id = $request->group_id;

        $contact = new Contact;
        $contact->firstName = $firstName;
        $contact->lastName = $lastName;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->group_id = $group_id;

        $saved = $contact->save();
        
        return [
            "status" => $saved
        ];
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {

        $this->validate($request, [
            'firstName' => 'required|string|max:20',
            'lastName' => 'required|string|max:20',
            'email' => 'required|string|email|max:255'
        ]);

        $contact->firstName = is_null($request->firstName) ? $contact->firstName : $request->firstName;
        $contact->lastName = is_null($request->lastName) ? $contact->lastName : $request->lastName;
        $contact->email = is_null($request->email) ? $contact->email : $request->email;
        $contact->phone = is_null($request->phone) ? $contact->phone : $request->phone;
        $contact->group_id = is_null($request->group_id) ? $contact->group_id : $request->group_id;
        $saved = $contact->save();
        return [
            "status" => $saved
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $deleted = $contact->delete();
        return [
            "status" => $deleted
        ];
    }
}
