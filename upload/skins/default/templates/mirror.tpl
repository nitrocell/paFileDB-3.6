{******************************************************************
      {#select_mirror#}
    </td>
  </tr>
  <tr>
    <td width="100%">
      <div align="center">
      {#select_mirror_info#}<br />
      <a href="{$settings.dburl}/index.php?act=download&id={$file.file_id}">{#main_server#}</a><br />
      {foreach key=row item=mirror from=$mirrors}
        <a href="{$settings.dburl}/index.php?act=download&id={$file.file_id}&mirror={$row}">{$mirror.name}</a><br />
      {/foreach}
      </div>
    </td>
  </tr>