<table width='100%'>
		<tr>
	<?
	foreach ($objects as $k=>$v){?>
		<td width='50%' style='padding:5px'><?php $this->renderPartial('_object',array('model'=>$v, 'demand'=>$demand)); ?> </td>
	<?if (($k+1)%2==0&&isset($objects[$k+1])){?></tr><tr><?}
	}
	?>
	</tr>
	</table>
 
