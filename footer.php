 <?php
 if(!empty($msg))
 echo "<div class='alert alert-success'>
	<strong>Success!</strong>$msg
	</div>";
 if(!empty($error))
 echo "<div class='alert alert-danger'>
	<strong>Error!</strong>$error
	</div>";
 ?>
</div>
</body>
</html>