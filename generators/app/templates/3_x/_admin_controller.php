<?php

class Controller<%= classified_name %> extends Controller {
	
	private $error = array(); 
	
	public function index() {   
	
		//Load language file
		$this->load->language('extension/<%= module_type %>/<%= underscored_name %>');

		//Set title from language file
		$this->document->setTitle($this->language->get('heading_title'));
		
		//Load settings model
		$this->load->model('setting/setting');
		
		//Save settings
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('<%= underscored_name %>', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('marketplace/extension', 'user_user_token=' . $this->session->data['user_token'] . '&type=<%= module_type %>', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=<%= module_type %>', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/<%= module_type %>/<%= underscored_name %>', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/<%= module_type %>/<%= underscored_name %>', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=<%= module_type %>', true);


		if (isset($this->request->post['<%= module_type %>_<%= underscored_name %>_status'])) {
			$data['<%= module_type %>_<%= underscored_name %>_status'] = $this->request->post['<%= module_type %>_<%= underscored_name %>_status'];
		} else {
			$data['<%= module_type %>_<%= underscored_name %>_status'] = $this->config->get('<%= module_type %>_<%= underscored_name %>_status');
		}

				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		//Send the output
		$this->response->setOutput($this->load->view('extension/<%= module_type %>/<%= underscored_name %>', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/<%= module_type %>/<%= underscored_name %>')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


}