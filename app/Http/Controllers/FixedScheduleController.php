<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FixedScheduleResource;
use App\Services\Contracts\FixedScheduleServiceContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FixedScheduleController extends Controller
{
    private FixedScheduleServiceContract $fixedScheduleService;

    /**
     * @param FixedScheduleServiceContract $fixedScheduleService
     */
    public function __construct (FixedScheduleServiceContract $fixedScheduleService)
    {
        $this->fixedScheduleService = $fixedScheduleService;
    }

    public function createFixedSchedule (Request $request)
    {
        $this->fixedScheduleService->createFixedSchedule($request->only(['id_schedule',
                                                                         'new_date',
                                                                         'new_shift',
                                                                         'new_id_room',
                                                                         'time_request',
                                                                         'reason',]));
    }

    public function updateFixedSchedule (Request $request)
    {
        $this->fixedScheduleService->updateFixedSchedule($request->only(['id',
                                                                         'new_id_room',
                                                                         'time',
                                                                         'status',
                                                                         'reason_deny']));
    }

    public function paginateFixedSchedulesByStatus (Request $request) : AnonymousResourceCollection
    {
        $fixedSchedules = $this->fixedScheduleService->paginateFixedSchedulesByStatus($request->status,
                                                                                      $request->pagination);
        return FixedScheduleResource::collection($fixedSchedules);
    }
}
