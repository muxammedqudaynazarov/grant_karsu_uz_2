<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Department;
use App\Models\EduYear;
use App\Models\Language;
use App\Models\Level;
use App\Models\Specialty;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\Subject;
use App\Models\SubjectList;
use App\Models\User;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

class HemisController extends Controller
{
    private function handleOAuthAuthorization(Request $request, GenericProvider $provider, string $redirectPath)
    {
        if (!$request->has('code')) {
            if ($request->has('start')) {
                $authorizationUrl = $provider->getAuthorizationUrl();
                Session::put('oauth2state', $provider->getState());
                return redirect($authorizationUrl);
            } else {
                return redirect($redirectPath . '?start=1');
            }
        } else if (empty($request->state) || (Session::has('oauth2state') && $request->state !== Session::get('oauth2state'))) {
            Session::forget('oauth2state');
            return response('Invalid state', 400);
        }

        return null;
    }

    public function student(Request $request)
    {
        $employeeProvider = new GenericProvider([
            'clientId' => env('CLIENT_ID'),
            'clientSecret' => env('CLIENT_SECRET'),
            'redirectUri' => env('REDIRECT_URI'),
            'urlAuthorize' => env('HEMIS_STUD_URL') . '/oauth/authorize',
            'urlAccessToken' => env('HEMIS_STUD_URL') . '/oauth/access-token',
            'urlResourceOwnerDetails' => env('HEMIS_STUD_URL') . '/oauth/api/user?fields=id,uuid,employee_id_number,type,roles,name,login,email,picture,firstname,surname,patronymic,birth_date,university_id,phone'
        ]);
        $authResponse = $this->handleOAuthAuthorization($request, $employeeProvider, '/hemis/');
        if ($authResponse) {
            return $authResponse;
        }
        try {
            $accessToken = $employeeProvider->getAccessToken('authorization_code', [
                'code' => $request->code
            ]);
            $resourceOwner = $employeeProvider->getResourceOwner($accessToken);
            $student_array = $resourceOwner->toArray();
            $student_array = $student_array['data'];
            $user = User::updateOrCreate(
                ['id' => $student_array['student_id_number']],
                [
                    'name' => $student_array['short_name'],
                    'token' => 'null',
                    'data' => $student_array,
                ]
            );
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Tizimga muvaffaqiyatli kirdingiz!');
        } catch (IdentityProviderException $e) {
            return response($e->getMessage(), 500);
        }
    }
}
