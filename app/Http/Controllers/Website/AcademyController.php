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
    
    public function academyData(Request $request){
        if($request->lang === '1'){
            $academy = Academy::all('id', 'en_name', 'en_city', 'en_country', 'avatar')->append(['Totaljobs'])->toArray();
            return $this->onSuccess($academy);
        }
        if($request->lang === '2'){
            $academy = Academy::all('id', 'ar_name', 'ar_city', 'ar_country', 'avatar')->append(['Totaljobs'])->toArray();
            return $this->onSuccess($academy);
        }
        else{
            return $this->onSuccess('Invild lang Input');
        }
    }
}
