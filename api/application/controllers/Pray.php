<?php

/**
 * @property Product_Model $product_model
 */
class Pray extends FONTEND_Controller {

    public function __construct() {
        parent::__construct();

    }


    function index() {
        // full cat by hirachiavy
        $question = $this->input->post('question');

        $this->load->model('ebook_model');
        $retVal = $this->ebook_model->get_random_page_by_type();
        if($this->is_vietnamese($question)){
          $this->data['answer'] = $retVal->page_content_vn;
        }else{
          $this->data['answer'] = $retVal->page_content_en;
        }
        $this->data['question'] = $question;
        // $this->template->write_view('content_block', $this->folder . 'result', $this->data);
        // $this->template->render();

        $this->load->view( $this->folder . 'result', $this->data);
    }

    function is_vietnamese($text) {
      // Regex includes most common Vietnamese accented characters
      return preg_match('/[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/iu', $text);
    }


}
