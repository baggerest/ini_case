<script language="JavaScript">
    function Unfolded() {
        setlist = new Array(<?php foreach (array_keys($conf_file_list) as $name) {echo "\"$name\",";} ?>);
        for(var va in setlist) {
            document.getElementById(setlist[va]).style.display = '';
        }
    }

    function closure() {
        setlist = new Array(<?php foreach (array_keys($conf_file_list) as $name) {echo "\"$name\",";} ?>);
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
        arr = [<?php foreach ($save_txt_ as $name => $savefile){if($savefile==$save_txt[0])echo "\"$name^import\",";} ?>];
        for(var importtextarea in arr) {
            if(arr.indexOf(id)!=-1) {
                document.getElementById(arr[importtextarea]).value = document.getElementById(id).value;
                check(arr[importtextarea]);
            }
        }
    }

    function cleanall(thname)
    {
        try {
            for (var key in thee[thname]) {
                cleanset(thname, key);
            }
        }catch (e) {
            alert(e);
        }
    }

    function cleanset(thname,setnumber)
    {
        if(setnumber==0)setnumber='import';
        item = thname + '^' + setnumber;
        document.getElementById(item).value = '';
        check(item);
    }
</script>