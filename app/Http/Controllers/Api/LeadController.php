<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Admin\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->all();

        //? VALIDAZIONE
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        //? VALIDAZIONE NON ANDATA A BUON FINE
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors()
                ]
            );
        }

        //? SALVATAGGIO DATI NEL DB
        // $new_lead = new Lead();
        // $new_lead->fill($data);
        // $new_lead->save();

        $new_lead = Lead::create($data);

        //? INVIO DELLE MAIL
        Mail::to('info@boolfolio.it')->send(new NewContact($new_lead));

        //? OTTENERE UNA RISPOSTA POSITIVA IN JSON
        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
