<?php
function check_POST($main_folder,$read_conf_list,$save_txt_)
{
    if (isset($_POST['setup'])) {
        $writetxt = array();
        try {
            foreach ($_POST as $setname => $value) {
                $analysis = explode('^', str_replace('_conf', '.conf', $setname));
                $key = array_search($analysis[0], $read_conf_list);
                if ($setname == 'setup' or ($value == '' && $analysis[1] != 'import') or ($key > 7 && $analysis[1] == 'import')) {
                    continue;
                }

                //多行、非import、重覆值、battle設定一直重覆設定
                if ($analysis[1] == "import") {
                    if($value=="") {
                        $writetxt[$analysis[0]][] = "";
                    } else {
                        $writetxt[$analysis[0]][] = $analysis[1] . ": " . trim(str_replace('import: ', '', $value));
                    }
                } else {
                    if (isset($writetxt[$analysis[0]])) {
                        if (in_array($analysis[1] . ": " . trim($value), $writetxt[$analysis[0]])) {
                            continue;
                        }
                    }
                    $writetxt[$analysis[0]][] = $analysis[1] . ": " . trim($value);
                }


//                $setv = str_replace('import: ', '', $value);
//                if ($analysis[1] == 'import' && !strpos($setv, "import: ")) {
//                    $analysis[1] = substr($value, 0, strpos($value, ":"));
//                    $setv = trim(substr($value, strpos($value, ":") + 1));
//                }
//                if (isset($writetxt[$analysis[0]])) {
//                    if (in_array($analysis[1] . ": " . $setv, $writetxt[$analysis[0]])) {
//                        continue;
//                    }
//                }
//                $writetxt[$analysis[0]][] = trim($value) == '' ? '' : $analysis[1] . ": " . $setv;
            }
            foreach ($writetxt as $confpath => $setlist) {
                $fop = fopen($main_folder . $save_txt_[$confpath], (array_search($confpath, $read_conf_list) < 8) ? "w" : "a");
                foreach ($setlist as $item) {
                    $item .= $item == '' ? '' : "\r\n";
                    fwrite($fop, $item);
                }
                fclose($fop);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}

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