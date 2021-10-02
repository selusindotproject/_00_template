<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T86_groups extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T86_groups_model');
        $this->load->library('form_validation');
		$this->load->library('datatables');
    }

    public function index()
    {
        // $this->load->view('t86_groups/t86_groups_list');

        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		} else {
            $data['hakAkses'] = getHakAkses(substr($this->uri->segment(1), 4));
            $this->session->set_userdata('hakAkses'.substr($this->uri->segment(1), 4), $data['hakAkses']);
            $data['_view'] = 't86_groups/t86_groups_list';
            $data['_caption'] = 'Groups';
            $this->load->view('_00_dashboard/_00_dashboard', $data);
        }
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->T86_groups_model->json();
    }

    public function read($id)
    {
        $row = $this->T86_groups_model->get_by_id($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'name' => $row->name,
				'description' => $row->description,
	    	);
            $this->load->view('t86_groups/t86_groups_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t86_groups'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('t86_groups/create_action'),
		    'id' => set_value('id'),
		    'name' => set_value('name'),
		    'description' => set_value('description'),
		);
        // $this->load->view('t86_groups/t86_groups_form', $data);
        $data['_view'] = 't86_groups/t86_groups_form';
        $data['_caption'] = 'Groups';
        $this->load->view('_00_dashboard/_00_dashboard', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'name' => $this->input->post('name',TRUE),
				'description' => $this->input->post('description',TRUE),
	    	);
            $this->T86_groups_model->insert($data);

            // create hak akses untuk groups baru
            createHakAkses($this->db->insert_id());

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t86_groups'));
        }
    }

    public function update($id)
    {
        $row = $this->T86_groups_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('t86_groups/update_action'),
				'id' => set_value('id', $row->id),
				'name' => set_value('name', $row->name),
				'description' => set_value('description', $row->description),
	    	);
            // $this->load->view('t86_groups/t86_groups_form', $data);
            $data['_view'] = 't86_groups/t86_groups_form';
            $data['_caption'] = 'Groups';
            $this->load->view('_00_dashboard/_00_dashboard', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t86_groups'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
				'name' => $this->input->post('name',TRUE),
				'description' => $this->input->post('description',TRUE),
	    	);
            $this->T86_groups_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t86_groups'));
        }
    }

    public function delete($id)
    {
        $row = $this->T86_groups_model->get_by_id($id);
        if ($row) {
            $this->T86_groups_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t86_groups'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t86_groups'));
        }
    }

    public function _rules()
    {
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t86_groups.xls";
        $judul = "t86_groups";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Name");
		xlsWriteLabel($tablehead, $kolomhead++, "Description");

		foreach ($this->T86_groups_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->name);
		    xlsWriteLabel($tablebody, $kolombody++, $data->description);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t86_groups.doc");

        $data = array(
            't86_groups_data' => $this->T86_groups_model->get_all(),
            'start' => 0
        );

        $this->load->view('t86_groups/t86_groups_doc',$data);
    }

}

/* End of file T86_groups.php */
/* Location: ./application/controllers/T86_groups.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-30 10:35:09 */
/* http://harviacode.com */
