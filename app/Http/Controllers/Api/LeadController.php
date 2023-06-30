<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Lead;
use App\Mail\NewContact;

class LeadController extends Controller
{
    public function store(Request $request){



        // 1. ricevo i dati dal form in post
        $data = $request->all();


        // 2. verifico la validità dei dati
        $validator = Validator::make( $data,
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|min:10',
            ],
            [
                'name.required' => 'Il nome è un campo obbligatorio',
                'name.min' => 'Il nome deve contenere almeno :min caratteri',
                'name.max' => 'Il nome non può avre piò di :max caratteri',
                'email.required' => 'La mail è un campo obbligatorio',
                'email.email' => 'Indirizzo email non corretto',
                'email.max' => 'La mail non può avre più di :max caratteri',
                'message.required' => 'Il messaggio è un campo obbligatorio',
                'message.min' => 'Il messaggio deve contenere almeno :min caratteri',
            ]
        );
        // 3. se non sono validi restituisco un json  con success = false e lista di errori
        if($validator->fails()){
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success','errors'));
        }

        // 4. se sono validi salvo i dati nel db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // 5. invio la mail
        Mail::to('info@boolean.com')->send(new NewContact($new_lead));

        // 6. restituisco un json con success =  true
        $success = true;
        return response()->json(compact('success'));
    }
}
