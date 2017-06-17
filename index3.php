<?php
include 'head_javascript.php';
include 'config.php';
include 'function.php';
include 'style.php';

if(isset($_POST['setup']))
{
    $writetxt = array();
    try {
        foreach ($_POST as $setname => $value) {
            $analysis = explode('^', str_replace('_conf', '.conf', $setname));
            $key = array_search($analysis[0], $read_conf_list);
            if ($setname == 'setup' or ($value == '' && $analysis[1] != 'import') or ($key > 7 && $analysis[1] == 'import')) {
                continue;
            }
            $setv = str_replace('import: ','',$value);
            if($analysis[1] == 'import' && !strpos($setv,"import: ")) {
                $analysis[1] = substr($value, 0, strpos($value, ":"));
                $setv = trim(substr($value, strpos($value, ":") + 1));
            }
            $writetxt[$analysis[0]][] = trim($value) == '' ? '' : $analysis[1] . ": " . $setv;
        }
        foreach ($writetxt as $confpath => $setlist) {
            if (array_search($confpath, $read_conf_list) < 8) {
                $fop = fopen($main_folder.$save_txt_[$confpath],"w");
            } else {
                $fop = fopen($main_folder.$save_txt_[$confpath],"a");
            }
            foreach ($setlist as $item) {
                $item .= $item ==''?'':"\r\n";
                fwrite($fop,$item);
            }
            fclose($fop);
        }
    }catch (Exception $e) {
        echo $e;
    }
}

$conf_file_list = get_conf_set_list($main_folder,$read_conf_list);
$save_txt_file_list = get_conf_set_list($main_folder,$save_txt);
echo "<form id='set_form' action='{$_SERVER['PHP_SELF']}' method='post'>";
echo "<div style='position: fixed;top: 20px;left: 20px;text-align: left'>";
echo "<a href='javascript:Unfolded();'>Unfolded list</a><br>";
echo "<a href='javascript:closure();'>closure list</a><br>";
echo "</div>";
echo "<div style='position: fixed;top: 20px;right: 20px;text-align: right'>";
echo "<input type='submit' name='setup' value='complete Setup' style='border-style: dotted'>";
echo "</div>";
echo "<table id='set_table' align='center' border='1' style='border-style: dashed;border-color:#FFAC55;padding:5px;text-align: center'>";
foreach ($conf_file_list as $filename => $setlist) {
    $check = true;
    echo "<tr><th id='{$filename}_conf' colspan='2' onclick='show_hide(\"$filename\");'>$filename</th><th id='{$filename}_txt' colspan='3' onclick='show_hide(\"$filename\");'>$save_txt_[$filename]</th><td><input type='submit' value='cleanAll' onclick='cleanall(\"$filename\");return false;'></td></tr>";
    echo "<tbody id='$filename' style='display: none'>";
    $index = 0;
    foreach ($setlist as $setname => $value) {
        $index++;
        if ($setname != 'import') {
            $value[1] = str_replace("'",$symbol,$value[1]);
            $value[1] = str_replace('"',$dsymbol,$value[1]);
            $value[1] = trim($value[1]);
            echo "<tr>";
            echo "<td title='$value[1]'><b>$setname</b></td><td style='color: $conf_set' title='$value[1]'><I>$value[0]</I></td>";
            $inputid = $filename . "^" . $index;
            $inputname = $filename . "^" . $setname;
            $inputvalue = isset($save_txt_file_list[$save_txt_[$filename]][$setname]) ? $save_txt_file_list[$save_txt_[$filename]][$setname][0] : "";
            echo "<td title='$value[1]'><b>$setname</b></td>";
            echo "<td style='border-color: $show_set_border_color' title='$value[1]'><input style='color: $show_set_font_color' type='text' id='$inputid' name='$inputname' value='$inputvalue' onkeyup='chedklengh(this.id);check(this.id);' onClick='this.select();' spellcheck='false' onkeypress='if(event.keyCode==13)return false;'></td>";
            if($inputvalue!='') {
                echo "<script>check('$inputid');</script>";
            }
            if ($check) {
                $check = false;
                go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_,$show_set_border_color,$show_set_font_color);
            }
            echo "</tr>";
        } else {
            foreach ($value as $listindex => $item) {
                $item[1] = str_replace("'",$symbol,$item[1]);
                $item[1] = str_replace('"',$dsymbol,$item[1]);
                $item[1] = trim($item[1]);
                echo "<tr><td title='$item[1]'><b>$setname</b></td><td style='color: $conf_set' title='$item[1]'><I>$item[0]</I></td><td><input type='text' readonly></td><td><input type='text' readonly></td>";
                if ($check) {
                    $check = false;
                    go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_,$show_set_border_color,$show_set_font_color);
                }
                echo "</tr>";
            }
        }
    }
    if(array_search($filename,$read_conf_list)>0 && array_search($filename,$read_conf_list)<8 && isset($save_txt_file_list[$save_txt_[$filename]])) {
        foreach ($save_txt_file_list[$save_txt_[$filename]] as $savename => $savevalue) {
            if($savename!='import' && !in_array($savename,array_keys($setlist))) {
                $index++;
                $savevalue[1] = str_replace("'",$symbol,$savevalue[1]);
                $savevalue[1] = str_replace('"',$dsymbol,$savevalue[1]);
                $savevalue[1] = trim($savevalue[1]);
                echo "<tr>";
                echo "<td><input type='text' readonly></td>";
                echo "<td><input type='text' readonly></td>";
                echo "<td title='$savevalue[1]'><b>$savename</b></td>";
                $saveid = $filename . "^" . $index;
                $inputsavename = $filename . "^" . $savename;
                echo "<td style='border-color: $show_set_border_color' title='$savevalue[1]'><input style='color: $show_set_font_color' type='text' id='$saveid' name='$inputsavename' value='$savevalue[0]' onkeyup='chedklengh(this.id);check(this.id);' spellcheck='false' onkeypress='if(event.keyCode==13)return false;' onClick='this.select();'></td>";
                echo "<td><input type='text' readonly></td>";
                echo "</tr>";
                if($savevalue[0]!='') {
                    echo "<script>check('$saveid');</script>";
                }
            }
        }
    }
    echo "</tbody>";
}
echo "</table>";
echo "</form>";
include 'bottom_javascript.php';
?>