<? 
namespace Huiskamers;
class OptionsController {
	public function route() {
		$this->show_page();
	}

	public function show_page() {
		include plugin_dir_path( __FILE__ ) . "../../views/options.php";
	}
}
?>