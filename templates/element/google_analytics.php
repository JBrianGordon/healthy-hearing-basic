<!-- Datalayer pushes -->
<?php
	$show = isset($show) ? $show : true;
	if ($show) {
	    if (isset($customVars) && is_array($customVars) && count($customVars) > 0) {
	        echo "<script>\n";
	        echo "window.dataLayer = window.dataLayer || [];\n";
	        foreach ($customVars as $key => $value) {
	            $slot = 1;
	            if (strpos($key, "|") !== false) {
	                list($key, $slot) = explode("|", $key);
	            }
	            $value = str_replace("'", "\'", $value); //escape ' characters
	            echo "window.dataLayer.push({\n";
	            echo "'slot{$slot}-name': '{$key}',\n";
	            echo "'slot{$slot}-value': '{$value}',\n";
	            echo "'slot{$slot}-scope': '3'\n";
	            echo "});\n";
	        }
	        echo "</script>\n";
	    }
	}
?>