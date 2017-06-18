<script language="JavaScript">
    var thee = [];
    function check(id)
    {
        thname = id.split('^')[0];
        setname = id.split('^')[1];
        if(setname=='import')setname=0
        if(thee[thname]==null)thee[thname]=[];
        if(thee[thname][setname]==null)thee[thname][setname] = 0;
        if(document.getElementById(id).value.trim()!='')
        {
            document.getElementById(id).style.backgroundColor = '#ff0000';
            thee[thname][setname] = 1;
        }else{
            document.getElementById(id).style.backgroundColor = '';
            thee[thname][setname] = 0;
        }
        try {
            var total = thee[thname].reduce(function (a, b) {
                return a+b;
            });
            document.getElementById(thname + '_txt').style.backgroundColor = total != 0 ? '#ff0000' : '#BDB885';
        } catch (e){
            alert(e);
        }
    }

    function show_hide(id) {
        document.getElementById(id).style.display = document.getElementById(id).style.display == 'none' ? '' : 'none';
    }

    function chedklengh(id) {
        obj = document.getElementById(id);
        obj.size = (obj.value.length > 24 ? obj.value.length : 20);
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

    function sameway(id) {
        arr = [<?php foreach ($save_txt_ as $name => $savefile){if($savefile==$save_txt[0])echo "\"$name^import\",";} ?>];
        for(var importtextarea in arr) {
            if(arr.indexOf(id)!=-1) {
                document.getElementById(arr[importtextarea]).value = document.getElementById(id).value;
                check(arr[importtextarea]);
            }
        }
    }

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
</script>