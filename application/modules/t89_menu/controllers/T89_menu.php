<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T89_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T89_menu_model');
        $this->load->library('form_validation');
		$this->load->library('datatables');
    }

    public function index()
    {
        // $this->load->view('t89_menu/t89_menu_list');

        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		} else {
            $data['hakAkses'] = getHakAkses(substr($this->uri->segment(1), 4));
            $this->session->set_userdata('hakAkses'.substr($this->uri->segment(1), 4), $data['hakAkses']);
            $data['_view'] = 't89_menu/t89_menu_list';
            $data['_caption'] = 'Menu';
            $this->load->view('_00_dashboard/_00_dashboard', $data);
        }
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->T89_menu_model->json();
    }

    public function read($id)
    {
        $row = $this->T89_menu_model->get_by_id($id);
        if ($row) {
            $data = array(
				'id' => $row->id,
				'kode' => $row->kode,
				'nama' => $row->nama,
	    	);
            $this->load->view('t89_menu/t89_menu_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t89_menu'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('t89_menu/create_action'),
		    'id' => set_value('id'),
		    'kode' => set_value('kode'),
		    'nama' => set_value('nama'),
		);
        // $this->load->view('t89_menu/t89_menu_form', $data);
        $data['_view'] = 't89_menu/t89_menu_form';
        $data['_caption'] = 'Menu';
        $this->load->view('_00_dashboard/_00_dashboard', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'kode' => $this->input->post('kode',TRUE),
				'nama' => $this->input->post('nama',TRUE),
	    	);
            $this->T89_menu_model->insert($data);

            // update menu baru untuk hak akses semua groups
            if ($this->input->post('nama',TRUE) != '#') {
                updateHakAkses($this->db->insert_id());
            }

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t89_menu'));
        }
    }

    public function update($id)
    {
        $row = $this->T89_menu_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('t89_menu/update_action'),
				'id' => set_value('id', $row->id),
				'kode' => set_value('kode', $row->kode),
				'nama' => set_value('nama', $row->nama),
	    	);
            // $this->load->view('t89_menu/t89_menu_form', $data);
            $data['_view'] = 't89_menu/t89_menu_form';
            $data['_caption'] = 'Menu';
            $this->load->view('_00_dashboard/_00_dashboard', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t89_menu'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
				'kode' => $this->input->post('kode',TRUE),
				'nama' => $this->input->post('nama',TRUE),
	    	);
            $this->T89_menu_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t89_menu'));
        }
    }

    public function delete($id)
    {
        $row = $this->T89_menu_model->get_by_id($id);
        if ($row) {
            $this->T89_menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t89_menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t89_menu'));
        }
    }

    public function _rules()
    {
		$this->form_validation->set_rules('kode', 'Kode', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t89_menu.xls";
        $judul = "t89_menu";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Kode");
		xlsWriteLabel($tablehead, $kolomhead++, "Nama");

		foreach ($this->T89_menu_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
		    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
		    xlsWriteLabel($tablebody, $kolombody++, $data->nama);

		    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t89_menu.doc");

        $data = array(
            't89_menu_data' => $this->T89_menu_model->get_all(),
            'start' => 0
        );

        $this->load->view('t89_menu/t89_menu_doc',$data);
    }

}

/* End of file T89_menu.php */
/* Location: ./application/controllers/T89_menu.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-09-30 10:29:00 */
/* http://harviacode.com */
