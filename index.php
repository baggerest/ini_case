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
</script>

<?php
header("Content-Type:text/html; charset=utf-8");
$main_folder = "C:/my/rathena/conf/";

$read_conf_list = array(
    "battle_athena.conf",
    "char_athena.conf",
    "inter_athena.conf",
    "log_athena.conf",
    "login_athena.conf",
    "map_athena.conf",
    "packet_athena.conf",
    "script_athena.conf",
    "battle/battle.conf",
    "battle/battleground.conf",
    "battle/client.conf",
    "battle/drops.conf",
    "battle/exp.conf",
    "battle/feature.conf",
    "battle/gm.conf",
    "battle/guild.conf",
    "battle/homunc.conf",
    "battle/items.conf",
    "battle/misc.conf",
    "battle/monster.conf",
    "battle/party.conf",
    "battle/pet.conf",
    "battle/player.conf",
    "battle/skill.conf",
    "battle/status.conf",
);
$count = count($read_conf_list);
$get_ = get_conf_set_list($main_folder,$read_conf_list);
$split = array();
echo "<form action='index.php' method='post'>";
echo "<div style='position: fixed;top: 20px;right: 20px;text-align: right'>";
echo "File place : ".$main_folder."<br />";
echo "<a href='javascript:openall($count)'>open all conf set list</a><br />";
echo "<a href='javascript:closeall($count)'>close all conf set list</a><br />";
echo "<input type='submit' value='set finish'>";
echo "</div>";
echo "<div>";
echo "<table align='center' border='1' style='border-style: dashed;border-color:#FFAC55;padding:5px;'>";
$i = 0;
foreach ($get_ as $name => $item)
{
    $i++;
    echo "<tr><th id='$name' colspan='4' style='cursor: pointer;background-color: #BDB885' onclick='show(\"menu{$i}\")'>".$name."</th>";
    echo "<td><input type='submit' value='recovery all' onclick='recoveryallset(\"$name\");return false;'></td>";
    echo "</tr>";
    echo "<tbody id='menu{$i}' style='display: none'>";
    foreach ($item as $number => $value)
    {
        $split = explode(": ",$value);
        echo "<tr>";
        echo "<td style='text-align: center'>";
        echo $number;
        echo "</td>";
        echo "<td style='text-align: right'>".$split[0]."</td>";
        echo "<td>";
        echo "<input id='".$name."^".$number."_' name='".$name."^".$number."_' type='text' value='".$split[1]."' size= ".(strlen($split[1])+5)." style='color: darkgrey' readonly='readonly' tabindex='-1'><br>";
        echo "<input id='".$name."^".$number."' name='".$name."^".$number."' type='text' value='".$split[1]."' size= ".(strlen($split[1])+5)." onchange='check(this.id,\"$name\",$number)' onkeyup='check(this.id,\"$name\",$number)'>";
        echo "</td>";
        echo "<td><input type='submit' value='recovery' onclick='recoveryset(\"$name\",$number);return false;'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
}
echo "</table></div></form>";


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
                            if(!strpos($contents,": "))
                            {
                                $contents .= " ";
                            }
                            $conf_list[$value][] = $contents;
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