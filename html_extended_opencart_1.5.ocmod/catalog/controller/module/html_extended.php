<?php
class ControllerModuleHTMLExtended extends Controller {
	public function index($setting) {
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$this->data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$this->data['html'] = $this->_render($setting['module_description'][$this->config->get('config_language_id')]['description']);

            $this->template = 'module/html_extended.tpl';
            $this->children = array(
                'common/header',
                'common/footer'
            );

			return $this->render();
		}
	}

    private function _render($content) {

        $html = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

        if (preg_match('|<\?php.+?\?>|isu', $html)) {

            ob_start();
            @eval('?>' . $html);
            $html = ob_get_contents();
            ob_end_clean();

        }

        return $html;
    }
}