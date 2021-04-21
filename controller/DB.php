<?php

	class Database
	{

		private $link;

		function __construct()
		{
			$this -> connect();
		}

		protected function connect(){
			$config = require('config.php');

			$dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'];

			try {
				$this -> link = new PDO($dsn, $config['db_user'], $config['db_password']);
			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
			}
		}

		private function prepare($sql){
			$req = $this -> link -> prepare($sql);
			return $req;
		}
		private function execute($sql){
			$req = $this -> prepare($sql);
			$req -> execute();
			return $req;
		}

		public function count_res($table, $condition){

			$sql = "SELECT COUNT(`id`) FROM `" . $table . "` WHERE " . $condition;

			$req = $this -> execute($sql);

			return $req -> fetchAll()[0][0];
		}

		public function select($table,$condition){

			$sql = "SELECT * FROM `" . $table . "` WHERE " . $condition;

			$req = $this -> execute($sql);

			return $req -> fetchAll();

		}

		public function insert($table, $columns, $values){

			$cols = $columns;
			$vals = $values;

			foreach ($cols as $key => $value) {
				$cols[$key] = '`' . $cols[$key] . '`';
			}
			$cols = implode(", ", $cols);

			foreach ($vals as $key => $value) {
				$vals[$key] = "'" . $vals[$key] . "'";
			}
			$vals = implode(",", $vals);

			$sql = "INSERT INTO `". $table ."`(" . $cols .") VALUES (" . $vals .")";
			$req = $this -> execute($sql);
			return $sql;

		}

		public function update($table, $columns, $values, $condition, $logic = false){

			$cols = $columns;
			$vals = $values;

			$params = array();

			foreach ($cols as $key => $value) {
				if(!$logic)
					$params[$key] = "`" . $cols[$key] . "`='" . $vals[$key] . "'";
				else
					$params[$key] = "`" . $cols[$key] . "`=" . $vals[$key] . "";
			}
			$params = implode(",", $params);

			$sql = "UPDATE `" . $table . "` SET " . $params . " WHERE " . $condition;
			$req = $this -> execute($sql);
			return $sql;

		}

		public function delete($table,$condition){
			$sql = "DELETE FROM `" . $table . "` WHERE " . $condition;

			$req = $this -> execute($sql);
			return $sql;
		}
	}