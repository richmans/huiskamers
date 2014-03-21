<?
namespace Huiskamers;
abstract class BaseController {
	public function methods(){ 
		return array('index', 'show', 'insert', 'edit', 'save', 'delete');
	}

	// returns the model class associated with this controller
	public function model() {
		// get my own classname
		$my_class = get_called_class();
		// chop off the 'Controller' part
		$model_name = substr($my_class,0,-10);
		return $model_name;
	}

	// returns the section name (as shown in the page url var)
	public function section() {
		// get my own classname
		$my_class = get_called_class();
		// chop off the 'Controller' part and the 'Huiskamers' part
		$section_name = strtolower(substr($my_class,11,-10));
		return $section_name;
	}

	public function route() {
		$method = $_GET['method'];
		$id = $_GET['id'];
		if (!in_array($method, $this->methods())) {
			$method = 'index';
		}
		$this->$method($id);

	}

	public function url($method, $id=NULL){
		$section = $this->section();
		$url = "?page=huiskamers_$section&method=$method";
		if ($id != NULL){
			$url .= "&id=$id";
		}
		return $url;
	}

	public function index($id) {
		$section = $this->section();
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}_index.php" );
	}

	public function insert($id) {
		$section = $this->section();
		$form_mode = 'new';
		$model = $this->model();
		$region = new $model();
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}_form.php" );	
	}

	public function edit($id) {
		$section = $this->section();
		$model = $this->model();
		$region = $model::find($id);
		$form_mode = 'edit';
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}_form.php" );	
	}
}
?>