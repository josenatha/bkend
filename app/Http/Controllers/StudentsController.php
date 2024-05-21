<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    protected $rules;
    protected $errorMessages;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|regex:/^(?!.*\s{2})[a-zA-Z]{3,}(?: [a-zA-Z]{3,})*$/',
            'first_surname' => 'required|string|regex:/^(?!.*\s{2})[a-zA-Z]{3,}(?: [a-zA-Z]{3,})*$/',
            'second_surname' => 'required|string|regex:/^(?!.*\s{2})[a-zA-Z]{3,}(?: [a-zA-Z]{3,})*$/',
            'date_of_birth' => 'required|date|before_or_equal:2020-01-01',
            'gender' => 'required|string|in:M,F,U',
            'curp' => 'required|string|max:18|regex:/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z\d][\dA]$/',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'photo' => 'nullable|string',
            'birth_certificate' => 'nullable|string',
            'grade' => 'required|string|in:Pre-Kinder,1st Grade,2nd Grade,3rd Grade,4th Grade,5th Grade,6th Grade',
            'note' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|in:Active,Inactive,Under review',
        ];

        $this->errorMessages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.regex' => 'The name format is invalid. It must contain between 3 and 15 characters, consisting of letters only, and up to 2 spaces.',
            'first_surname.required' => 'The first surname field is required.',
            'first_surname.string' => 'The first surname must be a string.',
            'first_surname.regex' => 'The first surname format is invalid. It must contain between 3 and 15 characters, consisting of letters only, and up to 2 spaces.',
            'second_surname.required' => 'The second surname field is required.',
            'second_surname.string' => 'The second surname must be a string.',
            'second_surname.regex' => 'The second surname format is invalid. It must contain between 3 and 15 characters, consisting of letters only, and up to 2 spaces.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'The date of birth must be a valid date.',
            'date_of_birth.after_or_equal' => 'The date of birth must be after or equal to January 1, 2020.',
            'gender.required' => 'The gender field is required.',
            'gender.in' => 'The gender must be male or female.',
            'curp.required' => 'The CURP field is required.',
            'curp.string' => 'The CURP must be a string.',
            'curp.max' => 'The CURP may not be greater than 18 characters.',
            'curp.regex' => 'The CURP format is invalid.',
            'blood_type.required' => 'The blood type field is required.',
            'blood_type.string' => 'The blood type must be a string.',
            'blood_type.in' => 'The blood type must be one of: A+, A-, B+, B-, AB+, AB-, O+, O-.',
            'photo.string' => 'The photo must be a string.',
            'birth_certificate.string' => 'The birth certificate must be a string.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be active, inactive or under review.',
        ];
    }

    public function index()
    {
        // Obtener todos los estudiantes con la relación 'user'
        $students = Student::with('user')->get();
        
        // Devolver la respuesta en formato JSON
        return response()->json($students);
    }

    public function show($id)
    {
        // Buscar un estudiante por su ID con la relación 'user' y 'payments' y ordenar los pagos
        $student = Student::with(['user', 'payments' => function ($query) {
            $query->orderBy('date', 'asc');
        }])->findOrFail($id);
        
        // Devolver la respuesta en formato JSON
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $student_id = Uuid::uuid4()->toString(); // *
        $request->merge(['id' => $student_id]); // *

        $validator = Validator::make($request->all(), $this->rules, $this->errorMessages);   

        // Si la validación falla, devolver un error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Crear un nuevo estudiante con los datos proporcionados
        $student = Student::create($request->all());
        
        // Devolver la respuesta en formato JSON con el estudiante creado
        return response()->json(['message' => 'Student created successfully.', 'student' => $student], 201);
    }

    public function update(Request $request, $id)
    {
        // Buscar el estudiante a actualizar por su ID
        $student = Student::findOrFail($id);
        
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), $this->rules, $this->errorMessages);


        // Si la validación falla, devolver un error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Actualizar los datos del estudiante
        $student->update($request->all());
        
        // Devolver la respuesta en formato JSON con el estudiante actualizado
        return response()->json(['message' => 'Student updated successfully.', 'student' => $student], 200);
    }

    public function destroy($id)
    {
        // Buscar el estudiante a eliminar por su ID
        $student = Student::findOrFail($id);
        
        // Eliminar el estudiante
        $student->delete();
        
        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Student deleted successfully.'], 204);
    }
}
