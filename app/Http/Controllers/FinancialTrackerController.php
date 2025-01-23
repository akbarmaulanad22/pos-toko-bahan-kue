<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialTrackerRequest;
use App\Models\FinancialTracker;
use App\Services\LogFinancialTrackerService;
use Illuminate\Http\Request;

class FinancialTrackerController extends Controller
{
    protected LogFinancialTrackerService $logFinancialTrackerService;
    
    public function __construct(LogFinancialTrackerService $logFinancialTrackerService) {
        $this->logFinancialTrackerService = $logFinancialTrackerService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.financial-trackers.index', [
            'title' => 'Financial Trackers',
            'financials' => FinancialTracker::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.financial-trackers.create', [
            'title' => 'Create Financial Trackers'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FinancialTrackerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinancialTrackerRequest $request)
    {
        FinancialTracker::create($request->all());

        $this->logFinancialTrackerService->insert(new Request($request->all()), 'insert');
        
        return redirect()->route('financial-trackers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinancialTracker  $financialTracker
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialTracker $financialTracker)
    {
        return view('pages.admin.financial-trackers.show', [
            'title' => 'Detail Financial Tracker',
            'financial' => $financialTracker
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FinancialTracker  $financialTracker
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialTracker $financialTracker)
    {
        return view('pages.admin.financial-trackers.edit', [
            'title' => 'Edit Financial Tracker',
            'financial' => $financialTracker
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\FinancialTrackerRequest  $request
     * @param  \App\Models\FinancialTracker  $financialTracker
     * @return \Illuminate\Http\Response
     */
    public function update(FinancialTrackerRequest $request, FinancialTracker $financialTracker)
    {
        $financialTracker->update($request->all());

        $this->logFinancialTrackerService->insert(new Request($request->all()), 'update');
        
        return redirect()->route('financial-trackers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinancialTracker  $financialTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialTracker $financialTracker)
    {
        $financialTracker->delete();

        $this->logFinancialTrackerService->insert(new Request($financialTracker->toArray()), 'delete');
        
        return redirect()->route('financial-trackers.index');
    }
}
