<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Job;
use App\Enums\JobTypeEnum;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{

    protected $job;

    public function __construct(JobRepository $job)
    {
        $this->job = $job;
    }

    public function index()
    {
        try {
            $jobs = $this->job->all();
            return response()->json([
                'status' => true,
                "errNum" => "S000",
                "msg" => "success",
                "data" => $jobs
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }

    }

    public function show(Request $request, $id)
    {
        try {
            $request['id'] = $id;
            $request->validate(['id' => 'required|exists:jobs,id,deleted_at,NULL']);
            $jobs = $this->job->find($id);

            return response()->json([
                'status' => true,
                "errNum" => "S000",
                "msg" => "success",
                "data" => $jobs
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'location' => 'required|string|max:255',
                'salary' => 'required|integer|min:1|max:50000',
                'type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, JobTypeEnum::cases()))],
            ]);

            $this->job->create($validated);
            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "message" => "Job created successfully."
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request['id'] = $id;
            $validated = $request->validate([
                'id' => 'required|exists:jobs,id,deleted_at,NULL',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'location' => 'required|string|max:255',
                'salary' => 'required|integer|min:0',
                'type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, JobTypeEnum::cases()))],
            ]);

            $this->job->update($validated, $id);

            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "message" => "Job updated successfully."
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }

    public function filter(Request $request)
    {
        try {
            $validated = $request->validate([
                'search' => 'required',
            ]);
            $data = $this->job->Fillter($validated['search']);
            return response()->json($data);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {

            $request['id'] = $id;
            $request->validate(['id' => 'required|exists:jobs,id,deleted_at,NULL']);

            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "message" => "Job Deleted successfully."
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }


    public function destroyForced(Request $request, $id)
    {
        try {

            $request['id'] = $id;
            $request->validate(['id' => 'required|exists:jobs,id,deleted_at,NULL']);
            $this->job->deleteForce($id);

            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "message" => "Job Deleted force successfully."
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }


    public function restoreIndex()
    {
        try {
            $jobs = $this->job->restoreIndex();
            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "data" => $jobs
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }


    public function restore(Request $request, $id)
    {
        try {

            $request['id'] = $id;
            $request->validate(['id' => 'required|exists:jobs,id,deleted_at,!=NULL']);
            $jobs = $this->job->restore($id);

            return response()->json([
                "status" => true,
                "errNum" => "S000",
                "message" => "Job : " . $jobs . " , Restore successfully."
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errNum' => 'V000',
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, "errNum" => $e->getCode(), "msg" => "error , " . $e->getMessage()]);
        }
    }


}
