<?
namespace Huiskamers;
class FormHelper {
	private $section;
	public function __construct($section){
		$this->section = $section;
	}

	public function input($field, $caption, $model, $explanation=NULL){
		$invalid_class = ($model->is_invalid($field)) ? 'class=\'form-invalid\'' : '';
		echo "<tr valign='top' $invalid_class>\n";
		echo "<th scope='row'><label for='$field'>$caption</label></th>\n";
		echo "<td>\n";
		$this->input_field($field, $caption, $model);
		if($explanation) echo "<p class='description'>$explanation</p>\n";
		echo "</td>\n";
		echo "<td>";
		echo $model->errors[$field]. "\n";
		echo "</td>\n";
		echo "</tr>\n";
	}

	public function get_lookup($options){
		$lookup_name = $options['lookup'];
		$lookup_model = "Huiskamers\\" . $options['model'];
		$lookup = array();
		if($lookup_name != NULL){
			$lookup = Lookup::$lookups[$lookup_name];
		}else if($lookup_model != NULL){
			$models = $lookup_model::all('name asc');
			$lookup[''] = 'Selecteer';
			foreach($models as $model){
				$lookup[$model->id()] = $model->name();
			}

		}
		return $lookup;
	}

	public function input_field($field, $caption, $model){
		$fields = $model->fields();
		$value = $model->$field();
		$options = $fields[$field];
		$type = $options['type'];
		if($type == 'dropdown'){
			$lookup = $this->get_lookup($options);
			$this->select_field($field, $caption, $value, $lookup);
		}else if($type == 'multiple_dropdown'){
			$lookup = $this->get_lookup($options);
			$this->multiple_select_field($field, $caption, $value, $lookup);
		}else if($type == 'number'){
			$this->input_string_field($field, $caption, $model);			
		}else if($type == 'boolean'){
			$this->input_boolean_field($field, $caption, $value);			
		}else if ($type == 'text'){
			$this->input_text_field($field, $caption, $model);			
		}else{
			$this->input_string_field($field, $caption, $model);			
		}
	}

	public function input_boolean_field($field, $caption, $value) {
		$checked = ($value == 1) ? 'checked' : '';
		$section = $this->section;
		echo "<input type='checkbox' name='{$section}[{$field}]' $checked value='1' />";
	}

	public function multiple_select_field($field, $caption, $value, $options){
		$values = explode(",", $value);
		$values = array_map(function($m) {return substr($m, 1, -1);}, $values);
		$nodisplay = 'display:none;';
		echo "<div class='multiple-select-container'>\n";
		foreach($values as $value){
			echo "<div class='multiple-select'>\n";
		
			$this->select_field($field, $caption, $value, $options, 0);

			echo "&nbsp;&nbsp;<a class='delete' style='color:#a00;$nodisplay' href='#'>Delete</a>";
			echo "</div>\n";
			$nodisplay = '';
		}
		echo "<a href='#' class='add'>Add</a>";
		echo "</div>\n";

	}

	public function select_field($field, $caption, $value, $options, $counter=''){
		$section = $this->section;

		$index = ($counter === '')? '' : "[]";
		echo "<select style='width:350px' name='{$section}[{$field}]$index'>\n";
		foreach($options as $option_key => $option_value){
			$selected = (intval($option_key) == intval($value))?'selected':'';
			$option = esc_attr($option);

			echo "<option value='$option_key' $selected>$option_value</option>\n";
		}
		echo "</select>\n";
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