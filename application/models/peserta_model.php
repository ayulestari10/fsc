<?php  

class Peserta_model extends CI_Model{
	private $table;
	private $key;

	function __construct(){
		parent::__construct();
		$this->table 	= 'admin';
		$this->key 		= 'username';
	}

	function get_all(){
		$query = $this->db->get($this->table); 
		return $query->result();
	}

	function get_data_byKey($username){
		$this->db->where($this->key, $username); 
		$query = $this->db->get($this->table);
		return $query->row();
	}

	function get_username($username){
		$this->db->where($this->key, $username); 
		$query = $this->db->get($this->table);
		foreach($query->result() as $row){
			$username = $row->username;
		}
		return $username;
	}

	function get_id_admin(){
		$this->db->where($this->key, $username); 
		$query = $this->db->get($this->table);
		foreach($query->result() as $row){
			$id_admin = $row->id_admin;
		}
		return $id_admin;
	}

	function insert($data){
		return $this->db->insert($this->table, $data); 
	}

	function update($username, $data){
		$this->db->where($this->key, $username); 
		return $this->db->update($this->table, $data);
	}

	function delete($username){
		return $this->db->delete($this->table, array($this->key => $username)); 
	}

	function get_data_byConditional($condition){
		$this->db->where($condition);
		$query = $this->db->get($this->table);
		return $query;
	}

	function get_all_data(){
		$data = $this->db->query('SELECT siswa.no_pendaftaran,siswa.nama,sekolah.nama_sekolah,siswa.skor, siswa.hasil FROM siswa LEFT JOIN sekolah ON siswa.no_pendaftaran=sekolah.no_pendaftaran');
		return $data->result();
	}

}

?>