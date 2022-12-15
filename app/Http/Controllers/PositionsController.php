<?php

namespace App\Http\Controllers;

use App\DataTables\PositionsDataTable;
use App\Models\Positions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PositionsDataTable $dataTable)
    {
        return $dataTable->render('positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.add');
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
                'name' => 'max:256|unique:positions',
            ],
         [
             'name.max' => 'Maximum characters exceeded - 256',
             'name.unique' => 'This position already exists',

         ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = Auth::user()->id;

        $position = new Positions();
        $position->name = $request->name;
        $position->admin_created_id = $user_id;
        $position->admin_updated_id = $user_id;
        $position->created_at = Carbon::now();
        $position->updated_at = Carbon::now();
        $position->save();
        return redirect()->route('positions.index')->with('success', 'Success create new position');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Positions::find($id);
        return view('positions.edit', compact('position'));
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
                'name' => 'max:256|unique:positions',
            ],
            [
                'name.max' => 'Maximum characters exceeded - 256',
                'name.unique' => 'This position already exists',

            ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = Auth::user()->id;

        $position = Positions::find($id);
        $position->name = $request->name;
        $position->admin_updated_id = $user_id;
        $position->updated_at = Carbon::now();
        $position->save();
        return redirect()->route('positions.index')->with('success', 'Success update position');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Positions::destroy($id);
        return redirect()->route('positions.index')->with('success', 'Success remove position');
    }

    public function showToDestroy(Request $request){
        $id = $request->id;
        $position = Positions::find($id);
        $name = $position->name;
        $route = 'positions.destroy';
        return view('components.modal', compact("id", "name", "route"));
    }
}
