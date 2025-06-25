<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

/**
 * @property CI_Config $config
 * @property CI_Input $input
 */

class Api extends CI_Controller
{
    private $jwt_key;

    public function __construct()
    {
        parent::__construct();
        $this->jwt_key = $this->config->item('jwt_key');
    }

    public function cek_token()
    {
        $token = $this->input->get('sso_token');
        try {
            $decoded = JWT::decode($token, new Key($this->jwt_key, 'HS256'));
            echo json_encode([
                'status' => 'success',
                'user' => [
                    'userid' => $decoded->userid,
                    'status_plh' => $decoded->status_plh,
                    'status_plt' => $decoded->status_plt
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}