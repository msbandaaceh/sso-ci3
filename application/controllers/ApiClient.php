<?php

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $pegawai
 * @property CI_Model $jabatan
 * @property CI_Model $pangkat
 * @property CI_Model $pegawai
 * @property CI_Model $notif
 * @property CI_Model $api
 * @property CI_Upload $upload
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */

class ApiClient extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('pengaturan/ModelPegawai', 'pegawai');
        $this->load->model('pengaturan/ModelUser', 'user');
        $this->load->model('ModelJabatan', 'jabatan');
        $this->load->model('ModelPangkat', 'pangkat');
        $this->load->model('ModelUtama', 'model');
        $this->load->model('ModelApi', 'api');
        $this->load->model('ModelNotifikasi', 'notif');

        // Handle preflight OPTIONS sebelum method apapun dieksekusi
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->_send_cors_headers();
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-Api-Key');
            header('Access-Control-Max-Age: 86400');
            http_response_code(204);
            exit;
        }

        $this->_send_cors_headers();
        header('Content-Type: application/json');
    }

    public function _remap($method, $args = array())
    {
        if (!$this->_validate_api_key()) {
            return;
        }
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $args);
        } else {
            show_404();
        }
    }

    private function _send_cors_headers()
    {
        $allowed = $this->config->item('cors_allowed_origins');
        $allowed = is_array($allowed) ? $allowed : array();
        $origin  = isset($_SERVER['HTTP_ORIGIN']) ? rtrim($_SERVER['HTTP_ORIGIN'], '/') : '';

        if (!empty($origin) && in_array($origin, $allowed, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
            header('Access-Control-Allow-Credentials: true');
        }

        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }

    private function _validate_api_key()
    {
        $expected = (string) $this->config->item('api_key');
        $key = null;

        // 1) Query string
        $key = $this->input->get('api_key');
        if (empty($key)) {
            $key = $this->input->get('kuncine');
        }

        // 2) Header X-Api-Key
        if (empty($key) && function_exists('getallheaders')) {
            $headers = getallheaders();
            if (isset($headers['X-Api-Key'])) {
                $key = $headers['X-Api-Key'];
            } elseif (isset($headers['x-api-key'])) {
                $key = $headers['x-api-key'];
            }
        }

        // 3) Body JSON
        if (empty($key)) {
            $raw = file_get_contents('php://input');
            if (!empty($raw)) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    if (isset($decoded['api_key']) && !empty($decoded['api_key'])) {
                        $key = $decoded['api_key'];
                    } elseif (isset($decoded['kuncine']) && !empty($decoded['kuncine'])) {
                        $key = $decoded['kuncine'];
                    }
                }
            }
        }

        if (empty($key) || !hash_equals($expected, (string) $key)) {
            $this->_log_failed_attempt();
            http_response_code(401);
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Unauthorized: API key tidak valid atau tidak diberikan.'
            ));
            return false;
        }

        return true;
    }

    private function _log_failed_attempt()
    {
        if ((int) $this->config->item('log_threshold') === 0) {
            return;
        }
        log_message('warning',
            'ApiClient auth failed | IP: ' . $this->input->ip_address() .
            ' | URI: ' . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-') .
            ' | Origin: ' . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '-')
        );
    }

    public function get_data_seleksi()
    {
        $tabel = $this->input->get('tabel');
        $kolom_seleksi = $this->input->get('kolom_seleksi');
        $seleksi = $this->input->get('seleksi');

        $data = $this->api->get_seleksi($tabel, $kolom_seleksi, $seleksi);
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_data_seleksi2()
    {
        $tabel = $this->input->get('tabel');
        $kolom_seleksi = $this->input->get('kolom_seleksi');
        $seleksi = $this->input->get('seleksi');
        $kolom_seleksi2 = $this->input->get('kolom_seleksi2');
        $seleksi2 = $this->input->get('seleksi2');

        $data = $this->api->get_seleksi2($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2);
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_data_seleksi_array()
    {
        $tabel = $this->input->get('tabel');
        $where = $this->input->get('where');

        $data = $this->api->get_seleksi_array($tabel, $where);
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_data_pegawai_aktif()
    {
        $kolom_seleksi = $this->input->get('kolom_seleksi');
        $seleksi = $this->input->get('seleksi');

        $data = $this->api->get_seleksi2('v_pegawai', $kolom_seleksi, $seleksi, 'status_pegawai', '1');
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->row()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_data_plh()
    {
        $kolom_seleksi = $this->input->get('kolom_seleksi');
        $seleksi = $this->input->get('seleksi');
    
        $data = $this->api->get_seleksi('v_plh', $kolom_seleksi, $seleksi);
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->row()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_data_tabel()
    {
        $tabel = $this->input->get('tabel');
        $data = $this->api->get_data_tabel($tabel);
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function pembaharuan_data()
    {
        header('Content-Type: application/json');

        $input = json_decode(trim(file_get_contents("php://input")), true);

        // Validasi input minimal
        if (!isset($input['tabel'], $input['kunci'], $input['id'], $input['data'])) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => 'Required fields: tabel, kunci, id, data']);
            return;
        }

        $tabel = $input['tabel'];
        $id = $input['id'];
        $kunci = $input['kunci'];
        $data = $input['data'];

        try {
            $query = $this->api->pembaharuan_data($tabel, $data, $kunci, $id);

            if ($query) {
                echo json_encode(['status' => true, 'message' => 'Update Data Berhasil']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => false, 'message' => 'Gagal Update Data']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function simpan_data()
    {
        header('Content-Type: application/json');

        $input = json_decode(trim(file_get_contents("php://input")), true);

        // Validasi input minimal
        if (!isset($input['tabel'], $input['data'])) {
            http_response_code(400);
            echo json_encode(['status' => false, 'message' => $input]);
            return;
        }

        $tabel = $input['tabel'];
        $data = $input['data'];

        try {
            $query = $this->api->simpan_data($tabel, $data);

            if ($query) {
                echo json_encode(['status' => true, 'message' => 'Simpan Data Berhasil']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => false, 'message' => 'Gagal Simpan Data']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function audittrail()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['action']) || !isset($input['title']) || !isset($input['table']) || !isset($input['description'])) {
            echo json_encode(['status' => false, 'message' => 'Parameter tidak lengkap']);
            return;
        }

        // panggil fungsi audit trail
        $sukses = $this->api->log_trail(
            $input['action'],
            $input['title'],
            $input['table'],
            $input['description'],
            $input['username'], // opsional: bisa kirim dari client
            $this->input->ip_address()
        );

        echo json_encode([
            'status' => $sukses,
            'message' => $sukses ? 'Audit trail berhasil disimpan' : 'Gagal menyimpan audit trail'
        ]);
    }

    public function get_lokasi()
    {
        $data = $this->api->get_seleksi('lokasi_kantor', 'id', '1');
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function get_lokasi_mpp()
    {
        $data = $this->api->get_seleksi('lokasi_kantor', 'id', '2');
        if ($data->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $data->result_array()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }
}