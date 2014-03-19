<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<?php if(isset($js)) foreach($js as $path){
    echo "<script src='$path'></script>";
}
?>
</body>
</html>
