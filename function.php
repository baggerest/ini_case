<?php

function get_conf_set_list($main_folder,$read_conf_list)
{
    try {
        $conf_list = array();
        foreach ($read_conf_list as $value) {
            $file = fopen($main_folder . $value, "r");
            if ($file) {
                $title = "";
                while (!feof($file)) {
                    $contents = fgets($file);
                    $contents = trim($contents);
                    if ($contents !== "" && substr($contents, 0, 2) !== '//') {
                        if (!strpos($contents, "//")) {
                            $sp[0] = substr($contents, 0, strpos($contents, ":"));
                            $sp[1] = trim(substr($contents, strpos($contents, ":") + 1));
                            if ($sp[0] == 'import') {
                                $conf_list[$value][$sp[0]][] = array($sp[1],$title);
                            } else {
                                $conf_list[$value][$sp[0]] = array($sp[1],$title);
                            }
                        }
                    } else {
                        if ($contents == "") {
                            $title = "";
                        } else {
                            $title .= $contents."\n";
                        }
                    }
                }
                fclose($file);
            }
        }
        return $conf_list;
    } catch (Exception $e) {
        echo $e;
    }
}

function go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_,$show_set_border_color,$show_set_font_color)
{
    $count = count($setlist);
    $count += isset($conf_file_list[$filename]['import']) ? count($conf_file_list[$filename]['import']) - 1 : 0;
    echo "<td rowspan='$count' style='border-color: $show_set_border_color' title='Edit $filename import'><textarea id='$filename^import' name='$filename^import' spellcheck='false' style='color: $show_set_font_color;height: " . ($count * $td_height_px) . "px' onchange='sameway(this.id);' onkeyup='check(this.id);' onClick='this.select();'>";
    if (isset($save_txt_file_list[$save_txt_[$filename]]['import'])) {
        $temp = $save_txt_file_list[$save_txt_[$filename]]['import'];
        foreach ($temp as $importvalue) {
            echo "import: " . $importvalue[0] . "\n";
        }
    }
    echo "</textarea></td>";
    echo "<script>check('$filename^import');</script>";
}