<?php

namespace App\Repositories;

use App\Models\Module;
use App\Models\Teacher;
use App\Models\ModuleClass;
use Illuminate\Support\Facades\DB;
use App\Repositories\Abstracts\BaseRepository;

class ModuleClassRepository extends BaseRepository implements Contracts\ModuleClassRepositoryContract
{
    function model () : string
    {
        return ModuleClass::class;
    }

    public function findByIdDepartment ($id_department, array $inputs)
    {
        $this->createModel();
        return $this->model->filter($inputs)
                           ->join(Module::table_as, 'module_classes.id_module', '=', 'mds.id')
                           ->where('mds.id_department', '=', $id_department)
                           ->leftJoin(Teacher::table_as, 'teas.id', '=', 'module_classes.id_teacher')
                           ->orderBy('module_classes.id')
                           ->get(['module_classes.id', 'module_classes.name', 'credit', 'number_reality',
                                  'type', 'teas.name as teacher']);
    }

    public function getIDModuleClassesMissing ($id_module_classes)
    {
        $this->createModel();
        $this->_createTemporaryTable($id_module_classes);
        return $this->model->rightJoin('temp', 'id', 'id_module_class')
                           ->whereNull('id')->pluck('id_module_class')->toArray();
    }

    public function _createTemporaryTable ($id_module_classes)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp (
                id_module_class varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        DB::unprepared($sql_query);
        DB::table('temp')->insert($id_module_classes);
    }


    public function softDeleteByIdDepartmentAndIdStudySession (string $idDepartment,
                                                               int    $idStudySession)
    {
        $this->createModel();
        $this->model->join(Module::table_as, 'module_classes.id_module', '=', 'mds.id')
                    ->where('id_department', '=', $idDepartment)
                    ->where('id_study_session', '=', $idStudySession)
                    ->update(['deleted_at' => now()]);
    }
}
