<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimelogRequest;
use App\Http\Requests\UpdateTimelogRequest;
use App\Models\Timelog;

class TimelogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Timelog $timelog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timelog $timelog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimelogRequest $request, Timelog $timelog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timelog $timelog)
    {
        //
    }
}
