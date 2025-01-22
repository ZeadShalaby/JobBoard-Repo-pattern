<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository
{
    protected $job;


    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function all()
    {
        return $this->job->all();
    }

    public function find($id)
    {
        return $this->job->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->job->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->job->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->job->findOrFail($id)->delete();
    }

    public function deleteForce($id)
    {
        return $this->job->findOrFail($id)->forceDelete();
    }

    public function Fillter($data)
    {
        return $this->job->search($data)->paginate(20);
    }

    public function restoreIndex()
    {
        return $this->job->onlyTrashed()->paginate(10);
    }


    public function restore($id)
    {
        $jobs = $this->job->withTrashed()->findOrFail($id);
        $jobs->restore();
        return $jobs->title;
    }
}