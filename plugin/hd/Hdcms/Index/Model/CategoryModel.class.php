<?php

/**
 * 栏目操作模型
 * Class CategoryModel
 */
class CategoryModel extends ViewModel
{
	public $table='category';
	public $view=array(
		'model'=>array(
			'type'=>INNER_JOIN,
			'on'=>'category.mid=model.mid'
		)
	);
	
}