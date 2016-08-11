<?php  

class Admin extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('peserta_model');
		$username = $this->session->userdata('username');
		if (!isset($username)) {
		   redirect('login/admin');
		   exit;
		}
	}
	function index(){
		$data = array(
			'dt'		 			=> $this->peserta_model->get_all_data(),
			'title'					=> 'Daftar Peserta | Penerimaan Peserta Baru',
			'content'				=> 'admin_area'
		);
		$this->load->view('includes/template', $data);
	}
	function logout_admin(){
		$this->session->unset_userdata('username');
		redirect('login/admin');
	}
	function detail(){
		$no_pendaftaran = $this->uri->segment(3);
		$data = array(
			'data_Peserta' 		=> $this->Peserta_model->get_data_byno_pendaftaran($no_pendaftaran),
			'data_sekolah' 		=> $this->sekolah_model->get_data_byno_pendaftaran($no_pendaftaran),
			'data_nilai' 		=> $this->nilai_model->get_data_byno_pendaftaran($no_pendaftaran),
			'data_ortu' 		=> $this->orang_tua_model->get_data_byno_pendaftaran($no_pendaftaran),
			'title'		=> 'Detail Peserta | Penerimaan Peserta Baru',
			'content'	=> 'detail'
		);
		$this->load->view('includes/template', $data);
	}
	function pengumuman_lulus(){
		$data = array(
			'no_pendaftaran'		=> $this->uri->segment(3),
			'dt' 		=> $this->Peserta_model->get_all(),
			'title'		=> 'Pengumuman | Penerimaan Peserta Baru',
			'content'	=> 'pengumuman_lulus'
		);
		$this->load->view('includes/template', $data);
	}
	function cetak_pengumuman(){
		$data = array(
			'dt' 	=> $this->peserta_model->get_all_data()
		);
        $html = $this->load->view('cetak_pengumuman', $data, true);
 
        $pdfFilePath = "Pengumuman Hasil Seleksi.pdf";
 
        $this->load->library('m_pdf');
 
        $this->m_pdf->pdf->WriteHTML($html);
 
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
	}				
	function edit_Peserta(){
		$no_pendaftaran = $this->uri->segment(3);
		if (!isset($no_pendaftaran)) {
		    redirect('admin');
		    exit;
		}
		if ($this->input->post('edit')){
			$data = array(
				'skor'		=> $this->input->post('skor'),
				'hasil'		=> $this->input->post('hasil')
			);
			$this->Peserta_model->update($no_pendaftaran, $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success" style="text-align:center;">Data berhasil diedit!</div>');
			redirect('admin/edit_Peserta/'.$no_pendaftaran);
		}
		$data = array(
			'data' 		=> $this->Peserta_model->get_data_byno_pendaftaran($no_pendaftaran),
			'title'		=> 'Edit Pengumuman | Penerimaan Peserta Baru',
			'content'	=> 'edit_data_by_admin'
		);
		$this->session->set_flashdata('no_pendaftaran', $no_pendaftaran);
		$this->load->view('includes/template', $data);
	}
	function delete_Peserta(){
		$no_pendaftaran = $this->uri->segment(3);
		if(isset($no_pendaftaran)){
			$this->Peserta_model->delete($no_pendaftaran);
		} else {
			redirect('admin');
		}
		redirect('admin');
	}
}

?>