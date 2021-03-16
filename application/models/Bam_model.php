<?php
class Bam_model extends CI_Model
{
	function load_data()
	{
		$this->db->select('books.book_name,authors.author_name,authors.author_id,books.book_id');
		$this->db->from('authors');
		$this->db->join('author_book_mapping','authors.author_id = author_book_mapping.author_id');
		$this->db->join('books','books.book_id=author_book_mapping.book_id');
		$this->db->order_by('authors.author_id', 'DESC');
		$data = $this->db->get()->result_array();
		return $data;
	}

	function insert($data)
	{
		$book_author_mapping=["author_id"=>"","book_id"=>""];
		foreach($data as $key=>$value)
		{
			 if($key=='author_name')
			 {
				 //insert in author table
				 $this->db->insert('authors', array("author_name"=>$value));
				 echo $this->db->last_query();
				 $insert_id = $this->db->insert_id();
				 $book_author_mapping['author_id']=$insert_id;
			 }
			 if($key=='book_name')
			 {
				 //insert in books
				 $this->db->insert('books', array("book_name"=>$value));
				 echo $this->db->last_query();
				 $insert_id = $this->db->insert_id();
				 $book_author_mapping['book_id']=$insert_id;

			 }
		}
		$this->db->insert('author_book_mapping', $book_author_mapping); 
		echo $this->db->last_query();

		unset($book_author_mapping);
	}

	function update($data, $id)
	{
		if(!empty($data['book_name'])){
		   $this->db->where('book_id', $id);
		   $this->db->update('books', $data);

		}
		else{
           $this->db->where('author_id', $id);
		   $this->db->update('authors', $data);
		}
		echo $this->db->last_query();

	}

	function delete($id)
	{
		$getIds=explode(',',$id);
		print_r($getIds);
		echo $getIds[0];
		$this->db->where('author_id',$getIds[0]);
		$this->db->delete('authors');
		echo $this->db->last_query();

		$this->db->where('book_id',$getIds[1]);
		$this->db->delete('books');

		$this->db->where('book_id',$getIds[1]);
		$this->db->where('author_id',$getIds[0]);
		$this->db->delete('author_book_mapping');

	}

	function search($search_keyword)
	{
		$this->db->select('books.book_name,authors.author_name,authors.author_id,books.book_id');
		$this->db->from('authors');
		$this->db->join('author_book_mapping','authors.author_id = author_book_mapping.author_id');
		$this->db->join('books','books.book_id=author_book_mapping.book_id');
		$this->db->like('books.book_name',$search_keyword);
		$this->db->or_like('authors.author_name',$search_keyword);
		$this->db->order_by('authors.author_id', 'DESC');
		$data = $this->db->get()->result_array();
		return $data;
	}
}
?>