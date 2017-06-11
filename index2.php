<?php
$main_folder = "D:/rathena/conf/";
$main_folder = "C:/my/rathena/conf/";

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
                while (!feof($file)) {
                    $contents = fgets($file);
                    $contents = trim($contents);
                    if ($contents !== "" && substr($contents, 0, 2) !== '//') {
                        if (!strpos($contents, "//")) {
                            $sp[0] = substr($contents, 0, strpos($contents, ":"));
                            $sp[1] = trim(substr($contents, strpos($contents, ":") + 1));
                            if ($sp[0] == 'import') {
                                $conf_list[$value][$sp[0]][] = $sp[1];
                            } else {
                                $conf_list[$value][$sp[0]] = $sp[1];
                            }
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
    echo "<td rowspan='$count'><textarea id='$filename^import' name='$filename^import' spellcheck='false' style='height: " . ($count * $td_height_px) . "px' onchange='sameway(this.id);'>";
    if (isset($save_txt_file_list[$save_txt_[$filename]]['import'])) {
        $temp = $save_txt_file_list[$save_txt_[$filename]]['import'];
        foreach ($temp as $importvalue) {
            echo $importvalue . "\n";
        }
    }
    echo "</textarea></td>";
}

$conf_file_list = get_conf_set_list($main_folder,$read_conf_list);
$save_txt_file_list = get_conf_set_list($main_folder,$save_txt);

$td_height_px = 27;
echo "<form action='' method='post'>";
echo "<table id='set_table' border='1' align='center' style='border-style: dashed;border-color:#FFAC55;padding:5px;text-align: center'>";
foreach ($conf_file_list as $filename => $setlist) {
    $check = true;
    echo "<tr><th colspan='2' onclick='show_hide(\"$filename\");'>$filename</th><th colspan='2' onclick='show_hide(\"$filename\");'>$save_txt_[$filename]</th></tr>";
    echo "<tbody id='$filename' style='display: none'>";
    foreach ($setlist as $setname => $value) {
        if ($setname != 'import') {
            echo "<tr>";
            echo "<td>$setname</td><td>$value</td>";
            $inputid = $filename . "^" . $setname;
            $inputvalue = isset($save_txt_file_list[$save_txt_[$filename]][$setname]) ? $save_txt_file_list[$save_txt_[$filename]][$setname] : "";
            echo "<td><input type='text' id='$inputid' name='$inputid' value='$inputvalue' onkeyup='chedklengh(this.id);'></td>";
            if ($check) {
                $check = false;
                go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_);
            }
            echo "</tr>";
        } else {
            foreach ($value as $listindex => $item) {
                echo "<tr><td>$setname</td><td>$item</td><td><input type='text' readonly></td>";
                if ($check) {
                    $check = false;
                    go_import($setlist,$conf_file_list,$filename,$td_height_px,$save_txt_file_list,$save_txt_);
                }
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