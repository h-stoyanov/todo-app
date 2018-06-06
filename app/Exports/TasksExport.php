<?php

namespace App\Exports;

use App\Task;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class TasksExport implements FromCollection
{
    private $tasks;

    /**
     * TasksExport constructor.
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }


    /**
     *
     * @return Collection
     */
    public function collection()
    {
        return $this->tasks;
    }
}