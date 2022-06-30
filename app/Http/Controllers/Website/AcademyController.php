<?php
namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Academies\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response
     */
    public function academyData(){

            $academy = Academy::all('id', 'name', 'avatar')->append(['Totaljobs'])->toArray();
            return $this->onSuccess($academy);
   
    }
}
