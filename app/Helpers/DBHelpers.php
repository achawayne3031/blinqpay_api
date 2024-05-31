<?php 



namespace App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DBHelpers
{
  

    public static function exists($dataModel, $data)
    {
        try {
            return $dataModel
                ::query()
                ->where($data)
                ->exists();
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

  

    ////// get all query data
    public static function all_data($dataModel)
    {
        try {
            return $dataModel::all();
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

    /////// Delete query data
    public static function delete_query($dataModel, $id)
    {
        try {
            return $dataModel::where('id', $id)->delete();
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

    /////// Delete query data for multiple records
    public static function delete_query_multi($dataModel, $filter)
    {
        try {
            DB::beginTransaction();

            $status = $dataModel::where($filter)->delete();

            DB::commit(); // execute the operations above and commit transaction

            return $status;
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

    ////// Update flexible /////
    public static function update_query_v3($dataModel, $data, $filter = null)
    {
        DB::beginTransaction();
        $status = null;

        try {
            if ($filter != null) {
                $status = $dataModel::where($filter)->update($data);
            } else {
                $status = $dataModel::query()->update($data);
            }
            DB::commit(); // execute the operations above and commit transaction
            return $status;
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

    /////// Update query data
    public static function update_query($dataModel, $data, $id = 0)
    {
        DB::beginTransaction();
        $status = null;

        try {
            if ($id != 0) {
                $status = $dataModel::where('id', $id)->update($data);
            } else {
                $status = $dataModel::query()->update($data);
            }
            DB::commit(); // execute the operations above and commit transaction

            return $status;
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }

    //////// Insert query data /////////
    public static function create_query($dataModel, $data)
    {
        try {
            return $dataModel::create($data);
        } catch (Exception $e) {
            return ResponseHelper::error_response(
                'Server Error',
                $e->getMessage(),
                401,
                $e->getLine()
            );
        }
    }
}
