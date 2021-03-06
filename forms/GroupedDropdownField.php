<?php
/**
 * Grouped dropdown, using <optgroup> tags.
 * 
 * $source parameter (from DropdownField) must be a two dimensional array.
 * The first level of the array is used for the <optgroup>, and the second
 * level are the <options> for each group.
 * 
 * Returns a <select> tag containing all the appropriate <option> tags, with
 * <optgroup> tags around the <option> tags as required.
 * 
 * <b>Usage</b>
 * 
 * <code>
 * new GroupedDropdownField(
 *    $name = "dropdown",
 *    $title = "Simple Grouped Dropdown",
 *    $source = array(
 *       "numbers" => array(
 *       		"1" => "1",
 *       		"2" => "2",
 *       		"3" => "3",
 *       		"4" => "4"
 *    		),
 *       "letters" => array(
 *       		"1" => "A",
 *       		"2" => "B",
 *       		"3" => "C",
 *       		"4" => "D",
 *       		"5" => "E",
 *       		"6" => "F"
 *    		)
 *    )
 * )
 * </code>
 * 
 * <b>Disabling individual items</b>
 * 
 * <code>
 * $groupedDrDownField->setDisabledItems( 
 *    array(
 *       "numbers" => array(
 *       		"1" => "1",
 *       		"3" => "3"
 *    		),
 *       "letters" => array(
 *       		"3" => "C"
 *    		)
 *    )
 * )
 * </code>
 * 
 * @package forms
 * @subpackage fields-basic
 */
class GroupedDropdownField extends DropdownField {

	public function Field($properties = array()) {
		$options = '';
		foreach($this->getSource() as $value => $title) {
			if(is_array($title)) {
				$options .= "<optgroup label=\"$value\">";
				foreach($title as $value2 => $title2) {
					$disabled = '';
					if( array_key_exists($value, $this->disabledItems)
							&& is_array($this->disabledItems[$value]) 
							&& in_array($value2, $this->disabledItems[$value]) ){
						$disabled = 'disabled="disabled"';
					}
					$selected = $value2 == $this->value ? " selected=\"selected\"" : "";
					$options .= "<option$selected value=\"$value2\" $disabled>$title2</option>";
				}
				$options .= "</optgroup>";
			} else { // Fall back to the standard dropdown field
				$disabled = '';
				if( in_array($value, $this->disabledItems) ){
					$disabled = 'disabled="disabled"';
				}
				$selected = $value == $this->value ? " selected=\"selected\"" : "";
				$options .= "<option$selected value=\"$value\" $disabled>$title</option>";
			}
		}

		return $this->createTag('select', $this->getAttributes(), $options);
	}

	public function Type() {
		return 'groupeddropdown dropdown';
	}
	
}

