<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\uuid;
use CodeIgniter\I18n\Time;


class SessionModel extends Model
{
    protected $table                = 'TSession';
    protected $primaryKey           = 'uidPK';
    protected $useAutoIncrement     = false;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $allowedFields        = ['uidPK', 'uidSalt', 'bStatus', 'sUserName', 'dtSessionStart', 'dtSessionValidTill', 'sClientInfo'];
    protected $useTimestamps        = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    public function getActiveSessionByID($uidPK) // TODO: (uid, salt) ---> suid
    {
        $sessionInfo = $this->find($uidPK);
        if($this->isSessionActive($sessionInfo)) {
            return $sessionInfo;
        }
        return null;
    }

    public function getActiveSessionByUserName($sUserName)
    {
        $arrSession = $this
        ->where('sUserName', $sUserName)
        ->orderBy('dtSessionStart', 'DESC')
        ->findAll();
        $activeSession = null;
        foreach ($arrSession as $sessionInfo) {
            if($this->isSessionActive($sessionInfo)) {
                $activeSession = $sessionInfo;
                break;
            }
        }
        return $activeSession;
    }

    public function isSessionActive($sessionInfo)
    {
        if(( $sessionInfo['bStatus'] & StatusConstants::ACTIVE)!=0) {
            $dtCurrent =  Time::Now('Europe/London');
            $dtValidTill = Time::parse(
                $sessionInfo['dtSessionValidTill'],
                'Europe/London'
            );
            return true;
        }
        return false;

        // echo ('<br/>valid till : ' . $sessionInfo['dtSessionValidTill']);
        // echo ('<br/>current : ' . gmdate(DATE_RFC3339) . '<br/>');
        // echo ($sessionInfo['dtSessionValidTill'] < gmdate('c')) ? "old" : "live";
    }


    public function createSession($sUserName, $sClientInfo)
    {
        $uuid = new Uuid();

        $newSessionData = [
            'uidPK' => $uuid->v4(true),
            'uidSalt' => $uuid->v4(true),
            'bStatus' => StatusConstants::ACTIVE,
            'sUserName' => $sUserName,
            'dtSessionStart' => gmdate(DATE_RFC3339),
            'dtSessionValidTill' => gmdate(DATE_RFC3339, strtotime('+ 3 minutes')),
            'sClientInfo' => $sClientInfo
        ];

        $this->insert($newSessionData);
        return $newSessionData;
    }

    public function endSession($uidPK)
    {
        $sessionInfo = $this->find($uidPK);
        $newStatus = $sessionInfo['bStatus']&(~StatusConstants::ACTIVE);
        $this->where('uidPK', $uidPK)
            ->set(['bStatus'=>$newStatus])
            ->update();
    }
}
