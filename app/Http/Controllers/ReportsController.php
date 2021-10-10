<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Requests\CreateReportRequest;

class ReportsController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reports = Report::latest()->paginate(5);
        return view('reports.index', compact("reports"));
    }

    public function fetch()
    {
        return Report::latest()->simplePaginate(3);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Report::class);

        $report = new Report();

        return view('reports.createOrEdit', compact('report'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function store(CreateReportRequest $request)
    {

        $this->authorize("create", Report::class);

        try {
            $request->user()->reports()->create($request->only('title', 'body', 'vehicle_id', 'injured_count', 'happened_at'));
        } catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()
                ->with('error', $e->getMessage());
        } catch ( \Exception $e ) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }


        return redirect()->route('reports.index')
            ->with('success', 'Your report has been published.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {

        $this->authorize("update", $report);

        return view("reports.createOrEdit", compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CreateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(CreateReportRequest $request, Report $report)
    {
        $this->authorize("update", $report);

        $report->update($request->only('title', 'body', 'vehicle_id', 'injured_count', 'happened_at'));

        if ($request->expectsJson())
        {
            return response()->json([
                'message' => "Your report has been updated.",
                'body_html' => $report->body_html
            ]);
        }

        return redirect('/reports')->with('success', "Your report has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $this->authorize("delete", $report);

        $report->delete();

        if (request()->expectsJson())
        {
            return response()->json([
                'message' => "Your report has been deleted."
            ]);
        }

        return redirect('/reports')->with('success', "Your report has been deleted.");
    }

}
