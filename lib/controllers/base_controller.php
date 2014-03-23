<?
namespace Huiskamers;
abstract class BaseController {
	public function methods(){ 
		return array('index', 'show', 'insert', 'edit', 'create', 'update', 'delete');
	}

	public function get_namespace() {
		return trim(strtolower(__NAMESPACE__));
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
		$namespace_length = strlen($this->get_namespace()) + 1;
		// chop off the 'Controller' part and the 'Huiskamers' part
		$section_name = strtolower(substr($my_class,$namespace_length,-10));
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
		$namespace = $this->get_namespace();
		$url = "?page={$namespace}_$section&method=$method";
		if ($id != NULL){
			$url .= "&id=$id";
		}
		return $url;
	}

	public function index($id) {
		$section = $this->section();
		$model_name = $this->model();
		$models = $model_name::where('1=1');

		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}/index.php" );
	}

	public function insert($id) {
		$section = $this->section();
		$form_mode = 'create';
		$model_name = $this->model();
		$model = new $model_name();
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}/form.php" );	
	}

	public function edit($id) {
		$section = $this->section();
		$model_name = $this->model();
		$model = $model_name::find($id);
		$form_mode = 'update';
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}/form.php" );	
	}

	public function create($id) {
		$section = $this->section();
		$model_name = $this->model();
		$model = new $model_name($_POST[$section]);
		$model->create();
		$this->redirect('index');
	}

	public function update($id) {
		$section = $this->section();
		$model_name = $this->model();
		$model = $model_name::find($id);
		$model->update_fields($_POST[$section]);
		$model->save();
		$this->redirect('index');
	}

	public function delete($id) {
		$section = $this->section();
		$model_name = $this->model();
		$model = $model_name::find($id);
		$model->delete();
		$this->redirect('index');
	}

	public function show($id) {
		$section = $this->section();
		$model_name = $this->model();
		$model = $model_name::find($id);
		include( plugin_dir_path( __FILE__ ) . "../../views/{$section}/show.php" );	
	}

	public function redirect($method, $id=NULL){
		$this->redirect_url($this->url($method, $id));
	}

	public function redirect_url($url){
		include( plugin_dir_path( __FILE__ ) . "../../views/redirect.php" );	
	}
}
?>