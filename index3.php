<?php
$main_folder = "";
switch ($_ENV['COMPUTERNAME']) {
    case 'DESKTOP-6OVHJN1':
        $main_folder = "C:/my/rathena/conf/";
        break;
    default:
        $main_folder = "D:/rathena/conf/";
}

$read_conf_list = array(
    0 => "battle_athena.conf",
    1 => "char_athena.conf",
    2 => "inter_athena.conf",
    3 => "log_athena.conf",
    4 => "login_athena.conf",
    5 => "map_athena.conf",
    6 => "packet_athena.conf",
    7 => "script_athena.conf",
    8 => "battle/battle.conf",
    9 => "battle/battleground.conf",
    10 => "battle/client.conf",
    11 => "battle/drops.conf",
    12 => "battle/exp.conf",
    13 => "battle/feature.conf",
    14 => "battle/gm.conf",
    15 => "battle/guild.conf",
    16 => "battle/homunc.conf",
    17 => "battle/items.conf",
    18 => "battle/misc.conf",
    19 => "battle/monster.conf",
    20 => "battle/party.conf",
    21 => "battle/pet.conf",
    22 => "battle/player.conf",
    23 => "battle/skill.conf",
    24 => "battle/status.conf",
);

$save_txt = array(
    0 => "import/battle_conf.txt",
    1 => "import/char_conf.txt",
    2 => "import/inter_conf.txt",
    3 => "import/log_conf.txt",
    4 => "import/login_conf.txt",
    5 => "import/map_conf.txt",
    6 => "import/packet_conf.txt",
    7 => "import/script_conf.txt",
);

$save_txt_ = array(
    $read_conf_list[0] => $save_txt[0],
    $read_conf_list[1] => $save_txt[1],
    $read_conf_list[2] => $save_txt[2],
    $read_conf_list[3] => $save_txt[3],
    $read_conf_list[4] => $save_txt[4],
    $read_conf_list[5] => $save_txt[5],
    $read_conf_list[6] => $save_txt[6],
    $read_conf_list[7] => $save_txt[7],
    $read_conf_list[8] => $save_txt[0],
    $read_conf_list[9] => $save_txt[0],
    $read_conf_list[10] => $save_txt[0],
    $read_conf_list[11] => $save_txt[0],
    $read_conf_list[12] => $save_txt[0],
    $read_conf_list[13] => $save_txt[0],
    $read_conf_list[14] => $save_txt[0],
    $read_conf_list[15] => $save_txt[0],
    $read_conf_list[16] => $save_txt[0],
    $read_conf_list[17] => $save_txt[0],
    $read_conf_list[18] => $save_txt[0],
    $read_conf_list[19] => $save_txt[0],
    $read_conf_list[20] => $save_txt[0],
    $read_conf_list[21] => $save_txt[0],
    $read_conf_list[22] => $save_txt[0],
    $read_conf_list[23] => $save_txt[0],
    $read_conf_list[24] => $save_txt[0],
);

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

function go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_)
{
    $count = count($setlist);
    $count += isset($conf_file_list[$filename]['import']) ? count($conf_file_list[$filename]['import']) - 1 : 0;
    echo "<td rowspan='$count' style='border-color: darkgreen'><textarea id='$filename^import' name='$filename^import' spellcheck='false' style='width: 300px;height: " . ($count * $td_height_px) . "px' onchange='sameway(this.id);'>";
    if (isset($save_txt_file_list[$save_txt_[$filename]]['import'])) {
        $temp = $save_txt_file_list[$save_txt_[$filename]]['import'];
        foreach ($temp as $importvalue) {
            echo "import: " . $importvalue[0] . "\n";
        }
    }
    echo "</textarea></td>";
}

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
            $writetxt[$analysis[0]][] = trim($value) == '' ? '' : $analysis[1] . ": " . str_replace('import: ','',$value);
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

$td_height_px = 27;
$symbol = "&prime;";
$dsymbol = "&Prime;";
echo "<form id='set_form' action='' method='post'>";
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
    echo "<tr><th id='{$filename}_conf' colspan='2' onclick='show_hide(\"$filename\");'>$filename</th><th id='{$filename}_txt' colspan='3' onclick='show_hide(\"$filename\");'>$save_txt_[$filename]</th></tr>";
    echo "<tbody id='$filename' style='display: none'>";
    foreach ($setlist as $setname => $value) {
        if ($setname != 'import') {
            $value[1] = str_replace("'",$symbol,$value[1]);
            $value[1] = str_replace("'",$dsymbol,$value[1]);
            echo "<tr>";
            echo "<td title='$value[1]'><b>$setname</b></td><td style='color: darkgray' title='$value[1]'><I>$value[0]</I></td>";
            $inputid = $filename . "^" . $setname;
            $inputvalue = isset($save_txt_file_list[$save_txt_[$filename]][$setname]) ? $save_txt_file_list[$save_txt_[$filename]][$setname][0] : "";
            echo "<td title='$value[1]'><b>$setname</b></td>";
            echo "<td style='border-color: darkgreen' title='$value[1]'><input style='color: blue' type='text' id='$inputid' name='$inputid' value='$inputvalue' onkeyup='chedklengh(this.id);' spellcheck='false' onkeypress='if(event.keyCode==13)return false;'></td>";
            if ($check) {
                $check = false;
                go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_);
            }
            echo "</tr>";
        } else {
            foreach ($value as $listindex => $item) {
                $item[1] = str_replace("'",$symbol,$item[1]);
                $item[1] = str_replace("'",$dsymbol,$item[1]);
                echo "<tr><td title='$item[1]'><b>$setname</b></td><td style='color: darkgray' title='$item[1]'><I>$item[0]</I></td><td><input type='text' readonly></td><td><input type='text' readonly></td>";
                if ($check) {
                    $check = false;
                    go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_);
                }
                echo "</tr>";
            }
        }
    }
    if(array_search($filename,$read_conf_list)>0 && array_search($filename,$read_conf_list)<8 && isset($save_txt_file_list[$save_txt_[$filename]])) {
        foreach ($save_txt_file_list[$save_txt_[$filename]] as $savename => $savevalue) {
            if($savename!='import' && !in_array($savename,array_keys($setlist))) {
                $savevalue[1] = str_replace("'",$symbol,$savevalue[1]);
                $savevalue[1] = str_replace("'",$dsymbol,$savevalue[1]);
                echo "<tr>";
                echo "<td><input type='text' readonly></td>";
                echo "<td><input type='text' readonly></td>";
                echo "<td title='$savevalue[1]'><b>$savename</b></td>";
                $saveid = $filename . "^" . $savename;
                echo "<td style='border-color: darkgreen' title='$savevalue[1]'><input style='color: blue' type='text' id='$saveid' name='$saveid' value='$savevalue[0]' onkeyup='chedklengh(this.id);' spellcheck='false' onkeypress='if(event.keyCode==13)return false;'></td>";
                echo "<td><input type='text' readonly></td>";
                echo "</tr>";
            }
        }
    }
    echo "</tbody>";
}
echo "</table>";
echo "</form>";
?>

<script type="text/javascript">
    var setlist = new Array(<?php foreach (array_keys($conf_file_list) as $name) {echo "\"$name\",";} ?>);

    function Unfolded() {
        for(var va in setlist) {
            document.getElementById(setlist[va]).style.display = '';
        }
    }

    function closure() {
        for(var va in setlist) {
            document.getElementById(setlist[va]).style.display = 'none';
        }
    }

    function show_hide(id) {
        document.getElementById(id).style.display = document.getElementById(id).style.display == 'none' ? '' : 'none';
    }

    function chedklengh(id) {
        obj = document.getElementById(id);
        obj.size = (obj.value.length > 24 ? obj.value.length : 20);
    }

    function sameway(id) {
        arr = new Array(<?php foreach ($save_txt_ as $name => $savefile) {
            if($savefile==$save_txt[0]) {
                echo "\"$name^import\",";
            }
        } ?>);
        for(var importtextarea in arr) {
            if(arr.indexOf(id)!=-1) {
                document.getElementById(arr[importtextarea]).value = document.getElementById(id).value;
            }
        }
    }
</script>

<style>
    th {
        cursor: pointer;
        background-color: #BDB885;
    }
    input {
        border: none;
        text-align: center;
    }
    textarea {
        border: none;
    }
</style>