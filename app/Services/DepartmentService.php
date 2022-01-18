<?php

namespace App\Services;

use App\Repositories\Contracts\ScheduleRepositoryContract;
use App\Repositories\Contracts\DepartmentRepositoryContract;
use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use App\Repositories\Contracts\FixedScheduleRepositoryContract;
use function Symfony\Component\String\s;

class DepartmentService implements Contracts\DepartmentServiceContract
{
    private DepartmentRepositoryContract $departmentRepository;
    private FixedScheduleRepositoryContract $fixedScheduleRepository;
    private ExamScheduleRepositoryContract $examScheduleRepository;
    private ScheduleRepositoryContract $scheduleDepository;

    /**
     * @param DepartmentRepositoryContract    $departmentRepository
     * @param FixedScheduleRepositoryContract $fixedScheduleRepository
     * @param ExamScheduleRepositoryContract  $examScheduleRepository
     * @param ScheduleRepositoryContract      $scheduleDepository
     */
    public function __construct (DepartmentRepositoryContract    $departmentRepository,
                                 FixedScheduleRepositoryContract $fixedScheduleRepository,
                                 ExamScheduleRepositoryContract  $examScheduleRepository,
                                 ScheduleRepositoryContract      $scheduleDepository)
    {
        $this->departmentRepository    = $departmentRepository;
        $this->fixedScheduleRepository = $fixedScheduleRepository;
        $this->examScheduleRepository  = $examScheduleRepository;
        $this->scheduleDepository      = $scheduleDepository;
    }

    public function getAllDepartments ()
    {
        return $this->departmentRepository->findAllWithDepartments();
    }

    public function getSchedules ($id_department, $start, $end)
    {
        return $this->scheduleDepository->findAllByIdDepartment($id_department, $start, $end);
    }

    public function getExamSchedules ($id_department, $start, $end)
    {
        return $this->examScheduleRepository->findByIdDepartment($id_department, $start, $end);
    }

    public function getFixedSchedulesByStatus ($id_department, $status)
    {
        return $this->fixedScheduleRepository->findByStatusAndIdDepartment($id_department, $status);
    }
}