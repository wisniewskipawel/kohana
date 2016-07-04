<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Catalog_Company_Review extends ORM {
	
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	
	protected $_table_name = 'catalog_company_reviews';
	
	protected $_belongs_to = array(
		'company' => array('model' => 'Catalog_Company', 'foreign_key' => 'company_id'),
	);
	
	protected $_created_column = array(
		'column' => 'date_created',
		'format' => 'Y-m-d H:i:s',
	);
	
	protected $_updated_column = array(
		'column' => 'date_updated',
		'format' => 'Y-m-d H:i:s',
	);
	
	public function has_company()
	{
		return $this->company_id && $this->company->loaded();
	}
	
	public function add_review(Model_Catalog_Company $company, $values)
	{
		$this->values($values, array(
			'email', 'rating', 'comment_body', 'comment_author',
		));
		
		$this->company_id = $company->pk();
		$this->status = Kohana::$config->load('modules.site_catalog.settings.reviews.moderate.disabled') ? 
			self::STATUS_ACTIVE : self::STATUS_INACTIVE;
		$this->ip_address = Request::$client_ip;
		$this->is_sended = FALSE;
		
		$this->save();
		
		return $this->saved();
	}
	
	public function edit_review($values)
	{
		$this->values($values, array(
			'email', 'rating', 'comment_body', 'comment_author',
		));
		
		$this->save();
		
		return $this->saved();
	}
	
	public function change_status($new_status)
	{
		$this->status = (int)$new_status;
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_company(Model_Catalog_Company $company)
	{
		return $this->where('company_id', '=', (int)$company->pk());
	}
	
	public function filter_by_comments()
	{
		return $this->where('comment_body', '!=', '');
	}
	
	public function filter_by_active()
	{
		return $this->where('status', '=', self::STATUS_ACTIVE);
	}
	
	public function find_all(Pagination $pagination = NULL)
	{
		if($pagination)
		{
			$this->limit($pagination->items_per_page)
				->offset($pagination->offset);
		}
		
		return parent::find_all();
	}
	
	public function company_reviews_query()
	{
		$query = DB::select(
				array('company_id', 'r_company_id'), 
				array(DB::expr('COUNT(*)'), 'count_reviews'),
				array(DB::expr('COUNT(IF(ccr.comment_body != \'\', 1, NULL))'), 'count_comments'),
				array(DB::expr('SUM(ccr.rating)/COUNT(*)'), 'rating')
			)
			->from(array($this->table_name(), 'ccr'))
			->where('ccr.status', '=', self::STATUS_ACTIVE)
			->group_by('ccr.company_id');
	
		return $query;
	}
	
	public function delete_by_company($company)
	{
		if(empty($company))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('company_id', is_array($company) ? 'IN' : '=', $company)
			->execute($this->_db);
	}
	
	public function send_new_review()
	{
		if(!$this->is_sended AND $this->status == self::STATUS_ACTIVE)
		{
			$this->is_sended = TRUE;
			$this->save();
			
			$email = new Model_Email;
			$email->find_by_alias('catalog.new_review');
			
			if($email->loaded())
			{
				$email->set_tags(array(
					'%review.email%' => $this->email, 
					'%review.rating%' => $this->rating, 
					'%review.comment_body%' => $this->comment_body, 
					'%review.comment_author%' => $this->comment_author,
					'%company.link%' => catalog::url($this->company),
				));
				
				$this->company->send_email_message($email);
			}
		}
	}
	
	public static function count_comments_by_company(Model_Catalog_Company $company)
	{
		$self = new self;
		$self->filter_by_company($company)
			->filter_by_comments()
			->filter_by_active();
		
		return $self->count_all();
	}
	
	public static function find_comments_by_company(Model_Catalog_Company $company, Pagination $pagination = NULL)
	{
		$self = new self;
		$self->filter_by_company($company)
			->filter_by_comments()
			->filter_by_active();
		
		return $self->find_all($pagination);
	}
	
}
