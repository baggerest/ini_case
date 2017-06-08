<?php
$main_folder = "D:/rathena/conf/";
//$main_folder = "C:/my/rathena/conf/";

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

$aa = get_conf_set_list($main_folder,$read_conf_list);

$aa1 = get_conf_set_list($main_folder,$save_txt);

