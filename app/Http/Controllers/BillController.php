<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Student;
use App\Repositories\BillRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\BillStoreRequest;

class BillController extends Controller
{
    private $BillRepository;

    public function __construct(BillRepository $BillRepo)
    {
        $this->BillRepository = $BillRepo;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(): View|JsonResponse
    {
        $billings = Bill::with('students:id,name,student_identification_number')
        ->select('id','student_id', 'billings', 'recent_bill', 'status')->get();

        $students = Student::select('id', 'student_identification_number', 'name')->get();

        if (request()->ajax()) {
            return datatables()->of($billings)
                ->addIndexColumn()
                ->addColumn('billings', fn ($model) => indonesianCurrency($model->billings))
                ->addColumn('recent_bill', fn($model) => indonesianCurrency($model->recent_bill))
                ->addColumn('status', 'billings.datatable.status')
                ->rawColumns(['status'])
            ->toJson();
        }

        return view('billings.index', [
            'students' => $students,
            'data' => $this->BillRepository->results(),
        ]);

    }

    /**
     * Store a newly created bill in storage
     *
     * @param \Illuminate\Http\BillStoreRequest $request
     * @param \Illuminate\Http\RedirectResponse
     */
    public function store(BillStoreRequest $request): RedirectResponse
    {
        foreach ($request->student_id as $student_id)
        {
            Bill::create(['student_id' => $student_id]);
        }

        return redirect()->route('billings.index')->with('success', 'Data berhasil ditambahkan');
    }
}
