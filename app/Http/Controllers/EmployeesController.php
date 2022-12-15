<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use App\Models\Employees;
use App\Models\Positions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeesDataTable $dataTable)
    {
        //
        return $dataTable->render('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Positions::all();
        if($positions){
            foreach ($positions as $item){
                $select[$item->id] = $item->name;
            }
        }
        return view('employees.add', compact('select'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'max:256|min:2',
                'hide_head' => 'required',
                'head' => 'required',
                'position' => 'required',
                // Тут должна быть регулярка, но я потратил много времени на её поиски
                'phone' => 'required',
                'image' => 'mimes:jpg,png|max:5000|dimensions:min_width=300,min_height=300',
                'email' => 'required|email',
                'date' => 'date_format:d.m.Y',
                'salary' => 'numeric|between:0.001,500.000',
            ],
            [
                'head.required' => 'Select your manager',
                'hide_head.required' => 'Select your manager',
                'name.max' => 'Maximum characters exceeded - 256',
                'name.min' => 'Minimum characters exceeded - 2',
                'position.required' => 'Select your position',
                'phone.required' => 'Phone required field',
                'phone.numeric' => 'Pls input only number type',
                'photo.mimes' => 'Need type files - jpg/png',
                'photo.size' => 'Max size 5 MB',
                'email.required' => 'Email required field',
                'email.email' => 'This field must have type email',
                'date.required' => 'Field date required',
                'date.date_format' => 'Correct format date',
                'salary.between' => 'Invalid data - min 0.001, max 500.000',
                'salary.numeric' => 'Pls input numeric type',
                'image.max' => 'Max 5mb for image',
                 "image.mimes" => 'The image must be a extension of type: jpg, png',
                "image.dimensions" => 'Minimum size must be 300x300'


            ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = Auth::user()->id;

        $employee = new Employees();

        $employee->name = $request->name;
        $employee->reception = Carbon::createFromFormat('d.m.Y', $request->date)->format('Y-m-d');

        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        $employee->position_id = $request->position;
        $employee->manager_id = $request->hide_head;

        $employee->name = $request->name;
        $employee->admin_created_id = $user_id;
        $employee->admin_updated_id = $user_id;
        $employee->created_at = Carbon::now();
        $employee->updated_at = Carbon::now();

        // image
        if($request->file('image')) {
            $path = 'images/300x300/';
            $image = $request->file('image');
            $img = Image::make($image->path())->encode('jpg', 80);
            // если я правильно понял, то нужен был не просто resize картинки
            // на этом этапе я растерялся какой должна быть исходная картинка, тз в тестовом ввело в заблуждение
            $canvas = Image::canvas(300, 300);
            $canvas->insert($img, 'center');
            $canvas->save($path.time() . '.' . $image->getClientOriginalExtension(), 80, 'jpg');
            $image = $path . $canvas->filename . "." . $canvas->extension;
        }else{
            $image = '';
        }
            $employee->image = $image;

        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Success create new position');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employees::find($id);
        $positions = Positions::all();
        if($positions){
            foreach ($positions as $item){
                $select[$item->id] = $item->name;
            }
        }
        return view('employees.edit', compact('employee', 'select'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'max:256|min:2',
                'hide_head' => 'required',
                'head' => 'required',
                'position' => 'required',
                // Тут должна быть регулярка, но я потратил много времени на её поиски
                'phone' => 'required',
                'image' => 'mimes:jpg,png|max:5000|dimensions:min_width=300,min_height=300',
                'email' => 'required|email',
                'date' => 'date_format:d.m.Y',
                'salary' => 'numeric|between:0.001,500.000',
            ],
            [
                'head.required' => 'Select your manager',
                'hide_head.required' => 'Select your manager',
                'name.max' => 'Maximum characters exceeded - 256',
                'name.min' => 'Minimum characters exceeded - 2',
                'position.required' => 'Select your position',
                'phone.required' => 'Phone required field',
                'phone.numeric' => 'Pls input only number type',
                'photo.mimes' => 'Need type files - jpg/png',
                'photo.size' => 'Max size 5 MB',
                'email.required' => 'Email required field',
                'email.email' => 'This field must have type email',
                'date.required' => 'Field date required',
                'date.date_format' => 'Correct format date',
                'salary.between' => 'Invalid data - min 0.001, max 500.000',
                'salary.numeric' => 'Pls input numeric type',
                'image.max' => 'Max 5mb for image',
                "image.mimes" => 'The image must be a extension of type: jpg, png',
                "image.dimensions" => 'Minimum size must be 300x300'


            ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = Auth::user()->id;

        $employee = Employees::find($id);

        $employee->name = $request->name;
        $employee->reception = Carbon::createFromFormat('d.m.Y', $request->date)->format('Y-m-d');

        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        $employee->position_id = $request->position;
        $employee->manager_id = $request->hide_head;

        $employee->name = $request->name;
        $employee->admin_updated_id = $user_id;
        $employee->updated_at = Carbon::now();

        // image
        if($request->file('image')) {
            $path = 'images/300x300/';
            $image = $request->file('image');
            $img = Image::make($image->path())->encode('jpg', 80);
            // если я правильно понял, то нужен был не просто resize картинки
            // на этом этапе я растерялся какой должна быть исходная картинка, тз в тестовом ввело в заблуждение
            $canvas = Image::canvas(300, 300);
            $canvas->insert($img, 'center');
            $canvas->save($path.time() . '.' . $image->getClientOriginalExtension(), 80, 'jpg');
            $image = $path . $canvas->filename ."." . $canvas->extension;
            $employee->image = $image;
        }

        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Success create new employee');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $getPeopleWithManager = Employees::where('manager_id', '=', $id)->get();
       $getFreeManagers = DB::table('employees')
            ->select('manager_id', DB::raw('COUNT(manager_id) as manager_count'))
            ->groupBy('manager_id')
            ->having('manager_count', '<', 5)
            ->take(5)
            ->get();
            $countPeople = count($getPeopleWithManager);
            $tmpNext = true;
            foreach($getFreeManagers as $item){
                    if($countPeople + $item->manager_count <=5 && $tmpNext){
                        foreach($getPeopleWithManager as $itemPeople){
                                $itemPeople->update([
                                    'manager_id' => $item->manager_id
                                ]);
                        }
                        $tmpNext=false;
                    }
            }
        Employees::destroy($id);

        return redirect()->route('employees.index')->with('success', 'Success remove employee');
    }

    public function showToDestroy(Request $request){
        $id = $request->id;
        $position = Employees::find($id);
        $name = $position->name;
        $route = 'employees.destroy';
        return view('components.modal', compact("id", "name", "route"));
    }

    public function autocomplete(Request $request)
    {
        $data = DB::table('employees')
            ->select(DB::raw('COUNT(manager_id) manager_count, manager_id'))
            ->where("name","LIKE",$request->term."%")
            ->groupBy('manager_id')
            ->having('manager_count', '<', 5)
            ->take(30)
            ->pluck('manager_id');

        $newData = DB::table('employees')->select('name', 'id')->whereIn('id', $data)->get();
            foreach($newData as $item){
                $json[] = [
                    'label' => $item->name,
                    'value' => $item->id
                ];
            }
        return response()->json($json);
    }
}


