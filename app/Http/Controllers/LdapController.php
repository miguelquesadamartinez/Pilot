<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Adldap\AdldapInterface;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LdapController extends Controller
{
    protected $ldap;

    public function __construct(AdldapInterface $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * LDAP Synchronization
     *
     * @return JsonResponse
     */
    public function ldapSynchronization()
    {

        ini_set('max_execution_time', env('MAX_EXECUTION_TIME'));

        DB::enableQueryLog();

        $data = $this->ldap->search()->users()->get();

        //$data = $this->ldap->search()->where('samaccountname', '=', 'm.quesada')->get();
        
        if (count($data)) {
            foreach ($data as $userData) {

                //password salt
                $salt = substr(md5(uniqid(rand(), true)), 0, 5); //generate a random key as salt
                $pwd = substr(str_shuffle(strtolower(sha1(rand() . time() . $salt))), 0, 50);
                $pwd = md5($salt . md5($pwd));

                if ( $userData->getDisplayName() == '' || $userData->getFirstAttribute('mail') == '') continue;

                $samacCountName = $userData->getFirstAttribute('samaccountname');
                $mail = $userData->getFirstAttribute('mail');
                $givenName = $userData->getDisplayName();
                //$sn = $userData['sn'][0];
                $objectGuidValue = $userData['objectguid'][0];
                $GUID = unpack("H*hex", $objectGuidValue);
                $ldapGuid = $GUID['hex'];

                //remove special characters
                $ldapGuid = str_replace(['�', '', '', '�ַ', 'M틣', '˃', '`'], '', $ldapGuid);
                $mail = str_replace(['�', '', '', '�ַ', 'M틣', '˃', '`'], '', $mail);
                $givenName = str_replace(['�', '', '', '�ַ', 'M틣', '˃', '`'], '', $givenName);
                //$sn = str_replace(['�', '', '', '�ַ', 'M틣', '˃', '`'], '', $sn);
                //$fullName = $givenName . " " . $sn;

                $date = date(app('global_format_date'));

                //dd($mail);
                if ($samacCountName != '') {
                    $user = User::whereSamaccountname($samacCountName)->first();
                    if (!$user) {

                        SearchHelper::DebuggerTxT("Adding user: " . $givenName) ;

                        $user = User::create([
                            'samaccountname' => $samacCountName,
                            'name' => $givenName,
                            'password' => $pwd,
                            'email' => $mail,
                            'objectguid' => $ldapGuid,
                            'created_at' => $date,
                            'updated_at' => $date,
                            'statut' => $userData->isActive()
                        ]);

                        $user->assignRole(3); // Role Searcher 

                    } else {

                        SearchHelper::DebuggerTxT("Modifiying user: " . $givenName) ;

                        if ($user->ldapGuid != $ldapGuid) {
                            $user->update(['objectguid' => $ldapGuid, 'updated_at' => $date]);
                        }

                        $user->update(['email' => $mail, 'updated_at' => $date, 'statut' => $userData->isActive()]);
                    }

                    if($samacCountName == 'm.quesada' || $samacCountName == 'g.naze'){
                        $user->assignRole(1); 
                        $user->assignRole(2);
                        $user->assignRole(4);
                        $user->assignRole(5);
                        $user->assignRole(6);
                        $user->assignRole(7);
                    }
                }
            }

            SearchHelper::DebuggerTxT("Executed SQLs:");
            SearchHelper::bindBuilderQuery(DB::getQueryLog());

            DB::flushQueryLog();
            DB::disableQueryLog();

        }

        return Redirect::to('/admin/users');
        //return response()->json(['message' => trans('user.user_sync_from_ldap_completed')]);

    }

    public function getLdapDomainColumn()
    {
        return 'domain';
    }

    public function getLdapGuidColumn()
    {
        return 'guid';
    }
}
