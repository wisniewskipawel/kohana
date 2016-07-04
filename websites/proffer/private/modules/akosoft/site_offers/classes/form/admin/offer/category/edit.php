<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Category_Edit extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms.categories');

		/** @var Model_Offer_Category $category */
		$category = $params['category'];
		$this->form_data($category->as_array());

		$this->add_input_text('category_name', array());
		
		$this->add_textarea('category_meta_description', array('required' => FALSE));
		
		$this->add_textarea('category_meta_keywords', array('required' => FALSE));
		
		$this->add_input_text('category_meta_robots', array('required' => FALSE));
		
		$this->add_input_text('category_meta_revisit_after', array('required' => FALSE));
		
		$this->add_input_text('category_meta_title', array());
		
		$this->add_textarea('category_text', array('required' => FALSE));
		
		$this->add_bool('category_age_confirm', array());

		$this->add_fieldset('image', $this->trans('image'));

		if($category->has_image())
		{
			$this->image->add_html(HTML::image(
					img::path_uri('offer_category', 'offer_category_medium',
						$category->pk(),
						$category->category_image
					)).HTML::anchor('admin/offer/categories/delete_image/'.$category->pk(), ___('images.delete_btn'))
			);
		}

		$this->image->add_input_file('image', array(
			'html_before' => ___('offers.forms.categories.image_info'),
			'required' => FALSE,
		))
			->add_validator('image', 'Bform_Validator_File_Filesize', array('filesize' => '1M'))
			->add_validator('image', 'Bform_Validator_File_Image');

		if($category->category_level == 2)
		{
			$icon_path = $category->get_icon_uri();

			$this->add_fieldset('icon', $this->trans('icon'));

			if($icon_path)
			{
				$this->icon->add_html(
					HTML::image($icon_path, array('style' => 'max-width:100px')).
					HTML::anchor(
						'admin/offer/categories/delete_icon/'.$category->pk(),
						$this->trans('delete_icon')
					)
				);
			}

			$this->icon->add_input_file('icon', array('label' => $this->trans('icon'), 'required' => FALSE))
				->add_validator('icon', 'Bform_Validator_File_Image');
		}

		$this->add_input_submit(___('form.save'));
	}

}
