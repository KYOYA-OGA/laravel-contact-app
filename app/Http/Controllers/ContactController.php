<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $contacts = $user
            ->contacts()
            ->latestFirst()
            ->paginate(10);
        $companies = $user
            ->companies()
            ->orderBy("name")
            ->pluck("name", "id")
            ->prepend("All Companies", "");

        return view("contacts.index", compact("contacts", "companies"));
    }

    public function create()
    {
        $contact = new Contact();
        $companies = auth()
            ->user()
            ->companies()
            ->orderBy("name")
            ->pluck("name", "id")
            ->prepend("All Companies", "");

        return view("contacts.create", compact("companies", "contact"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "address" => "required",
            "company_id" => "required|exists:companies,id",
        ]);

        $request
            ->user()
            ->contacts()
            ->create($request->all());

        return redirect()
            ->route("contacts.index")
            ->with("message", "Contact created successfully");
    }

    public function show($id)
    {
        $contact = $this->findContact($id);
        return view("contacts.show", compact("contact"));
    }

    protected function findContact($id)
    {
        return Contact::findOrFail($id);
    }

    public function edit($id)
    {
        $companies = auth()
            ->user()
            ->companies()
            ->orderBy("name")
            ->pluck("name", "id")
            ->prepend("All Companies", "");
        $contact = Contact::findOrFail($id);
        return view("contacts.edit", compact("contact", "companies"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "address" => "required",
            "company_id" => "required|exists:companies,id",
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()
            ->route("contacts.index")
            ->with("message", "Contact updated successfully");
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with("message", "Contact deleted successfully");
    }
}