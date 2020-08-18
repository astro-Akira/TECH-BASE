<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title="mission_5"></title>
    </head>
    <body>
        <?php
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date=date("Y/m/d H:i:s");
            $inPass=$_POST["inPass"];
            $edtNum=$_POST["edtNum"];
            $delete=$_POST["delete"];
            $dltPass=$_POST["dltPass"];
            $edit=$_POST["edit"];
            $edtPass=$_POST["edtPass"];
            
            //DB接続用
            $dsn = 'データベース名';
            $user = 'ユーザー名';
            $password = 'パスワード';
            $pdo = new PDO($dsn,$user,$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            //DB接続完了
            
            //Table作成用
            $sql = "CREATE TABLE mission_5"
	        ." ("
	        . "id INT AUTO_INCREMENT PRIMARY KEY,"
	        . "name char(32),"
	        . "comment TEXT,"
	        . "date DATETIME,"
	        . "password TEXT"
	        .");";
	        $stmt = $pdo->query($sql);
            //Tabale作成完了
            
            //投稿用
            if(!empty($name)&&!empty($comment)&&!empty($inPass)&&empty($edtNum)){
            
                $sql = $pdo -> prepare("INSERT INTO mission_5 (name, comment, date, password)
                                        VALUES (:name, :comment, :date, :password)");
	            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	            $sql -> bindParam(':password', $inPass, PDO::PARAM_STR);
            	$sql -> execute();
            	
            	if($sql){
            	    echo "受け付けました";
            	}else{
            	    echo "エラー発生";
            	}
            }
            //投稿完了 
            
            //削除用
            if(!empty($delete)&&!empty($dltPass)){
                $id=$delete;
                $sql = 'SELECT * FROM mission_5 WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
                $stmt->execute();
                $results = $stmt->fetchAll(); 
                	foreach ($results as $row){
                	    if($delete==$row["id"]&&$dltPass==$row["password"]){
                	        $id=$delete;
                	        $sql = 'delete from mission_5 where id=:id';
	                        $stmt = $pdo->prepare($sql);
                        	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        	$stmt->execute();
                	    }
                	}
            }
            //削除完了
            
            //編集用
            //編集対象選択用
            if(!empty($edit)&&!empty($edtPass)){
                $id=$edit;
                $sql = 'SELECT * FROM mission_5 WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
                $stmt->execute();
                $results = $stmt->fetchAll(); 
                	foreach ($results as $row){
                	    if($edit==$row["id"]&&$edtPass==$row["password"]){
                	        $ename=$row["name"];
                	        $ecomment=$row["comment"];
                	        $edtNum=$row["id"];
                	    }else{echo "something wrong";
                	    }
                	}
            }
            //編集対象選択完了
            //編集実行用
            if(!empty($name)&&!empty($comment)&&!empty($edtNum)&&!empty($inPass)){
                $id=$edtNum;
                $name=$_POST["name"];
                $comment=$_POST["comment"];
                $date=date("Y/m/d H:i:s");
                $inPass=$_POST["inPass"];
                $sql='UPDATE mission_5 SET name=:name, comment=:comment, date=:date, password=:password, WHERE id=:id';
                $stmt=$pdo -> prepare($sql);      
                $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
                $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
	            $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
	            $stmt -> bindParam(':password', $inPass, PDO::PARAM_STR);
	            
            	$stmt -> execute();
            }
            //編集実行完了
            //編集完了
        
        ?>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php echo $ename; ?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php echo $ecomment; ?>"><br>
        <input type="text" name="inPass" placeholder="パスワード">
        <input type="hidden" name="edtNum" value="<?php echo $edtNum; ?>">
        <input type="submit" name="submit" value="送信"><br><br>
        <input type="text" name="delete" placeholder="削除" ><br>
        <input type="text" name="dltPass" placeholder="パスワード">
        <input type="submit" name="submit" value="削除"><br><br>
        <input type="text" name="edit" placeholder="編集"><br>
        <input type="text" name="edtPass" placeholder="パスワード">
        <input type="submit" name="submit" value="編集" ><br><br><br>
    </form>
    
        <?php
            $sql="SELECT*FROM mission_5";
            $stmt=$pdo -> query($sql);
            $results=$stmt -> fetchAll();
            foreach($results as $row){
                echo $row["id"].",";
                echo $row["name"].",";
                echo $row["comment"].",";
                echo $row["date"].",";
                echo $row["password"]."<br>";
                echo "<hr>";
            }
        ?>
    </body>
</html>