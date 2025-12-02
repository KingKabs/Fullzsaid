<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller {

    public function index() {
        $query = Person::where('is_sold', false); // only show available items

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%$search%")
                        ->orWhere('lastName', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('country', 'like', "%$search%");
            });
        }

        $persons = $query->latest()->paginate(20);

        return view('persons.index', compact('persons'));
    }

    public function create() {
        return view('persons.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'emailPass' => 'nullable|string',
            'faUname' => 'nullable|string',
            'faPass' => 'nullable|string',
            'backupCode' => 'nullable|string',
            'securityQa' => 'nullable|string',
            'state' => 'nullable|string',
            'gender' => 'nullable|string|max:10',
            'zip' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'ssn' => 'nullable|string|max:255',
            'cs' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'purchaseDate' => 'nullable|date',
        ]);

        Person::create($data);

        return redirect()->route('persons.index')->with('success', 'Person created successfully.');
    }

    public function show(Person $person) {
        return view('persons.show', compact('person'));
    }

    public function edit(Person $person) {
        return view('persons.edit', compact('person'));
    }

    public function update(Request $request, Person $person) {
        $data = $request->validate([
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'emailPass' => 'nullable|string',
            'faUname' => 'nullable|string',
            'faPass' => 'nullable|string',
            'backupCode' => 'nullable|string',
            'securityQa' => 'nullable|string',
            'state' => 'nullable|string',
            'gender' => 'nullable|string|max:10',
            'zip' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'ssn' => 'nullable|string|max:255',
            'cs' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'purchaseDate' => 'nullable|date',
        ]);

        $person->update($data);

        return redirect()->route('persons.index')->with('success', 'Person updated successfully.');
    }

    public function destroy(Person $person) {
        $person->delete();

        return redirect()->route('persons.index')->with('success', 'Person deleted.');
    }
}
