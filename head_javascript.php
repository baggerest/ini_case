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
</script>