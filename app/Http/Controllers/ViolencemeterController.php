<?php

namespace App\Http\Controllers;

use App\Violencemeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViolencemeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $violencemeters = Violencemeter::all();
        return response()->json(compact('violencemeters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required', 'string', 'max:255', 'unique:violencemeters'],
            'gravity' => ['required', 'numeric']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        Violencemeter::create([
            'name'=>$request->get('name'),
            'gravity'=>$request->get('gravity')
        ]);

        return response()->json(['message'=>'Nuevo item creado'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Violencemeter  $violencemeter
     * @return \Illuminate\Http\Response
     */
    public function show(Violencemeter $violencemeter)
    {
        return response()->json(compact('violencemeter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Violencemeter  $violencemeter
     * @return \Illuminate\Http\Response
     */
    public function edit(Violencemeter $violencemeter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Violencemeter  $violencemeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Violencemeter $violencemeter)
    {
        $validator = Validator::make($request->all(), [
            'name'=>['required', 'string', 'max:255', 'unique:violencemeters'],
            'gravity' => ['required', 'numeric']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $violencemeter->name = $request->get('name');
        $violencemeter->gravity = $request->get('gravity');
        $violencemeter->save();
        return response()->json(['message'=>'Item actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Violencemeter  $violencemeter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Violencemeter $violencemeter)
    {
        $violencemeter->delete();
        return response()->json(['Item eliminado']);
    }
}
