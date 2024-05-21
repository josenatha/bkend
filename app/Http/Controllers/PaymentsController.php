<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    protected $rules;
    protected $errorMessages;

    public function __construct()
    {
        $this->rules = [
            'amount' => 'required|regex:/^\d{1,6}(\.\d{1,2})?$/',
            'date' => 'required|string',
            'photo' => 'required|string',
            'note' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            'verified' => 'required|boolean',
        ];

        $this->errorMessages = [
            'amount.required' => 'The amount field is required.',
            'amount.regex' => 'The amount format is invalid. It must be a decimal number with up to 6 digits before the decimal point and up to 2 digits after the decimal point.',
            'date.required' => 'The payment date field is required.',
            'date.string' => 'The payment date must be a string.',
            'photo.required' => 'The photo field is required.',
            'photo.string' => 'The photo must be a string.',
            'note.string' => 'The note must be a string.',
            'student_id.required' => 'The student ID field is required.',
            'student_id.exists' => 'The selected student ID is invalid.',
            'verified.required' => 'The verified field is required.',
            'verified.boolean' => 'The verified field must be a boolean value.',
        ];
    }
        
        public function index()
        {
            $payments = Payment::with('student.user')->get();
            
            return response()->json($payments);
        }

        public function show($id)
        {
            $payment = Payment::with('student.user')->findOrFail($id);
            
            return response()->json($payment);
        }


        public function store(Request $request)
        {
            $payment_id = Uuid::uuid4()->toString();
            $request->merge(['id' => $payment_id]);

            $validator = Validator::make($request->all(), $this->rules, $this->errorMessages);   

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $payment = Payment::create($request->all());
            
            return response()->json(['message' => 'Payment created successfully.', 'payment' => $payment], 201);
        }

        public function update(Request $request, $id)
        {
            $payment = Payment::findOrFail($id);
            
            $validator = Validator::make($request->all(), $this->rules, $this->errorMessages);


            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $payment->update($request->all());
            
            return response()->json(['message' => 'Payment updated successfully.', 'payment' => $payment], 200);
        }

        public function destroy($id)
        {
            $payment = Payment::findOrFail($id);
            
            $payment->delete();
            
            return response()->json(['message' => 'Payment deleted successfully.'], 204);
        }
    }
