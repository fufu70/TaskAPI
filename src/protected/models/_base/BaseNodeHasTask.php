<?php

/**
 * This is the model base class for the table "{{node_has_task}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "NodeHasTask".
 *
 * Columns in table "{{node_has_task}}" available as properties of the model,
 * followed by relations of table "{{node_has_task}}" available as properties of the model.
 *
 * @property integer $node_has_task_id
 * @property integer $node_id
 * @property integer $task_id
 *
 * @property Node $node
 * @property Task $task
 */
abstract class BaseNodeHasTask extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{node_has_task}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'NodeHasTask|NodeHasTasks', $n);
	}

	public static function representingColumn() {
		return 'node_has_task_id';
	}

	public function rules() {
		return array(
			array('node_id, task_id', 'required'),
			array('node_id, task_id', 'numerical', 'integerOnly'=>true),
			array('node_has_task_id, node_id, task_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'node' => array(self::BELONGS_TO, 'Node', 'node_id'),
			'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'node_has_task_id' => Yii::t('app', 'Node Has Task'),
			'node_id' => null,
			'task_id' => null,
			'node' => null,
			'task' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('node_has_task_id', $this->node_has_task_id);
		$criteria->compare('node_id', $this->node_id);
		$criteria->compare('task_id', $this->task_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}