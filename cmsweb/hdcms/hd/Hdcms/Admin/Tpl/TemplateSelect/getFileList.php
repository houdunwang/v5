<if value="$history">
        <a href="javascript:;" class="back hd-cancel" onclick="getFileList('{$history}')" style="padding:2px 10px;margin:5px;">返回</a>
</if>
    <table class="table2">
        <thead>
        <tr>
        	<td class="w50">类型</td>
            <td>名称</td>
            <td class="w150">大小</td>
            <td class="w80">修改时间</td>
        </tr>
        </thead>
        <list from="$file" name="f">
            <tr>
            	<td>
            		<if value="$f.type=='file'">
            		<b class='file'>文件</b>
            		<else/>
            		<b class='dir'>目录</b>
            		</if>
            	</td>
                <td>
                    <div>
	                    <if value="$f.type=='file'">
	            			<a href="javascript:;" class="{$f.type}"  onclick="getTplFile('{$f.path}')">
	                            <span class="{$f.type}">{$f.name}</span>
	                        </a>
	            		<else/>
	            			<a href="javascript:;" class="{$f.type}" onclick="getFileList('{$f.url}');">
	                            <span class="{$f.type}">{$f.name}</span>
	                        </a>
	            		</if>
                    </div>
                </td>
                <td>{$f.size|get_size}</td>
                <td>{$f.filemtime|date:"Y-m-d",@@}</td>
            </tr>
        </list>
    </table>