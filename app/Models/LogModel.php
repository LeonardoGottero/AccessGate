<?php
namespace App\Models;
use CodeIgniter\Model;
class LogModel extends Model {
    protected $table = 'logs';
    protected $primaryKey = 'LogsId';
    protected $allowedFields = ['time', 'action', 'UserId', 'AccountId', 'DeviceId'];
    public function GetLogsWithAccountId($AccountId) {
        return $this->db->table($this->table)
            ->select('logs.*, users.name as name, users.surname as surname, devices.device_name as device_name')
            ->join('users', 'users.UserId = logs.UserId', 'left')
            ->join('devices', 'devices.DeviceId = logs.DeviceId', 'left')
            ->orderBy('logs.time', 'DESC')
            ->where('logs.AccountId', $AccountId)
            ->get()
            ->getResultArray();
    }
    public function GetLogsWithNames($AccountId, $Search) {
        $Terms = explode(' ', $Search);
        $query = $this->db->table($this->table)
            ->select('logs.*, users.name as name, users.surname as surname, devices.device_name as device_name')
            ->join('users', 'users.UserId = logs.UserId', 'left')
            ->join('devices', 'devices.DeviceId = logs.DeviceId', 'left')
            ->orderBy('logs.time', 'DESC')
            ->where('logs.AccountId', $AccountId);
        if (count($Terms) == 1) {
            $query->groupStart()
                ->like('users.name', $Search, 'both')
                ->orLike('users.surname', $Search, 'both')
                ->groupEnd();
        } elseif (count($Terms) == 2) {
            $query->groupStart()
                ->like('users.name', $Terms[0], 'both')
                ->like('users.surname', $Terms[1], 'both')
                ->groupEnd();
        } else {
            $query->groupStart();
            foreach ($Terms as $Term) {
                $query->orGroupStart()
                    ->like('users.name', $term, 'both')
                    ->orLike('users.surname', $term, 'both')
                    ->groupEnd();
            }
            $query->groupEnd();
        }
        return $query->get()->getResultArray();
    }
    public function GetLastLog($UserId){
        return $this->where('UserId', $UserId)
                    ->orderBy('time', 'DESC')
                    ->first();
    }
    public function getLogCountsByAction($UserId){
        return $this->db->table($this->table)
                    ->select('action, COUNT(action) as count')
                    ->where('UserId', $UserId)
                    ->groupBy('action')
                    ->get()
                    ->getResultArray();
    }
    public function getDailyLogCountsForLast7Days($UserId){
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        return $this->db->table($this->table)
                    ->select("DATE(time) as log_date, action, COUNT(action) as count")
                    ->where('UserId', $UserId)
                    ->where('time >=', $sevenDaysAgo)
                    ->groupBy("log_date, action")
                    ->orderBy('log_date', 'ASC')
                    ->get()
                    ->getResultArray();
    }
}