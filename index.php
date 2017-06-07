<script language="javascript">
    function show(item)
    {
        document.getElementById(item).style.display = document.getElementById(item).style.display=="none"?"":"none";
    }

    function openall(count)
    {
        for(i=1;i<=count;i++)
        {
            document.getElementById('menu'+i).style.display = '';
        }
    }

    function closeall(count)
    {
        for(i=1;i<=count;i++)
        {
            document.getElementById('menu'+i).style.display = 'none';
        }
    }

    var thaa = new Array();
    function check(item,thname,setnumber)
    {
        if(thaa[thname]==null)thaa[thname]=new Array();
        if(thaa[thname][setnumber]==null)thaa[thname][setnumber] = 0;
        if(document.getElementById(item).value!=document.getElementById(item+'_').value)
        {
            document.getElementById(item).style.backgroundColor = '#ff0000';
            thaa[thname][setnumber] = 1;
        }else{
            document.getElementById(item).style.backgroundColor = document.getElementById(item+'_').style.backgroundColor;
            thaa[thname][setnumber] = 0;
        }
        var sum = thaa[thname].reduce(function(a, b) {
            return a + b;
        });
        document.getElementById(thname).style.backgroundColor = sum!=0?'#ff0000':'#BDB885';
    }

    function recoveryset(thname,setnumber)
    {
        item = thname + '^' + setnumber;
        document.getElementById(item).value = document.getElementById(item+'_').value;
        check(item,thname,setnumber);
    }

    function recoveryallset(thname)
    {
        for(var key in thaa[thname])
        {
            recoveryset(thname,key);
        }
    }

    function changecolor(item) {
        document.getElementById(item).style.backgroundColor = '#ff0000';
    }
</script>

<?php
header("Content-Type:text/html; charset=utf-8");
$main_folder = "D:/rathena/conf/";

$read_conf_list = array(
    0 => "char_athena.conf",
    1 => "inter_athena.conf",
    2 => "log_athena.conf",
    3 => "login_athena.conf",
    4 => "map_athena.conf",
    5 => "packet_athena.conf",
    6 => "script_athena.conf",
    7 => "battle/battle.conf",
    8 => "battle/battleground.conf",
    9 => "battle/client.conf",
    10 => "battle/drops.conf",
    11 => "battle/exp.conf",
    12 => "battle/feature.conf",
    13 => "battle/gm.conf",
    14 => "battle/guild.conf",
    15 => "battle/homunc.conf",
    16 => "battle/items.conf",
    17 => "battle/misc.conf",
    18 => "battle/monster.conf",
    19 => "battle/party.conf",
    20 => "battle/pet.conf",
    21 => "battle/player.conf",
    22 => "battle/skill.conf",
    23 => "battle/status.conf",
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
    $read_conf_list[0] => $save_txt[1],
    $read_conf_list[1] => $save_txt[2],
    $read_conf_list[2] => $save_txt[3],
    $read_conf_list[3] => $save_txt[4],
    $read_conf_list[4] => $save_txt[5],
    $read_conf_list[5] => $save_txt[6],
    $read_conf_list[6] => $save_txt[7],
    $read_conf_list[7] => $save_txt[0],
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
);

function get_conf_set_list($main_folder,$read_conf_list)
{
    try
    {
        $conf_list = array();
        foreach ($read_conf_list as $value)
        {
            $file = fopen($main_folder.$value,"r");
            if ($file)
            {
                while (!feof($file))
                {
                    $contents = fgets($file);
                    $contents = trim($contents);
                    if($contents!=="" && substr($contents,0,2)!=='//')
                    {
                        if(!strpos($contents,"//"))
                        {
                            $sp[0] = substr($contents,0,strpos($contents,":"));
                            $sp[1] = trim(substr($contents,strpos($contents,":")+1));
                            $conf_list[$value][] = $sp;
                        }
                    }
                }
                fclose($file);
            }
        }
        return $conf_list;
    }
    catch (Exception $e)
    {
        echo $e;
    }
}

function margearray($v1,$v2,$save_txt_)
{
    foreach ($v1 as $name => $item)
    {
        foreach ($item as $number => $value)
        {
            foreach ($v2 as $fi => $vv)
            {
                foreach ($vv as $vvvv)
                {
                    if($save_txt_[$name]==$fi&&$value[0]==$vvvv[0])
                    {
                        if($vvvv[0]=='import')
                        {
                            if (!in_array($vvvv, $v1[$name]))
                            {
                                $v1[$name][] = $vvvv;
                            }
                        }else{
                            $v1[$name][$number][2] = $vvvv[1];
                        }
                    }
                }
            }
        }
    }
    return $v1;
}

$count = count($read_conf_list);
$get_ = get_conf_set_list($main_folder,$read_conf_list);
$get_txt = get_conf_set_list($main_folder,$save_txt);
$getnew_ = margearray($get_,$get_txt,$save_txt_);

echo "<form action='index.php' method='post'>";
echo "<div style='position: fixed;top: 20px;right: 20px;text-align: right'>";
echo "File place : ".$main_folder."<br />";
echo "<a href='javascript:openall($count)'>open all conf set list</a><br />";
echo "<a href='javascript:closeall($count)'>close all conf set list</a><br />";
echo "</div>";
echo "<div>";
echo "<table align='center' border='1' style='border-style: dashed;border-color:#FFAC55;padding:5px;'>";
$i = 0;
foreach ($getnew_ as $name => $item)
{
    $i++;
    echo "<tr><th id='$name' colspan='4' style='cursor: pointer;background-color: #BDB885' onclick='show(\"menu{$i}\")'>".$name."</th>";
    echo "<td><input type='submit' value='recovery file' onclick='recoveryallset(\"$name\");return false;'></td>";
    echo "</tr>";
    echo "<tbody id='menu{$i}' style='display: none'>";
    foreach ($item as $number => $value)
    {
        $valuetemp = isset($value[2])?$value[2]:$value[1];
        $backcolor = $valuetemp!=$value[1]?'#ff0000':'';
        if($valuetemp!=$value[1])
        {
            echo "<script>changecolor('$name');</script>";
        }
        echo "<tr>";
        echo "<td style='text-align: center'>";
        echo $number;
        echo "</td>";
        echo "<td style='text-align: right'>".$value[0]."</td>";
        echo "<td>";
        echo "<input id='".$name."^".$number."_' name='".$name."^".$number."_' type='text' value='".$value[1]."' size= ".(strlen($value[1])+5)." style='color: darkgrey' readonly='readonly' tabindex='-1'><br>";
        echo "<input id='".$name."^".$number."' name='".$name."^".$number."' type='text' value='".$valuetemp."' size= ".(strlen($valuetemp)+5)." style='background-color: $backcolor' onchange='check(this.id,\"$name\",$number)' onkeyup='check(this.id,\"$name\",$number)'>";
        echo "</td>";
        echo "<td align='center'><input id='".$name."^".$number."x' value='save' type='submit' onclick='return false;'></td>";
        echo "<td align='center'><input type='submit' value='recovery' onclick='recoveryset(\"$name\",$number);return false;'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
}
echo "</table></div></form>";

