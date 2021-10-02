<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T90_groups_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T90_groups_menu_model');
        $this->load->library('form_validation');
		$this->load->library('datatables');
    }

    public function index()
    {
        // $this->load->view('t90_groups_menu/t90_groups_menu_list');
        $data['hakAkses'] = getHakAkses(substr($this->uri->segment(1), 4));
        $this->session->set_userdata('hakAkses'.substr($this->uri->segment(1), 4), $data['hakAkses']);
        $data['_view'] = 't90_groups_menu/t90_groups_menu_list';
        $data['_caption'] = 'Groups_menu';
        $this->load->view('_00_dashboard/_00_dashboard', $data);
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->T90_groups_menu_model->json();
    }

    public function read($id)
    {
        $row = $this->T90_groups_menu_model->get_by_id($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'idgroups' => $row->idgroups,
				'idmenu' => $row->idmenu,
				'rights' => $row->rights,
	    	);
            $this->load->view('t90_groups_menu/t90_groups_menu_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t90_groups_menu'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('t90_groups_menu/create_action'),
		    'id' => set_value('id'),
		    'idgroups' => set_value('idgroups'),
		    'idmenu' => set_value('idmenu'),
		    'rights' => set_value('rights'),
		);
        // $this->load->view('t90_groups_menu/t90_groups_menu_form', $data);
        $data['_view'] = 't90_groups_menu/t90_groups_menu_form';
        $data['_caption'] = 'Groups_menu';
        $this->load->view('_00_dashboard/_00_dashboard', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'idgroups' => $this->input->post('idgroups',TRUE),
				'idmenu' => $this->input->post('idmenu',TRUE),
				'rights' => $this->input->post('rights',TRUE),
	    	);
            $this->T90_groups_menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t90_groups_menu'));
        }
    }

    public function update($id)
    {
        // $row = $this->T90_groups_menu_model->get_by_id($id);
        $dataGroups = $this->T90_groups_menu_model->getAllByIdGroups($id);
        if ($dataGroups) {

            $data = array(
                'button' => 'Simpan',
                'action' => site_url('t90_groups_menu/update_action'),
				// 'id' => set_value('id', $row->id),
				// 'idgroups' => set_value('idgroups', $row->idgroups),
				// 'idmenu' => set_value('idmenu', $row->idmenu),
				// 'rights' => set_value('rights', $row->rights),
                'dataGroups' => $dataGroups,
	    	);
            // $this->load->view('t90_groups_menu/t90_groups_menu_form', $data);
            $data['_view'] = 't90_groups_menu/t90_groups_menu_form';
            $data['_caption'] = 'Hak Akses';
            $this->load->view('_00_dashboard/_00_dashboard', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t86_groups'));
        }
    }

    public function update_action()
    {
        // $this->_rules();
        // if ($this->form_validation->run() == FALSE) {
        //     $this->update($this->input->post('id', TRUE));
        // } else {
        //     $data = array(
		// 		'idgroups' => $this->input->post('idgroups',TRUE),
		// 		'idmenu' => $this->input->post('idmenu',TRUE),
		// 		'rights' => $this->input->post('rights',TRUE),
	    // 	);
        //     $this->T90_groups_menu_model->update($this->input->post('id', TRUE), $data);
        //     $this->session->set_flashdata('message', 'Update Record Success');
        //     redirect(site_url('t90_groups_menu'));
        // }

        $data = $this->input->post();
        foreach($data['idgroupsmenu'] as $key => $value) {
            $idgroupsmenu = $value;
            $rights =
                $this->input->post('_1_'.$value, true)
                + $this->input->post('_2_'.$value, true)
                + $this->input->post('_4_'.$value, true);
            $detail = array(
                'rights' => $rights,
            );
            $this->T90_groups_menu_model->update($value, $detail);
        }
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url('t86_groups'));
    }

    public function delete($id)
    {
        $row = $this->T90_groups_menu_model->get_by_id($id);
        if ($row) {
            $this->T90_groups_menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t90_groups_menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t90_groups_menu'));
        }
    }

    public function _rules()
    {
		$this->form_validation->set_rules('idgroups', 'Idgroups', 'trim|required');
		$this->form_validation->set_rules('idmenu', 'Idmenu', 'trim|required');
		$this->form_validation->set_rules('rights', 'Rights', 'trim|required');
		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t90_groups_menu.xls";
        $judul = "t90_groups_menu";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
		xlsWriteLabel($tablehead, $kolomhead++, "Idgroups");
		xlsWriteLabel($tablehead, $kolomhead++, "Idmenu");
		xlsWriteLabel($tablehead, $kolomhead++, "Rights");

		foreach ($this->T90_groups_menu_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->idgroups);
		    xlsWriteNumber($tablebody, $kolombody++, $data->idmenu);
		    xlsWriteNumber($tablebody, $kolombody++, $data->rights);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t90_groups_menu.doc");

        $data = array(
            't90_groups_menu_data' => $this->T90_groups_menu_model->get_all(),
            'start' => 0
        );

        $this->load->view('t90_groups_menu/t90_groups_menu_doc',$data);
    }

}

/* End of file T90_groups_menu.php */
/* Location: ./application/controllers/T90_groups_menu.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-30 11:17:05 */
/* http://harviacode.com */
