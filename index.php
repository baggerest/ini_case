<script language="JavaScript">
    <!--
    var currentMenu = 1;
    function ShowSubMenu(id) {
        if (document.all("SubMenu"+id).style.display == "")
        {
            document.getElementById("SubMenu"+id).style.display = "none";
            currentMenu = 0;
        }
        else
        {
            if (currentMenu != 0)
            {
                document.getElementById("SubMenu"+id).style.display = "none";
            }
            document.getElementById("SubMenu"+id).style.display = "";
            currentMenu = id;
        }
    }
    -->
</script>
<script language="javascript">
    function show(item)
    {
        switch (document.getElementById(item).style.display)
        {
            case 'block':
                document.getElementById(item).style.display = 'none';
                break;
            case 'none':
                document.getElementById(item).style.display = 'block';
                break;
        }
    }
</script>

<?php
header("Content-Type:text/html; charset=utf-8");
$main_folder = "C:/wamp64/www/rathena/conf/";

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
$get_ = get_conf_set_list($main_folder,$read_conf_list);
$split = array();
echo "<div style='margin-left: auto;margin-right: auto'>";
echo "<table align='center' border='1' style='border-style: dashed;border-color:#FFAC55;padding:5px;'>";
$i = 0;
foreach ($get_ as $name => $item)
{
    $i++;
    echo "<tr><th colspan='3' style='background-color: darkkhaki' onclick='show(\"menu{$i}\")'>".$name."</th></tr>";
    echo "<tbody id='menu{$i}' style='display:none'>";
    foreach ($item as $number => $value)
    {
        $split = explode(": ",$value);
        echo "<tr>";
        echo "<td>";
        echo $number;
        echo "</td>";
        echo "<td>".$split[0]."</td>";
        echo "<td>";
        echo "<input  name='".$split[0]."' type='text' value='".$split[1]."' size= ".(strlen($split[1])+5).">";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
}
echo "</table></div>";


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