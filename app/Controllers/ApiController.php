<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AccountModel;
use App\Models\UserModel;
use App\Models\LogModel;
use App\Models\DUModel;
use App\Models\DeviceModel;
use CodeIgniter\HTTP\ResponseInterface;
class ApiController extends BaseController{
    private $AccountModel;
    private $UserModel;
    private $LogModel;
    private $DeviceModel;
    private $DUModel;
    public function __construct(){
        $this->AccountModel = new AccountModel();
        $this->UserModel = new UserModel();
        $this->LogModel = new LogModel();
        $this->DeviceModel = new DeviceModel();
        $this->DUModel = new DUModel();
    }
    public function CheckTag(){
        $data = $this->request->getJSON();
        if (!isset($data->tag, $data->action, $data->device)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST, 'Invalid input. Missing required fields.');
        }
        $device = $this->DeviceModel->where('device_uid', $data->device)->first();
        if (!$device) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND, 'Device not found.');
        }
        $user = $this->UserModel->where('tag', $data->tag)->first();
        if (!$user) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND, 'Tag not found.');
        }
        $deviceUserPermission = $this->DUModel->where('UserId', $user['UserId'])
                                              ->where('DeviceId', $device['DeviceId'])
                                              ->first();
        if (!$deviceUserPermission || $deviceUserPermission['Allowed'] != 1) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN, 'User not permitted on this device.');
        }
        $account = $this->AccountModel->find($device['AccountId']);
        if (!$account) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Associated account could not be found.');
        }
        $currentTime = date('H:i:s');
        if ($currentTime < $user['from_time'] || $currentTime > $user['to_time']) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN, 'Access denied outside of allowed time range.');
        }
        $actionWeb = ($data->action == 2) ? 0 : 1;
        $this->LogModel->insert([
            'UserId' => $user['UserId'],
            'time' => date('Y-m-d H:i:s'),
            'action' => $actionWeb,
            'AccountId' => $account['AccountId'],
            'DeviceId' => $device['DeviceId']
        ]);
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK, 'Access granted.');
    }
    public function FirstConnection(){
        $data = $this->request->getJSON();
        if (!isset($data->device)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST, 'Device UID not provided.');
        }
        $existingDevice = $this->DeviceModel->where('device_uid', $data->device)->first();
        if ($existingDevice) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK, 'Device already registered.');
        }
        $this->DeviceModel->insert(['device_uid' => $data->device]);
        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED, 'New device registered successfully.');
    }
    public function SetStatus(){
        $data = $this->request->getJSON();
        $device = $this->DeviceModel->where('device_uid', $data->device)->first();
        if (!$device) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND, 'Device not found.');
        }
        if (!isset($data->status)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST, 'Status not provided.');
        }
        $allowedStatuses = ['En espera', 'Abriendo', 'Abierto', 'Cerrando'];
        $this->DeviceModel->update($device['DeviceId'],['status' => $data->status]);
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK, 'Status updated successfully.');
    }
    public function GetStatus(){
        $DeviceId = $this->request->getGet('Device');
        if (!$DeviceId) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST, 'Device ID not provided.');
        }
        $device = $this->DeviceModel->where('DeviceId', $DeviceId)->first();
        if (!$device) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND, 'Device not found.');
        }
        return $this->response->setJSON(['status' => $device['status']]);
    }
}