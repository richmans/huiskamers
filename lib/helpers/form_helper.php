<?
namespace Huiskamers;
class FormHelper {
	private $section;
	public function __construct($section){
		$this->section = $section;
	}

	public function input($field, $caption, $model){
		$invalid_class = ($model->is_invalid('name')) ? 'class=\'form-invalid\'' : '';
		echo "<tr valign='top' $invalid_class>\n";
		echo "<th scope='row'><label for='$field'>$caption</label></th>\n";
		echo "<td>\n";
		$this->input_field($field, $caption, $model);
		echo "</td>\n";
		echo "<td>";
		echo $model->errors[$field]. "\n";
		echo "</td>\n";
		echo "</tr>\n";
	}

	public function input_field($field, $caption, $model){
		$fields = $model->fields();
		$options = $fields[$field];
		$type = $options['type'];
		if($type == 'number'){
			$this->input_string_field($field, $caption, $model);			
		}else if ($type == 'text'){
			$this->input_text_field($field, $caption, $model);			
		}else{
			$this->input_string_field($field, $caption, $model);			
		}
	}

	public function input_text_field($field, $caption, $model){
		$value = esc_html($model->$field());
		$section = $this->section;
		echo "<textarea style='width:350px' name='{$section}[{$field}]' type='text' id='{$section}_{$field}'>$value</textarea>";
	}

	public function input_string_field($field, $caption, $model){
		$value = esc_attr($model->$field());
		$section = $this->section;
		echo "<input name='{$section}[{$field}]' type='text' id='{$section}_{$field}' value='$value' class='regular-text' autocomplete='off'/>";
	}
}
?>