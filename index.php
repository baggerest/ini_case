<?php
header("Content-Type:text/html; charset=big5");
$main_foder = "D:/rathena/conf/";

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
try
{
    foreach ($read_conf_list as $value)
    {
        $file = fopen($main_foder.$value,"r");
        if ($file)
        {
            echo "[".$value."]<br>";
            $i = 0;
            while (!feof($file))
            {
                $contents = fgets($file);
                $contents = trim($contents);
                $i++;
                if($contents!=="" && substr($contents,0,2)!=='//')
                {
                    if(!strpos($contents,"//")) {
                        echo $i . ")" . $contents . "<br>";
                    }
                }
            }
            fclose($file);
        }
    }
}
catch (Exception $e)
{
    echo $e;
}