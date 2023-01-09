<?php

namespace App\Traits;

use App\Models\College;
use App\Models\Program;

trait FilterTrait {
    public $filters = [];

    protected function getFilterColleges()
    {
        return College::get();
    }

    protected function getFilterPrograms()
    {
        return Program::query()
            ->where('college_id', $this->filters['college_id'] ?? '')
            ->get();
    }

    public function updatedFiltersCollegeId($value)
    {
        unset($this->filters['program_id']);
        if (empty($value)) {
            unset($this->filters['college_id']);
        }
    }
}
