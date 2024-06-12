<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5000; $i++) {
            $contact = Contact::create(['name' => $faker->name]);

            for ($j = 0; $j < rand(1, 3); $j++) {
                Phone::create(['contact_id' => $contact->id, 'phone_number' => $faker->phoneNumber]);
                Email::create(['contact_id' => $contact->id, 'email' => $faker->email]);
                Address::create([
                    'contact_id' => $contact->id,
                    'address' => $faker->address,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'postal_code' => $faker->postcode,
                ]);
            }
        }
    }
}
