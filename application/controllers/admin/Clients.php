<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/PHPExcel/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Clients extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->breadcrumbs->unshift(1, "Clients", 'admin/clients');
        $this->load->model('common/client_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push("Client List");
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['message_public'] = (validation_errors()) ? validation_errors() : NULL;
            $this->data['client_list'] = $this->client_model->get_clients();

            $this->template->admin_render('admin/clients/index', $this->data);
        }
    }

    public function export_client() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        } else {

            $list_header = array(
                'id' => 'ID',
                'user_app_id' => 'User App ID',
                'user_fb_id' => 'User FB ID',
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'gender' => 'Gender',
                'phone_number' => 'Phone Number',
                'location' => 'Location',
                'gift_id' => 'Gift ID',
                'gift_name' => 'Gift Name',
                'created' => 'Date Created',
                'updated' => 'Date Updated'
            );

            $list_data = $this->client_model->get_clients();
            foreach ($list_data as $key => $item) {
                unset($list_data[$key]['email']);
            }
            write_excel($list_header, $list_data);
            // redirect('admin/clients', 'refresh');
        }
    }

}

function write_excel($list_header, $list_data) {

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->fromArray($list_header, '', 'A1');
    $sheet->fromArray($list_data, '', 'A2');

    foreach (range('A', 'I') as $columnID) {
        $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
    }

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="client_export.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
