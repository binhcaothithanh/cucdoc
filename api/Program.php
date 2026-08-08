<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Thay đổi lớp cha sang FONTEND_Controller để thừa kế lõi xác thực JWT Token
class Program extends FONTEND_Controller {

    public function __construct() {
        // Khởi tạo và ngắt xử lý giao diện HTML truyền thống
        parent::__construct(true);

        $this->load->model('Program_Model');
        $this->load->helper('api');

        // Thiết lập cấu hình CORS Header hỗ trợ Mobile kết nối trục tiếp
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header('Content-Type: application/json; charset=utf-8');
    }

    /**
     * API: Lấy toàn bộ danh sách chương trình tập (Không yêu cầu Token)
     */
    public function index() {
        $data = $this->Program_Model->get_all();
        output_json(true, 'Success', $data);
    }

    /**
     * API: Bộ lọc danh sách chương trình tập nâng cao (Không bắt buộc Token)
     * URL: GET /api/program/list
     */
    public function list() {
        $type       = $this->input->get('type');
        $catalog_id = $this->input->get('catalog_id');
        $gender     = $this->input->get('gender');
        $goal     = $this->input->get('goal');
        $level      = $this->input->get('level');
        $search     = $this->input->get('search');
       $creator_id = $this->input->get('creator_id');

        $limit      = $this->input->get('limit') ? (int)$this->input->get('limit') : 20;
        $offset     = $this->input->get('offset') ? (int)$this->input->get('offset') : 0;

        // 💡 Mẹo nhỏ: Nếu client có truyền token thì bóc ra để sau này xử lý cá nhân hóa (ví dụ: xem trạng thái đã thích chưa)
        // Nếu không có token hoặc token sai, vẫn cho phép chạy tiếp chứ không ngắt (return) giữa chừng.
        // $headers = $this->input->get_request_header('Authorization', TRUE);
        $user_id = null;
        // if (!empty($headers)) {
            // Chỉ lấy ID nếu token hợp lệ, không ép văng lỗi 401 bừa bãi ở trang danh sách chung
            // $user_id = $this->_getUserIdFromTokenSilent();
            $user_id = $this->_getUserIdFromToken();
            // var_dump($user_id);
            // die;
            if (!$user_id) {
                return; // Hàm cha đã tự export lỗi 401 và exit
              }
            else{
              // var_dump($user_id);
              // die;
            }
        // }

        $data = $this->Program_Model->getPrograms(
            $catalog_id,
            $gender,
            $level,
            $limit,
            $goal,
            $offset,
            $search,
            $type,
            $creator_id
        );

        output_json(true, 'Program list', $data);
    }

    /**
     * API: Lấy danh sách ID các chương trình đã lưu của tài khoản (BẮT BUỘC Bearer Token)
     * URL mới chuẩn REST: GET /api/program/saved
     */
    // public function saved() {
    //     // Hàm này bắt buộc phải có token
    //     $user_id = $this->_getUserIdFromToken();
    //     if (!$user_id) {
    //         return; // Ngắt luôn nếu không có token (Hàm cha đã tự xuất JSON lỗi 401)
    //     }
    //
    //     $programs = $this->Program_Model->get_saved_program_ids($user_id);
    //     return output_json(true, 'Success', $programs);
    // }

    /**
     * API: Bộ lọc danh sách chương trình tập nâng cao (Không bắt buộc Token)
     */
    // public function list() {
    //     $type       = $this->input->get('type');
    //     $catalog_id = $this->input->get('catalog_id');
    //     $gender     = $this->input->get('gender');
    //     $level      = $this->input->get('level');
    //     $search     = $this->input->get('search');
    //     $creator_id = $this->input->get('creator_id');
    //
    //     $limit      = $this->input->get('limit') ? (int)$this->input->get('limit') : 20;
    //     $offset     = $this->input->get('offset') ? (int)$this->input->get('offset') : 0;
    //
    //     $data = $this->Program_Model->getPrograms(
    //         $catalog_id,
    //         $gender,
    //         $level,
    //         $limit,
    //         $offset,
    //         $search,
    //         $type,
    //         $creator_id
    //     );
    //     output_json(true, 'Program list', $data);
    // }

    /**
     * API: Chi tiết cấu trúc chương trình tập (Không yêu cầu Token)
     */
    public function detail($id) {
        if (!$id) {
            return output_json(false, 'Program ID is required');
        }

        $program = $this->Program_Model->getProgramDetail($id);
        if (!$program) {
            return output_json(false, 'Program not found');
        }

        return output_json(true, 'Success', $program);
    }

    /**
     * API: Lưu chương trình tập yêu thích (Yêu cầu Bearer Token)
     */
    public function save() {
        // Tự động giải mã Token lấy ID, nếu lỗi hàm tự xuất HTTP 401 chặn luôn logic phía sau
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $inputs = json_decode(file_get_contents('php://input'), true);
        if (empty($inputs)) {
            $inputs = $this->input->post() ?: $this->input->get();
        }

        $program_id = $inputs['program_id'] ?? null;

        if (!$program_id) {
            return output_json(false, 'Program ID required');
        }

        $this->Program_Model->save_program($user_id, $program_id);
        return output_json(true, 'Program saved');
    }

    /**
     * API: Hủy lưu chương trình tập yêu thích (Yêu cầu Bearer Token)
     */
    public function unsave() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $inputs = json_decode(file_get_contents('php://input'), true);
        if (empty($inputs)) {
            $inputs = $this->input->post() ?: $this->input->get();
        }

        $program_id = $inputs['program_id'] ?? null;

        if (!$program_id) {
            return output_json(false, 'Program ID required');
        }

        $this->Program_Model->unsave_program($user_id, $program_id);
        return output_json(true, 'Program unsaved');
    }

    /**
     * API: Lấy danh sách ID các chương trình đã lưu của tài khoản (Yêu cầu Bearer Token)
     */
    public function saved() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $programs = $this->Program_Model->get_saved_program_ids($user_id);
        return output_json(true, 'Success', $programs);
    }

    /**
     * API: Kích hoạt chương trình tập hiện tại (Yêu cầu Bearer Token)
     */
    public function active() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $inputs = json_decode(file_get_contents('php://input'), true);
        if (empty($inputs)) {
            $inputs = $this->input->post() ?: $this->input->get();
        }

        $program_id = $inputs['program_id'] ?? null;
        $start_date = $inputs['start_date'] ?? date('Y-m-d');

        if (!$program_id) {
            return output_json(false, 'Missing program_id');
        }

        // Tự động load model bổ trợ nếu chưa khai báo tự động
        $this->load->model('User_Active_Program_Model');

        // Vô hiệu hóa giáo án kích hoạt cũ trước đó của cá nhân user này
        $this->User_Active_Program_Model->update_by(
            ['is_completed' => 1],
            ['user_id' => $user_id, 'is_completed' => 0]
        );

        // Chèn bản ghi giáo án mới
        $this->User_Active_Program_Model->insert([
            'user_id' => $user_id,
            'program_id' => $program_id,
            'start_date' => $start_date,
            'is_completed' => 0
        ]);

        output_json(true, 'Program set as active');
    }

    /**
     * API: Khởi tạo giáo án mới (Yêu cầu Bearer Token)
     */
    public function create() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $program_name = $this->input->post('program_name');
        $type = $this->input->post('type');

        if (empty($program_name) || empty($type)) {
            return output_json(false, 'Invalid payload: Name and Type are required');
        }

        $image_name = $this->_uploadImage('image');

        $data = $this->input->post();
        $data['image'] = $image_name;
        $data['user_id'] = $user_id; // Ép ID chủ sở hữu lấy từ Token

        $programId = $this->Program_Model->createProgram($data);

        if (!$programId) {
            return output_json(false, 'Create program failed');
        }

        return output_json(true, 'Success', [
            'program_id' => $programId,
            'image'      => $image_name
        ]);
    }

    /**
     * API: Cập nhật thông tin giáo án (Yêu cầu Bearer Token)
     */
    public function update() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $program_id = $this->input->post('program_id');
        if (!$program_id) {
            return output_json(false, 'Missing program_id');
        }

        $program = $this->Program_Model->getById($program_id);
        if (!$program) {
            return output_json(false, 'Program not found');
        }

        // Bảo mật nâng cao: Kiểm tra xem user đang sửa có phải chủ sở hữu thật sự không
        if (isset($program->user_id) && $program->user_id != $user_id) {
            return output_json(false, 'Permission denied: You are not the owner');
        }

        $image_name = $program->image;

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            if ($program->image && file_exists('./assets/images/program/' . $program->image)) {
                @unlink('./assets/images/program/' . $program->image);
            }
            $image_name = $this->_uploadImage('image');

            if (!$image_name) {
                return output_json(false, 'Upload failed: ' . $this->upload->display_errors('', ''));
            }
        }

        $data = $this->input->post();
        $data['image'] = $image_name;

        $success = $this->Program_Model->updateProgramStructure($program_id, $data);

        if (!$success) {
            return output_json(false, 'Database update failed');
        }

        return output_json(true, 'Updated Success', [
            'program_id' => $program_id,
            'image'      => $image_name
        ]);
    }

    /**
     * API: Xóa giáo án (Yêu cầu Bearer Token)
     */
    public function delete() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $input = json_decode(file_get_contents("php://input"), true);
        $program_id = isset($input['program_id']) ? intval($input['program_id']) : 0;

        if (!$program_id) {
            return output_json(false, 'Missing program_id');
        }

        // Tự động kiểm tra quyền sở hữu và xóa an toàn trong Model
        $deleted = $this->Program_Model->delete_program($program_id, $user_id);

        if ($deleted['success']) {
            echo json_encode([
                'status' => true,
                'program_id' => $program_id
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Delete failed or you are not the owner'
            ]);
        }
    }

    /**
     * API: Lấy toàn bộ danh sách giáo án cá nhân tự biên soạn (Yêu cầu Bearer Token)
     */
    public function user_programs() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        output_json(true, 'Success', [
            'data' => $this->Program_Model->get_user_programs($user_id)
        ]);
    }

    /**
     * API: Thêm động tác vào ngày tập (Yêu cầu Bearer Token)
     */
    public function add_exercise() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['day_id']) || empty($data['exercise_id'])) {
            return output_json(false, 'Missing params');
        }

        $this->Program_Model->add_exercise_to_day($data['day_id'], $data['exercise_id']);
        output_json(true, 'add success');
    }

    /**
     * API: Gỡ động tác khỏi ngày tập (Yêu cầu Bearer Token)
     */
    public function remove_exercise() {
        $user_id = $this->_getUserIdFromToken();
        if (!$user_id) return;

        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['day_id']) || empty($data['exercise_id'])) {
            return output_json(false, 'Missing params');
        }

        $this->Program_Model->remove_exercise($data['day_id'], $data['exercise_id']);
        output_json(true, 'remove success');
    }

    /**
     * Private Helper: Xử lý lưu trữ và mã hóa file ảnh tải lên
     */
    private function _uploadImage($field_name) {
        $config['upload_path']   = './assets/images/program/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp|JPG|JPEG|PNG|WEBP';
        $config['encrypt_name']  = true;
        $config['max_size']      = 5120;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            $file_data = $this->upload->data();
            return $file_data['file_name'];
        }

        log_message('error', 'Upload Error: ' . $this->upload->display_errors());
        return null;
    }
}
