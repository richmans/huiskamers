<?
namespace Huiskamers;
abstract class BaseController {
	public function methods(){ 
		return array('index', 'show', 'edit', 'save', 'delete');
	}

	public function route() {
		$method = $_GET['method'];
		$id = $_GET['id'];
		if (!in_array($method, $this->methods())) {
			$method = 'index';
		}
		$this->$method($id);

	}

	public function index($id) {
		$section = $this->section();
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}_index.php" );
	}
}
?>