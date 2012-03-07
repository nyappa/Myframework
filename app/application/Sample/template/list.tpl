{*foreach from=$log_list item=list*}
<input type="button" value='{*$list*}' onClick="load_log('{*$list*}','10')"><br>
{*foreachelse*}
なし
{*/foreach*}

