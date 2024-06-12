<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Contact::query()->with(['phones', 'emails', 'addresses']);
 
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm)
                  ->orWhereHas('addresses', function ($q) use ($searchTerm) {
                      $q->where('city', 'like', $searchTerm);
                  })
                  ->orWhereHas('phones', function ($q) use ($searchTerm) {
                      $q->where('phone_number', 'like', $searchTerm);  
                  })
                  ->orWhereHas('emails', function ($q) use ($searchTerm) {
                      $q->where('email', 'like', $searchTerm);
                  });
        }
    
        return $query->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phones' => 'required|array',
            'phones.*' => 'string|max:15',
            'emails' => 'required|array',
            'emails.*' => 'email|max:255',
            'addresses' => 'required|array',
            'addresses.*.address' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.postal_code' => 'required|string|max:10',
        ]);

        $contact = Contact::create(['name' => $validated['name']]);

        foreach ($validated['phones'] as $phone) {
            $contact->phones()->create(['phone_number' => $phone]);
        }

        foreach ($validated['emails'] as $email) {
            $contact->emails()->create(['email' => $email]);
        }

        foreach ($validated['addresses'] as $address) {
            $contact->addresses()->create($address);
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']), 201);
    }

    public function show($id)
    {
        $contact = Contact::with(['phones', 'emails', 'addresses'])->findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phones' => 'required|array',
            'phones.*' => 'string|max:15',
            'emails' => 'required|array',
            'emails.*' => 'email|max:255',
            'addresses' => 'required|array',
            'addresses.*.address' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.postal_code' => 'required|string|max:10',
        ]);

        $contact->update(['name' => $validated['name']]);

        $contact->phones()->delete();
        foreach ($validated['phones'] as $phone) {
            $contact->phones()->create(['phone_number' => $phone]);
        }

        $contact->emails()->delete();
        foreach ($validated['emails'] as $email) {
            $contact->emails()->create(['email' => $email]);
        }

        $contact->addresses()->delete();
        foreach ($validated['addresses'] as $address) {
            $contact->addresses()->create($address);
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']), 200);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
