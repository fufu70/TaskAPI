<?php

Yii::import('application.models._base.BaseNodeHasTask');

class NodeHasTask extends BaseNodeHasTask
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}